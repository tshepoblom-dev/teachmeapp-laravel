/**
 * useRealTimeNotifications
 *
 * Subscribes to the user's private Echo channel, prepends incoming
 * notifications to the reactive bell list, shows an in-app toast, fires a
 * native browser notification when the tab is not focused, and plays a
 * short chime sound on every incoming notification.
 */

import { onMounted, onBeforeUnmount } from 'vue'
import { usePage }                    from '@inertiajs/vue3'
import { useEcho, connectionState }   from './useEcho'
import { useBrowserNotifications }    from './useBrowserNotifications'
import { useToast }                   from './useToast'
import { useFcm }                     from './useFcm'

const TOAST_LABELS = {
    booking_accepted:  '✅ Booking accepted',
    booking_cancelled: '❌ Booking cancelled',
    booking_completed: '🎓 Session completed',
    booking_request:   '📅 New booking request',
    session_starting:  '🔔 Session starting soon',
    session_started:   '▶️ Session started',
    session_ended:     '⏹️ Session ended',
    payment_received:  '💰 Payment received',
    payout_processed:  '💸 Payout processed',
    kyc_approved:      '✅ KYC approved',
    kyc_rejected:      '❌ KYC rejected',
    tier_upgraded:     '⭐ Tier upgraded',
}

function resolveToastType(type) {
    if (['booking_cancelled', 'kyc_rejected'].includes(type))    return 'error'
    if (['session_starting', 'booking_request'].includes(type))  return 'warning'
    return 'info'
}

// ─── Notification chime (Web Audio API) ──────────────────────────────────────
// Browsers block AudioContext.start() until after a user gesture (click,
// keydown, etc.). We prime the context on the first interaction so it's
// in a running state by the time a notification arrives.

let audioCtx = null
let audioReady = false

function primeAudioContext() {
    if (audioReady) return
    try {
        audioCtx = new (window.AudioContext || window.webkitAudioContext)()
        audioCtx.resume().then(() => { audioReady = true }).catch(() => {})
    } catch {
        // Web Audio not supported — chime silently disabled.
    }
}

// Wire up priming on the first meaningful user gesture (self-removing).
;['click', 'keydown', 'touchstart', 'pointerdown'].forEach(evt => {
    window.addEventListener(evt, function primer() {
        primeAudioContext()
        window.removeEventListener(evt, primer)
    }, { once: true, passive: true })
})

function getAudioContext() {
    if (!audioCtx || !audioReady) return null
    // Context can be suspended after inactivity — resume() is async so we
    // return it immediately; scheduled nodes play once it is running again.
    if (audioCtx.state === 'suspended') audioCtx.resume().catch(() => {})
    return audioCtx
}

/**
 * Play a soft two-tone chime.
 * Uses the Web Audio API — no external file needed.
 *
 * @param {'default'|'alert'|'success'} tone
 */
function playChime(tone = 'default') {
    const ctx = getAudioContext()
    if (!ctx) return

    // Tone map: [frequency (Hz), duration (s), gain]
    const tones = {
        default: [[880, 0.08, 0.18], [1100, 0.12, 0.14]],   // ding
        alert:   [[440, 0.10, 0.20], [330,  0.15, 0.14]],   // lower, warning-ish
        success: [[880, 0.07, 0.18], [1320, 0.14, 0.14]],   // brighter
    }

    const sequence = tones[tone] ?? tones.default
    let offset = ctx.currentTime + 0.01

    for (const [freq, dur, gainVal] of sequence) {
        const osc  = ctx.createOscillator()
        const gain = ctx.createGain()

        osc.connect(gain)
        gain.connect(ctx.destination)

        osc.type      = 'sine'
        osc.frequency.setValueAtTime(freq, offset)

        gain.gain.setValueAtTime(gainVal, offset)
        gain.gain.exponentialRampToValueAtTime(0.001, offset + dur)

        osc.start(offset)
        osc.stop(offset + dur)

        offset += dur * 0.6   // slight overlap for a smooth chime
    }
}

/**
 * Map a notification type to a chime tone.
 */
function chimeForType(type) {
    if (['booking_cancelled', 'kyc_rejected'].includes(type))   return 'alert'
    if (['booking_accepted', 'kyc_approved', 'tier_upgraded'].includes(type)) return 'success'
    return 'default'
}

// ─────────────────────────────────────────────────────────────────────────────

export function useRealTimeNotifications() {
    const page    = usePage()
    const toast   = useToast()
    const { requestPermission, notifyFromPayload } = useBrowserNotifications()
    const { listenToUser, echo }                   = useEcho()
    const { initFcm, onForegroundMessage }         = useFcm()

    let stopFn = () => {}

    async function startListening() {
        const userId = page.props.auth?.user?.id
        if (!userId) return

        // Echo could not be constructed (missing env vars or already failed)
        if (!echo) {
            console.info('[Notifications] Real-time unavailable — Echo not initialised.')
            return
        }

        // Don't attempt to subscribe if the connection has already permanently failed
        if (connectionState.value === 'failed') {
            console.info('[Notifications] Real-time unavailable — WebSocket connection failed.')
            return
        }

        await requestPermission()

        stopFn = listenToUser(userId, (payload) => {
            // 1. Prepend to reactive bell list
            const notifications = page.props.unreadNotifications
            if (Array.isArray(notifications)) {
                notifications.unshift({
                    id:         payload.id,
                    type:       payload.type,
                    message:    payload.message,
                    booking_id: payload.data?.booking_id ?? null,
                    created_at: payload.created_at,
                })
                if (notifications.length > 10) notifications.splice(10)
            }

            // 2. Increment badge
            if (typeof page.props.unreadCount === 'number') {
                page.props.unreadCount += 1
            }

            // 3. Play chime 🔔
            playChime(chimeForType(payload.type))

            // 4. In-app toast
            const label     = TOAST_LABELS[payload.type] ?? '🔔 Notification'
            const toastType = resolveToastType(payload.type)
            toast[toastType](`${label}: ${payload.message}`, 6000)

            // 5. Browser notification when tab not focused
            notifyFromPayload(payload)
        })

        // ── Firebase Cloud Messaging (foreground handler) ──────────
        // FCM is best-effort — a push-service error (network block, bad VAPID
        // key, missing service worker) must not abort the Echo subscription
        // that is already running above.
        try {
            await initFcm()

            onForegroundMessage((payload) => {
                const { title, body } = payload.notification ?? {}
                const data = payload.data ?? {}

                // Re-use your existing toast + chime pipeline
                const type  = data.type ?? 'default'
                const label = TOAST_LABELS[type] ?? title ?? '🔔 Notification'
                toast.info(`${label}: ${body ?? ''}`, 6000)
                playChime(chimeForType(type))
            })
        } catch (err) {
            // AbortError  → browser push service unreachable (network / VAPID)
            // NotSupportedError → browser has no push support
            // Any other rejection from initFcm()
            console.warn('[Notifications] FCM init failed — foreground push disabled. Echo/WebSocket notifications are unaffected.', err)
        }
    }

    function stopListening() { stopFn() }

    onMounted(startListening)
    onBeforeUnmount(stopListening)

    return { startListening, stopListening }
}

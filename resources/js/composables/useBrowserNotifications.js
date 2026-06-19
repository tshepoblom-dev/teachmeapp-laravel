/**
 * useBrowserNotifications.js
 *
 * Thin composable around the Web Notifications API.
 *
 * Exports:
 *   supported          — ref<boolean>  browser supports Notification API
 *   permission         — ref<string>   current permission: 'default'|'granted'|'denied'
 *   permitted          — ref<boolean>  true when permission === 'granted'
 *   requestPermission  — async fn      call from a user-gesture handler
 *   notify             — fn            fire a native OS notification directly
 *   notifyFromPayload  — fn            fire from a NotificationBroadcast payload
 *
 * Usage:
 *   import { useBrowserNotifications } from '@/composables/useBrowserNotifications'
 *   const { permitted, requestPermission, notifyFromPayload } = useBrowserNotifications()
 *   await requestPermission()
 *   notifyFromPayload(payload)   // payload from Echo 'notification.new' event
 */

import { ref, computed } from 'vue'

// Module-level state — shared across all callers (singleton pattern)
const supported  = ref('Notification' in window)
const permission = ref(supported.value ? Notification.permission : 'denied')
const permitted  = computed(() => permission.value === 'granted')

// Human-readable titles for each notification type (mirrors TOAST_LABELS)
const TYPE_TITLES = {
  booking_accepted:  'Booking Accepted',
  booking_cancelled: 'Booking Cancelled',
  booking_completed: 'Session Completed',
  booking_request:   'New Booking Request',
  session_starting:  'Session Starting Soon',
  session_started:   'Session Started',
  session_ended:     'Session Ended',
  payment_received:  'Payment Received',
  payout_processed:  'Payout Processed',
  kyc_approved:      'KYC Approved',
  kyc_rejected:      'KYC Rejected',
  tier_upgraded:     'Tier Upgraded',
}

// ─────────────────────────────────────────────────────────────────────────────

/**
 * Request notification permission from the browser.
 * Must be called from a user-gesture handler (button click) to avoid
 * the browser silently ignoring the prompt.
 *
 * @returns {Promise<NotificationPermission>}
 */
async function requestPermission() {
  if (!supported.value) return 'denied'

  const result = await Notification.requestPermission()
  permission.value = result
  return result
}

/**
 * Fire a native OS notification with explicit title and options.
 *
 * @param {string} title
 * @param {object} [options]
 * @param {string}  [options.body]           Notification body text
 * @param {string}  [options.icon]           Icon URL (defaults to /favicon.ico)
 * @param {string}  [options.tag]            De-dupe tag
 * @param {boolean} [options.onlyWhenHidden] Only fire when tab is not visible
 * @returns {Notification|null}
 */
function notify(title, options = {}) {
  if (!supported.value || permission.value !== 'granted') return null

  const { onlyWhenHidden = false, body, icon = '/favicon.ico', tag } = options

  if (onlyWhenHidden && document.visibilityState === 'visible') return null

  const n = new Notification(title, { body, icon, tag })

  // Clicking focuses the tab
  n.onclick = () => {
    window.focus()
    n.close()
  }

  return n
}

/**
 * Fire a native OS notification from a raw NotificationBroadcast payload.
 *
 * The payload shape (from NotificationBroadcast::broadcastWith()):
 *   { id, type, data: { message?, title?, body?, booking_id?, … }, created_at, read_at }
 *
 * Only fires when the tab is not visible — in-app toasts handle the visible case.
 *
 * @param {object} payload  — raw Echo event payload
 */
function notifyFromPayload(payload) {
  if (!supported.value || permission.value !== 'granted') return
  if (document.visibilityState === 'visible') return

  const type  = payload?.type ?? ''
  const data  = payload?.data ?? {}

  // Resolve the title: prefer data.title, fall back to the type map, then generic
  const title = data.title ?? TYPE_TITLES[type] ?? '🔔 New Notification'

  // Resolve the body: prefer data.message, then data.body, then a short fallback
  const body  = data.message ?? data.body ?? ''

  // Use the notification type as a de-dupe tag so rapid duplicates collapse
  const tag   = `notif-${type}`

  notify(title, { body, tag, onlyWhenHidden: false })
}

// ─────────────────────────────────────────────────────────────────────────────

export function useBrowserNotifications() {
  return {
    supported,
    permission,
    permitted,
    requestPermission,
    notify,
    notifyFromPayload,
  }
}

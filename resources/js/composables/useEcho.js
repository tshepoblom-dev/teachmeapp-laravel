/**
 * useEcho.js — Singleton Laravel Echo / Pusher composable.
 *
 * Uses Pusher as the WebSocket driver (works on any shared hosting — no
 * persistent server process required). Falls back gracefully when credentials
 * are not configured.
 *
 * Environment variables required (set in .env, exposed via Vite):
 *   VITE_PUSHER_APP_KEY     — Pusher app key
 *   VITE_PUSHER_APP_CLUSTER — Pusher cluster (e.g. "mt1", "eu", "ap1")
 */

import { ref }   from 'vue'
import Echo      from 'laravel-echo'
import Pusher    from 'pusher-js'
// at the top of useEcho.js
import axios from 'axios'

// ─── Singleton state ──────────────────────────────────────────────────────────
let echoInstance = null

export const connectionState = ref('disconnected')

// ─── Environment guard ────────────────────────────────────────────────────────
function isConfigured() {
    const key     = import.meta.env.VITE_PUSHER_APP_KEY
    const cluster = import.meta.env.VITE_PUSHER_APP_CLUSTER
    return Boolean(key && cluster && key !== '' && cluster !== '')
}

// ─── Factory ──────────────────────────────────────────────────────────────────
function createEcho() {
    if (!isConfigured()) {
        console.info(
            '[Echo] VITE_PUSHER_APP_KEY or VITE_PUSHER_APP_CLUSTER not set — ' +
            'real-time features disabled.'
        )
        return null
    }

    window.Pusher = Pusher

    if (import.meta.env.PROD) {
        Pusher.logToConsole = false
    }

    // Read the CSRF token once at Echo construction time.
    // The meta tag is always present in the Inertia HTML shell.
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content') ?? ''

    const echo = new Echo({
        broadcaster:             'pusher',
        key:                     import.meta.env.VITE_PUSHER_APP_KEY,
        cluster:                 import.meta.env.VITE_PUSHER_APP_CLUSTER,
        forceTLS:                true,
        activityTimeout:         60_000,
        pongTimeout:             10_000,
        unavailableTimeout:      15_000,
        maxReconnectionAttempts: 5,

        // Custom authorizer so we control exactly what is sent to
        // /broadcasting/auth. Two things are required for a session-based
        // Inertia app:
        //   1. withCredentials: true  → browser sends the session cookie
        //   2. X-CSRF-TOKEN header    → Laravel's VerifyCsrfToken middleware
        // Without either of these the endpoint returns 403.
        authorizer: (channel) => ({
            authorize: (socketId, callback) => {
                axios.post(
                    '/broadcasting/auth',
                    { socket_id: socketId, channel_name: channel.name },
                    {
                        withCredentials: true,
                        headers: { 'X-CSRF-TOKEN': csrfToken },
                    },
                )
                .then(res  => callback(false, res.data))
                .catch(err => callback(true,  err))
            },
        }),
    })

    // ── Connection state tracking ─────────────────────────────────────────────
    const connector = echo.connector?.pusher
    if (connector) {
        connectionState.value = 'connecting'

        connector.connection.bind('connected',    () => { connectionState.value = 'connected' })
        connector.connection.bind('disconnected', () => { connectionState.value = 'disconnected' })
        connector.connection.bind('unavailable',  () => {
            connectionState.value = 'unavailable'
            console.warn('[Echo] WebSocket server unavailable — real-time updates paused.')
        })
        connector.connection.bind('failed', () => {
            connectionState.value = 'failed'
            console.warn('[Echo] WebSocket connection failed after max retries.')
        })
        connector.connection.bind('error', (err) => {
            if (connectionState.value !== 'failed') {
                console.warn('[Echo] WebSocket error:', err?.error?.data?.code ?? err)
            }
        })
    }

    return echo
}

// ─── Singleton accessor ───────────────────────────────────────────────────────
function getInstance() {
    if (!echoInstance) echoInstance = createEcho()
    return echoInstance
}

// ─── Helpers ──────────────────────────────────────────────────────────────────

function listenToSession(sessionId, event, callback) {
    const echo = getInstance()
    if (!echo) return () => {}

    const channel   = echo.private(`session.${sessionId}`)
    const eventName = event.startsWith('.') ? event : `.${event}`
    channel.listen(eventName, callback)

    return () => { channel.stopListening(eventName, callback) }
}

function listenToUser(userId, callback) {
    const echo = getInstance()
    if (!echo) return () => {}

    const channel = echo.private(`App.Models.User.${userId}`)
    channel.listen('.notification.new', callback)

    return () => { channel.stopListening('.notification.new', callback) }
}

function leaveSession(sessionId) {
    const echo = getInstance()
    if (!echo) return
    echo.leave(`session.${sessionId}`)
}

// ─── Public composable ────────────────────────────────────────────────────────

export function useEcho() {
    return {
        echo: getInstance(),
        connectionState,
        listenToSession,
        listenToUser,
        leaveSession,
    }
}

export function destroyEcho() {
    if (echoInstance) {
        echoInstance.disconnect()
        echoInstance = null
        connectionState.value = 'disconnected'
    }
}

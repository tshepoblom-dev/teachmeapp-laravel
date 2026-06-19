import { ref }        from 'vue'
import { getToken, onMessage } from 'firebase/messaging'
import { messaging }  from '@/firebase'
import axios          from 'axios'

const fcmToken  = ref(null)
const fcmReady  = ref(false)

const VAPID_KEY = import.meta.env.VITE_FIREBASE_VAPID_KEY

/**
 * Request permission, obtain the FCM registration token,
 * and save it to your Laravel backend (users.fcm_token).
 */
async function initFcm() {
  if (fcmReady.value) return fcmToken.value

  try {
    const permission = await Notification.requestPermission()
    if (permission !== 'granted') {
      console.info('[FCM] Notification permission denied.')
      return null
    }

    const token = await getToken(messaging, { vapidKey: VAPID_KEY })

    if (token) {
      fcmToken.value = token
      fcmReady.value = true

      // Persist to backend — hits your existing /api/fcm-token route (see Step 5)
      await axios.post('/api/fcm-token', { token })
      console.info('[FCM] Token registered:', token)
    } else {
      console.warn('[FCM] No token returned — check VAPID key and SW registration.')
    }

    return token
  } catch (err) {
    console.error('[FCM] Init error:', err)
    return null
  }
}

/**
 * Listen for foreground messages and call your handler.
 * Background messages are handled by the service worker.
 *
 * @param {(payload: object) => void} handler
 * @returns {() => void} unsubscribe function
 */
function onForegroundMessage(handler) {
  return onMessage(messaging, handler)
}

export function useFcm() {
  return { fcmToken, fcmReady, initFcm, onForegroundMessage }
}
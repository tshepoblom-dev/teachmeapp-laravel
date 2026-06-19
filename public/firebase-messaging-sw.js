self.addEventListener('install', () => self.skipWaiting())
self.addEventListener('activate', (e) => e.waitUntil(self.clients.claim()))
importScripts('/firebase-app-compat.js')
importScripts('/firebase-messaging-compat.js')
// public/firebase-messaging-sw.js
//importScripts('https://www.gstatic.com/firebasejs/10.12.0/firebase-app-compat.js')
//importScripts('https://www.gstatic.com/firebasejs/10.12.0/firebase-messaging-compat.js')
/*
firebase.initializeApp({
  apiKey:  'AIzaSyD2USA9rXIw-VJGArj1pn0LtYFXIXeTY08',
  authDomain: 'teachme-app-d5474.firebaseapp.com',
  projectId: 'teachme-app-d5474',
  storageBucket: 'teachme-app-d5474.firebasestorage.app',
  messagingSenderId: '941977571389',
  appId: '1:941977571389:web:77f0b97bc36563ae97da54',
})
*/
firebase.initializeApp({
  apiKey: 'AIzaSyD2USA9rXIw-VJGArj1pn0LtYFXIXeTY08',
  authDomain: 'teachme-app-d5474.firebaseapp.com',
  projectId: 'teachme-app-d5474',
  storageBucket: 'teachme-app-d5474.firebasestorage.app',
  messagingSenderId: '941977571389',
  appId: '1:941977571389:web:77f0b97bc36563ae97da54',
})

const messaging = firebase.messaging()

// Handle background push messages
messaging.onBackgroundMessage((payload) => {
  const { title, body, icon } = payload.notification ?? {}

  self.registration.showNotification(title ?? '🔔 New Notification', {
    body:  body  ?? '',
    icon:  icon  ?? '/favicon.ico',
    badge: '/favicon.ico',
    data:  payload.data ?? {},
  })
})

// Clicking the background notification focuses the app tab
self.addEventListener('notificationclick', (event) => {
  event.notification.close()
  event.waitUntil(
    clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientList) => {
      for (const client of clientList) {
        if ('focus' in client) return client.focus()
      }
      return clients.openWindow('/')
    })
  )
})
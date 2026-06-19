// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
import { getMessaging } from "firebase/messaging";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
/*
const firebaseConfig = {
  apiKey: "AIzaSyD2USA9rXIw-VJGArj1pn0LtYFXIXeTY08",
  authDomain: "teachme-app-d5474.firebaseapp.com",
  projectId: "teachme-app-d5474",
  storageBucket: "teachme-app-d5474.firebasestorage.app",
  messagingSenderId: "941977571389",
  appId: "1:941977571389:web:77f0b97bc36563ae97da54",
  measurementId: "G-H0WBQ597DD"
};
*/
const firebaseConfig = {
  apiKey:            import.meta.env.VITE_FIREBASE_API_KEY,
  authDomain:        import.meta.env.VITE_FIREBASE_AUTH_DOMAIN,
  projectId:         import.meta.env.VITE_FIREBASE_PROJECT_ID,
  storageBucket:     import.meta.env.VITE_FIREBASE_STORAGE_BUCKET,
  messagingSenderId: import.meta.env.VITE_FIREBASE_MESSAGING_SENDER_ID,
  appId:             import.meta.env.VITE_FIREBASE_APP_ID,
}
  
// Initialize Firebase
export const app = initializeApp(firebaseConfig);

// getAnalytics() throws in some browsers and with ad-blockers.
// Wrap it so a blocked analytics call never breaks the whole app.
let analytics = null;
try {
  analytics = getAnalytics(app);
} catch {
  // Analytics unavailable — safe to ignore
}
export { analytics };

export const messaging = getMessaging(app);

/*
import { initializeApp } from 'firebase/app'
import { getMessaging }  from 'firebase/messaging'

const firebaseConfig = {
  apiKey:            import.meta.env.VITE_FIREBASE_API_KEY,
  authDomain:        import.meta.env.VITE_FIREBASE_AUTH_DOMAIN,
  projectId:         import.meta.env.VITE_FIREBASE_PROJECT_ID,
  storageBucket:     import.meta.env.VITE_FIREBASE_STORAGE_BUCKET,
  messagingSenderId: import.meta.env.VITE_FIREBASE_MESSAGING_SENDER_ID,
  appId:             import.meta.env.VITE_FIREBASE_APP_ID,
}

export const app       = initializeApp(firebaseConfig)
export const messaging = getMessaging(app)
*/
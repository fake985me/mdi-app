// Jalankan dengan: node scripts/seedFirestore.js
// src/lib/firebaseConfig.js
import { initializeApp } from 'firebase/app'
import { getAuth } from 'firebase/auth'
import { getFirestore } from 'firebase/firestore'

const firebaseConfig = {
  apiKey: 'AIzaSyCpmQttP_xy3Btkr10DJ6riBbUQ3VFPjus',
  authDomain: 'moimstone-123.firebaseapp.com',
  projectId: 'moimstone-123',
  storageBucket: 'moimstone-123.firebasestorage.app',
  messagingSenderId: '380268904564',
  appId: '1:380268904564:web:23850f23d684e30e881121',
  measurementId: 'G-P1CBV7MZ4R',
}

export const firebaseApp = initializeApp(firebaseConfig)
export const auth = getAuth(firebaseApp)
export const db = getFirestore(firebaseApp)

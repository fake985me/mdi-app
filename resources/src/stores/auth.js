import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import {
  getAuth,
  signInWithEmailAndPassword,
  createUserWithEmailAndPassword,
  signOut,
  onAuthStateChanged,
} from 'firebase/auth'
import {
  getFirestore,
  doc,
  getDoc,
  setDoc,
  collection,
  query,
  where,
  getDocs,
} from 'firebase/firestore'
import { firebaseApp } from '@/lib/firebaseConfig' // Pastikan export firebaseApp dengan benar

// Inisialisasi Firebase Auth & Firestore
const auth = getAuth(firebaseApp)
const db = getFirestore(firebaseApp)

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const userProfile = ref(null)
  const loading = ref(false)
  const error = ref(null)

  const isAuthenticated = computed(() => !!user.value)
  const isSuperAdmin = computed(() => userProfile.value?.role?.name === 'super_admin')
  const isAdmin = computed(() => ['super_admin', 'admin'].includes(userProfile.value?.role?.name))

  // Login
  async function signIn(email, password) {
    loading.value = true
    error.value = null
    try {
      const userCredential = await signInWithEmailAndPassword(auth, email, password)
      user.value = userCredential.user
      await fetchUserProfile()
      return { success: true }
    } catch (err) {
      error.value = err.message
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  // Registrasi
  async function signUp(email, password, userData) {
    loading.value = true
    error.value = null
    try {
      const userCredential = await createUserWithEmailAndPassword(auth, email, password)
      user.value = userCredential.user

      // Ambil role default "user"
      const roleQuery = query(collection(db, 'user_roles'), where('name', '==', 'user'))
      const roleSnap = await getDocs(roleQuery)
      const roleDoc = roleSnap.docs[0]

      if (!roleDoc) {
        throw new Error('Role "user" tidak ditemukan')
      }

      // Simpan profil user di Firestore
      await setDoc(doc(db, 'users', user.value.uid), {
        ...userData,
        role_id: roleDoc.id,
        created_at: new Date().toISOString(),
      })

      await fetchUserProfile()

      return { success: true }
    } catch (err) {
      error.value = err.message
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  // Logout
  async function signOutUser() {
    loading.value = true
    error.value = null
    try {
      await signOut(auth)
      user.value = null
      userProfile.value = null
      return { success: true }
    } catch (err) {
      error.value = err.message
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  // Ambil data user profile
  async function fetchUserProfile() {
    if (!user.value) return
    try {
      const userDocRef = doc(db, 'users', user.value.uid)
      const userDoc = await getDoc(userDocRef)

      if (!userDoc.exists()) {
        console.warn('Dokumen user tidak ditemukan')
        return
      }

      const userData = userDoc.data()

      // Ambil data role
      if (userData?.role_id) {
        const roleDoc = await getDoc(doc(db, 'user_roles', userData.role_id))
        userData.role = roleDoc.exists() ? roleDoc.data() : null
      }

      userProfile.value = userData

      // Update last login (aman walau doc belum ada)
      await setDoc(
        userDocRef,
        {
          last_login: new Date().toISOString(),
        },
        { merge: true },
      )
    } catch (err) {
      console.error('Error fetching profile:', err)
    }
  }

  // Jalankan saat awal load
  async function initialize() {
    loading.value = true
    try {
      const currentUser = auth.currentUser
      if (currentUser) {
        user.value = currentUser
        await fetchUserProfile()
      }
    } catch (err) {
      console.error('Initialize error:', err)
    } finally {
      loading.value = false
    }
  }

  // Listener auth state
  onAuthStateChanged(auth, async (firebaseUser) => {
    if (firebaseUser) {
      user.value = firebaseUser
      await fetchUserProfile()
    } else {
      user.value = null
      userProfile.value = null
    }
  })

  return {
    user,
    userProfile,
    loading,
    error,
    isAuthenticated,
    isSuperAdmin,
    isAdmin,
    signIn,
    signUp,
    signOut: signOutUser,
    fetchUserProfile,
    initialize,
  }
})

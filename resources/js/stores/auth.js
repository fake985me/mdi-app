import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const profile = ref(null)
  const loading = ref(false)

  const isAuthenticated = computed(() => !!user.value)
  const isSuperadmin = computed(() => profile.value?.role === 'superadmin')

  // Set up base API URL 
  const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000'

  // Helper function to make API requests
  const apiRequest = async (endpoint, options = {}) => {
    const headers = {
      'Content-Type': 'application/json',
      ...options.headers
    }

    // Add authorization header if user is authenticated
    const token = localStorage.getItem('auth_token')
    if (token) {
      headers['Authorization'] = `Bearer ${token}`
    }

    const response = await fetch(`${API_BASE_URL}${endpoint}`, {
      ...options,
      headers
    })

    if (response.status === 401) {
      // Token might be expired, clear auth data
      localStorage.removeItem('auth_token')
      user.value = null
      profile.value = null
      // Optionally redirect to login
    }

    return response
  }

  const signIn = async (email, password) => {
    loading.value = true
    try {
      const response = await apiRequest('/api/login', {
        method: 'POST',
        body: JSON.stringify({ email, password })
      })

      const data = await response.json()

      if (!response.ok) {
        return { success: false, error: data.message || 'Login failed' }
      }

      // Store token
      localStorage.setItem('auth_token', data.token)
      user.value = data.user
      profile.value = data.profile

      return { success: true }
    } catch (error) {
      console.error('Sign in error:', error)
      return { success: false, error: error.message }
    } finally {
      loading.value = false
    }
  }

  const signUp = async (email, password, fullName) => {
    loading.value = true
    try {
      const response = await apiRequest('/api/register', {
        method: 'POST',
        body: JSON.stringify({ 
          name: fullName,
          email,
          password,
          password_confirmation: password // Laravel expects password_confirmation
        })
      })

      const data = await response.json()

      if (!response.ok) {
        return { success: false, error: data.message || 'Registration failed' }
      }

      // Store token
      localStorage.setItem('auth_token', data.token)
      user.value = data.user
      profile.value = data.profile

      return { success: true }
    } catch (error) {
      console.error('Sign up error:', error)
      return { success: false, error: error.message }
    } finally {
      loading.value = false
    }
  }

  const signOut = async () => {
    try {
      // Only call logout API if user is authenticated
      if (user.value) {
        await apiRequest('/api/logout', {
          method: 'POST'
        })
      }
    } catch (error) {
      console.error('Logout error:', error)
      // Continue with local cleanup even if API call fails
    } finally {
      // Clear local auth data
      localStorage.removeItem('auth_token')
      user.value = null
      profile.value = null
    }
    
    return { success: true }
  }

  const fetchProfile = async () => {
    if (!user.value) return

    try {
      const response = await apiRequest('/api/user')
      const data = await response.json()

      if (response.ok) {
        profile.value = data.profile
        user.value = data.user
      } else {
        console.error('Profile fetch error:', data.message)
      }
    } catch (error) {
      console.error('Fetch profile error:', error)
    }
  }

  const initialize = async () => {
    const token = localStorage.getItem('auth_token')
    if (!token) {
      // No token, user is not logged in
      return
    }

    try {
      const response = await apiRequest('/api/user')
      const data = await response.json()

      if (response.ok) {
        user.value = data.user
        profile.value = data.profile
      } else {
        // Token is invalid, clear it
        localStorage.removeItem('auth_token')
        user.value = null
        profile.value = null
      }
    } catch (error) {
      console.error('Auth initialization error:', error)
      // Clear invalid session data
      localStorage.removeItem('auth_token')
      user.value = null
      profile.value = null
    }
  }

  return {
    user,
    profile,
    loading,
    isAuthenticated,
    isSuperadmin,
    signIn,
    signUp,
    signOut,
    fetchProfile,
    initialize
  }
})
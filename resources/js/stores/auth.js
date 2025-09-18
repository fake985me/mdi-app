import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const profile = ref(null)
  const loading = ref(false)

  const isAuthenticated = computed(() => !!user.value)
  const isSuperadmin = computed(() => profile.value?.role === 'superadmin')

  const signIn = async (email, password) => {
    loading.value = true
    try {
      const { data, error } = await supabase.auth.signInWithPassword({
        email,
        password
      })
      if (error) throw error
      
      user.value = data.user
      await fetchProfile()
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
      const { data, error } = await supabase.auth.signUp({
        email,
        password
      })
      if (error) throw error

      if (data.user) {
        // Create profile
        const { error: profileError } = await supabase
          .from('profiles')
          .insert({
            user_id: data.user.id,
            email,
            full_name: fullName
          })
        if (profileError) {
          console.error('Profile creation error:', profileError)
          // Don't throw error for profile creation, user can still sign in
        }
      }

      return { success: true }
    } catch (error) {
      console.error('Sign up error:', error)
      return { success: false, error: error.message }
    } finally {
      loading.value = false
    }
  }

  const signOut = async () => {
    const { error } = await supabase.auth.signOut()
    if (!error) {
      user.value = null
      profile.value = null
    }
    return { success: !error, error: error?.message }
  }

  const fetchProfile = async () => {
    if (!user.value) return

    try {
    const { data, error } = await supabase
      .from('profiles')
      .select('*')
      .eq('user_id', user.value.id)
      .limit(1)

      if (!error && data && data.length > 0) {
        profile.value = data[0]
      } else if (error) {
        console.error('Profile fetch error:', error)
        // Create profile if it doesn't exist
        const { error: createError } = await supabase
          .from('profiles')
          .insert({
            user_id: user.value.id,
            email: user.value.email,
            full_name: user.value.user_metadata?.full_name || user.value.email
          })
        
        if (!createError) {
          // Fetch the newly created profile
          const { data: newData } = await supabase
            .from('profiles')
            .select('*')
            .eq('user_id', user.value.id)
            .limit(1)
          
          if (newData && newData.length > 0) {
            profile.value = newData[0]
          }
        }
      }
    } catch (error) {
      console.error('Fetch profile error:', error)
    }
  }

  const initialize = async () => {
    try {
      const { data: { user: authUser }, error } = await supabase.auth.getUser()
      if (error) {
        // Clear invalid session data
        await signOut()
      } else if (authUser) {
        user.value = authUser
        await fetchProfile()
      }
    } catch (error) {
      console.error('Auth initialization error:', error)
      // Clear invalid session data
      await signOut()
    }

    supabase.auth.onAuthStateChange(async (event, session) => {
      if (session?.user) {
        user.value = session.user
        await fetchProfile()
      } else {
        user.value = null
        profile.value = null
      }
    })
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
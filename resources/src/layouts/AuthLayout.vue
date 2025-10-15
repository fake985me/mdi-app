<template>
  <div class="auth-layout">
    <main>
      <header>
        <button @click="handleLogout">Sign Out</button>
      </header>
      <slot />
    </main>
  </div>
</template>

<script setup>
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()

const handleLogout = async () => {
  const result = await authStore.signOut()
  if (result.success) {
    // Redirect to the login page after successful logout
    router.push('/')
  } else {
    console.error('Logout failed:', result.error)
    // Handle logout error (e.g., show a notification or alert)
    alert('Logout failed: ' + result.error.message)
  }
}
</script>

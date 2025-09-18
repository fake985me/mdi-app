<template>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center">
    <div class="max-w-md w-full space-y-8">
      <div class="text-center">
        <div class="flex justify-center mb-4">
          <div class="w-16 h-16 bg-blue-600 rounded-lg flex items-center justify-center">
            <Package class="w-8 h-8 text-white" />
          </div>
        </div>
        <h2 class="text-3xl font-bold text-gray-900">Sign in to your account</h2>
        <p class="mt-2 text-sm text-gray-600">
          Don't have an account?
          <router-link to="/register" class="text-blue-600 hover:text-blue-500">
            Register here
          </router-link>
        </p>
      </div>

      <form @submit.prevent="handleLogin" class="mt-8 space-y-6">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">
            Email address
          </label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            placeholder="Enter your email"
          />
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">
            Password
          </label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            placeholder="Enter your password"
          />
        </div>

        <div v-if="error" class="bg-red-50 border border-red-200 rounded-md p-4">
          <div class="flex">
            <AlertCircle class="w-5 h-5 text-red-400 mr-2" />
            <p class="text-sm text-red-800">{{ error }}</p>
          </div>
        </div>

        <button
          type="submit"
          :disabled="authStore.loading"
          class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
        >
          <Loader2 v-if="authStore.loading" class="w-5 h-5 animate-spin" />
          <span v-else>Sign in</span>
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import { Package, AlertCircle, Loader2 } from 'lucide-vue-next'

const router = useRouter()
const authStore = useAuthStore()

const form = reactive({
  email: '',
  password: ''
})

const error = ref('')

const handleLogin = async () => {
  error.value = ''
  
  const result = await authStore.signIn(form.email, form.password)
  
  if (result.success) {
    router.push('/dashboard')
  } else {
    error.value = result.error
  }
}
</script>
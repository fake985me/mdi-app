<template>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center">
    <div class="max-w-md w-full space-y-8">
      <div class="text-center">
        <div class="flex justify-center mb-4">
          <div class="w-16 h-16 bg-blue-600 rounded-lg flex items-center justify-center">
            <Package class="w-8 h-8 text-white" />
          </div>
        </div>
        <h2 class="text-3xl font-bold text-gray-900">Create your account</h2>
        <p class="mt-2 text-sm text-gray-600">
          Already have an account?
          <router-link to="/login" class="text-blue-600 hover:text-blue-500">
            Sign in here
          </router-link>
        </p>
      </div>

      <form @submit.prevent="handleRegister" class="mt-8 space-y-6">
        <div>
          <label for="fullName" class="block text-sm font-medium text-gray-700">
            Full Name
          </label>
          <input
            id="fullName"
            v-model="form.fullName"
            type="text"
            required
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            placeholder="Enter your full name"
          />
        </div>

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

        <div v-if="success" class="bg-green-50 border border-green-200 rounded-md p-4">
          <div class="flex">
            <CheckCircle class="w-5 h-5 text-green-400 mr-2" />
            <p class="text-sm text-green-800">Account created successfully! Please sign in.</p>
          </div>
        </div>

        <button
          type="submit"
          :disabled="authStore.loading"
          class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
        >
          <Loader2 v-if="authStore.loading" class="w-5 h-5 animate-spin" />
          <span v-else>Create Account</span>
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useAuthStore } from '../../stores/auth'
import { Package, AlertCircle, CheckCircle, Loader2 } from 'lucide-vue-next'

const authStore = useAuthStore()

const form = reactive({
  fullName: '',
  email: '',
  password: ''
})

const error = ref('')
const success = ref(false)

const handleRegister = async () => {
  error.value = ''
  success.value = false
  
  const result = await authStore.signUp(form.email, form.password, form.fullName)
  
  if (result.success) {
    success.value = true
    form.fullName = ''
    form.email = ''
    form.password = ''
  } else {
    error.value = result.error
  }
}
</script>
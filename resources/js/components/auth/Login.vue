<template>
  <app-layout :app-name="appName">
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
      <div class="px-8 py-6 mt-4 text-left bg-white shadow-lg rounded-lg w-full max-w-md">
        <h3 class="text-2xl font-bold text-center">Login to your account</h3>
        <form @submit.prevent="login">
          <div class="mt-4">
            <div>
              <label class="block" for="email">Email</label>
              <input 
                v-model="form.email"
                type="email" 
                name="email" 
                placeholder="Email"
                class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                required
              >
              <span v-if="errors.email" class="text-xs text-red-600">{{ errors.email }}</span>
            </div>
            <div class="mt-4">
              <label class="block">Password</label>
              <input 
                v-model="form.password"
                type="password" 
                name="password" 
                placeholder="Password"
                class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                required
              >
              <span v-if="errors.password" class="text-xs text-red-600">{{ errors.password }}</span>
            </div>
            <div class="flex items-center justify-between mt-4">
              <button 
                type="submit"
                :disabled="loading"
                class="px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-900 disabled:opacity-50"
              >
                {{ loading ? 'Logging in...' : 'Login' }}
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '../layouts/AppLayout.vue';
import api from '../../services/api';

export default {
  name: 'Login',
  components: {
    AppLayout
  },
  data() {
    return {
      appName: 'Inventory Management System',
      loading: false,
      form: {
        email: '',
        password: ''
      },
      errors: {}
    };
  },
  methods: {
    async login() {
      this.loading = true;
      this.errors = {};
      
      try {
        const response = await api.login(this.form);
        
        // Store token and user data in localStorage
        localStorage.setItem('authToken', response.data.data.token);
        localStorage.setItem('user', JSON.stringify(response.data.data.user));
        
        // Redirect to dashboard using Vue Router
        this.$router.push('/dashboard');
      } catch (error) {
        // Handle login error
        console.error('Login error:', error);
        if (error.response?.data?.message) {
          this.errors = {
            email: error.response.data.message
          };
        } else {
          this.errors = {
            email: 'Invalid credentials'
          };
        }
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>
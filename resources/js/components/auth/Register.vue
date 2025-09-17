<template>
  <app-layout :app-name="appName">
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
      <div class="px-8 py-6 mt-4 text-left bg-white shadow-lg rounded-lg w-full max-w-md">
        <h3 class="text-2xl font-bold text-center">Create an account</h3>
        <form @submit.prevent="register">
          <div class="mt-4">
            <div>
              <label class="block" for="name">Name</label>
              <input 
                v-model="form.name"
                type="text" 
                name="name" 
                placeholder="Name"
                class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                required
              >
              <span v-if="errors.name" class="text-xs text-red-600">{{ errors.name }}</span>
            </div>
            <div class="mt-4">
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
            <div class="mt-4">
              <label class="block">Confirm Password</label>
              <input 
                v-model="form.password_confirmation"
                type="password" 
                name="password_confirmation" 
                placeholder="Confirm Password"
                class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                required
              >
            </div>
            <div class="flex items-center justify-between mt-4">
              <button 
                type="submit"
                :disabled="loading"
                class="px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-900 disabled:opacity-50"
              >
                {{ loading ? 'Registering...' : 'Register' }}
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
  name: 'Register',
  components: {
    AppLayout
  },
  data() {
    return {
      appName: 'Inventory Management System',
      loading: false,
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      },
      errors: {}
    };
  },
  methods: {
    async register() {
      this.loading = true;
      this.errors = {};
      
      try {
        // For registration, we would need a separate endpoint
        // For now, we'll redirect to login page
        this.$router.push('/login');
      } catch (error) {
        // Handle registration error
        console.error('Registration error:', error);
        this.errors = {
          email: 'This email is already registered'
        };
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>
<template>
  <app-layout :app-name="appName">
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
      <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Inventory Management System</h1>
        <p class="text-xl text-gray-600 mb-8">Efficient inventory and finance management solution</p>
        <div class="space-x-4">
          <router-link to="/landing" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Visit Landing Page</router-link>
          <template v-if="user">
            <router-link to="/dashboard" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">Go to Dashboard</router-link>
          </template>
          <template v-else>
            <router-link to="/login" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">Login</router-link>
          </template>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from './layouts/AppLayout.vue';

export default {
  name: 'Welcome',
  components: {
    AppLayout
  },
  data() {
    return {
      appName: 'Inventory Management System',
      user: null // This should be populated with actual user data
    };
  },
  mounted() {
    // Check if user is authenticated
    this.checkAuth();
  },
  methods: {
    checkAuth() {
      try {
        const userData = localStorage.getItem('user');
        if (userData) {
          this.user = JSON.parse(userData);
        }
      } catch (error) {
        console.error('Auth check error:', error);
        this.user = null;
      }
    }
  }
};
</script>
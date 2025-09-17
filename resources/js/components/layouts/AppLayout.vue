<template>
  <div class="min-h-screen bg-gray-100">
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ appName }}
        </h2>
        <nav class="flex space-x-4">
          <router-link to="/dashboard" class="text-gray-600 hover:text-gray-900">Dashboard</router-link>
          <router-link to="/products" class="text-gray-600 hover:text-gray-900">Products</router-link>
          <router-link to="/settings/web" class="text-gray-600 hover:text-gray-900">Web Settings</router-link>
          <template v-if="user">
            <a v-if="user.isSuperAdmin" href="#" class="text-gray-600 hover:text-gray-900">Super Admin</a>
            <a href="#" @click="logout" class="text-gray-600 hover:text-gray-900">Logout</a>
          </template>
          <template v-else>
            <router-link to="/login" class="text-gray-600 hover:text-gray-900">Login</router-link>
          </template>
        </nav>
      </div>
    </header>
    <main>
      <slot></slot>
    </main>
  </div>
</template>

<script>
import api from '../../services/api';

export default {
  name: 'AppLayout',
  props: {
    appName: {
      type: String,
      default: 'Inventory Management System'
    }
  },
  data() {
    return {
      user: null
    };
  },
  mounted() {
    this.checkAuth();
  },
  methods: {
    async checkAuth() {
      try {
        if (localStorage.getItem('authToken')) {
          const response = await api.getUser();
          this.user = response.data.data;
          localStorage.setItem('user', JSON.stringify(this.user));
        }
      } catch (error) {
        console.error('Auth check error:', error);
        localStorage.removeItem('authToken');
        localStorage.removeItem('user');
        this.user = null;
      }
    },
    async logout() {
      try {
        await api.logout();
      } catch (error) {
        console.error('Logout error:', error);
      } finally {
        localStorage.removeItem('authToken');
        localStorage.removeItem('user');
        this.user = null;
        this.$router.push('/login');
      }
    }
  }
};
</script>
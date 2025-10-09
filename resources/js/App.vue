<template>
  <div id="app">
    <nav class="bg-gray-800 text-white p-4">
      <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center">
          <h1 class="text-xl font-bold">Warehouse & Finance Management</h1>
        </div>
        <div class="flex items-center space-x-4">
          <button @click="switchLanguage('en')" class="px-3 py-1 rounded bg-blue-600 hover:bg-blue-700">EN</button>
          <button @click="switchLanguage('id')" class="px-3 py-1 rounded bg-blue-600 hover:bg-blue-700">ID</button>
          <div v-if="user" class="relative">
            <button @click="showUserMenu = !showUserMenu" class="flex items-center space-x-2">
              <span>{{ user.name }}</span>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <div v-if="showUserMenu" class="absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-md shadow-lg py-1 z-50">
              <a href="#" @click.prevent="logout" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <div class="container mx-auto mt-4">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
  name: 'App',
  setup() {
    const { locale } = useI18n();
    const router = useRouter();
    const showUserMenu = ref(false);
    const user = ref(null);

    const switchLanguage = (lang) => {
      locale.value = lang;
      // Set the locale in local storage
      localStorage.setItem('locale', lang);
      // Set the locale in the API request header
      axios.defaults.headers.common['Accept-Language'] = lang;
    };

    const logout = async () => {
      try {
        await axios.post('/api/logout', {}, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
      } catch (error) {
        console.error('Logout error:', error);
      } finally {
        // Remove token and user data
        localStorage.removeItem('token');
        user.value = null;
        router.push('/login');
      }
    };

    onMounted(() => {
      // Set the language from localStorage or default to 'en'
      const savedLocale = localStorage.getItem('locale') || 'en';
      locale.value = savedLocale;
      axios.defaults.headers.common['Accept-Language'] = savedLocale;
      
      // Get user data if token exists
      const token = localStorage.getItem('token');
      if (token) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        // Fetch user data
        axios.get('/api/user', {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        })
        .then(response => {
          user.value = response.data;
        })
        .catch(error => {
          console.error('Error fetching user data:', error);
          // If there's an error, clear the token
          localStorage.removeItem('token');
          router.push('/login');
        });
      }
    });

    return {
      locale,
      showUserMenu,
      user,
      switchLanguage,
      logout
    };
  }
};
</script>
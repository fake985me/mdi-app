<template>
  <header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center">
          <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                aria-hidden="true"
                class="w-24 h-20"
                viewBox="0 0 2 2"
              >
                <path
                  fill="#3636e0"
                  d="M.892 1.548H.678v-.296q0-.034-.008-.047t-.027-.013q-.036 0-.036.061v.296H.394v-.296q0-.034-.008-.047t-.027-.014q-.036 0-.036.061v.296H.11V1.21q0-.092.064-.157T.331.988q.095 0 .17.077Q.585.988.669.988q.107 0 .172.075.051.058.051.17zM1.374.8h.214v.458q0 .126-.069.205-.04.046-.1.073t-.125.027q-.128 0-.215-.083t-.088-.202q0-.116.087-.201t.206-.085l.057.003v.227q-.026-.02-.053-.02-.033 0-.057.023t-.024.056q0 .032.024.055t.059.023q.082 0 .082-.11zm.578.199v.549h-.214V.999zM1.926.786q-.032-.03-.075-.03t-.075.03-.032.07q0 .014.003.026l.006.016q.007.016.021.028.03.028.077.028c.047 0 .057-.009.077-.028q.014-.013.021-.029l.002-.005q.006-.017.006-.037 0-.04-.032-.07m.065.016Q1.973.754 1.928.729T1.834.717q-.046.011-.068.048L1.763.77l-.001.002q.02-.036.066-.045.048-.01.092.014t.064.069q.017.042.001.077.021-.04.004-.087m.043-.02Q2.011.722 1.955.692c-.056-.03-.076-.025-.116-.015q-.056.014-.083.058l-.004.006-.001.002Q1.775.7 1.832.689q.058-.012.114.018t.078.085q.021.051.002.094.025-.049.004-.106"
                />
              </svg>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center space-x-8">
          <template v-for="item in navigationItems" :key="item.id">
            <a
              v-if="item.path.startsWith('http') || item.path.startsWith('/')"
              :href="item.path"
              class="text-gray-700 hover:text-blue-600 transition-colors"
            >
              {{ item.name }}
            </a>
            <router-link
              v-else
              :to="item.path"
              class="text-gray-700 hover:text-blue-600 transition-colors"
            >
              {{ item.name }}
            </router-link>
          </template>
          <LanguageSelector />
          <div v-if="!authStore.isAuthenticated" class="flex items-center space-x-4">
            <router-link
              to="/login"
              class="text-gray-700 hover:text-blue-600 transition-colors"
            >
              {{ t('login') }}
            </router-link>
            <router-link
              to="/register"
              class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors"
            >
              {{ t('register') }}
            </router-link>
          </div>
          <div v-else class="flex items-center space-x-4">
            <router-link
              to="/dashboard"
              class="text-gray-700 hover:text-blue-600 transition-colors"
            >
              {{ t('dashboard') }}
            </router-link>
            <div class="flex items-center space-x-2">
              <span class="text-sm text-gray-600">{{ authStore.profile?.full_name }}</span>
              <button
                @click="handleLogout"
                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors"
              >
                {{ t('logout') }}
              </button>
            </div>
          </div>
        </div>

        <!-- Mobile Menu Button -->
        <div class="md:hidden flex items-center space-x-2">
          <LanguageSelector />
          <button
            @click="showMobileMenu = !showMobileMenu"
            class="p-2 text-gray-600 hover:text-gray-900"
          >
            <Menu v-if="!showMobileMenu" class="w-6 h-6" />
            <X v-else class="w-6 h-6" />
          </button>
        </div>
      </div>

      <!-- Mobile Navigation -->
      <div
        v-if="showMobileMenu"
        class="md:hidden border-t border-gray-200 py-4"
      >
        <div class="space-y-4">
          <template v-for="item in navigationItems" :key="item.id">
            <a
              v-if="item.path.startsWith('http') || item.path.startsWith('/')"
              :href="item.path"
              class="block text-gray-700 hover:text-blue-600 transition-colors"
              @click="showMobileMenu = false"
            >
              {{ item.name }}
            </a>
            <router-link
              v-else
              :to="item.path"
              class="block text-gray-700 hover:text-blue-600 transition-colors"
              @click="showMobileMenu = false"
            >
              {{ item.name }}
            </router-link>
          </template>
          <div v-if="!authStore.isAuthenticated" class="pt-4 border-t border-gray-200 space-y-2">
            <router-link
              to="/login"
              class="block text-gray-700 hover:text-blue-600 transition-colors"
              @click="showMobileMenu = false"
            >
              {{ t('login') }}
            </router-link>
            <router-link
              to="/register"
              class="block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-center"
              @click="showMobileMenu = false"
            >
              {{ t('register') }}
            </router-link>
          </div>
          <div v-else class="pt-4 border-t border-gray-200 space-y-2">
            <div class="text-sm text-gray-600 px-4">
              {{ t('welcome') }}, {{ authStore.profile?.full_name }}
            </div>
            <router-link
              to="/dashboard"
              class="block text-gray-700 hover:text-blue-600 transition-colors"
              @click="showMobileMenu = false"
            >
              {{ t('dashboard') }}
            </router-link>
            <button
              @click="handleLogout"
              class="block w-full text-left bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors"
            >
              {{ t('logout') }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import { useLanguage } from '../composables/useLanguage';
import LanguageSelector from './LanguageSelector.vue';
import { Package, Menu, X } from 'lucide-vue-next';

const { t } = useLanguage();
const router = useRouter();
const authStore = useAuthStore();
const showMobileMenu = ref(false);
const navigationItems = ref([]);

onMounted(async () => {
  try {
    // Fetch public navigation items
    const response = await fetch('/api/public/navigation');
    
    // Check content type to determine if response is JSON
    const contentType = response.headers.get('content-type');
    
    // Get response as text first
    const responseText = await response.text();
    
    // If response is OK and content type indicates JSON, then parse it
    if (response.ok && contentType && contentType.includes('application/json')) {
      const data = JSON.parse(responseText);
      navigationItems.value = data.data || [];
    } else if (!response.ok) {
      // If response is not OK, try to parse as JSON but handle failure gracefully
      try {
        const errorData = JSON.parse(responseText);
        console.error('Failed to fetch navigation:', errorData.message || 'Failed to fetch navigation');
      } catch (jsonError) {
        // If error response is not JSON (e.g., HTML error page), provide a generic message
        console.error('API returned non-JSON error response:', responseText.substring(0, 200) + '...');
        console.error(`Server error: ${response.status} - ${response.statusText}`);
      }
    } else {
      // If response is OK but not JSON, it's unexpected
      console.error('API returned non-JSON response when JSON was expected:', responseText.substring(0, 200) + '...');
      console.error('Server returned unexpected response format');
    }
  } catch (error) {
    console.error('Error fetching navigation:', error);
  }
});

const handleLogout = async () => {
  await authStore.signOut();
  showMobileMenu.value = false;
  router.push('/');
};
</script>

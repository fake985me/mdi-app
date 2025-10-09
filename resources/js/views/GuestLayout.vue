<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Guest navbar -->
    <nav class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <div class="flex-shrink-0 flex items-center">
              <span class="text-xl font-bold text-gray-800">{{ settings.navbar_title || 'Warehouse & Finance' }}</span>
            </div>
            <div class="hidden md:ml-6 md:flex md:space-x-8">
              <a href="/" class="border-indigo-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                {{ t('home') }}
              </a>
              <a href="/products" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                {{ t('products') }}
              </a>
              <a href="/about" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                {{ t('about') }}
              </a>
              <a href="/contact" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                {{ t('contact') }}
              </a>
            </div>
          </div>
          <div class="flex items-center">
            <button 
              @click="switchLanguage('en')" 
              class="px-3 py-1 rounded mr-2"
              :class="locale === 'en' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700'"
            >
              EN
            </button>
            <button 
              @click="switchLanguage('id')" 
              class="px-3 py-1 rounded"
              :class="locale === 'id' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700'"
            >
              ID
            </button>
            <router-link 
              to="/login" 
              class="ml-4 px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"
            >
              {{ t('login') }}
            </router-link>
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero section -->
    <div class="relative bg-white overflow-hidden">
      <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
          <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
            <div class="sm:text-center lg:text-left">
              <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                <span class="block xl:inline">{{ settings.hero_title || t('hero_title') }}</span>
              </h1>
              <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                {{ settings.hero_description || t('hero_description') }}
              </p>
              <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                <div class="rounded-md shadow">
                  <a href="/products" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                    {{ t('view_products') }}
                  </a>
                </div>
                <div class="mt-3 sm:mt-0 sm:ml-3">
                  <a href="/contact" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10">
                    {{ t('contact_us') }}
                  </a>
                </div>
              </div>
            </div>
          </main>
        </div>
      </div>
    </div>

    <!-- Features section -->
    <div class="py-12 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center">
          <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">{{ t('features') }}</h2>
          <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
            {{ settings.features_title || t('why_our_products') }}
          </p>
          <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
            {{ settings.features_description || t('features_description') }}
          </p>
        </div>

        <div class="mt-10">
          <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
            <div class="relative">
              <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <div class="ml-16">
                <h3 class="text-lg font-medium text-gray-900">{{ settings.feature1_title || t('feature1_title') }}</h3>
                <p class="mt-2 text-base text-gray-500">
                  {{ settings.feature1_description || t('feature1_description') }}
                </p>
              </div>
            </div>

            <div class="relative">
              <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-16">
                <h3 class="text-lg font-medium text-gray-900">{{ settings.feature2_title || t('feature2_title') }}</h3>
                <p class="mt-2 text-base text-gray-500">
                  {{ settings.feature2_description || t('feature2_description') }}
                </p>
              </div>
            </div>

            <div class="relative">
              <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
              </div>
              <div class="ml-16">
                <h3 class="text-lg font-medium text-gray-900">{{ settings.feature3_title || t('feature3_title') }}</h3>
                <p class="mt-2 text-base text-gray-500">
                  {{ settings.feature3_description || t('feature3_description') }}
                </p>
              </div>
            </div>

            <div class="relative">
              <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
              </div>
              <div class="ml-16">
                <h3 class="text-lg font-medium text-gray-900">{{ settings.feature4_title || t('feature4_title') }}</h3>
                <p class="mt-2 text-base text-gray-500">
                  {{ settings.feature4_description || t('feature4_description') }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Products section -->
    <div class="bg-gray-50">
      <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
        <div class="lg:text-center">
          <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">{{ t('products') }}</h2>
          <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
            {{ settings.products_title || t('featured_products') }}
          </p>
          <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
            {{ settings.products_description || t('featured_products_description') }}
          </p>
        </div>

        <div class="mt-10" v-if="items.length > 0">
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <div 
              v-for="item in items" 
              :key="item.id"
              class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300"
            >
              <div class="h-48 flex items-center justify-center bg-gray-100">
                <img 
                  v-if="item.images && item.images.length > 0" 
                  :src="`/storage/${item.images[0].image_path}`" 
                  :alt="item.name"
                  class="h-full w-full object-contain"
                />
                <div v-else class="text-gray-500 p-4">
                  {{ t('no_image') }}
                </div>
              </div>
              <div class="p-4">
                <h3 class="text-lg font-medium text-gray-900">{{ item.name }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ item.category?.name }}</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">Rp {{ item.price?.toLocaleString() || '0' }}</p>
                <div class="mt-4 flex justify-between">
                  <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    {{ t('stock') }}: {{ item.current_stock || 0 }}
                  </span>
                  <button class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    {{ t('view_details') }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-else class="text-center py-10 text-gray-500">
          {{ t('no_products_available') }}
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white">
      <div class="max-w-7xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
        <div class="mt-8 flex justify-center space-x-6">
          <a href="#" class="text-gray-400 hover:text-gray-500">
            <span class="sr-only">Facebook</span>
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
            </svg>
          </a>
          <a href="#" class="text-gray-400 hover:text-gray-500">
            <span class="sr-only">Instagram</span>
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
            </svg>
          </a>
          <a href="#" class="text-gray-400 hover:text-gray-500">
            <span class="sr-only">Twitter</span>
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
            </svg>
          </a>
        </div>
        <p class="mt-8 text-center text-base text-gray-400">
          &copy; {{ new Date().getFullYear() }} {{ settings.company_name || 'Company Name' }}. {{ t('all_rights_reserved') }}.
        </p>
      </div>
    </footer>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import axios from 'axios';

export default {
  name: 'GuestLayout',
  setup() {
    const { t, locale } = useI18n();
    const settings = ref({});
    const items = ref([]);

    const fetchSettings = async () => {
      try {
        const response = await axios.get('/api/guest/settings');
        settings.value = response.data;
      } catch (error) {
        console.error('Error fetching settings:', error);
        // Default settings
        settings.value = {
          navbar_title: 'Warehouse & Finance',
          hero_title: 'Manage your warehouse efficiently',
          hero_description: 'Our platform helps you manage inventory, sales, and finances with ease.',
          features_title: 'Why Our Products',
          features_description: 'We provide the best tools for warehouse and finance management.',
          feature1_title: 'Inventory Management',
          feature1_description: 'Track all your inventory in real-time with our intuitive dashboard.',
          feature2_title: 'Financial Tracking',
          feature2_description: 'Monitor your finances with detailed reports and analytics.',
          feature3_title: 'Easy to Use',
          feature3_description: 'Our platform is designed with the user in mind for maximum efficiency.',
          feature4_title: 'Secure',
          feature4_description: 'Your data is protected with enterprise-grade security features.',
          products_title: 'Featured Products',
          products_description: 'Check out our featured products below.',
          company_name: 'Company Name'
        };
      }
    };

    const fetchItems = async () => {
      try {
        const response = await axios.get('/api/guest/items');
        items.value = response.data.data || [];
        
        // Add current_stock property to each item
        for (const item of items.value) {
          try {
            const stockResponse = await axios.get(`/api/stock-movements/${item.id}`);
            item.current_stock = stockResponse.data.current_stock || 0;
          } catch (stockError) {
            console.error(`Error fetching stock for item ${item.id}:`, stockError);
            item.current_stock = 0;
          }
        }
      } catch (error) {
        console.error('Error fetching items:', error);
      }
    };

    const switchLanguage = (lang) => {
      locale.value = lang;
      // Set the locale in local storage
      localStorage.setItem('locale', lang);
    };

    onMounted(() => {
      fetchSettings();
      fetchItems();
    });

    return {
      t,
      locale,
      settings,
      items,
      switchLanguage
    };
  }
};
</script>
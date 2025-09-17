<template>
  <app-layout :app-name="appName">
    <div class="container mx-auto px-4 py-8">
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ webSettings.home_hero_title }}</h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          {{ webSettings.home_hero_description }}
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="(feature, index) in webSettings.home_features" :key="index" class="bg-white rounded-lg shadow-md p-6">
          <div class="text-blue-600 text-4xl mb-4">
            <i :class="feature.icon"></i>
          </div>
          <h3 class="text-xl font-semibold mb-2">{{ feature.title }}</h3>
          <p class="text-gray-600">
            {{ feature.description }}
          </p>
        </div>
      </div>

      <div v-if="products && products.length > 0" class="mt-12">
        <h2 class="text-2xl font-bold text-center mb-8">Featured Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="product in products" :key="product.id" class="bg-white rounded-lg shadow-md overflow-hidden">
            <div v-if="product.image" class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-48 flex items-center justify-center">
              <span class="text-gray-500">No Image</span>
            </div>
            <div class="p-4">
              <h3 class="text-lg font-semibold">{{ product.name }}</h3>
              <p class="text-gray-600 text-sm mt-1">{{ product.category?.name || 'Uncategorized' }}</p>
              <p class="text-gray-800 font-bold mt-2">${{ product.price?.toFixed(2) || '0.00' }}</p>
              <p class="text-gray-600 text-sm mt-2">{{ product.description?.substring(0, 100) }}...</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from './layouts/AppLayout.vue';
import api from '../services/api';

export default {
  name: 'Landing',
  components: {
    AppLayout
  },
  data() {
    return {
      appName: 'Inventory Management System',
      webSettings: {
        home_hero_title: 'Welcome to Our Inventory Management System',
        home_hero_description: 'Efficiently manage your inventory, track stock levels, and monitor sales with our comprehensive solution.',
        home_features: [
          {
            title: 'Inventory Tracking',
            description: 'Keep track of all your products with real-time inventory updates and alerts.',
            icon: 'fas fa-boxes'
          },
          {
            title: 'Sales Analytics',
            description: 'Monitor your sales performance with detailed reports and insightful charts.',
            icon: 'fas fa-chart-line'
          },
          {
            title: 'Stock Movements',
            description: 'Track all stock movements including purchases, sales, and transfers.',
            icon: 'fas fa-sync-alt'
          }
        ]
      },
      products: []
    };
  },
  mounted() {
    // Fetch web settings
    this.fetchWebSettings();
    // Fetch featured products from API
    this.fetchFeaturedProducts();
  },
  methods: {
    async fetchWebSettings() {
      try {
        const response = await api.getWebSettings();
        const settings = response.data.data;
        
        // Check if settings is defined
        if (!settings) {
          console.error('Web settings data is undefined');
          return;
        }
        
        // Update webSettings with fetched data
        this.webSettings.home_hero_title = settings.home_hero_title || this.webSettings.home_hero_title;
        this.webSettings.home_hero_description = settings.home_hero_description || this.webSettings.home_hero_description;
        this.webSettings.home_features = Array.isArray(settings.home_features) ? settings.home_features : this.webSettings.home_features;
      } catch (error) {
        console.error('Web settings fetch error:', error);
      }
    },
    async fetchFeaturedProducts() {
      try {
        // In a real application, you would fetch featured products from the API
        // For now, we'll simulate this with a timeout
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Example product data - in a real app this would come from an API
        this.products = [
          {
            id: 1,
            name: 'Laptop',
            price: 999.99,
            description: 'High-performance laptop for professionals',
            category: { name: 'Electronics' }
          },
          {
            id: 2,
            name: 'Desk Chair',
            price: 199.99,
            description: 'Ergonomic office chair for comfort',
            category: { name: 'Furniture' }
          },
          {
            id: 3,
            name: 'Coffee Maker',
            price: 89.99,
            description: 'Automatic drip coffee maker',
            category: { name: 'Appliances' }
          }
        ];
      } catch (error) {
        console.error('Featured products fetch error:', error);
        this.products = [];
      }
    }
  }
};
</script>
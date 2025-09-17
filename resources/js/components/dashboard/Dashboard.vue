<template>
  <app-layout :app-name="appName">
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Stock overview card -->
        <div class="bg-white rounded-lg shadow-md p-6">
          <h2 class="text-xl font-semibold mb-4">Stock Overview</h2>
          <p class="text-gray-600">Total Products: {{ stats.totalProducts }}</p>
          <p class="text-gray-600">Low Stock Items: {{ stats.lowStockItems }}</p>
          <p class="text-gray-600">Out of Stock Items: {{ stats.outOfStockItems }}</p>
        </div>
        
        <!-- Sales overview card -->
        <div class="bg-white rounded-lg shadow-md p-6">
          <h2 class="text-xl font-semibold mb-4">Categories & Brands</h2>
          <p class="text-gray-600">Total Categories: {{ stats.totalCategories }}</p>
          <p class="text-gray-600">Total Brands: {{ stats.totalBrands }}</p>
        </div>
        
        <!-- Recent activity card -->
        <div class="bg-white rounded-lg shadow-md p-6">
          <h2 class="text-xl font-semibold mb-4">Recent Products</h2>
          <p class="text-gray-600" v-if="!recentProducts || recentProducts.length === 0">No recent products</p>
          <ul v-else>
            <li v-for="product in recentProducts" :key="product.id" class="mb-2">
              {{ product.name }} - {{ product.sku }}
            </li>
          </ul>
        </div>
      </div>
      
      <!-- Charts will be added here -->
      <div class="mt-8">
        <h2 class="text-2xl font-bold mb-4">Charts</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Stock Levels (Candlestick Chart)</h3>
            <div class="h-64 flex items-center justify-center bg-gray-100 rounded">
              <p class="text-gray-500">Candlestick chart will be displayed here</p>
            </div>
          </div>
          
          <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Top Selling Products (Pie Chart)</h3>
            <div class="h-64 flex items-center justify-center bg-gray-100 rounded">
              <p class="text-gray-500">Pie chart will be displayed here</p>
            </div>
          </div>
          
          <div class="bg-white rounded-lg shadow-md p-6 lg:col-span-2">
            <h3 class="text-lg font-semibold mb-4">Sales Trend (Line Chart)</h3>
            <div class="h-64 flex items-center justify-center bg-gray-100 rounded">
              <p class="text-gray-500">Line chart will be displayed here</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '../layouts/AppLayout.vue';
import api from '../../services/api';

export default {
  name: 'Dashboard',
  components: {
    AppLayout
  },
  data() {
    return {
      appName: 'Inventory Management System',
      stats: {
        totalProducts: 0,
        lowStockItems: 0,
        outOfStockItems: 0,
        totalCategories: 0,
        totalBrands: 0
      },
      recentProducts: []
    };
  },
  mounted() {
    // Fetch dashboard data from API
    this.fetchDashboardData();
  },
  methods: {
    async fetchDashboardData() {
      try {
        const response = await api.getDashboardData();
        this.stats = response.data.data.stats;
        this.recentProducts = response.data.data.recentProducts;
      } catch (error) {
        console.error('Dashboard data fetch error:', error);
      }
    }
  }
};
</script>
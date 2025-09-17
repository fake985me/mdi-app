<template>
  <app-layout :app-name="appName">
    <div class="container mx-auto px-4 py-8">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ product?.name || 'Product Details' }}</h1>
        <div class="space-x-2">
          <router-link :to="`/products/${product?.id}/edit`" 
             class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Edit Product
          </router-link>
          <router-link to="/products" 
             class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back to Products
          </router-link>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="md:flex">
          <div class="md:flex-shrink-0 md:w-1/3 p-6">
            <div v-if="product?.image" class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-64 flex items-center justify-center">
              <span class="text-gray-500">No Image</span>
            </div>
            <div v-else class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-64 flex items-center justify-center">
              <span class="text-gray-500">No Image</span>
            </div>
          </div>
          <div class="p-6 md:w-2/3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <h3 class="text-lg font-semibold text-gray-700">SKU</h3>
                <p class="text-gray-900">{{ product?.sku || 'N/A' }}</p>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-gray-700">Price</h3>
                <p class="text-gray-900">${{ product?.price?.toFixed(2) || '0.00' }}</p>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-gray-700">Category</h3>
                <p class="text-gray-900">{{ product?.category?.name || 'N/A' }}</p>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-gray-700">Subcategory</h3>
                <p class="text-gray-900">{{ product?.subcategory?.name || 'N/A' }}</p>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-gray-700">Brand</h3>
                <p class="text-gray-900">{{ product?.brand?.name || 'N/A' }}</p>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-gray-700">Stock Quantity</h3>
                <p class="text-gray-900">{{ product?.stock_quantity || 0 }}</p>
              </div>
            </div>

            <div class="mt-6">
              <h3 class="text-lg font-semibold text-gray-700">Description</h3>
              <p class="text-gray-900 mt-2">{{ product?.description || 'No description provided.' }}</p>
            </div>

            <div v-if="product?.specifications" class="mt-6">
              <h3 class="text-lg font-semibold text-gray-700">Specifications</h3>
              <div class="mt-2">
                <div v-for="(value, key) in product.specifications" :key="key" class="flex justify-between border-b border-gray-200 py-2">
                  <span class="text-gray-600">{{ formatSpecKey(key) }}</span>
                  <span class="text-gray-900">{{ value }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-8 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold mb-4">Product Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <a href="#" class="bg-blue-100 hover:bg-blue-200 text-blue-800 font-bold py-3 px-4 rounded text-center">
            Add Stock
          </a>
          <a href="#" class="bg-green-100 hover:bg-green-200 text-green-800 font-bold py-3 px-4 rounded text-center">
            Sell Product
          </a>
          <a href="#" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-800 font-bold py-3 px-4 rounded text-center">
            Borrow Product
          </a>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '../layouts/AppLayout.vue';
import api from '../../services/api';

export default {
  name: 'ProductDetail',
  components: {
    AppLayout
  },
  data() {
    return {
      appName: 'Inventory Management System',
      product: null
    };
  },
  mounted() {
    // Fetch product data from API
    this.fetchProduct();
  },
  methods: {
    async fetchProduct() {
      try {
        const productId = this.$route.params.id;
        const response = await api.getProduct(productId);
        this.product = response.data.data;
      } catch (error) {
        console.error('Product fetch error:', error);
      }
    },
    formatSpecKey(key) {
      return key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    }
  }
};
</script>
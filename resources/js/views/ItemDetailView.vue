<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">{{ item.name }}</h1>
      <div>
        <router-link 
          :to="{ name: 'ItemEdit', params: { id: item.id } }" 
          class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2"
        >
          {{ t('edit') }}
        </router-link>
        <router-link 
          :to="{ name: 'Items' }" 
          class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
        >
          {{ t('back') }}
        </router-link>
      </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <div class="lg:col-span-2">
        <!-- Image Gallery -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
          <h2 class="text-xl font-semibold mb-4">{{ t('images') }}</h2>
          
          <div v-if="item.images && item.images.length > 0" class="mb-4">
            <div class="flex justify-center mb-4">
              <img 
                :src="`/storage/${currentImage.image_path}`" 
                :alt="item.name"
                class="max-h-96 object-contain"
              />
            </div>
            
            <div class="grid grid-cols-5 gap-2">
              <div 
                v-for="(image, index) in item.images" 
                :key="index"
                :class="{
                  'border-2 border-blue-500 rounded cursor-pointer': currentImage.image_path === image.image_path,
                  'border border-gray-300 rounded cursor-pointer': currentImage.image_path !== image.image_path
                }"
                @click="currentImage = image"
              >
                <img 
                  :src="`/storage/${image.image_path}`" 
                  :alt="item.name"
                  class="w-full h-20 object-cover rounded"
                />
              </div>
            </div>
          </div>
          <div v-else class="text-center py-10 text-gray-500">
            {{ t('no_images_available') }}
          </div>
        </div>
        
        <!-- Specifications -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
          <h2 class="text-xl font-semibold mb-4">{{ t('specifications') }}</h2>
          
          <div v-if="item.specifications && Object.keys(item.specifications).length > 0">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div 
                v-for="(value, key) in item.specifications" 
                :key="key"
                class="border-b border-gray-200 pb-2"
              >
                <span class="font-medium">{{ formatSpecName(key) }}:</span> {{ value }}
              </div>
            </div>
          </div>
          <div v-else class="text-gray-500">
            {{ t('no_specifications') }}
          </div>
        </div>
      </div>
      
      <div>
        <!-- Item Details -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
          <h2 class="text-xl font-semibold mb-4">{{ t('details') }}</h2>
          
          <div class="space-y-3">
            <div>
              <span class="font-medium">{{ t('item_code') }}:</span> {{ item.code }}
            </div>
            <div>
              <span class="font-medium">{{ t('name') }}:</span> {{ item.name }}
            </div>
            <div>
              <span class="font-medium">{{ t('category') }}:</span> {{ item.category?.name }}
            </div>
            <div>
              <span class="font-medium">{{ t('subcategory') }}:</span> {{ item.subcategory?.name }}
            </div>
            <div>
              <span class="font-medium">{{ t('brand') }}:</span> {{ item.brand?.name }}
            </div>
            <div>
              <span class="font-medium">{{ t('price') }}:</span> Rp {{ item.price?.toLocaleString() || '0' }}
            </div>
            <div>
              <span class="font-medium">{{ t('current_stock') }}:</span> 
              <span :class="{
                'text-red-500 font-bold': currentStock < 5,
                'text-green-500 font-bold': currentStock >= 5
              }">
                {{ currentStock }}
              </span>
            </div>
          </div>
        </div>
        
        <!-- Description -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
          <h2 class="text-xl font-semibold mb-4">{{ t('description') }}</h2>
          <p v-if="item.description">{{ item.description }}</p>
          <p v-else class="text-gray-500">{{ t('no_description') }}</p>
        </div>
        
        <!-- Actions -->
        <div class="bg-white shadow-md rounded-lg p-6">
          <h2 class="text-xl font-semibold mb-4">{{ t('actions') }}</h2>
          <div class="space-y-2">
            <button 
              class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
              @click="createPurchase"
            >
              {{ t('create_purchase') }}
            </button>
            <button 
              class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
              @click="createSale"
            >
              {{ t('create_sale') }}
            </button>
            <button 
              class="w-full bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded"
              @click="createLoan"
            >
              {{ t('create_loan') }}
            </button>
            <button 
              class="w-full bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded"
              @click="createWarranty"
            >
              {{ t('create_warranty') }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';

export default {
  name: 'ItemDetailView',
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    const route = useRoute();
    
    const item = ref({});
    const currentImage = ref({});
    const currentStock = ref(0);

    const fetchItem = async () => {
      try {
        const response = await axios.get(`/api/items/${route.params.id}`, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        item.value = response.data;
        
        // Set the first image as the current image
        if (item.value.images && item.value.images.length > 0) {
          // Find primary image first
          const primaryImage = item.value.images.find(img => img.is_primary);
          currentImage.value = primaryImage || item.value.images[0];
        }
        
        // Get current stock
        try {
          const stockResponse = await axios.get(`/api/stock-movements/${route.params.id}`, {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
          });
          
          currentStock.value = stockResponse.data.current_stock || 0;
        } catch (stockError) {
          console.error('Error fetching stock:', stockError);
          currentStock.value = 0;
        }
      } catch (error) {
        console.error('Error fetching item:', error);
      }
    };

    const formatSpecName = (key) => {
      // Convert snake_case or camelCase to Title Case
      return key
        .replace(/([A-Z])/g, ' $1')
        .replace(/^./, str => str.toUpperCase())
        .split('_')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
    };

    // Navigation functions
    const createPurchase = () => {
      // This would require more implementation to pre-fill the form
      router.push({ name: 'PurchaseCreate' });
    };

    const createSale = () => {
      // This would require more implementation to pre-fill the form
      router.push({ name: 'SaleCreate' });
    };

    const createLoan = () => {
      router.push({ 
        name: 'LoanCreate',
        query: { item_id: item.value.id } // Pass item ID to pre-fill the form
      });
    };

    const createWarranty = () => {
      router.push({ 
        name: 'WarrantyCreate',
        query: { item_id: item.value.id } // Pass item ID to pre-fill the form
      });
    };

    onMounted(() => {
      fetchItem();
    });

    return {
      t,
      item,
      currentImage,
      currentStock,
      formatSpecName,
      createPurchase,
      createSale,
      createLoan,
      createWarranty
    };
  }
};
</script>
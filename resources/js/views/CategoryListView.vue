<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">{{ t('categories') }}</h1>
      <router-link 
        :to="{ name: 'CategoryCreate' }" 
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
      >
        {{ t('create') }}
      </router-link>
    </div>
    
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <div class="p-4 border-b">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
          <div class="flex-1">
            <input
              type="text"
              :placeholder="t('search') + '...'"
              v-model="searchQuery"
              @input="searchCategories"
              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>
          <div class="flex gap-2">
            <select 
              v-model="perPage" 
              @change="fetchCategories"
              class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="10">10 {{ t('categories') }}</option>
              <option value="25">25 {{ t('categories') }}</option>
              <option value="50">50 {{ t('categories') }}</option>
            </select>
          </div>
        </div>
      </div>
      
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('name') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('description') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('subcategories') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('actions') }}</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="category in categories" :key="category.id">
              <td class="px-6 py-4 whitespace-nowrap">{{ category.name }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ category.description }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ category.subcategories?.length || 0 }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <router-link 
                  :to="{ name: 'CategoryEdit', params: { id: category.id } }" 
                  class="text-indigo-600 hover:text-indigo-900 mr-3"
                >
                  {{ t('edit') }}
                </router-link>
                <button 
                  @click="deleteCategory(category.id)" 
                  class="text-red-600 hover:text-red-900"
                >
                  {{ t('delete') }}
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <div class="px-4 py-3 border-t bg-gray-50 flex items-center justify-between">
        <div class="text-sm text-gray-700">
          {{ t('showing') }} {{ (currentPage - 1) * perPage + 1 }} - {{ Math.min(currentPage * perPage, totalItems) }} {{ t('of') }} {{ totalItems }} {{ t('categories') }}
        </div>
        <div class="flex space-x-2">
          <button
            @click="changePage(currentPage - 1)"
            :disabled="currentPage === 1"
            class="px-3 py-1 rounded border bg-white text-gray-700 hover:bg-gray-50 disabled:opacity-50"
          >
            {{ t('previous') }}
          </button>
          
          <button
            @click="changePage(page)"
            v-for="page in totalPages"
            :key="page"
            :class="{
              'px-3 py-1 rounded border bg-blue-500 text-white': page === currentPage,
              'px-3 py-1 rounded border bg-white text-gray-700 hover:bg-gray-50': page !== currentPage
            }"
          >
            {{ page }}
          </button>
          
          <button
            @click="changePage(currentPage + 1)"
            :disabled="currentPage === totalPages"
            class="px-3 py-1 rounded border bg-white text-gray-700 hover:bg-gray-50 disabled:opacity-50"
          >
            {{ t('next') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
  name: 'CategoryListView',
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    const categories = ref([]);
    const totalItems = ref(0);
    const currentPage = ref(1);
    const perPage = ref(10);
    const searchQuery = ref('');

    const fetchCategories = async () => {
      try {
        const response = await axios.get('/api/categories', {
          params: {
            page: currentPage.value,
            per_page: perPage.value,
            search: searchQuery.value
          },
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        categories.value = response.data.data;
        totalItems.value = response.data.total;
        currentPage.value = response.data.current_page;
      } catch (error) {
        console.error('Error fetching categories:', error);
      }
    };

    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        fetchCategories();
      }
    };

    const searchCategories = () => {
      currentPage.value = 1;
      fetchCategories();
    };

    const deleteCategory = async (id) => {
      if (confirm(t('delete_confirmation'))) {
        try {
          await axios.delete(`/api/categories/${id}`, {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
          });
          fetchCategories(); // Refresh the list
        } catch (error) {
          console.error('Error deleting category:', error);
        }
      }
    };

    // Computed properties
    const totalPages = () => Math.ceil(totalItems.value / perPage.value);

    onMounted(() => {
      fetchCategories();
    });

    return {
      t,
      categories,
      totalItems,
      currentPage,
      perPage,
      searchQuery,
      totalPages,
      fetchCategories,
      changePage,
      searchCategories,
      deleteCategory
    };
  }
};
</script>
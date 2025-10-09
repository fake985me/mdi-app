<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">{{ t('warranties') }}</h1>
      <router-link 
        :to="{ name: 'WarrantyCreate' }" 
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
              @input="searchWarranties"
              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>
          <div class="flex gap-2">
            <select 
              v-model="statusFilter" 
              @change="fetchWarranties"
              class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="">{{ t('all') }}</option>
              <option value="aktif">{{ t('active') }}</option>
              <option value="kadaluarsa">{{ t('expired') }}</option>
              <option value="klaim">{{ t('claimed') }}</option>
            </select>
            <select 
              v-model="perPage" 
              @change="fetchWarranties"
              class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="10">10 {{ t('warranties') }}</option>
              <option value="25">25 {{ t('warranties') }}</option>
              <option value="50">50 {{ t('warranties') }}</option>
            </select>
          </div>
        </div>
      </div>
      
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('warranty_number') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('item_name') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('start_date') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('end_date') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('status') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('actions') }}</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="warranty in warranties" :key="warranty.id">
              <td class="px-6 py-4 whitespace-nowrap">{{ warranty.warranty_number }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ warranty.item?.name }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ formatDate(warranty.start_date) }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ formatDate(warranty.end_date) }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="{
                  'px-2 inline-flex text-xs leading-5 font-semibold rounded-full': true,
                  'bg-green-100 text-green-800': warranty.status === 'aktif',
                  'bg-red-100 text-red-800': warranty.status === 'kadaluarsa',
                  'bg-yellow-100 text-yellow-800': warranty.status === 'klaim'
                }">
                  {{ getStatusLabel(warranty.status) }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <router-link 
                  :to="{ name: 'WarrantyDetail', params: { id: warranty.id } }" 
                  class="text-indigo-600 hover:text-indigo-900 mr-3"
                >
                  {{ t('view') }}
                </router-link>
                <button 
                  @click="deleteWarranty(warranty.id)" 
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
          {{ t('showing') }} {{ (currentPage - 1) * perPage + 1 }} - {{ Math.min(currentPage * perPage, totalItems) }} {{ t('of') }} {{ totalItems }} {{ t('warranties') }}
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
import axios from 'axios';

export default {
  name: 'WarrantyListView',
  setup() {
    const { t } = useI18n();
    const warranties = ref([]);
    const totalItems = ref(0);
    const currentPage = ref(1);
    const perPage = ref(10);
    const searchQuery = ref('');
    const statusFilter = ref('');

    const fetchWarranties = async () => {
      try {
        const response = await axios.get('/api/warranties', {
          params: {
            page: currentPage.value,
            per_page: perPage.value,
            search: searchQuery.value,
            status: statusFilter.value
          },
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        warranties.value = response.data.data;
        totalItems.value = response.data.total;
        currentPage.value = response.data.current_page;
      } catch (error) {
        console.error('Error fetching warranties:', error);
      }
    };

    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        fetchWarranties();
      }
    };

    const searchWarranties = () => {
      currentPage.value = 1;
      fetchWarranties();
    };

    const deleteWarranty = async (id) => {
      if (confirm(t('delete_confirmation'))) {
        try {
          await axios.delete(`/api/warranties/${id}`, {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
          });
          fetchWarranties(); // Refresh the list
        } catch (error) {
          console.error('Error deleting warranty:', error);
        }
      }
    };

    const formatDate = (dateString) => {
      const options = { year: 'numeric', month: 'short', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    };

    const getStatusLabel = (status) => {
      switch (status) {
        case 'aktif': return t('active');
        case 'kadaluarsa': return t('expired');
        case 'klaim': return t('claimed');
        default: return status;
      }
    };

    // Computed properties
    const totalPages = () => Math.ceil(totalItems.value / perPage.value);

    onMounted(() => {
      fetchWarranties();
    });

    return {
      t,
      warranties,
      totalItems,
      currentPage,
      perPage,
      searchQuery,
      statusFilter,
      totalPages,
      fetchWarranties,
      changePage,
      searchWarranties,
      deleteWarranty,
      formatDate,
      getStatusLabel
    };
  }
};
</script>
<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">{{ t('stock_movements') }}</h1>
      <button 
        @click="showCreateModal = true"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
      >
        {{ t('create') }}
      </button>
    </div>
    
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <div class="p-4 border-b">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
          <div class="flex-1">
            <input
              type="text"
              :placeholder="t('search') + '...'"
              v-model="searchQuery"
              @input="searchStockMovements"
              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>
          <div class="flex gap-2">
            <select 
              v-model="typeFilter" 
              @change="fetchStockMovements"
              class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="">{{ t('all') }}</option>
              <option value="masuk">{{ t('stock_in') }}</option>
              <option value="keluar">{{ t('stock_out') }}</option>
            </select>
            <select 
              v-model="perPage" 
              @change="fetchStockMovements"
              class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="10">10 {{ t('items') }}</option>
              <option value="25">25 {{ t('items') }}</option>
              <option value="50">50 {{ t('items') }}</option>
            </select>
          </div>
        </div>
      </div>
      
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('date') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('item_name') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('type') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('quantity') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('reference') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('description') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('actions') }}</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="movement in stockMovements" :key="movement.id">
              <td class="px-6 py-4 whitespace-nowrap">{{ formatDate(movement.date) }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ movement.item?.name }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="{
                  'px-2 inline-flex text-xs leading-5 font-semibold rounded-full': true,
                  'bg-green-100 text-green-800': movement.type === 'masuk',
                  'bg-red-100 text-red-800': movement.type === 'keluar'
                }">
                  {{ movement.type === 'masuk' ? t('stock_in') : t('stock_out') }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">{{ movement.quantity }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span v-if="movement.reference_type === 'pembelian'">{{ t('purchase') }} #{{ movement.reference_id }}</span>
                <span v-if="movement.reference_type === 'penjualan'">{{ t('sale') }} #{{ movement.reference_id }}</span>
                <span v-if="movement.reference_type === 'peminjaman'">{{ t('loan') }} #{{ movement.reference_id }}</span>
                <span v-if="movement.reference_type === 'pengembalian'">{{ t('return') }} #{{ movement.reference_id }}</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">{{ movement.description }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button 
                  @click="deleteStockMovement(movement.id)" 
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
          {{ t('showing') }} {{ (currentPage - 1) * perPage + 1 }} - {{ Math.min(currentPage * perPage, totalItems) }} {{ t('of') }} {{ totalItems }} {{ t('stock_movements') }}
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
    
    <!-- Create Stock Movement Modal -->
    <div v-if="showCreateModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">{{ t('create_stock_movement') }}</h2>
        
        <form @submit.prevent="createStockMovement">
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="item_id">
              {{ t('item') }}
            </label>
            <select 
              v-model="newMovement.item_id"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            >
              <option v-for="item in items" :key="item.id" :value="item.id">{{ item.name }}</option>
            </select>
          </div>
          
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="type">
              {{ t('type') }}
            </label>
            <select 
              v-model="newMovement.type"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            >
              <option value="masuk">{{ t('stock_in') }}</option>
              <option value="keluar">{{ t('stock_out') }}</option>
            </select>
          </div>
          
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="quantity">
              {{ t('quantity') }}
            </label>
            <input
              type="number"
              v-model="newMovement.quantity"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            />
          </div>
          
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="date">
              {{ t('date') }}
            </label>
            <input
              type="date"
              v-model="newMovement.date"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            />
          </div>
          
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="description">
              {{ t('description') }}
            </label>
            <textarea
              v-model="newMovement.description"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            ></textarea>
          </div>
          
          <div class="flex items-center justify-between">
            <button
              type="button"
              @click="showCreateModal = false"
              class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            >
              {{ t('cancel') }}
            </button>
            <button
              type="submit"
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            >
              {{ t('create') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import axios from 'axios';

export default {
  name: 'StockMovementListView',
  setup() {
    const { t } = useI18n();
    const stockMovements = ref([]);
    const items = ref([]);
    const totalItems = ref(0);
    const currentPage = ref(1);
    const perPage = ref(10);
    const searchQuery = ref('');
    const typeFilter = ref('');
    const showCreateModal = ref(false);
    const newMovement = ref({
      item_id: '',
      type: '',
      quantity: 1,
      date: new Date().toISOString().split('T')[0],
      description: ''
    });

    const fetchStockMovements = async () => {
      try {
        const response = await axios.get('/api/stock-movements', {
          params: {
            page: currentPage.value,
            per_page: perPage.value,
            search: searchQuery.value,
            type: typeFilter.value
          },
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        stockMovements.value = response.data.data;
        totalItems.value = response.data.total;
        currentPage.value = response.data.current_page;
      } catch (error) {
        console.error('Error fetching stock movements:', error);
      }
    };

    const fetchItems = async () => {
      try {
        const response = await axios.get('/api/items', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        items.value = response.data.data;
      } catch (error) {
        console.error('Error fetching items:', error);
      }
    };

    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        fetchStockMovements();
      }
    };

    const searchStockMovements = () => {
      currentPage.value = 1;
      fetchStockMovements();
    };

    const deleteStockMovement = async (id) => {
      if (confirm(t('delete_confirmation'))) {
        try {
          await axios.delete(`/api/stock-movements/${id}`, {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
          });
          fetchStockMovements(); // Refresh the list
        } catch (error) {
          console.error('Error deleting stock movement:', error);
        }
      }
    };

    const createStockMovement = async () => {
      try {
        await axios.post('/api/stock-movements', newMovement.value, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        // Reset form and close modal
        newMovement.value = {
          item_id: '',
          type: '',
          quantity: 1,
          date: new Date().toISOString().split('T')[0],
          description: ''
        };
        
        showCreateModal.value = false;
        fetchStockMovements(); // Refresh the list
      } catch (error) {
        console.error('Error creating stock movement:', error);
      }
    };

    const formatDate = (dateString) => {
      const options = { year: 'numeric', month: 'short', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    };

    // Computed properties
    const totalPages = () => Math.ceil(totalItems.value / perPage.value);

    onMounted(() => {
      fetchStockMovements();
      fetchItems();
    });

    return {
      t,
      stockMovements,
      items,
      totalItems,
      currentPage,
      perPage,
      searchQuery,
      typeFilter,
      showCreateModal,
      newMovement,
      totalPages,
      fetchStockMovements,
      changePage,
      searchStockMovements,
      deleteStockMovement,
      createStockMovement,
      formatDate
    };
  }
};
</script>
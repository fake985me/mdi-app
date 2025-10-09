<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">{{ t('create_loan') }}</h1>
    
    <div class="bg-white shadow-md rounded-lg p-6">
      <form @submit.prevent="createLoan">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="item_id">
              {{ t('item') }}
            </label>
            <select 
              v-model="loan.item_id"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            >
              <option value="" disabled>{{ t('select_item') }}</option>
              <option v-for="item in items" :key="item.id" :value="item.id">
                {{ item.name }} ({{ t('current_stock') }}: {{ getItemStock(item.id) }})
              </option>
            </select>
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="borrower">
              {{ t('borrower') }}
            </label>
            <input
              type="text"
              v-model="loan.borrower"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="loan_date">
              {{ t('loan_date') }}
            </label>
            <input
              type="date"
              v-model="loan.loan_date"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="return_date">
              {{ t('return_date') }}
            </label>
            <input
              type="date"
              v-model="loan.return_date"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
          
          <div class="md:col-span-2">
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="notes">
              {{ t('notes') }}
            </label>
            <textarea
              v-model="loan.notes"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              rows="3"
            ></textarea>
          </div>
        </div>
        
        <div class="flex items-center justify-between">
          <router-link 
            :to="{ name: 'Loans' }" 
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
          >
            {{ t('cancel') }}
          </router-link>
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
</template>

<script>
import { ref, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
  name: 'LoanCreateView',
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    
    const loan = ref({
      item_id: '',
      borrower: '',
      loan_date: new Date().toISOString().split('T')[0],
      return_date: '',
      notes: ''
    });
    
    const items = ref([]);
    const stockLevels = ref({});

    const fetchItems = async () => {
      try {
        const response = await axios.get('/api/items', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        items.value = response.data.data;
        
        // Fetch stock levels for each item
        for (const item of response.data.data) {
          try {
            const stockResponse = await axios.get(`/api/stock-movements/${item.id}`, {
              headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
              }
            });
            
            stockLevels.value[item.id] = stockResponse.data.current_stock || 0;
          } catch (error) {
            console.error(`Error fetching stock for item ${item.id}:`, error);
            stockLevels.value[item.id] = 0;
          }
        }
      } catch (error) {
        console.error('Error fetching items:', error);
      }
    };

    const getItemStock = (itemId) => {
      return stockLevels.value[itemId] || 0;
    };

    const createLoan = async () => {
      // Check if we have enough stock
      const itemStock = stockLevels.value[loan.value.item_id] || 0;
      if (itemStock < 1) {
        alert(t('insufficient_stock'));
        return;
      }
      
      try {
        await axios.post('/api/loans', loan.value, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        router.push({ name: 'Loans' });
      } catch (error) {
        console.error('Error creating loan:', error);
      }
    };

    onMounted(() => {
      fetchItems();
    });

    return {
      t,
      loan,
      items,
      stockLevels,
      getItemStock,
      createLoan
    };
  }
};
</script>
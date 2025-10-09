<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">{{ t('create_sale') }}</h1>
    
    <div class="bg-white shadow-md rounded-lg p-6">
      <form @submit.prevent="createSale">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="customer_id">
              {{ t('customer') }}
            </label>
            <select 
              v-model="sale.customer_id"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            >
              <option value="" disabled>{{ t('select_customer') }}</option>
              <option v-for="customer in customers" :key="customer.id" :value="customer.id">
                {{ customer.name }}
              </option>
            </select>
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="date">
              {{ t('date') }}
            </label>
            <input
              type="date"
              v-model="sale.date"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            />
          </div>
          
          <div class="md:col-span-2">
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="notes">
              {{ t('notes') }}
            </label>
            <textarea
              v-model="sale.notes"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              rows="3"
            ></textarea>
          </div>
        </div>
        
        <div class="mb-6">
          <h2 class="text-lg font-semibold mb-4">{{ t('sale_items') }}</h2>
          
          <div class="mb-4 flex">
            <select 
              v-model="newItem.item_id"
              class="shadow appearance-none border rounded-l w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            >
              <option value="" disabled>{{ t('select_item') }}</option>
              <option v-for="item in items" :key="item.id" :value="item.id">
                {{ item.name }} ({{ t('current_stock') }}: {{ getItemStock(item.id) }})
              </option>
            </select>
            
            <input
              type="number"
              v-model="newItem.quantity"
              placeholder="Qty"
              class="shadow appearance-none border-t border-b w-24 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              min="1"
              :max="getMaxQuantity(newItem.item_id)"
            />
            
            <input
              type="number"
              v-model="newItem.price"
              placeholder="Price"
              class="shadow appearance-none border w-32 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              min="0"
              step="0.01"
            />
            
            <button
              type="button"
              @click="addSaleItem"
              class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-r"
            >
              {{ t('add') }}
            </button>
          </div>
          
          <div v-if="saleItems.length > 0" class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('item') }}</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('quantity') }}</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('price') }}</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('subtotal') }}</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('actions') }}</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(item, index) in saleItems" :key="index">
                  <td class="px-6 py-4 whitespace-nowrap">{{ getItemName(item.item_id) }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ item.quantity }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">Rp {{ item.price.toLocaleString() }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">Rp {{ (item.quantity * item.price).toLocaleString() }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <button 
                      @click="removeSaleItem(index)"
                      class="text-red-600 hover:text-red-900"
                    >
                      {{ t('remove') }}
                    </button>
                  </td>
                </tr>
                <tr class="bg-gray-100 font-semibold">
                  <td class="px-6 py-4 whitespace-nowrap" colspan="3">{{ t('total') }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">Rp {{ calculateTotal().toLocaleString() }}</td>
                  <td class="px-6 py-4 whitespace-nowrap"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        
        <div class="flex items-center justify-between">
          <router-link 
            :to="{ name: 'Sales' }" 
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
          >
            {{ t('cancel') }}
          </router-link>
          <button
            type="submit"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            :disabled="saleItems.length === 0"
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
  name: 'SaleCreateView',
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    
    const sale = ref({
      customer_id: '',
      date: new Date().toISOString().split('T')[0],
      notes: ''
    });
    
    const customers = ref([]);
    const items = ref([]);
    const stockLevels = ref({});
    const saleItems = ref([]);
    const newItem = ref({
      item_id: '',
      quantity: 1,
      price: 0
    });

    const fetchCustomers = async () => {
      try {
        const response = await axios.get('/api/customers', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        customers.value = response.data.data;
      } catch (error) {
        console.error('Error fetching customers:', error);
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

    const addSaleItem = () => {
      if (newItem.value.item_id && newItem.value.quantity > 0 && newItem.value.price >= 0) {
        // Check if we have enough stock
        const itemStock = stockLevels.value[newItem.value.item_id] || 0;
        if (newItem.value.quantity > itemStock) {
          alert(t('insufficient_stock'));
          return;
        }
        
        // Check if item already exists
        const existingItem = saleItems.value.find(item => item.item_id === newItem.value.item_id);
        
        if (existingItem) {
          // Check if total quantity would exceed stock
          if ((existingItem.quantity + newItem.value.quantity) > itemStock) {
            alert(t('insufficient_stock'));
            return;
          }
          
          // Update quantity and price
          existingItem.quantity = parseInt(existingItem.quantity) + parseInt(newItem.value.quantity);
          existingItem.price = parseFloat(newItem.value.price);
        } else {
          // Add new item to the list
          saleItems.value.push({ ...newItem.value });
        }
        
        // Reset the new item form
        newItem.value = {
          item_id: '',
          quantity: 1,
          price: 0
        };
      }
    };

    const removeSaleItem = (index) => {
      saleItems.value.splice(index, 1);
    };

    const getItemName = (itemId) => {
      const item = items.value.find(item => item.id === itemId);
      return item ? item.name : 'Unknown Item';
    };

    const getItemStock = (itemId) => {
      return stockLevels.value[itemId] || 0;
    };

    const getMaxQuantity = (itemId) => {
      return stockLevels.value[itemId] || 0;
    };

    const calculateTotal = () => {
      return saleItems.value.reduce((total, item) => {
        return total + (item.quantity * item.price);
      }, 0);
    };

    const createSale = async () => {
      try {
        // Create the sale
        const saleResponse = await axios.post('/api/sales', sale.value, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        // Add items to the sale
        for (const item of saleItems.value) {
          await axios.post(`/api/sales/${saleResponse.data.id}/items`, {
            item_id: item.item_id,
            quantity: item.quantity,
            price: item.price
          }, {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
          });
        }
        
        router.push({ name: 'Sales' });
      } catch (error) {
        console.error('Error creating sale:', error);
      }
    };

    onMounted(() => {
      fetchCustomers();
      fetchItems();
    });

    return {
      t,
      sale,
      customers,
      items,
      stockLevels,
      saleItems,
      newItem,
      addSaleItem,
      removeSaleItem,
      getItemName,
      getItemStock,
      getMaxQuantity,
      calculateTotal,
      createSale
    };
  }
};
</script>
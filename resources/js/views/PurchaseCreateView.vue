<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">{{ t('create_purchase') }}</h1>
    
    <div class="bg-white shadow-md rounded-lg p-6">
      <form @submit.prevent="createPurchase">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="supplier_id">
              {{ t('supplier') }}
            </label>
            <select 
              v-model="purchase.supplier_id"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            >
              <option value="" disabled>{{ t('select_supplier') }}</option>
              <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">
                {{ supplier.name }}
              </option>
            </select>
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="date">
              {{ t('date') }}
            </label>
            <input
              type="date"
              v-model="purchase.date"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            />
          </div>
          
          <div class="md:col-span-2">
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="notes">
              {{ t('notes') }}
            </label>
            <textarea
              v-model="purchase.notes"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              rows="3"
            ></textarea>
          </div>
        </div>
        
        <div class="mb-6">
          <h2 class="text-lg font-semibold mb-4">{{ t('purchase_items') }}</h2>
          
          <div class="mb-4 flex">
            <select 
              v-model="newItem.item_id"
              class="shadow appearance-none border rounded-l w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            >
              <option value="" disabled>{{ t('select_item') }}</option>
              <option v-for="item in items" :key="item.id" :value="item.id">{{ item.name }}</option>
            </select>
            
            <input
              type="number"
              v-model="newItem.quantity"
              placeholder="Qty"
              class="shadow appearance-none border-t border-b w-24 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              min="1"
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
              @click="addPurchaseItem"
              class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-r"
            >
              {{ t('add') }}
            </button>
          </div>
          
          <div v-if="purchaseItems.length > 0" class="overflow-x-auto">
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
                <tr v-for="(item, index) in purchaseItems" :key="index">
                  <td class="px-6 py-4 whitespace-nowrap">{{ getItemName(item.item_id) }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ item.quantity }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">Rp {{ item.price.toLocaleString() }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">Rp {{ (item.quantity * item.price).toLocaleString() }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <button 
                      @click="removePurchaseItem(index)"
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
            :to="{ name: 'Purchases' }" 
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
  name: 'PurchaseCreateView',
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    
    const purchase = ref({
      supplier_id: '',
      date: new Date().toISOString().split('T')[0],
      notes: ''
    });
    
    const suppliers = ref([]);
    const items = ref([]);
    const purchaseItems = ref([]);
    const newItem = ref({
      item_id: '',
      quantity: 1,
      price: 0
    });

    const fetchSuppliers = async () => {
      try {
        const response = await axios.get('/api/suppliers', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        suppliers.value = response.data.data;
      } catch (error) {
        console.error('Error fetching suppliers:', error);
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

    const addPurchaseItem = () => {
      if (newItem.value.item_id && newItem.value.quantity > 0 && newItem.value.price >= 0) {
        // Check if item already exists
        const existingItem = purchaseItems.value.find(item => item.item_id === newItem.value.item_id);
        
        if (existingItem) {
          // Update quantity and price
          existingItem.quantity = parseInt(existingItem.quantity) + parseInt(newItem.value.quantity);
          existingItem.price = parseFloat(newItem.value.price);
        } else {
          // Add new item to the list
          purchaseItems.value.push({ ...newItem.value });
        }
        
        // Reset the new item form
        newItem.value = {
          item_id: '',
          quantity: 1,
          price: 0
        };
      }
    };

    const removePurchaseItem = (index) => {
      purchaseItems.value.splice(index, 1);
    };

    const getItemName = (itemId) => {
      const item = items.value.find(item => item.id === itemId);
      return item ? item.name : 'Unknown Item';
    };

    const calculateTotal = () => {
      return purchaseItems.value.reduce((total, item) => {
        return total + (item.quantity * item.price);
      }, 0);
    };

    const createPurchase = async () => {
      try {
        // Create the purchase
        const purchaseResponse = await axios.post('/api/purchases', purchase.value, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        // Add items to the purchase
        for (const item of purchaseItems.value) {
          await axios.post(`/api/purchases/${purchaseResponse.data.id}/items`, {
            item_id: item.item_id,
            quantity: item.quantity,
            price: item.price
          }, {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
          });
        }
        
        router.push({ name: 'Purchases' });
      } catch (error) {
        console.error('Error creating purchase:', error);
      }
    };

    onMounted(() => {
      fetchSuppliers();
      fetchItems();
    });

    return {
      t,
      purchase,
      suppliers,
      items,
      purchaseItems,
      newItem,
      addPurchaseItem,
      removePurchaseItem,
      getItemName,
      calculateTotal,
      createPurchase
    };
  }
};
</script>
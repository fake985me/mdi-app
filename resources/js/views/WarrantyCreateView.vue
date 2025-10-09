<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">{{ t('create_warranty') }}</h1>
    
    <div class="bg-white shadow-md rounded-lg p-6">
      <form @submit.prevent="createWarranty">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="item_id">
              {{ t('item') }}
            </label>
            <select 
              v-model="warranty.item_id"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            >
              <option value="" disabled>{{ t('select_item') }}</option>
              <option v-for="item in items" :key="item.id" :value="item.id">{{ item.name }}</option>
            </select>
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="start_date">
              {{ t('start_date') }}
            </label>
            <input
              type="date"
              v-model="warranty.start_date"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="end_date">
              {{ t('end_date') }}
            </label>
            <input
              type="date"
              v-model="warranty.end_date"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="status">
              {{ t('status') }}
            </label>
            <select 
              v-model="warranty.status"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            >
              <option value="aktif">{{ t('active') }}</option>
              <option value="kadaluarsa">{{ t('expired') }}</option>
              <option value="klaim">{{ t('claimed') }}</option>
            </select>
          </div>
          
          <div class="md:col-span-2">
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="terms">
              {{ t('terms') }}
            </label>
            <textarea
              v-model="warranty.terms"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              rows="3"
            ></textarea>
          </div>
          
          <div class="md:col-span-2">
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="notes">
              {{ t('notes') }}
            </label>
            <textarea
              v-model="warranty.notes"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              rows="3"
            ></textarea>
          </div>
        </div>
        
        <div class="flex items-center justify-between">
          <router-link 
            :to="{ name: 'Warranties' }" 
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
  name: 'WarrantyCreateView',
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    
    const warranty = ref({
      item_id: '',
      start_date: new Date().toISOString().split('T')[0],
      end_date: '',
      terms: '',
      notes: '',
      status: 'aktif'
    });
    
    const items = ref([]);

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

    const createWarranty = async () => {
      // Validate dates
      if (new Date(warranty.value.end_date) <= new Date(warranty.value.start_date)) {
        alert(t('end_date_must_be_after_start_date'));
        return;
      }
      
      try {
        await axios.post('/api/warranties', warranty.value, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        router.push({ name: 'Warranties' });
      } catch (error) {
        console.error('Error creating warranty:', error);
      }
    };

    onMounted(() => {
      fetchItems();
    });

    return {
      t,
      warranty,
      items,
      createWarranty
    };
  }
};
</script>
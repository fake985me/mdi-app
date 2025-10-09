<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">{{ t('create_category') }}</h1>
    
    <div class="bg-white shadow-md rounded-lg p-6">
      <form @submit.prevent="createCategory">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="name">
              {{ t('name') }}
            </label>
            <input
              type="text"
              v-model="category.name"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="parent_id">
              {{ t('parent_category') }}
            </label>
            <select 
              v-model="category.parent_id"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            >
              <option value="">{{ t('no_parent') }}</option>
              <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
            </select>
          </div>
          
          <div class="md:col-span-2">
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="description">
              {{ t('description') }}
            </label>
            <textarea
              v-model="category.description"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              rows="3"
            ></textarea>
          </div>
        </div>
        
        <div class="flex items-center justify-between">
          <router-link 
            :to="{ name: 'Categories' }" 
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
  name: 'CategoryCreateView',
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    
    const category = ref({
      name: '',
      parent_id: null,
      description: ''
    });
    
    const categories = ref([]);

    const fetchCategories = async () => {
      try {
        const response = await axios.get('/api/categories', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        categories.value = response.data.data;
      } catch (error) {
        console.error('Error fetching categories:', error);
      }
    };

    const createCategory = async () => {
      try {
        await axios.post('/api/categories', category.value, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        router.push({ name: 'Categories' });
      } catch (error) {
        console.error('Error creating category:', error);
      }
    };

    onMounted(() => {
      fetchCategories();
    });

    return {
      t,
      category,
      categories,
      createCategory
    };
  }
};
</script>
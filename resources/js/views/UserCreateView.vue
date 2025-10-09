<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">{{ t('create_user') }}</h1>
    
    <div class="bg-white shadow-md rounded-lg p-6">
      <form @submit.prevent="createUser">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="name">
              {{ t('name') }}
            </label>
            <input
              type="text"
              v-model="user.name"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="email">
              {{ t('email') }}
            </label>
            <input
              type="email"
              v-model="user.email"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="password">
              {{ t('password') }}
            </label>
            <input
              type="password"
              v-model="user.password"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="password_confirmation">
              {{ t('confirm_password') }}
            </label>
            <input
              type="password"
              v-model="user.password_confirmation"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="role">
              {{ t('role') }}
            </label>
            <select 
              v-model="user.role"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            >
              <option value="user">{{ t('user') }}</option>
              <option value="admin">{{ t('admin') }}</option>
              <option value="superadmin">{{ t('superadmin') }}</option>
            </select>
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="phone">
              {{ t('phone') }}
            </label>
            <input
              type="text"
              v-model="user.phone"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
          
          <div class="md:col-span-2">
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="address">
              {{ t('address') }}
            </label>
            <textarea
              v-model="user.address"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              rows="3"
            ></textarea>
          </div>
        </div>
        
        <div class="flex items-center justify-between">
          <router-link 
            :to="{ name: 'Users' }" 
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
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
  name: 'UserCreateView',
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    
    const user = ref({
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      role: 'user',
      phone: '',
      address: ''
    });

    const createUser = async () => {
      // Validate passwords match
      if (user.value.password !== user.value.password_confirmation) {
        alert(t('passwords_do_not_match'));
        return;
      }
      
      try {
        await axios.post('/api/users', user.value, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        router.push({ name: 'Users' });
      } catch (error) {
        console.error('Error creating user:', error);
      }
    };

    return {
      t,
      user,
      createUser
    };
  }
};
</script>
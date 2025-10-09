<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">{{ t('edit_user') }}</h1>
    
    <div class="bg-white shadow-md rounded-lg p-6">
      <form @submit.prevent="updateUser">
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
              :placeholder="t('leave_blank_to_keep_current')"
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
              :placeholder="t('leave_blank_to_keep_current')"
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
            {{ t('update') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';

export default {
  name: 'UserEditView',
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    const route = useRoute();
    
    const user = ref({
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      role: 'user',
      phone: '',
      address: ''
    });

    const fetchUser = async () => {
      try {
        const response = await axios.get(`/api/users/${route.params.id}`, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        user.value = response.data;
        // Clear password fields for security
        user.value.password = '';
        user.value.password_confirmation = '';
      } catch (error) {
        console.error('Error fetching user:', error);
      }
    };

    const updateUser = async () => {
      // Validate passwords if they were changed
      if (user.value.password || user.value.password_confirmation) {
        if (user.value.password !== user.value.password_confirmation) {
          alert(t('passwords_do_not_match'));
          return;
        }
      } else {
        // If passwords are empty, remove them from the update
        delete user.value.password;
        delete user.value.password_confirmation;
      }
      
      try {
        await axios.put(`/api/users/${route.params.id}`, user.value, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        router.push({ name: 'Users' });
      } catch (error) {
        console.error('Error updating user:', error);
      }
    };

    onMounted(() => {
      fetchUser();
    });

    return {
      t,
      user,
      updateUser
    };
  }
};
</script>
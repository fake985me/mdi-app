<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">{{ t('users') }}</h1>
      <router-link 
        :to="{ name: 'UserCreate' }" 
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
              @input="searchUsers"
              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>
          <div class="flex gap-2">
            <select 
              v-model="roleFilter" 
              @change="fetchUsers"
              class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="">{{ t('all') }}</option>
              <option value="superadmin">{{ t('superadmin') }}</option>
              <option value="admin">{{ t('admin') }}</option>
              <option value="user">{{ t('user') }}</option>
            </select>
            <select 
              v-model="perPage" 
              @change="fetchUsers"
              class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="10">10 {{ t('users') }}</option>
              <option value="25">25 {{ t('users') }}</option>
              <option value="50">50 {{ t('users') }}</option>
            </select>
          </div>
        </div>
      </div>
      
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('name') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('email') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('role') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('status') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('actions') }}</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="user in users" :key="user.id">
              <td class="px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="{
                  'px-2 inline-flex text-xs leading-5 font-semibold rounded-full': true,
                  'bg-red-100 text-red-800': user.role === 'superadmin',
                  'bg-blue-100 text-blue-800': user.role === 'admin',
                  'bg-green-100 text-green-800': user.role === 'user'
                }">
                  {{ getUserRoleLabel(user.role) }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="{
                  'px-2 inline-flex text-xs leading-5 font-semibold rounded-full': true,
                  'bg-green-100 text-green-800': user.status === 'active',
                  'bg-gray-100 text-gray-800': user.status === 'inactive'
                }">
                  {{ getUserStatusLabel(user.status) }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <router-link 
                  :to="{ name: 'UserEdit', params: { id: user.id } }" 
                  class="text-indigo-600 hover:text-indigo-900 mr-3"
                >
                  {{ t('edit') }}
                </router-link>
                <button 
                  @click="deleteUser(user.id)" 
                  class="text-red-600 hover:text-red-900"
                  :disabled="user.id === currentUser.id"
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
          {{ t('showing') }} {{ (currentPage - 1) * perPage + 1 }} - {{ Math.min(currentPage * perPage, totalItems) }} {{ t('of') }} {{ totalItems }} {{ t('users') }}
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
  name: 'UserListView',
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    
    const users = ref([]);
    const totalItems = ref(0);
    const currentPage = ref(1);
    const perPage = ref(10);
    const searchQuery = ref('');
    const roleFilter = ref('');
    const currentUser = ref({});

    const fetchUsers = async () => {
      try {
        const response = await axios.get('/api/users', {
          params: {
            page: currentPage.value,
            per_page: perPage.value,
            search: searchQuery.value,
            role: roleFilter.value
          },
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        users.value = response.data.data;
        totalItems.value = response.data.total;
        currentPage.value = response.data.current_page;
      } catch (error) {
        console.error('Error fetching users:', error);
      }
    };

    const fetchCurrentUser = async () => {
      try {
        const response = await axios.get('/api/user', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        currentUser.value = response.data;
      } catch (error) {
        console.error('Error fetching current user:', error);
      }
    };

    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        fetchUsers();
      }
    };

    const searchUsers = () => {
      currentPage.value = 1;
      fetchUsers();
    };

    const deleteUser = async (id) => {
      // Check if trying to delete self
      if (id === currentUser.value.id) {
        alert(t('cannot_delete_yourself'));
        return;
      }
      
      if (confirm(t('delete_confirmation'))) {
        try {
          await axios.delete(`/api/users/${id}`, {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
          });
          fetchUsers(); // Refresh the list
        } catch (error) {
          console.error('Error deleting user:', error);
        }
      }
    };

    const getUserRoleLabel = (role) => {
      switch (role) {
        case 'superadmin': return t('superadmin');
        case 'admin': return t('admin');
        case 'user': return t('user');
        default: return role;
      }
    };

    const getUserStatusLabel = (status) => {
      switch (status) {
        case 'active': return t('active');
        case 'inactive': return t('inactive');
        default: return status;
      }
    };

    // Computed properties
    const totalPages = () => Math.ceil(totalItems.value / perPage.value);

    onMounted(() => {
      fetchUsers();
      fetchCurrentUser();
    });

    return {
      t,
      users,
      totalItems,
      currentPage,
      perPage,
      searchQuery,
      roleFilter,
      currentUser,
      totalPages,
      fetchUsers,
      changePage,
      searchUsers,
      deleteUser,
      getUserRoleLabel,
      getUserStatusLabel
    };
  }
};
</script>
<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">{{ t('loans') }}</h1>
      <router-link 
        :to="{ name: 'LoanCreate' }" 
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
              @input="searchLoans"
              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>
          <div class="flex gap-2">
            <select 
              v-model="statusFilter" 
              @change="fetchLoans"
              class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="">{{ t('all') }}</option>
              <option value="dipinjam">{{ t('loaned') }}</option>
              <option value="dikembalikan">{{ t('returned') }}</option>
              <option value="terlambat">{{ t('overdue') }}</option>
            </select>
            <select 
              v-model="perPage" 
              @change="fetchLoans"
              class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="10">10 {{ t('loans') }}</option>
              <option value="25">25 {{ t('loans') }}</option>
              <option value="50">50 {{ t('loans') }}</option>
            </select>
          </div>
        </div>
      </div>
      
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('item_name') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('borrower') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('loan_date') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('return_date') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('status') }}</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t('actions') }}</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="loan in loans" :key="loan.id">
              <td class="px-6 py-4 whitespace-nowrap">{{ loan.item?.name }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ loan.borrower }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ formatDate(loan.loan_date) }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span v-if="loan.return_date">{{ formatDate(loan.return_date) }}</span>
                <span v-else class="text-red-500">{{ t('not_returned') }}</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="{
                  'px-2 inline-flex text-xs leading-5 font-semibold rounded-full': true,
                  'bg-yellow-100 text-yellow-800': loan.status === 'dipinjam',
                  'bg-green-100 text-green-800': loan.status === 'dikembalikan',
                  'bg-red-100 text-red-800': loan.status === 'terlambat'
                }">
                  {{ getStatusLabel(loan.status) }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <router-link 
                  :to="{ name: 'LoanDetail', params: { id: loan.id } }" 
                  class="text-indigo-600 hover:text-indigo-900 mr-3"
                >
                  {{ t('view') }}
                </router-link>
                <button 
                  @click="deleteLoan(loan.id)" 
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
          {{ t('showing') }} {{ (currentPage - 1) * perPage + 1 }} - {{ Math.min(currentPage * perPage, totalItems) }} {{ t('of') }} {{ totalItems }} {{ t('loans') }}
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
  name: 'LoanListView',
  setup() {
    const { t } = useI18n();
    const loans = ref([]);
    const totalItems = ref(0);
    const currentPage = ref(1);
    const perPage = ref(10);
    const searchQuery = ref('');
    const statusFilter = ref('');

    const fetchLoans = async () => {
      try {
        const response = await axios.get('/api/loans', {
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
        
        loans.value = response.data.data;
        totalItems.value = response.data.total;
        currentPage.value = response.data.current_page;
      } catch (error) {
        console.error('Error fetching loans:', error);
      }
    };

    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        fetchLoans();
      }
    };

    const searchLoans = () => {
      currentPage.value = 1;
      fetchLoans();
    };

    const deleteLoan = async (id) => {
      if (confirm(t('delete_confirmation'))) {
        try {
          await axios.delete(`/api/loans/${id}`, {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
          });
          fetchLoans(); // Refresh the list
        } catch (error) {
          console.error('Error deleting loan:', error);
        }
      }
    };

    const formatDate = (dateString) => {
      const options = { year: 'numeric', month: 'short', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    };

    const getStatusLabel = (status) => {
      switch (status) {
        case 'dipinjam': return t('loaned');
        case 'dikembalikan': return t('returned');
        case 'terlambat': return t('overdue');
        default: return status;
      }
    };

    // Computed properties
    const totalPages = () => Math.ceil(totalItems.value / perPage.value);

    onMounted(() => {
      fetchLoans();
    });

    return {
      t,
      loans,
      totalItems,
      currentPage,
      perPage,
      searchQuery,
      statusFilter,
      totalPages,
      fetchLoans,
      changePage,
      searchLoans,
      deleteLoan,
      formatDate,
      getStatusLabel
    };
  }
};
</script>
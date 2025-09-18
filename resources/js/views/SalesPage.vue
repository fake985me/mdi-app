<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Sales</h1>
        <p class="text-gray-600">Manage sales transactions and customer orders</p>
      </div>
      <button
        @click="showAddModal = true"
        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center space-x-2"
      >
        <Plus class="w-5 h-5" />
        <span>Add Sale</span>
      </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Total Sales</p>
            <p class="text-2xl font-bold text-green-600">${{ totalSales.toFixed(2) }}</p>
          </div>
          <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
            <DollarSign class="w-6 h-6 text-green-600" />
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Sales Count</p>
            <p class="text-2xl font-bold text-blue-600">{{ warehouseStore.sales.length }}</p>
          </div>
          <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
            <ShoppingCart class="w-6 h-6 text-blue-600" />
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Average Sale</p>
            <p class="text-2xl font-bold text-purple-600">${{ averageSale.toFixed(2) }}</p>
          </div>
          <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
            <TrendingUp class="w-6 h-6 text-purple-600" />
          </div>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search sales..."
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
          <input
            v-model="dateFrom"
            type="date"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
          <input
            v-model="dateTo"
            type="date"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          />
        </div>
      </div>
    </div>

    <!-- Sales Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Customer
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Contact
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Sale Date
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Total Amount
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Created By
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="sale in filteredSales" :key="sale.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ sale.customer_name || 'Anonymous' }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ sale.customer_contact || 'N/A' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatDate(sale.sale_date) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                ${{ sale.total_amount }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ sale.profiles?.full_name || 'System' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button
                  @click="viewSale(sale)"
                  class="text-blue-600 hover:text-blue-900 mr-3"
                >
                  View
                </button>
                <button
                  @click="deleteSale(sale.id)"
                  class="text-red-600 hover:text-red-900"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Add Sale Modal -->
    <div v-if="showAddModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg p-6 w-full max-w-md max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Add Sale</h3>
        
        <form @submit.prevent="handleSubmit" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Customer Name</label>
            <input
              v-model="saleForm.customer_name"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Customer Contact</label>
            <input
              v-model="saleForm.customer_contact"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Sale Date</label>
            <input
              v-model="saleForm.sale_date"
              type="date"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Total Amount</label>
            <input
              v-model="saleForm.total_amount"
              type="number"
              step="0.01"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
            <textarea
              v-model="saleForm.notes"
              rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            ></textarea>
          </div>
          
          <div class="flex justify-end space-x-4">
            <button
              type="button"
              @click="closeModal"
              class="px-4 py-2 text-gray-600 hover:text-gray-800"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
            >
              Add Sale
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, reactive } from 'vue'
import { useWarehouseStore } from '../stores/warehouse'
import { useAuthStore } from '../stores/auth'
import { Plus, DollarSign, ShoppingCart, TrendingUp } from 'lucide-vue-next'

const warehouseStore = useWarehouseStore()
const authStore = useAuthStore()

const showAddModal = ref(false)
const searchQuery = ref('')
const dateFrom = ref('')
const dateTo = ref('')

const saleForm = reactive({
  customer_name: '',
  customer_contact: '',
  sale_date: new Date().toISOString().split('T')[0],
  total_amount: 0,
  notes: '',
  created_by: null
})

const totalSales = computed(() => {
  return warehouseStore.sales.reduce((sum, sale) => sum + parseFloat(sale.total_amount || 0), 0)
})

const averageSale = computed(() => {
  const count = warehouseStore.sales.length
  return count > 0 ? totalSales.value / count : 0
})

const filteredSales = computed(() => {
  let filtered = warehouseStore.sales

  if (searchQuery.value) {
    filtered = filtered.filter(s =>
      (s.customer_name && s.customer_name.toLowerCase().includes(searchQuery.value.toLowerCase())) ||
      (s.customer_contact && s.customer_contact.toLowerCase().includes(searchQuery.value.toLowerCase()))
    )
  }

  if (dateFrom.value) {
    filtered = filtered.filter(s => new Date(s.sale_date) >= new Date(dateFrom.value))
  }

  if (dateTo.value) {
    filtered = filtered.filter(s => new Date(s.sale_date) <= new Date(dateTo.value))
  }

  return filtered
})

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString()
}

const viewSale = (sale) => {
  alert(`Sale Details:\nCustomer: ${sale.customer_name || 'Anonymous'}\nAmount: $${sale.total_amount}\nDate: ${formatDate(sale.sale_date)}`)
}

const deleteSale = async (id) => {
  if (confirm('Are you sure you want to delete this sale?')) {
    await warehouseStore.deleteSale(id)
  }
}

const handleSubmit = async () => {
  saleForm.created_by = authStore.profile?.id
  await warehouseStore.createSale(saleForm)
  closeModal()
}

const closeModal = () => {
  showAddModal.value = false
  Object.assign(saleForm, {
    customer_name: '',
    customer_contact: '',
    sale_date: new Date().toISOString().split('T')[0],
    total_amount: 0,
    notes: '',
    created_by: null
  })
}

onMounted(async () => {
  await warehouseStore.fetchSales()
})
</script>
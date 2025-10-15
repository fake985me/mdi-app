<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Warranties</h1>
        <p class="text-gray-600">Manage product warranties and customer information</p>
      </div>
      <button
        @click="showAddModal = true"
        class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors flex items-center space-x-2"
      >
        <Plus class="w-5 h-5" />
        <span>Add Warranty</span>
      </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Active Warranties</p>
            <p class="text-2xl font-bold text-green-600">{{ activeWarranties }}</p>
          </div>
          <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
            <Shield class="w-6 h-6 text-green-600" />
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Expiring Soon</p>
            <p class="text-2xl font-bold text-orange-600">{{ expiringSoon }}</p>
          </div>
          <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
            <AlertTriangle class="w-6 h-6 text-orange-600" />
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Expired</p>
            <p class="text-2xl font-bold text-red-600">{{ expiredWarranties }}</p>
          </div>
          <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
            <XCircle class="w-6 h-6 text-red-600" />
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
            placeholder="Search warranties..."
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
          <select
            v-model="statusFilter"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="expiring">Expiring Soon</option>
            <option value="expired">Expired</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Product</label>
          <select
            v-model="productFilter"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="">All Products</option>
            <option v-for="product in warehouseStore.products" :key="product.id" :value="product.id">
              {{ product.name }}
            </option>
          </select>
        </div>
      </div>
    </div>

    <!-- Warranties Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Product
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Customer
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Start Date
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                End Date
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="warranty in filteredWarranties" :key="warranty.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ warranty.products?.name }}</div>
                <div class="text-sm text-gray-500">{{ warranty.products?.sku }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ warranty.customer_name || 'N/A' }}</div>
                <div class="text-sm text-gray-500">{{ warranty.customer_contact || 'N/A' }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatDate(warranty.warranty_start_date) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatDate(warranty.warranty_end_date) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span
                  class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                  :class="getWarrantyStatusClass(warranty.warranty_end_date)"
                >
                  {{ getWarrantyStatus(warranty.warranty_end_date) }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button
                  @click="viewWarranty(warranty)"
                  class="text-blue-600 hover:text-blue-900 mr-3"
                >
                  View
                </button>
                <button
                  @click="deleteWarranty(warranty.id)"
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

    <!-- Add Warranty Modal -->
    <div v-if="showAddModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg p-6 w-full max-w-md max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Add Warranty</h3>
        
        <form @submit.prevent="handleSubmit" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Product</label>
            <select
              v-model="warrantyForm.product_id"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="">Select Product</option>
              <option v-for="product in warehouseStore.products" :key="product.id" :value="product.id">
                {{ product.name }} ({{ product.sku }})
              </option>
            </select>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Customer Name</label>
            <input
              v-model="warrantyForm.customer_name"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Customer Contact</label>
            <input
              v-model="warrantyForm.customer_contact"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Warranty Start Date</label>
            <input
              v-model="warrantyForm.warranty_start_date"
              type="date"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Warranty End Date</label>
            <input
              v-model="warrantyForm.warranty_end_date"
              type="date"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Warranty Terms</label>
            <textarea
              v-model="warrantyForm.warranty_terms"
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
              class="px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700"
            >
              Add Warranty
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, reactive } from 'vue'
import { useWarehouseStore } from '../../stores/warehouse'
import { Plus, Shield, AlertTriangle, XCircle } from 'lucide-vue-next'

const warehouseStore = useWarehouseStore()

const showAddModal = ref(false)
const searchQuery = ref('')
const statusFilter = ref('')
const productFilter = ref('')

const warrantyForm = reactive({
  product_id: '',
  customer_name: '',
  customer_contact: '',
  warranty_start_date: new Date().toISOString().split('T')[0],
  warranty_end_date: '',
  warranty_terms: ''
})

const activeWarranties = computed(() => {
  const now = new Date()
  return warehouseStore.warranties.filter(w => new Date(w.warranty_end_date) > now).length
})

const expiringSoon = computed(() => {
  const now = new Date()
  const thirtyDaysFromNow = new Date(now.getTime() + 30 * 24 * 60 * 60 * 1000)
  return warehouseStore.warranties.filter(w => {
    const endDate = new Date(w.warranty_end_date)
    return endDate > now && endDate <= thirtyDaysFromNow
  }).length
})

const expiredWarranties = computed(() => {
  const now = new Date()
  return warehouseStore.warranties.filter(w => new Date(w.warranty_end_date) <= now).length
})

const filteredWarranties = computed(() => {
  let filtered = warehouseStore.warranties

  if (searchQuery.value) {
    filtered = filtered.filter(w =>
      (w.products?.name && w.products.name.toLowerCase().includes(searchQuery.value.toLowerCase())) ||
      (w.customer_name && w.customer_name.toLowerCase().includes(searchQuery.value.toLowerCase()))
    )
  }

  if (statusFilter.value) {
    const now = new Date()
    const thirtyDaysFromNow = new Date(now.getTime() + 30 * 24 * 60 * 60 * 1000)
    
    filtered = filtered.filter(w => {
      const endDate = new Date(w.warranty_end_date)
      if (statusFilter.value === 'active') return endDate > thirtyDaysFromNow
      if (statusFilter.value === 'expiring') return endDate > now && endDate <= thirtyDaysFromNow
      if (statusFilter.value === 'expired') return endDate <= now
      return true
    })
  }

  if (productFilter.value) {
    filtered = filtered.filter(w => w.product_id === productFilter.value)
  }

  return filtered
})

const getWarrantyStatus = (endDate) => {
  const now = new Date()
  const end = new Date(endDate)
  const thirtyDaysFromNow = new Date(now.getTime() + 30 * 24 * 60 * 60 * 1000)

  if (end <= now) return 'Expired'
  if (end <= thirtyDaysFromNow) return 'Expiring Soon'
  return 'Active'
}

const getWarrantyStatusClass = (endDate) => {
  const status = getWarrantyStatus(endDate)
  const classes = {
    'Active': 'bg-green-100 text-green-800',
    'Expiring Soon': 'bg-orange-100 text-orange-800',
    'Expired': 'bg-red-100 text-red-800'
  }
  return classes[status]
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString()
}

const viewWarranty = (warranty) => {
  alert(`Warranty Details:\nProduct: ${warranty.products?.name}\nCustomer: ${warranty.customer_name}\nEnd Date: ${formatDate(warranty.warranty_end_date)}`)
}

const deleteWarranty = async (id) => {
  if (confirm('Are you sure you want to delete this warranty?')) {
    await warehouseStore.deleteWarranty(id)
  }
}

const handleSubmit = async () => {
  await warehouseStore.createWarranty(warrantyForm)
  closeModal()
}

const closeModal = () => {
  showAddModal.value = false
  Object.assign(warrantyForm, {
    product_id: '',
    customer_name: '',
    customer_contact: '',
    warranty_start_date: new Date().toISOString().split('T')[0],
    warranty_end_date: '',
    warranty_terms: ''
  })
}

onMounted(async () => {
  await warehouseStore.fetchWarranties()
  await warehouseStore.fetchProducts()
})
</script>
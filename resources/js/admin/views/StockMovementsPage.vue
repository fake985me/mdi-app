<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Stock Movements</h1>
        <p class="text-gray-600">Track all inventory movements and transactions</p>
      </div>
      <button
        @click="showAddModal = true"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2"
      >
        <Plus class="w-5 h-5" />
        <span>Add Movement</span>
      </button>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search movements..."
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Movement Type</label>
          <select
            v-model="typeFilter"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="">All Types</option>
            <option value="incoming">Incoming</option>
            <option value="outgoing">Outgoing</option>
            <option value="purchase">Purchase</option>
            <option value="sale">Sale</option>
            <option value="borrow">Borrow</option>
            <option value="return">Return</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
          <input
            v-model="dateFilter"
            type="date"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          />
        </div>
      </div>
    </div>

    <!-- Stock Movements Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Product
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Type
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Quantity
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Unit Price
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Total Amount
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Date
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Created By
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="movement in filteredMovements" :key="movement.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ movement.products?.name }}</div>
                <div class="text-sm text-gray-500">{{ movement.products?.sku }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span
                  class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                  :class="getMovementTypeClass(movement.movement_type)"
                >
                  {{ movement.movement_type }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ movement.quantity }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                ${{ movement.unit_price || '0.00' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                ${{ movement.total_amount || '0.00' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatDate(movement.created_at) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ movement.profiles?.full_name || 'System' }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Add Movement Modal -->
    <div v-if="showAddModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg p-6 w-full max-w-md max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Add Stock Movement</h3>
        
        <form @submit.prevent="handleSubmit" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Product</label>
            <select
              v-model="movementForm.product_id"
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
            <label class="block text-sm font-medium text-gray-700 mb-1">Movement Type</label>
            <select
              v-model="movementForm.movement_type"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="">Select Type</option>
              <option value="incoming">Incoming</option>
              <option value="outgoing">Outgoing</option>
              <option value="purchase">Purchase</option>
              <option value="sale">Sale</option>
              <option value="borrow">Borrow</option>
              <option value="return">Return</option>
            </select>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
            <input
              v-model="movementForm.quantity"
              type="number"
              min="1"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Unit Price</label>
            <input
              v-model="movementForm.unit_price"
              type="number"
              step="0.01"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
            <textarea
              v-model="movementForm.notes"
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
              class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
            >
              Add Movement
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
import { useAuthStore } from '../../stores/auth'
import { Plus } from 'lucide-vue-next'

const warehouseStore = useWarehouseStore()
const authStore = useAuthStore()

const showAddModal = ref(false)
const searchQuery = ref('')
const typeFilter = ref('')
const dateFilter = ref('')

const movementForm = reactive({
  product_id: '',
  movement_type: '',
  quantity: 1,
  unit_price: 0,
  notes: '',
  created_by: null
})

const filteredMovements = computed(() => {
  let filtered = warehouseStore.stockMovements

  if (searchQuery.value) {
    filtered = filtered.filter(m =>
      m.products?.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      m.products?.sku.toLowerCase().includes(searchQuery.value.toLowerCase())
    )
  }

  if (typeFilter.value) {
    filtered = filtered.filter(m => m.movement_type === typeFilter.value)
  }

  if (dateFilter.value) {
    filtered = filtered.filter(m => 
      new Date(m.created_at).toDateString() === new Date(dateFilter.value).toDateString()
    )
  }

  return filtered
})

const getMovementTypeClass = (type) => {
  const classes = {
    incoming: 'bg-green-100 text-green-800',
    outgoing: 'bg-red-100 text-red-800',
    purchase: 'bg-blue-100 text-blue-800',
    sale: 'bg-purple-100 text-purple-800',
    borrow: 'bg-orange-100 text-orange-800',
    return: 'bg-teal-100 text-teal-800'
  }
  return classes[type] || 'bg-gray-100 text-gray-800'
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString()
}

const handleSubmit = async () => {
  movementForm.created_by = authStore.profile?.id
  movementForm.total_amount = movementForm.quantity * (movementForm.unit_price || 0)
  
  await warehouseStore.createStockMovement(movementForm)
  closeModal()
}

const closeModal = () => {
  showAddModal.value = false
  Object.assign(movementForm, {
    product_id: '',
    movement_type: '',
    quantity: 1,
    unit_price: 0,
    notes: '',
    created_by: null
  })
}

onMounted(async () => {
  await warehouseStore.fetchStockMovements()
  await warehouseStore.fetchProducts()
})
</script>
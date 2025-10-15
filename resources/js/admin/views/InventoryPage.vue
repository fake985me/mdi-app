<template>
  <div class="p-6">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Inventory Overview</h1>
      <p class="text-gray-600">Monitor stock levels and inventory status</p>
    </div>

    <!-- Stock Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Total Items</p>
            <p class="text-2xl font-bold text-gray-900">{{ totalItems }}</p>
          </div>
          <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
            <Package class="w-6 h-6 text-blue-600" />
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Low Stock</p>
            <p class="text-2xl font-bold text-orange-600">{{ lowStockCount }}</p>
          </div>
          <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
            <AlertTriangle class="w-6 h-6 text-orange-600" />
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Out of Stock</p>
            <p class="text-2xl font-bold text-red-600">{{ outOfStockCount }}</p>
          </div>
          <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
            <XCircle class="w-6 h-6 text-red-600" />
          </div>
        </div>
      </div>
    </div>

    <!-- Inventory Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
      <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
          <h2 class="text-lg font-semibold text-gray-900">Inventory Status</h2>
          <div class="flex space-x-4">
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search products..."
              class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
            <select
              v-model="statusFilter"
              class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="">All Status</option>
              <option value="normal">Normal Stock</option>
              <option value="low">Low Stock</option>
              <option value="out">Out of Stock</option>
            </select>
          </div>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Product
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                SKU
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Category
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Current Stock
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Min Stock
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
            <tr v-for="product in filteredProducts" :key="product.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10">
                    <img
                      v-if="product.image_url"
                      :src="product.image_url"
                      :alt="product.name"
                      class="h-10 w-10 rounded-lg object-cover"
                    />
                    <div v-else class="h-10 w-10 bg-gray-200 rounded-lg flex items-center justify-center">
                      <Package class="w-5 h-5 text-gray-400" />
                    </div>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ product.name }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ product.sku }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ product.categories?.name || 'Uncategorized' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium"
                  :class="getStockColorClass(product.current_stock, product.minimum_stock)">
                {{ product.current_stock }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ product.minimum_stock }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span
                  class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                  :class="getStatusBadgeClass(product.current_stock, product.minimum_stock)"
                >
                  {{ getStockStatus(product.current_stock, product.minimum_stock) }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button
                  @click="adjustStock(product)"
                  class="text-blue-600 hover:text-blue-900 mr-3"
                >
                  Adjust Stock
                </button>
                <router-link
                  :to="`/products`"
                  class="text-gray-600 hover:text-gray-900"
                >
                  View Details
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Stock Adjustment Modal -->
    <div v-if="showAdjustModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg p-6 w-full max-w-md max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Adjust Stock</h3>
        
        <div class="mb-4">
          <p class="text-sm text-gray-600 mb-2">Product: {{ selectedProduct?.name }}</p>
          <p class="text-sm text-gray-600 mb-4">Current Stock: {{ selectedProduct?.current_stock }}</p>
        </div>
        
        <form @submit.prevent="handleStockAdjustment" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Movement Type</label>
            <select
              v-model="stockForm.movement_type"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="incoming">Incoming (Add Stock)</option>
              <option value="outgoing">Outgoing (Remove Stock)</option>
            </select>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
            <input
              v-model="stockForm.quantity"
              type="number"
              min="1"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
            <textarea
              v-model="stockForm.notes"
              rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              placeholder="Optional notes about this stock movement"
            ></textarea>
          </div>
          
          <div class="flex justify-end space-x-4">
            <button
              type="button"
              @click="closeAdjustModal"
              class="px-4 py-2 text-gray-600 hover:text-gray-800"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
            >
              Adjust Stock
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
import { Package, AlertTriangle, XCircle } from 'lucide-vue-next'

const warehouseStore = useWarehouseStore()
const authStore = useAuthStore()

const searchQuery = ref('')
const statusFilter = ref('')
const showAdjustModal = ref(false)
const selectedProduct = ref(null)

const stockForm = reactive({
  movement_type: 'incoming',
  quantity: 1,
  notes: ''
})

const totalItems = computed(() => {
  return warehouseStore.products.reduce((sum, product) => sum + product.current_stock, 0)
})

const lowStockCount = computed(() => {
  return warehouseStore.products.filter(p => 
    p.current_stock > 0 && p.current_stock <= p.minimum_stock
  ).length
})

const outOfStockCount = computed(() => {
  return warehouseStore.products.filter(p => p.current_stock === 0).length
})

const filteredProducts = computed(() => {
  let filtered = warehouseStore.products

  if (searchQuery.value) {
    filtered = filtered.filter(p =>
      p.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      p.sku.toLowerCase().includes(searchQuery.value.toLowerCase())
    )
  }

  if (statusFilter.value) {
    if (statusFilter.value === 'normal') {
      filtered = filtered.filter(p => p.current_stock > p.minimum_stock)
    } else if (statusFilter.value === 'low') {
      filtered = filtered.filter(p => p.current_stock > 0 && p.current_stock <= p.minimum_stock)
    } else if (statusFilter.value === 'out') {
      filtered = filtered.filter(p => p.current_stock === 0)
    }
  }

  return filtered
})

const getStockStatus = (currentStock, minStock) => {
  if (currentStock === 0) return 'Out of Stock'
  if (currentStock <= minStock) return 'Low Stock'
  return 'Normal'
}

const getStockColorClass = (currentStock, minStock) => {
  if (currentStock === 0) return 'text-red-600'
  if (currentStock <= minStock) return 'text-orange-600'
  return 'text-green-600'
}

const getStatusBadgeClass = (currentStock, minStock) => {
  if (currentStock === 0) return 'bg-red-100 text-red-800'
  if (currentStock <= minStock) return 'bg-orange-100 text-orange-800'
  return 'bg-green-100 text-green-800'
}

const adjustStock = (product) => {
  selectedProduct.value = product
  showAdjustModal.value = true
}

const closeAdjustModal = () => {
  showAdjustModal.value = false
  selectedProduct.value = null
  stockForm.movement_type = 'incoming'
  stockForm.quantity = 1
  stockForm.notes = ''
}

const handleStockAdjustment = async () => {
  if (!selectedProduct.value) return

  const movement = {
    product_id: selectedProduct.value.id,
    movement_type: stockForm.movement_type,
    quantity: parseInt(stockForm.quantity),
    notes: stockForm.notes,
    created_by: authStore.profile?.id
  }

  await warehouseStore.createStockMovement(movement)
  closeAdjustModal()
}

onMounted(async () => {
  await warehouseStore.fetchProducts()
  await warehouseStore.fetchCategories()
})
</script>
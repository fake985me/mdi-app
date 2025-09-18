<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Borrowings</h1>
        <p class="text-gray-600">Manage item borrowing and returns</p>
      </div>
      <button
        @click="showAddModal = true"
        class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors flex items-center space-x-2"
      >
        <Plus class="w-5 h-5" />
        <span>Add Borrowing</span>
      </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Active Borrowings</p>
            <p class="text-2xl font-bold text-blue-600">{{ activeBorrowings }}</p>
          </div>
          <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
            <ArrowLeftRight class="w-6 h-6 text-blue-600" />
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Overdue</p>
            <p class="text-2xl font-bold text-red-600">{{ overdueBorrowings }}</p>
          </div>
          <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
            <AlertTriangle class="w-6 h-6 text-red-600" />
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Returned</p>
            <p class="text-2xl font-bold text-green-600">{{ returnedBorrowings }}</p>
          </div>
          <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
            <CheckCircle class="w-6 h-6 text-green-600" />
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
            placeholder="Search borrowings..."
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
            <option value="overdue">Overdue</option>
            <option value="returned">Returned</option>
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

    <!-- Borrowings Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Product
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Borrower
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Quantity
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Borrow Date
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Expected Return
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
            <tr v-for="borrowing in filteredBorrowings" :key="borrowing.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ borrowing.products?.name }}</div>
                <div class="text-sm text-gray-500">{{ borrowing.products?.sku }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ borrowing.borrower_name }}</div>
                <div class="text-sm text-gray-500">{{ borrowing.borrower_contact || 'N/A' }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ borrowing.quantity }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatDate(borrowing.borrow_date) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatDate(borrowing.expected_return_date) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span
                  class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                  :class="getBorrowingStatusClass(borrowing)"
                >
                  {{ getBorrowingStatus(borrowing) }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button
                  v-if="borrowing.status === 'active'"
                  @click="returnBorrowing(borrowing.id)"
                  class="text-green-600 hover:text-green-900 mr-3"
                >
                  Mark Returned
                </button>
                <button
                  @click="viewBorrowing(borrowing)"
                  class="text-blue-600 hover:text-blue-900 mr-3"
                >
                  View
                </button>
                <button
                  @click="deleteBorrowing(borrowing.id)"
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

    <!-- Add Borrowing Modal -->
    <div v-if="showAddModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg p-6 w-full max-w-md max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Add Borrowing</h3>
        
        <form @submit.prevent="handleSubmit" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Product</label>
            <select
              v-model="borrowingForm.product_id"
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
            <label class="block text-sm font-medium text-gray-700 mb-1">Borrower Name</label>
            <input
              v-model="borrowingForm.borrower_name"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Borrower Contact</label>
            <input
              v-model="borrowingForm.borrower_contact"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
            <input
              v-model="borrowingForm.quantity"
              type="number"
              min="1"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Borrow Date</label>
            <input
              v-model="borrowingForm.borrow_date"
              type="date"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Expected Return Date</label>
            <input
              v-model="borrowingForm.expected_return_date"
              type="date"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
            <textarea
              v-model="borrowingForm.notes"
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
              class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700"
            >
              Add Borrowing
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
import { Plus, ArrowLeftRight, AlertTriangle, CheckCircle } from 'lucide-vue-next'

const warehouseStore = useWarehouseStore()
const authStore = useAuthStore()

const showAddModal = ref(false)
const searchQuery = ref('')
const statusFilter = ref('')
const productFilter = ref('')

const borrowingForm = reactive({
  product_id: '',
  borrower_name: '',
  borrower_contact: '',
  quantity: 1,
  borrow_date: new Date().toISOString().split('T')[0],
  expected_return_date: '',
  notes: '',
  created_by: null
})

const activeBorrowings = computed(() => {
  return warehouseStore.borrowings.filter(b => b.status === 'active').length
})

const overdueBorrowings = computed(() => {
  return warehouseStore.borrowings.filter(b => b.status === 'overdue').length
})

const returnedBorrowings = computed(() => {
  return warehouseStore.borrowings.filter(b => b.status === 'returned').length
})

const filteredBorrowings = computed(() => {
  let filtered = warehouseStore.borrowings

  if (searchQuery.value) {
    filtered = filtered.filter(b =>
      b.borrower_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      (b.products?.name && b.products.name.toLowerCase().includes(searchQuery.value.toLowerCase()))
    )
  }

  if (statusFilter.value) {
    if (statusFilter.value === 'overdue') {
      const now = new Date()
      filtered = filtered.filter(b => 
        b.status === 'active' && new Date(b.expected_return_date) < now
      )
    } else {
      filtered = filtered.filter(b => b.status === statusFilter.value)
    }
  }

  if (productFilter.value) {
    filtered = filtered.filter(b => b.product_id === productFilter.value)
  }

  return filtered
})

const getBorrowingStatus = (borrowing) => {
  if (borrowing.status === 'returned') return 'Returned'
  
  const now = new Date()
  const expectedReturn = new Date(borrowing.expected_return_date)
  
  if (expectedReturn < now) return 'Overdue'
  return 'Active'
}

const getBorrowingStatusClass = (borrowing) => {
  const status = getBorrowingStatus(borrowing)
  const classes = {
    'Active': 'bg-blue-100 text-blue-800',
    'Overdue': 'bg-red-100 text-red-800',
    'Returned': 'bg-green-100 text-green-800'
  }
  return classes[status]
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString()
}

const viewBorrowing = (borrowing) => {
  alert(`Borrowing Details:\nProduct: ${borrowing.products?.name}\nBorrower: ${borrowing.borrower_name}\nQuantity: ${borrowing.quantity}\nExpected Return: ${formatDate(borrowing.expected_return_date)}`)
}

const returnBorrowing = async (id) => {
  if (confirm('Mark this borrowing as returned?')) {
    await warehouseStore.returnBorrowing(id)
  }
}

const deleteBorrowing = async (id) => {
  if (confirm('Are you sure you want to delete this borrowing?')) {
    await warehouseStore.deleteBorrowing(id)
  }
}

const handleSubmit = async () => {
  borrowingForm.created_by = authStore.profile?.id
  await warehouseStore.createBorrowing(borrowingForm)
  closeModal()
}

const closeModal = () => {
  showAddModal.value = false
  Object.assign(borrowingForm, {
    product_id: '',
    borrower_name: '',
    borrower_contact: '',
    quantity: 1,
    borrow_date: new Date().toISOString().split('T')[0],
    expected_return_date: '',
    notes: '',
    created_by: null
  })
}

onMounted(async () => {
  await warehouseStore.fetchBorrowings()
  await warehouseStore.fetchProducts()
})
</script>
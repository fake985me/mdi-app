<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Purchases</h1>
        <p class="text-gray-600">Manage purchase orders and supplier transactions</p>
      </div>
      <button
        @click="showAddModal = true"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2"
      >
        <Plus class="w-5 h-5" />
        <span>Add Purchase</span>
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
            placeholder="Search purchases..."
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

    <!-- Purchases Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Supplier
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Contact
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Purchase Date
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
            <tr v-for="purchase in filteredPurchases" :key="purchase.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ purchase.supplier_name }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ purchase.supplier_contact || 'N/A' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatDate(purchase.purchase_date) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                ${{ purchase.total_amount }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ purchase.profiles?.full_name || 'System' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button
                  @click="viewPurchase(purchase)"
                  class="text-blue-600 hover:text-blue-900 mr-3"
                >
                  View
                </button>
                <button
                  @click="deletePurchase(purchase.id)"
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

    <!-- Add Purchase Modal -->
    <div v-if="showAddModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg p-6 w-full max-w-md max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Add Purchase</h3>
        
        <form @submit.prevent="handleSubmit" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Supplier Name</label>
            <input
              v-model="purchaseForm.supplier_name"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Supplier Contact</label>
            <input
              v-model="purchaseForm.supplier_contact"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Purchase Date</label>
            <input
              v-model="purchaseForm.purchase_date"
              type="date"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Total Amount</label>
            <input
              v-model="purchaseForm.total_amount"
              type="number"
              step="0.01"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
            <textarea
              v-model="purchaseForm.notes"
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
              Add Purchase
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
const dateFrom = ref('')
const dateTo = ref('')

const purchaseForm = reactive({
  supplier_name: '',
  supplier_contact: '',
  purchase_date: new Date().toISOString().split('T')[0],
  total_amount: 0,
  notes: '',
  created_by: null
})

const filteredPurchases = computed(() => {
  let filtered = warehouseStore.purchases

  if (searchQuery.value) {
    filtered = filtered.filter(p =>
      p.supplier_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      (p.supplier_contact && p.supplier_contact.toLowerCase().includes(searchQuery.value.toLowerCase()))
    )
  }

  if (dateFrom.value) {
    filtered = filtered.filter(p => new Date(p.purchase_date) >= new Date(dateFrom.value))
  }

  if (dateTo.value) {
    filtered = filtered.filter(p => new Date(p.purchase_date) <= new Date(dateTo.value))
  }

  return filtered
})

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString()
}

const viewPurchase = (purchase) => {
  alert(`Purchase Details:\nSupplier: ${purchase.supplier_name}\nAmount: $${purchase.total_amount}\nDate: ${formatDate(purchase.purchase_date)}`)
}

const deletePurchase = async (id) => {
  if (confirm('Are you sure you want to delete this purchase?')) {
    await warehouseStore.deletePurchase(id)
  }
}

const handleSubmit = async () => {
  purchaseForm.created_by = authStore.profile?.id
  await warehouseStore.createPurchase(purchaseForm)
  closeModal()
}

const closeModal = () => {
  showAddModal.value = false
  Object.assign(purchaseForm, {
    supplier_name: '',
    supplier_contact: '',
    purchase_date: new Date().toISOString().split('T')[0],
    total_amount: 0,
    notes: '',
    created_by: null
  })
}

onMounted(async () => {
  await warehouseStore.fetchPurchases()
})
</script>
<template>
  <div class="p-6">

    <!-- Loading State -->
    <div v-if="loading" class="flex justify-center items-center py-20">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <p class="text-sm text-red-700">
            <span class="font-medium">Error!</span> {{ error }}
          </p>
          <button 
            @click="loadNavigationItems"
            class="mt-2 text-sm font-medium text-red-700 hover:text-red-900"
          >
            Coba Lagi
          </button>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div v-else>
      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Navigation Management</h1>
          <p class="text-gray-600">Manage public navigation items and their structure</p>
        </div>
        <button
          @click="openCreateModal"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium flex items-center"
        >
          <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          Add Navigation Item
        </button>
      </div>

      <!-- Navigation Table -->
      <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Path</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Public</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
              <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="item in navigationItems" :key="item.id">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ item.name }}</div>
                <div v-if="item.parent_id" class="text-sm text-gray-500">Child of {{ getParentName(item.parent_id) }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ item.path }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ item.slug }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span 
                  :class="[
                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                    item.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                  ]"
                >
                  {{ item.is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <button
                  @click="togglePublicStatus(item)"
                  :class="[
                    'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full',
                    item.is_public ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'
                  ]"
                >
                  {{ item.is_public ? 'Public' : 'Private' }}
                </button>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ item.sort_order }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <button
                  @click="openEditModal(item)"
                  class="text-indigo-600 hover:text-indigo-900 mr-3"
                >
                  Edit
                </button>
                <button
                  @click="deleteItem(item.id)"
                  class="text-red-600 hover:text-red-900"
                >
                  Delete
                </button>
              </td>
            </tr>
            
            <!-- Empty state -->
            <tr v-if="navigationItems.length === 0">
              <td colspan="7" class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No navigation items</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new navigation item.</p>
                <div class="mt-6">
                  <button
                    @click="openCreateModal"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                  >
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Create Navigation Item
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                  {{ editingItem ? 'Edit Navigation Item' : 'Add Navigation Item' }}
                </h3>
                
                <form class="space-y-4">
                  <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input
                      type="text"
                      id="name"
                      v-model="form.name"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                      placeholder="Display name for navigation"
                    />
                  </div>
                  
                  <div>
                    <label for="path" class="block text-sm font-medium text-gray-700">Path</label>
                    <input
                      type="text"
                      id="path"
                      v-model="form.path"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                      placeholder="/path/to/page"
                    />
                  </div>
                  
                  <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                    <input
                      type="text"
                      id="slug"
                      v-model="form.slug"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                      placeholder="unique-identifier"
                    />
                  </div>
                  
                  <div>
                    <label for="parent" class="block text-sm font-medium text-gray-700">Parent Navigation</label>
                    <select
                      id="parent"
                      v-model="form.parent_id"
                      class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    >
                      <option value="">No Parent (Top Level)</option>
                      <option v-for="item in navigationItems" :key="item.id" :value="item.id">
                        {{ item.name }}
                      </option>
                    </select>
                  </div>
                  
                  <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700">Sort Order</label>
                    <input
                      type="number"
                      id="sort_order"
                      v-model.number="form.sort_order"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                      min="0"
                    />
                  </div>
                  
                  <div class="flex items-center">
                    <input
                      id="is_active"
                      type="checkbox"
                      v-model="form.is_active"
                      class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    />
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                  </div>
                  
                  <div class="flex items-center">
                    <input
                      id="is_public"
                      type="checkbox"
                      v-model="form.is_public"
                      class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    />
                    <label for="is_public" class="ml-2 block text-sm text-gray-900">Public</label>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button
              @click="saveItem"
              type="button"
              class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
            >
              {{ editingItem ? 'Update' : 'Create' }}
            </button>
            <button
              @click="closeModal"
              type="button"
              class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
            >
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useNavigationStore } from '../stores/navigation'

// Store and state
const navigationStore = useNavigationStore()
const navigationItems = ref([])
const loading = ref(true)
const error = ref(null)
const showModal = ref(false)
const editingItem = ref(null)

// Form state
const form = ref({
  name: '',
  path: '',
  slug: '',
  parent_id: null,
  sort_order: 0,
  is_active: true,
  is_public: true
})

// Lifecycle
onMounted(() => {
  loadNavigationItems()
})

// Methods
const loadNavigationItems = async () => {
  try {
    loading.value = true
    error.value = null
    navigationItems.value = await navigationStore.getNavigationItems()
  } catch (err) {
    error.value = err.message || 'An error occurred while loading navigation items'
    console.error('Error loading navigation items:', err)
  } finally {
    loading.value = false
  }
}

const openCreateModal = () => {
  resetForm()
  editingItem.value = null
  showModal.value = true
}

const openEditModal = (item) => {
  // Copy item properties to form
  form.value = {
    name: item.name || '',
    path: item.path || '',
    slug: item.slug || '',
    parent_id: item.parent_id || null,
    sort_order: item.sort_order || 0,
    is_active: item.is_active !== undefined ? item.is_active : false,
    is_public: item.is_public !== undefined ? item.is_public : false
  }
  editingItem.value = item
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  editingItem.value = null
  resetForm()
}

const resetForm = () => {
  form.value = {
    name: '',
    path: '',
    slug: '',
    parent_id: null,
    sort_order: 0,
    is_active: true,
    is_public: true
  }
}

const saveItem = async () => {
  try {
    // Prepare data with proper type conversion
    const itemData = {
      name: form.value.name.trim(),
      path: form.value.path.trim(),
      slug: form.value.slug.trim(),
      parent_id: form.value.parent_id || null,
      sort_order: parseInt(form.value.sort_order) || 0,
      is_active: Boolean(form.value.is_active),
      is_public: Boolean(form.value.is_public)
    }

    // Validate required fields
    if (!itemData.name || !itemData.path || !itemData.slug) {
      error.value = 'Name, path, and slug are required fields'
      return
    }

    if (editingItem.value) {
      await navigationStore.updateNavigationItem(editingItem.value.id, itemData)
    } else {
      await navigationStore.createNavigationItem(itemData)
    }

    await loadNavigationItems()
    closeModal()
  } catch (err) {
    error.value = err.message || 'An error occurred while saving navigation item'
    console.error('Error saving navigation item:', err)
  }
}

const deleteItem = async (id) => {
  if (!confirm('Are you sure you want to delete this navigation item?')) return

  try {
    await navigationStore.deleteNavigationItem(id)
    await loadNavigationItems()
  } catch (err) {
    error.value = err.message || 'An error occurred while deleting navigation item'
    console.error('Error deleting navigation item:', err)
  }
}

const togglePublicStatus = async (item) => {
  try {
    const updatedItem = {
      ...item,
      is_public: !item.is_public
    }
    await navigationStore.updateNavigationItem(item.id, updatedItem)
    // Update local item
    item.is_public = updatedItem.is_public
  } catch (err) {
    error.value = err.message || 'An error occurred while updating public status'
    console.error('Error updating navigation item public status:', err)
  }
}

const getParentName = (parentId) => {
  const parent = navigationItems.value.find(item => item.id === parentId)
  return parent ? parent.name : 'Unknown'
}
</script>
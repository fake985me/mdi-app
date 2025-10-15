<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Categories</h1>
        <p class="text-gray-600">Manage product categories and subcategories</p>
      </div>
      <button
        @click="showAddCategoryModal = true"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2"
      >
        <Plus class="w-5 h-5" />
        <span>Add Category</span>
      </button>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Categories -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
          <h2 class="text-lg font-semibold text-gray-900">Categories</h2>
        </div>
        <div class="p-6">
          <div class="space-y-4">
            <div
              v-for="category in warehouseStore.categories"
              :key="category.id"
              class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors"
            >
              <div>
                <h3 class="font-medium text-gray-900">{{ category.name }}</h3>
                <p class="text-sm text-gray-600">{{ category.description || 'No description' }}</p>
                <p class="text-xs text-gray-500 mt-1">
                  {{ getSubcategoryCount(category.id) }} subcategories
                </p>
              </div>
              <div class="flex space-x-2">
                <button
                  @click="editCategory(category)"
                  class="text-blue-600 hover:text-blue-800 p-1"
                >
                  <Edit2 class="w-4 h-4" />
                </button>
                <button
                  @click="deleteCategory(category.id)"
                  class="text-red-600 hover:text-red-800 p-1"
                >
                  <Trash2 class="w-4 h-4" />
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Subcategories -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
          <h2 class="text-lg font-semibold text-gray-900">Subcategories</h2>
          <button
            @click="showAddSubcategoryModal = true"
            class="bg-green-600 text-white px-3 py-1 rounded-md hover:bg-green-700 transition-colors text-sm flex items-center space-x-1"
          >
            <Plus class="w-4 h-4" />
            <span>Add Subcategory</span>
          </button>
        </div>
        <div class="p-6">
          <div class="space-y-4">
            <div
              v-for="subcategory in warehouseStore.subcategories"
              :key="subcategory.id"
              class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors"
            >
              <div>
                <h3 class="font-medium text-gray-900">{{ subcategory.name }}</h3>
                <p class="text-sm text-gray-600">{{ subcategory.description || 'No description' }}</p>
                <p class="text-xs text-gray-500 mt-1">
                  Category: {{ subcategory.categories?.name }}
                </p>
              </div>
              <div class="flex space-x-2">
                <button
                  @click="editSubcategory(subcategory)"
                  class="text-blue-600 hover:text-blue-800 p-1"
                >
                  <Edit2 class="w-4 h-4" />
                </button>
                <button
                  @click="deleteSubcategory(subcategory.id)"
                  class="text-red-600 hover:text-red-800 p-1"
                >
                  <Trash2 class="w-4 h-4" />
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Category Modal -->
    <div v-if="showAddCategoryModal || editingCategory" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg p-6 w-full max-w-md max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
          {{ editingCategory ? 'Edit Category' : 'Add New Category' }}
        </h3>
        
        <form @submit.prevent="handleCategorySubmit" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input
              v-model="categoryForm.name"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea
              v-model="categoryForm.description"
              rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            ></textarea>
          </div>
          
          <div class="flex justify-end space-x-4">
            <button
              type="button"
              @click="closeCategoryModal"
              class="px-4 py-2 text-gray-600 hover:text-gray-800"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
            >
              {{ editingCategory ? 'Update' : 'Add' }} Category
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Add Subcategory Modal -->
    <div v-if="showAddSubcategoryModal || editingSubcategory" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg p-6 w-full max-w-md max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
          {{ editingSubcategory ? 'Edit Subcategory' : 'Add New Subcategory' }}
        </h3>
        
        <form @submit.prevent="handleSubcategorySubmit" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select
              v-model="subcategoryForm.category_id"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="">Select Category</option>
              <option v-for="category in warehouseStore.categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </select>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input
              v-model="subcategoryForm.name"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea
              v-model="subcategoryForm.description"
              rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            ></textarea>
          </div>
          
          <div class="flex justify-end space-x-4">
            <button
              type="button"
              @click="closeSubcategoryModal"
              class="px-4 py-2 text-gray-600 hover:text-gray-800"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
            >
              {{ editingSubcategory ? 'Update' : 'Add' }} Subcategory
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
import { Plus, Edit2, Trash2 } from 'lucide-vue-next'

const warehouseStore = useWarehouseStore()

const showAddCategoryModal = ref(false)
const showAddSubcategoryModal = ref(false)
const editingCategory = ref(null)
const editingSubcategory = ref(null)

const categoryForm = reactive({
  name: '',
  description: ''
})

const subcategoryForm = reactive({
  category_id: '',
  name: '',
  description: ''
})

const getSubcategoryCount = (categoryId) => {
  return warehouseStore.subcategories.filter(sub => sub.category_id === categoryId).length
}

const editCategory = (category) => {
  editingCategory.value = category
  Object.assign(categoryForm, {
    name: category.name,
    description: category.description || ''
  })
}

const editSubcategory = (subcategory) => {
  editingSubcategory.value = subcategory
  Object.assign(subcategoryForm, {
    category_id: subcategory.category_id,
    name: subcategory.name,
    description: subcategory.description || ''
  })
}

const deleteCategory = async (id) => {
  if (confirm('Are you sure you want to delete this category? This will also delete all associated subcategories.')) {
    const result = await warehouseStore.deleteCategory(id)
    if (result.error) {
      alert('Error deleting category: ' + result.error.message)
    }
  }
}

const deleteSubcategory = async (id) => {
  if (confirm('Are you sure you want to delete this subcategory?')) {
    const result = await warehouseStore.deleteSubcategory(id)
    if (result.error) {
      alert('Error deleting subcategory: ' + result.error.message)
    }
  }
}

const handleCategorySubmit = async () => {
  if (editingCategory.value) {
    await warehouseStore.updateCategory(editingCategory.value.id, categoryForm)
  } else {
    await warehouseStore.createCategory(categoryForm)
  }
  closeCategoryModal()
}

const handleSubcategorySubmit = async () => {
  if (editingSubcategory.value) {
    await warehouseStore.updateSubcategory(editingSubcategory.value.id, subcategoryForm)
  } else {
    await warehouseStore.createSubcategory(subcategoryForm)
  }
  closeSubcategoryModal()
}

const closeCategoryModal = () => {
  showAddCategoryModal.value = false
  editingCategory.value = null
  Object.assign(categoryForm, {
    name: '',
    description: ''
  })
}

const closeSubcategoryModal = () => {
  showAddSubcategoryModal.value = false
  editingSubcategory.value = null
  Object.assign(subcategoryForm, {
    category_id: '',
    name: '',
    description: ''
  })
}

onMounted(async () => {
  await warehouseStore.fetchCategories()
  await warehouseStore.fetchSubcategories()
})
</script>
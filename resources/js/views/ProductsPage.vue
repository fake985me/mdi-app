<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Products</h1>
        <p class="text-gray-600">Manage your product inventory</p>
      </div>
      <button
        @click="showAddModal = true"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2"
      >
        <Plus class="w-5 h-5" />
        <span>Add Product</span>
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
            placeholder="Search products..."
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
          <select
            v-model="selectedCategory"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="">All Categories</option>
            <option v-for="category in warehouseStore.categories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Subcategory</label>
          <select
            v-model="selectedSubcategory"
            :disabled="!selectedCategory"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-100 disabled:cursor-not-allowed"
          >
            <option value="">All Subcategories</option>
            <option v-for="subcategory in filteredSubcategories" :key="subcategory.id" :value="subcategory.id">
              {{ subcategory.name }}
            </option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Stock Status</label>
          <select
            v-model="stockFilter"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="">All Items</option>
            <option value="low">Low Stock</option>
            <option value="out">Out of Stock</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Import/Export Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-900">Import/Export Products</h2>
        <div class="flex space-x-3">
          <button
            @click="triggerImportClick"
            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center space-x-2"
          >
            <Upload class="w-5 h-5" />
            <span>Import Products</span>
          </button>
          <button
            @click="exportProducts"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2"
          >
            <Download class="w-5 h-5" />
            <span>Export Products</span>
          </button>
          <input
            ref="fileInput"
            type="file"
            accept=".xlsx,.xls,.csv"
            class="hidden"
            @change="handleFileImport"
          />
        </div>
      </div>
      <div v-if="importProgress" class="mt-3">
        <div class="w-full bg-gray-200 rounded-full h-2.5">
          <div 
            class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" 
            :style="{ width: importProgress + '%' }" 
          ></div>
        </div>
        <p class="text-sm text-gray-600 mt-1">{{ importProgress }}% Complete</p>
      </div>
      <div v-if="importResult" class="mt-3 p-3 bg-gray-50 rounded-md">
        <p class="text-sm text-green-600" v-if="importResult.success">{{ importResult.message }}</p>
        <div v-else class="text-sm text-red-600">
          <p>{{ importResult.message }}</p>
          <ul class="mt-1 list-disc list-inside" v-if="importResult.errors && importResult.errors.length > 0">
            <li v-for="(error, index) in importResult.errors" :key="index" class="text-xs">{{ error }}</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      <div
        v-for="product in filteredProducts"
        :key="product.id"
        class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow"
      >
        <div class="h-48 bg-gray-100 flex items-center justify-center">
          <img
            v-if="product.image_url"
            :src="product.image_url"
            :alt="product.name"
            class="w-full h-full object-cover"
          />
          <Box v-else class="w-16 h-16 text-gray-400" />
        </div>
        
        <div class="p-4">
          <div class="flex justify-between items-start mb-2">
            <h3 class="font-semibold text-gray-900 truncate">{{ product.name }}</h3>
            <div class="flex space-x-1">
              <button
                @click="editProduct(product)"
                class="text-blue-600 hover:text-blue-800 p-1"
              >
                <Edit2 class="w-4 h-4" />
              </button>
              <button
                @click="deleteProduct(product.id)"
                class="text-red-600 hover:text-red-800 p-1"
              >
                <Trash2 class="w-4 h-4" />
              </button>
            </div>
          </div>
          
          <div class="mb-2">
            <span class="text-sm text-gray-600">{{ product.categories?.name }}</span>
            <span v-if="product.subcategories?.name" class="text-sm text-gray-500"> / {{ product.subcategories.name }}</span>
          </div>
          <p class="text-xs text-gray-500 mb-3">SKU: {{ product.sku }}</p>
          
          <div class="space-y-2">
            <div class="flex justify-between">
              <span class="text-sm text-gray-600">Price:</span>
              <span class="text-sm font-medium text-green-600">${{ product.price }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-sm text-gray-600">Stock:</span>
              <span
                class="text-sm font-medium"
                :class="getStockColor(product.current_stock, product.minimum_stock)"
              >
                {{ product.current_stock }}
              </span>
            </div>
            <div class="flex justify-between">
              <span class="text-sm text-gray-600">Min Stock:</span>
              <span class="text-sm text-gray-900">{{ product.minimum_stock }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add/Edit Product Modal -->
    <div v-if="showAddModal || editingProduct" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg p-6 w-full max-w-md max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
          {{ editingProduct ? 'Edit Product' : 'Add New Product' }}
        </h3>
        
        <form @submit.prevent="handleSubmit" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input
              v-model="productForm.name"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
            <input
              v-model="productForm.sku"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select
              v-model="productForm.category_id"
              @change="onCategoryChange"
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
            <label class="block text-sm font-medium text-gray-700 mb-1">Subcategory</label>
            <select
              v-model="productForm.subcategory_id"
              :disabled="!productForm.category_id"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-100 disabled:cursor-not-allowed"
            >
              <option value="">Select Subcategory (Optional)</option>
              <option v-for="subcategory in availableSubcategories" :key="subcategory.id" :value="subcategory.id">
                {{ subcategory.name }}
              </option>
            </select>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
            <input
              v-model="productForm.price"
              type="number"
              step="0.01"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Current Stock</label>
            <input
              v-model="productForm.current_stock"
              type="number"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Minimum Stock</label>
            <input
              v-model="productForm.minimum_stock"
              type="number"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
            
            <!-- Upload Method Selection -->
            <div class="flex space-x-4 mb-3">
              <label class="flex items-center">
                <input
                  v-model="imageUploadMethod"
                  type="radio"
                  value="upload"
                  class="mr-2"
                />
                <span class="text-sm">Upload File</span>
              </label>
              <label class="flex items-center">
                <input
                  v-model="imageUploadMethod"
                  type="radio"
                  value="url"
                  class="mr-2"
                />
                <span class="text-sm">Image URL</span>
              </label>
            </div>

            <!-- File Upload -->
            <div v-if="imageUploadMethod === 'upload'" class="space-y-2">
              <input
                @change="handleImageUpload"
                type="file"
                accept="image/jpeg,image/png,image/gif,image/webp"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              />
              <p class="text-xs text-gray-500">Max size: 5MB. Formats: JPG, PNG, GIF, WebP</p>
              
              <!-- Upload Progress -->
              <div v-if="uploadProgress > 0 && uploadProgress < 100" class="w-full bg-gray-200 rounded-full h-2">
                <div 
                  class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                  :style="`width: ${uploadProgress}%`"
                ></div>
              </div>
            </div>

            <!-- URL Input -->
            <div v-if="imageUploadMethod === 'url'">
              <input
                v-model="productForm.image_url"
                type="url"
                placeholder="https://example.com/image.jpg"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              />
              <p class="text-xs text-gray-500 mt-1">Enter a direct link to an image</p>
            </div>

            <!-- Image Preview -->
            <div v-if="productForm.image_url" class="mt-3">
              <div class="relative inline-block">
                <img
                  :src="productForm.image_url"
                  alt="Product preview"
                  class="w-32 h-32 object-cover rounded-lg border border-gray-300"
                  @error="handleImageError"
                />
                <button
                  type="button"
                  @click="removeImage"
                  class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600"
                >
                  ×
                </button>
              </div>
            </div>
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
              {{ editingProduct ? 'Update' : 'Add' }} Product
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
import { Plus, Edit2, Trash2, Box, Upload, Download } from 'lucide-vue-next'

const warehouseStore = useWarehouseStore()

const showAddModal = ref(false)
const editingProduct = ref(null)
const imageUploadMethod = ref('upload')
const uploadProgress = ref(0)
const searchQuery = ref('')
const selectedCategory = ref('')
const selectedSubcategory = ref('')
const stockFilter = ref('')

const productForm = reactive({
  name: '',
  sku: '',
  category_id: '',
  subcategory_id: '',
  price: 0,
  current_stock: 0,
  minimum_stock: 0,
  image_url: ''
})

const fileInput = ref(null)
const importProgress = ref(0)
const importResult = ref(null)

const triggerImportClick = () => {
  fileInput.value.click()
}

const handleFileImport = async (event) => {
  const file = event.target.files[0]
  if (file) {
    try {
      importResult.value = null
      
      // Show progress (simulated for now)
      importProgress.value = 10
      
      // Call the store's import function
      const result = await warehouseStore.importProducts(file)
      
      importProgress.value = 100
      importResult.value = result
      
      // Reset after 3 seconds
      setTimeout(() => {
        importProgress.value = 0
      }, 3000)
    } catch (error) {
      importProgress.value = 0
      importResult.value = {
        success: false,
        message: error.message || 'Import failed'
      }
    }
  }
}

const exportProducts = async () => {
  try {
    const result = await warehouseStore.exportProducts()
    importResult.value = result
  } catch (error) {
    importResult.value = {
      success: false,
      message: error.message || 'Export failed'
    }
  }
}

// No subcategory-related computed properties since we don't have subcategories in our backend

const filteredProducts = computed(() => {
  let filtered = warehouseStore.products

  if (searchQuery.value) {
    filtered = filtered.filter(p =>
      p.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      p.sku.toLowerCase().includes(searchQuery.value.toLowerCase())
    )
  }

  if (selectedCategory.value) {
    filtered = filtered.filter(p => p.category_id === selectedCategory.value)
  }

  if (stockFilter.value === 'low') {
    filtered = filtered.filter(p => p.current_stock <= p.minimum_stock)
  } else if (stockFilter.value === 'out') {
    filtered = filtered.filter(p => p.current_stock === 0)
  }

  return filtered
})

const getStockColor = (currentStock, minStock) => {
  if (currentStock === 0) return 'text-red-600'
  if (currentStock <= minStock) return 'text-orange-600'
  return 'text-green-600'
}

const onCategoryChange = () => {
  // Category change handler - no subcategory to reset now
}

const editProduct = (product) => {
  editingProduct.value = product
  Object.assign(productForm, {
    name: product.name,
    sku: product.sku,
    category_id: product.category_id,
    subcategory_id: product.subcategory_id || '',
    price: product.price,
    current_stock: product.current_stock,
    minimum_stock: product.minimum_stock,
    image_url: product.image_url
  })
}

const deleteProduct = async (id) => {
  if (confirm('Are you sure you want to delete this product?')) {
    await warehouseStore.deleteProduct(id)
  }
}

const handleImageUpload = async (event) => {
  const file = event.target.files[0]
  if (file) {
    // Validate file size (5MB limit)
    if (file.size > 5 * 1024 * 1024) {
      alert('File size must be less than 5MB')
      return
    }

    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp']
    if (!allowedTypes.includes(file.type)) {
      alert('Please select a valid image file (JPG, PNG, GIF, WebP)')
      return
    }

    uploadProgress.value = 10
    const result = await warehouseStore.uploadImage(file)
    uploadProgress.value = 100
    
    if (result.success) {
      productForm.image_url = result.url
      setTimeout(() => {
        uploadProgress.value = 0
      }, 1000)
    } else {
      alert('Failed to upload image: ' + result.error)
      uploadProgress.value = 0
    }
  }
}

const handleImageError = () => {
  console.warn('Failed to load image:', productForm.image_url)
}

const removeImage = () => {
  productForm.image_url = ''
  uploadProgress.value = 0
}

const handleSubmit = async () => {
  if (editingProduct.value) {
    await warehouseStore.updateProduct(editingProduct.value.id, productForm)
  } else {
    await warehouseStore.createProduct(productForm)
  }
  closeModal()
}

const closeModal = () => {
  showAddModal.value = false
  editingProduct.value = null
  imageUploadMethod.value = 'upload'
  uploadProgress.value = 0
  Object.assign(productForm, {
    name: '',
    sku: '',
    category_id: '',
    subcategory_id: '',
    price: 0,
    current_stock: 0,
    minimum_stock: 0,
    image_url: ''
  })
}

onMounted(async () => {
  await warehouseStore.fetchProducts()
  await warehouseStore.fetchCategories()
  await warehouseStore.fetchSubcategories()
})
</script>
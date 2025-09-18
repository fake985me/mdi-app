<template>
  <div class="min-h-screen">
    <!-- Hero Section -->
    <section
      class="bg-gradient-primary text-white py-20 relative overflow-hidden"
    >
      <div class="absolute inset-0 bg-black opacity-10"></div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center relative z-10">
          <h1 class="text-5xl md:text-6xl font-bold mb-6 slide-in">
            Product Catalog
          </h1>
          <p
            class="text-xl md:text-2xl text-blue-100 slide-in"
            style="animation-delay: 0.2s"
          >
            Explore our comprehensive inventory
          </p>
        </div>
      </div>
    </section>

    <!-- Filters Section -->
    <section
      class="glass-dark shadow-lg border-b border-white border-opacity-20"
    >
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
          <div>
            <label class="block text-sm font-medium text-white mb-2"
              >Search Products</label
            >
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search by name or SKU..."
              class="form-input"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-white mb-2"
              >Category</label
            >
            <select v-model="selectedCategory" class="form-input">
              <option value="">All Categories</option>
              <option
                v-for="category in categories"
                :key="category.id"
                :value="category.id"
              >
                {{ category.name }}
              </option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-white mb-2"
              >Subcategory</label
            >
            <select v-model="selectedSubcategory" class="form-input">
              <option value="">All Subcategories</option>
              <option
                v-for="subcategory in subcategories"
                :key="subcategory.id"
                :value="subcategory.id"
              >
                {{ subcategory.name }}
              </option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-white mb-2"
              >Price Range</label
            >
            <select v-model="priceRange" class="form-input">
              <option value="">All Prices</option>
              <option value="0-50">$0 - $50</option>
              <option value="50-200">$50 - $200</option>
              <option value="200-500">$200 - $500</option>
              <option value="500+">$500+</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-white mb-2"
              >Sort By</label
            >
            <select v-model="sortBy" class="form-input">
              <option value="name">Name A-Z</option>
              <option value="price-low">Price: Low to High</option>
              <option value="price-high">Price: High to Low</option>
              <option value="stock">Stock Level</option>
            </select>
          </div>
        </div>
      </div>
    </section>

    <!-- Products Grid -->
    <section class="py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Loading State -->
        <div v-if="loading" class="flex justify-center items-center py-20">
          <div
            class="animate-spin rounded-full h-16 w-16 border-4 border-white border-t-transparent"
          ></div>
        </div>

        <!-- Products Grid -->
        <div
          v-else-if="filteredProducts.length > 0"
          class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8"
        >
          <div
            v-for="product in filteredProducts"
            :key="product.id"
            class="card card-hover overflow-hidden group"
          >
            <!-- Product Image -->
            <div
              class="relative h-64 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden"
            >
              <img
                v-if="product.image_url"
                :src="product.image_url"
                :alt="product.name"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                @error="handleImageError"
              />
              <div
                v-else
                class="w-full h-full flex items-center justify-center"
              >
                <Package class="w-16 h-16 text-gray-400" />
              </div>

              <!-- Stock Badge -->
              <div class="absolute top-3 right-3">
                <span
                  class="badge"
                  :class="
                    getStockBadgeClass(
                      product.current_stock,
                      product.minimum_stock
                    )
                  "
                >
                  {{
                    getStockStatus(product.current_stock, product.minimum_stock)
                  }}
                </span>
              </div>
            </div>

            <!-- Product Info -->
            <div class="p-6">
              <div class="mb-2">
                <span class="badge badge-info">
                  {{ product.categories?.name }}
                </span>
              </div>

              <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                {{ product.name }}
              </h3>
              <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                {{ product.description }}
              </p>

              <div class="flex items-center justify-between mb-3">
                <span class="text-xs text-gray-500 font-mono"
                  >SKU: {{ product.sku }}</span
                >
                <span class="text-sm text-gray-600"
                  >Stock: {{ product.current_stock }}</span
                >
              </div>

              <div class="flex items-center justify-between">
                <div class="flex flex-col">
                  <span class="text-2xl font-bold text-green-600"
                    >${{ product.price }}</span
                  >
                  <span
                    v-if="product.cost_price"
                    class="text-sm text-gray-500 line-through"
                  >
                    ${{ product.cost_price }}
                  </span>
                </div>
                <button
                  @click="viewProduct(product)"
                  class="btn btn-primary btn-animate"
                >
                  <Eye class="w-4 h-4 mr-2" />
                  View Details
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- No Products Found -->
        <div v-else class="text-center py-20">
          <Package class="w-16 h-16 text-white opacity-50 mx-auto mb-4" />
          <h3 class="text-lg font-medium text-white mb-2">No products found</h3>
          <p class="text-gray-300">
            Try adjusting your search criteria or filters.
          </p>
        </div>
      </div>
    </section>

    <!-- Product Details Modal -->
    <div v-if="selectedProduct" class="modal-backdrop">
      <div class="modal max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="relative">
          <!-- Close Button -->
          <button
            @click="selectedProduct = null"
            class="absolute top-4 right-4 z-10 p-2 glass rounded-full shadow-lg hover:bg-gray-100 transition-colors"
          >
            <X class="w-5 h-5 text-gray-600" />
          </button>

          <!-- Product Image -->
          <div
            class="h-80 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden rounded-t-xl"
          >
            <img
              v-if="selectedProduct.image_url"
              :src="selectedProduct.image_url"
              :alt="selectedProduct.name"
              class="w-full h-full object-cover"
            />
            <div v-else class="w-full h-full flex items-center justify-center">
              <Package class="w-20 h-20 text-gray-400" />
            </div>
          </div>

          <!-- Product Details -->
          <div class="p-8">
            <div class="mb-4">
              <span class="badge badge-info">
                {{ selectedProduct.categories?.name }}
              </span>
            </div>

            <h2 class="text-3xl font-bold text-gray-900 mb-4">
              {{ selectedProduct.name }}
            </h2>
            <p class="text-gray-600 mb-6">{{ selectedProduct.description }}</p>

            <div class="grid grid-cols-2 gap-6 mb-6">
              <div>
                <h4
                  class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2"
                >
                  Price
                </h4>
                <p class="text-3xl font-bold text-green-600">
                  ${{ selectedProduct.price }}
                </p>
              </div>
              <div>
                <h4
                  class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2"
                >
                  Stock
                </h4>
                <p
                  class="text-2xl font-semibold"
                  :class="
                    getStockColorClass(
                      selectedProduct.current_stock,
                      selectedProduct.minimum_stock
                    )
                  "
                >
                  {{ selectedProduct.current_stock }} units
                </p>
              </div>
            </div>

            <div class="border-t border-gray-200 border-opacity-30 pt-6">
              <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                  <dt class="text-sm font-medium text-gray-500">SKU</dt>
                  <dd class="mt-1 text-sm text-gray-900 font-mono">
                    {{ selectedProduct.sku }}
                  </dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500">
                    Minimum Stock
                  </dt>
                  <dd class="mt-1 text-sm text-gray-900">
                    {{ selectedProduct.minimum_stock }} units
                  </dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500">
                    Maximum Stock
                  </dt>
                  <dd class="mt-1 text-sm text-gray-900">
                    {{ selectedProduct.maximum_stock }} units
                  </dd>
                </div>
                <div>
                  <dt class="text-sm font-medium text-gray-500">Status</dt>
                  <dd class="mt-1">
                    <span
                      class="badge"
                      :class="
                        getStockBadgeClass(
                          selectedProduct.current_stock,
                          selectedProduct.minimum_stock
                        )
                      "
                    >
                      {{
                        getStockStatus(
                          selectedProduct.current_stock,
                          selectedProduct.minimum_stock
                        )
                      }}
                    </span>
                  </dd>
                </div>
              </dl>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { supabase } from '../lib/supabase'
import { Package, Eye, X } from 'lucide-vue-next'

const products = ref([])
const categories = ref([])
const subcategories = ref([])
const loading = ref(true)
const selectedProduct = ref(null)

// Filters
const searchQuery = ref('')
const selectedCategory = ref('')
const selectedSubcategory = ref('')
const priceRange = ref('')
const sortBy = ref('name')

const getStockBadgeClass = (stock) => {
  if (stock === 0) return 'bg-red-600'
  if (stock < 5) return 'bg-yellow-500'
  return 'bg-green-600'
}

const getStockStatus = (stock) => {
  if (stock === 0) return 'Out of Stock'
  if (stock < 5) return 'Low Stock'
  return 'In Stock'
}

const filteredProducts = computed(() => {
  let filtered = [...products.value]

  // Search filter
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(product =>
      product.name.toLowerCase().includes(query) ||
      product.sku.toLowerCase().includes(query) ||
      product.description?.toLowerCase().includes(query)
    )
  }

  // Category filter
  if (selectedCategory.value) {
    filtered = filtered.filter(product => product.category_id === selectedCategory.value)
  }

  // Subcategory filter
  if (selectedSubcategory.value) {
    filtered = filtered.filter(product => product.subcategory_id === selectedSubcategory.value)
  }

  // Price range filter
  if (priceRange.value) {
    const [min, max] = priceRange.value.split('-').map(p => p.replace('+', ''))
    filtered = filtered.filter(product => {
      const price = parseFloat(product.price)
      if (priceRange.value === '500+') return price >= 500
      return price >= parseFloat(min) && price <= parseFloat(max)
    })
  }

  // Sort
  filtered.sort((a, b) => {
    switch (sortBy.value) {
      case 'name':
        return a.name.localeCompare(b.name)
      case 'price-low':
        return parseFloat(a.price) - parseFloat(b.price)
      case 'price-high':
        return parseFloat(b.price) - parseFloat(a.price)
      case 'stock':
        return b.current_stock - a.current_stock
      default:
        return 0
    }
  })

  return filtered
})

const fetchProducts = async () => {
  try {
    const { data, error } = await supabase
      .from('products')
      .select('*')

    if (error) throw error
    products.value = data || []
  } catch (error) {
    console.error('Error fetching products:', error)
  }
}

const fetchCategories = async () => {
  try {
    const { data, error } = await supabase
      .from('categories')
      .select('*')
      .order('name')

    if (error) throw error
    categories.value = data || []
  } catch (error) {
    console.error('Error fetching categories:', error)
  }
}

const fetchSubcategories = async () => {
  try {
    const { data, error } = await supabase
      .from('subcategories')
      .select('*')
      .order('name')

    if (error) throw error
    subcategories.value = data || []
  } catch (error) {
    console.error('Error fetching subcategories:', error)
  }
}

onMounted(async () => {
  loading.value = true
  await Promise.all([fetchProducts(), fetchCategories(), fetchSubcategories()])
  loading.value = false
})
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>

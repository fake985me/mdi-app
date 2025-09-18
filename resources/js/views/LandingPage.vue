<template>
  <div class="min-h-screen">
    <!-- Hero Section -->
    <section id="hero" class="bg-gradient-primary text-white relative overflow-hidden">
      <div class="absolute inset-0 bg-black opacity-10"></div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center relative z-10">
          <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                aria-hidden="true"
                class="w-24 h-20"
                viewBox="0 0 2 2"
              >
                <path
                  fill="#3636e0"
                  d="M.892 1.548H.678v-.296q0-.034-.008-.047t-.027-.013q-.036 0-.036.061v.296H.394v-.296q0-.034-.008-.047t-.027-.014q-.036 0-.036.061v.296H.11V1.21q0-.092.064-.157T.331.988q.095 0 .17.077Q.585.988.669.988q.107 0 .172.075.051.058.051.17zM1.374.8h.214v.458q0 .126-.069.205-.04.046-.1.073t-.125.027q-.128 0-.215-.083t-.088-.202q0-.116.087-.201t.206-.085l.057.003v.227q-.026-.02-.053-.02-.033 0-.057.023t-.024.056q0 .032.024.055t.059.023q.082 0 .082-.11zm.578.199v.549h-.214V.999zM1.926.786q-.032-.03-.075-.03t-.075.03-.032.07q0 .014.003.026l.006.016q.007.016.021.028.03.028.077.028c.047 0 .057-.009.077-.028q.014-.013.021-.029l.002-.005q.006-.017.006-.037 0-.04-.032-.07m.065.016Q1.973.754 1.928.729T1.834.717q-.046.011-.068.048L1.763.77l-.001.002q.02-.036.066-.045.048-.01.092.014t.064.069q.017.042.001.077.021-.04.004-.087m.043-.02Q2.011.722 1.955.692c-.056-.03-.076-.025-.116-.015q-.056.014-.083.058l-.004.006-.001.002Q1.775.7 1.832.689q.058-.012.114.018t.078.085q.021.051.002.094.025-.049.004-.106"
                />
              </svg>
          <p class="text-xl md:text-2xl mb-8 text-blue-100 slide-in" style="animation-delay: 0.2s">
            Streamline your inventory, track stock movements, and manage your warehouse operations efficiently
          </p>
          <router-link
            to="/register"
            class="btn btn-primary btn-animate bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 slide-in"
            style="animation-delay: 0.4s"
          >
            Get Started
          </router-link>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 relative">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-white mb-4 slide-up">Everything You Need</h2>
          <p class="text-lg text-gray-300 slide-up" style="animation-delay: 0.2s">Comprehensive warehouse management features</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div class="card card-hover p-8 fade-in" style="animation-delay: 0.1s">
            <div class="w-12 h-12 bg-gradient-primary rounded-lg flex items-center justify-center mb-4 shadow-lg">
              <Package class="w-6 h-6 text-white" />
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Inventory Management</h3>
            <p class="text-gray-600">Track stock levels, set minimum quantities, and manage product information</p>
          </div>

          <div class="card card-hover p-8 fade-in" style="animation-delay: 0.2s">
            <div class="w-12 h-12 bg-gradient-success rounded-lg flex items-center justify-center mb-4 shadow-lg">
              <BarChart3 class="w-6 h-6 text-white" />
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Analytics Dashboard</h3>
            <p class="text-gray-600">Visualize your data with charts and reports for better decision making</p>
          </div>

          <div class="card card-hover p-8 fade-in" style="animation-delay: 0.3s">
            <div class="w-12 h-12 bg-gradient-to-r from-purple-400 to-pink-400 rounded-lg flex items-center justify-center mb-4 shadow-lg">
              <ShoppingCart class="w-6 h-6 text-white" />
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Sales & Purchases</h3>
            <p class="text-gray-600">Manage sales transactions and purchase orders seamlessly</p>
          </div>

          <div class="card card-hover p-8 fade-in" style="animation-delay: 0.4s">
            <div class="w-12 h-12 bg-gradient-to-r from-orange-400 to-red-400 rounded-lg flex items-center justify-center mb-4 shadow-lg">
              <Shield class="w-6 h-6 text-white" />
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Warranty Tracking</h3>
            <p class="text-gray-600">Keep track of product warranties and customer information</p>
          </div>

          <div class="card card-hover p-8 fade-in" style="animation-delay: 0.5s">
            <div class="w-12 h-12 bg-gradient-secondary rounded-lg flex items-center justify-center mb-4 shadow-lg">
              <ArrowLeftRight class="w-6 h-6 text-white" />
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Borrowing System</h3>
            <p class="text-gray-600">Manage item borrowing and returns with due date tracking</p>
          </div>

          <div class="card card-hover p-8 fade-in" style="animation-delay: 0.6s">
            <div class="w-12 h-12 bg-gradient-to-r from-teal-400 to-blue-400 rounded-lg flex items-center justify-center mb-4 shadow-lg">
              <Users class="w-6 h-6 text-white" />
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">User Management</h3>
            <p class="text-gray-600">Control access and manage user roles and permissions</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Products Showcase -->
    <section id="products" class="py-20 glass-dark">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-white mb-4 slide-up">Sample Products</h2>
          <p class="text-lg text-gray-300 slide-up" style="animation-delay: 0.2s">Explore our product catalog</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div
            v-for="product in randomProducts"
            :key="product.id"
            class="card card-hover overflow-hidden group fade-in"
            :style="`animation-delay: ${0.1 * (randomProducts.indexOf(product) + 1)}s`"
          >
            <div class="h-48 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center overflow-hidden">
              <img
                v-if="product.image_url"
                :src="product.image_url"
                :alt="product.name"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
              />
              <Box v-else class="w-16 h-16 text-gray-400" />
            </div>
            <div class="p-4">
              <h3 class="font-semibold text-gray-900 mb-1">{{ product.name }}</h3>
              <p class="text-sm text-gray-600 mb-2">{{ product.categories?.name }}</p>
              <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-green-600">
                  ${{ product.price }}
                </span>
                <span class="text-sm text-gray-500">
                  Stock: {{ product.current_stock }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="glass-dark text-white border-t border-white border-opacity-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center">
          <div class="flex items-center justify-center mb-4">
            <div class="w-8 h-8 bg-gradient-primary rounded-lg flex items-center justify-center mr-2 shadow-lg">
              <Package class="w-5 h-5 text-white" />
            </div>
            <span class="text-xl font-bold">Warehouse System</span>
          </div>
          <p class="text-gray-300 mb-4">Modern warehouse management for your business</p>
          <div class="space-y-2 text-sm text-gray-300">
            <p>Email: contact@warehouse-system.com</p>
            <p>Phone: +1 (555) 123-4567</p>
            <p>Address: 123 Warehouse St, Business City, BC 12345</p>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useWarehouseStore } from '../stores/warehouse'
import { Package, BarChart3, ShoppingCart, Shield, ArrowLeftRight, Users, Box } from 'lucide-vue-next'

const warehouseStore = useWarehouseStore()
const randomProducts = ref([])

onMounted(async () => {
  await warehouseStore.fetchProducts()
  // Get 8 random products
  const shuffled = [...warehouseStore.products].sort(() => 0.5 - Math.random())
  randomProducts.value = shuffled.slice(0, 8)
})
</script>
<template>
  <div class="min-h-screen">
    <!-- Dynamic Sections -->
    <div v-if="loading" class="flex justify-center items-center py-20">
      <div class="animate-spin rounded-full h-16 w-16 border-4 border-white border-t-transparent"></div>
    </div>
    
    <div v-else>
      <div v-for="section in activeSections" :key="section.id">
        <!-- Hero Section -->
        <section
          v-if="section.section_type === 'hero' && section.is_active"
          :style="{ backgroundColor: section.settings?.background_color || '#1e40af' }"
          class="text-white relative overflow-hidden"
        >
          <div class="absolute inset-0 opacity-10" 
               :style="{ backgroundColor: section.settings?.background_color || '#1e40af' }">
          </div>
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center relative z-10">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                aria-hidden="true"
                class="w-24 h-20"
                viewBox="0 0 2 2"
                v-if="!section.content?.image_url"
              >
                <path
                  fill="#3636e0"
                  d="M.892 1.548H.678v-.296q0-.034-.008-.047t-.027-.013q-.036 0-.036.061v.296H.394v-.296q0-.034-.008-.047t-.027-.014q-.036 0-.036.061v.296H.11V1.21q0-.092.064-.157T.331.988q.095 0 .17.077Q.585.988.669.988q.107 0 .172.075.051.058.051.17zM1.374.8h.214v.458q0 .126-.069.205-.04.046-.1.073t-.125.027q-.128 0-.215-.083t-.088-.202q0-.116.087-.201t.206-.085l.057.003v.227q-.026-.02-.053-.02-.033 0-.057.023t-.024.056q0 .032.024.055t.059.023q.082 0 .082-.11zm.578.199v.549h-.214V.999zM1.926.786q-.032-.03-.075-.03t-.075.03-.032.07q0 .014.003.026l.006.016q.007.016.021.028.03.028.077.028c.047 0 .057-.009.077-.028q.014-.013.021-.029l.002-.005q.006-.017.006-.037 0-.04-.032-.07m.065.016Q1.973.754 1.928.729T1.834.717q-.046.011-.068.048L1.763.77l-.001.002q.02-.036.066-.045.048-.01.092.014t.064.069q.017.042.001.077.021-.04.004-.087m.043-.02Q2.011.722 1.955.692c-.056-.03-.076-.025-.116-.015q-.056.014-.083.058l-.004.006-.001.002Q1.775.7 1.832.689q.058-.012.114.018t.078.085q.021.051.002.094.025-.049.004-.106"
                />
              </svg>
              <img
                v-if="section.content?.image_url"
                :src="section.content.image_url"
                :alt="section.content.title || 'Hero image'"
                class="mx-auto mb-6 h-20 object-contain"
              />
              <h1 
                class="text-4xl md:text-5xl font-bold mb-4 slide-in" 
                :style="{ color: section.settings?.text_color || '#ffffff' }"
                style="animation-delay: 0.2s"
              >
                {{ section.content?.title || 'Welcome to Our Store' }}
              </h1>
              <p 
                class="text-xl md:text-2xl mb-8 text-blue-100 slide-in" 
                :style="{ color: section.settings?.text_color || '#ffffff' }"
                style="animation-delay: 0.2s"
              >
                {{ section.content?.subtitle || 'Discover amazing products at great prices' }}
              </p>
              <router-link
                v-if="section.content?.cta_link"
                :to="section.content.cta_link"
                class="btn btn-primary btn-animate bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 slide-in"
                style="animation-delay: 0.4s"
              >
                {{ section.content?.cta_text || 'Get Started' }}
              </router-link>
            </div>
          </div>
        </section>

        <!-- Features Section -->
        <section
          v-else-if="section.section_type === 'features' && section.is_active"
          class="py-20 relative"
          :class="section.settings?.theme === 'dark' ? 'bg-gray-900 text-white' : 'bg-white text-gray-900'"
        >
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
              <h2 
                class="text-3xl font-bold mb-4 slide-up"
                :class="section.settings?.theme === 'dark' ? 'text-white' : 'text-gray-900'"
              >
                {{ section.content?.title || 'Why Choose Us' }}
              </h2>
              <p 
                class="text-lg text-gray-500 slide-up" 
                :class="section.settings?.theme === 'dark' ? 'text-gray-300' : 'text-gray-600'"
                style="animation-delay: 0.2s"
              >
                {{ section.content?.subtitle || 'We provide the best experience for our customers' }}
              </p>
            </div>

            <div 
              class="grid grid-cols-1 md:grid-cols-3 gap-8"
              :class="section.settings?.columns === 2 ? 'md:grid-cols-2' : section.settings?.columns === 4 ? 'md:grid-cols-4' : 'md:grid-cols-3'"
            >
              <div
                v-for="(feature, index) in section.content?.features || []"
                :key="index"
                class="card card-hover p-8 fade-in"
                :style="{ animationDelay: `${0.1 * (index + 1)}s` }"
              >
                <div class="w-12 h-12 bg-gradient-primary rounded-lg flex items-center justify-center mb-4 shadow-lg">
                  <component 
                    :is="feature.icon || 'Package'" 
                    class="w-6 h-6 text-white" 
                  />
                </div>
                <h3 
                  class="text-xl font-semibold mb-2"
                  :class="section.settings?.theme === 'dark' ? 'text-white' : 'text-gray-900'"
                >
                  {{ feature.title || 'Feature Title' }}
                </h3>
                <p 
                  class="text-gray-600"
                  :class="section.settings?.theme === 'dark' ? 'text-gray-300' : 'text-gray-600'"
                >
                  {{ feature.description || 'Feature description' }}
                </p>
              </div>
            </div>
          </div>
        </section>

        <!-- Products Showcase -->
        <section
          v-else-if="section.section_type === 'products' && section.is_active"
          class="py-20 glass-dark"
        >
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
              <h2 class="text-3xl font-bold text-white mb-4 slide-up">
                {{ section.content?.title || 'Featured Products' }}
              </h2>
              <p class="text-lg text-gray-300 slide-up" style="animation-delay: 0.2s">
                {{ section.content?.subtitle || 'Check out our most popular items' }}
              </p>
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

        <!-- Testimonials -->
        <section
          v-else-if="section.section_type === 'testimonials' && section.is_active"
          class="py-20"
          :class="section.settings?.theme === 'dark' ? 'bg-gray-900 text-white' : 'bg-gray-50 text-gray-900'"
        >
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
              <h2 
                class="text-3xl font-bold mb-4"
                :class="section.settings?.theme === 'dark' ? 'text-white' : 'text-gray-900'"
              >
                {{ section.content?.title || 'What Our Customers Say' }}
              </h2>
              <p 
                class="text-lg"
                :class="section.settings?.theme === 'dark' ? 'text-gray-300' : 'text-gray-600'"
              >
                {{ section.content?.subtitle || 'Hear from our satisfied customers' }}
              </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div
                v-for="(testimonial, index) in section.content?.testimonials || []"
                :key="index"
                class="bg-white p-6 rounded-lg shadow-md"
              >
                <div class="flex items-center mb-4">
                  <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                    <span class="font-semibold text-gray-700">
                      {{ testimonial.name?.charAt(0) || 'U' }}
                    </span>
                  </div>
                  <div>
                    <h4 class="font-semibold text-gray-900">{{ testimonial.name || 'Customer Name' }}</h4>
                    <p class="text-sm text-gray-500">{{ testimonial.position || 'Position' }}</p>
                  </div>
                </div>
                <p class="text-gray-600 mb-4">{{ testimonial.content || 'Testimonial content' }}</p>
                <div class="flex text-yellow-400">
                  <Star v-for="star in testimonial.rating || 5" :key="star" class="w-5 h-5" />
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Call to Action -->
        <section
          v-else-if="section.section_type === 'cta' && section.is_active"
          :style="{ backgroundColor: section.settings?.background_color || '#3b82f6' }"
          class="py-20 text-white"
        >
          <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 
              class="text-3xl font-bold mb-4"
              :style="{ color: section.settings?.text_color || '#ffffff' }"
            >
              {{ section.content?.title || 'Ready to get started?' }}
            </h2>
            <p 
              class="text-xl mb-8"
              :style="{ color: section.settings?.text_color || '#ffffff' }"
            >
              {{ section.content?.subtitle || 'Join thousands of satisfied customers today' }}
            </p>
            <router-link
              :to="section.content?.cta_link || '/register'"
              class="inline-block px-8 py-4 rounded-lg font-semibold transition-all duration-300"
              :style="{ 
                backgroundColor: section.settings?.button_color || '#ffffff',
                color: section.settings?.button_text_color || '#3b82f6'
              }"
            >
              {{ section.content?.cta_text || 'Get Started' }}
            </router-link>
          </div>
        </section>
      </div>
    </div>

    <!-- Default Footer if no footer section is configured -->
    <footer class="glass-dark text-white border-t border-white border-opacity-20">
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
import { useWarehouseStore } from '../../stores/warehouse'
import { useLandingPageStore } from '../../stores/landingPage'
import { Package, BarChart3, ShoppingCart, Shield, ArrowLeftRight, Users, Box, Star } from 'lucide-vue-next'

const warehouseStore = useWarehouseStore()
const landingPageStore = useLandingPageStore()
const randomProducts = ref([])
const activeSections = ref([])
const loading = ref(true)

onMounted(async () => {
  try {
    // Load both products and landing page sections
    await Promise.all([
      warehouseStore.fetchProducts(),
      loadActiveSections()
    ]);
    
    // Get 8 random products
    const shuffled = [...warehouseStore.products].sort(() => 0.5 - Math.random())
    randomProducts.value = shuffled.slice(0, 8)
  } catch (error) {
    console.error('Error loading data:', error)
  } finally {
    loading.value = false
  }
})

const loadActiveSections = async () => {
  try {
    activeSections.value = await landingPageStore.getActiveSections()
  } catch (error) {
    console.error('Error loading landing page sections:', error)
    // Fallback to empty array
    activeSections.value = []
  }
}
</script>
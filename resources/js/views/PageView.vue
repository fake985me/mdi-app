<template>
  <div v-if="loading" class="flex justify-center items-center py-20">
    <div class="animate-spin rounded-full h-16 w-16 border-4 border-blue-600 border-t-transparent"></div>
  </div>
  
  <div v-else-if="error" class="flex justify-center items-center py-20">
    <div class="text-center">
      <div class="text-red-500 mb-4">
        <AlertCircle class="w-16 h-16 mx-auto" />
      </div>
      <h2 class="text-2xl font-bold text-gray-900 mb-2">Error Loading Page</h2>
      <p class="text-gray-600">{{ error }}</p>
      <router-link 
        to="/" 
        class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors"
      >
        Back to Home
      </router-link>
    </div>
  </div>
  
  <div v-else-if="page" class="min-h-screen">
    <!-- Hero Section -->
    <section
      v-for="section in page.content"
      :key="section.id"
      :id="section.id"
      class="py-12"
      :class="getSectionClasses(section)"
    >
      <!-- Hero Section -->
      <div v-if="section.type === 'hero'" class="relative overflow-hidden">
        <div 
          v-if="section.content.image_url"
          class="absolute inset-0 bg-cover bg-center opacity-20"
          :style="{ backgroundImage: `url(${section.content.image_url})` }"
        ></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
          <div class="text-center py-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
              {{ section.content.title }}
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
              {{ section.content.subtitle }}
            </p>
            <router-link
              v-if="section.content.primary_button_text"
              :to="section.content.primary_button_url || '#' "
              class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors inline-block"
            >
              {{ section.content.primary_button_text }}
            </router-link>
          </div>
        </div>
      </div>
      
      <!-- Content with Image Section -->
      <div 
        v-else-if="section.type === 'content_with_image'" 
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
        :class="{
          'flex flex-col-reverse md:flex-row': section.settings.image_position === 'right',
          'flex flex-col md:flex-row': section.settings.image_position === 'left',
          'flex flex-col': section.settings.image_position === 'top'
        }"
      >
        <div 
          class="flex-1"
          :class="{
            'md:pr-12': section.settings.image_position === 'right',
            'md:pl-12': section.settings.image_position === 'left'
          }"
        >
          <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ section.content.title }}</h2>
          <div class="prose prose-lg text-gray-600" v-html="section.content.content"></div>
        </div>
        <div 
          class="flex-1 mb-8 md:mb-0"
          :class="{
            'md:pl-12': section.settings.image_position === 'right',
            'md:pr-12': section.settings.image_position === 'left'
          }"
        >
          <img 
            v-if="section.content.image_url" 
            :src="section.content.image_url" 
            :alt="section.content.title" 
            class="w-full h-auto rounded-lg shadow-lg"
          >
          <div v-else class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-64 flex items-center justify-center text-gray-400">
            <ImageIcon class="w-12 h-12" />
          </div>
        </div>
      </div>
      
      <!-- Carousel/Slider Section -->
      <div v-else-if="section.type === 'carousel'" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 v-if="section.content.title" class="text-3xl font-bold text-center text-gray-900 mb-8">
          {{ section.content.title }}
        </h2>
        
        <div class="relative">
          <div class="overflow-hidden rounded-xl">
            <div 
              class="flex transition-transform duration-500 ease-in-out"
              :style="{ transform: `translateX(-${(section.currentSlide || 0) * 100}%)` }"
            >
              <div 
                v-for="(slide, slideIndex) in section.content.slides" 
                :key="slideIndex"
                class="w-full flex-shrink-0"
              >
                <div class="relative h-96 md:h-[500px]">
                  <img 
                    v-if="slide.image_url" 
                    :src="slide.image_url" 
                    :alt="slide.alt_text || slide.title" 
                    class="w-full h-full object-cover"
                  >
                  <div v-else class="w-full h-full bg-gradient-to-r from-blue-400 to-indigo-600 flex items-center justify-center">
                    <ImageIcon class="w-16 h-16 text-white" />
                  </div>
                  <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                    <div class="text-center text-white px-4">
                      <h3 class="text-2xl md:text-4xl font-bold mb-2">{{ slide.title }}</h3>
                      <p class="text-lg md:text-xl mb-4">{{ slide.subtitle }}</p>
                      <p class="mb-6 max-w-2xl mx-auto">{{ slide.description }}</p>
                      <router-link
                        v-if="slide.button_text"
                        :to="slide.button_url || '#' "
                        class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-block"
                      >
                        {{ slide.button_text }}
                      </router-link>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Navigation Arrows -->
          <button 
            @click="prevSlide(index)"
            class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 rounded-full p-2 hover:bg-opacity-100 transition-all"
          >
            <ChevronLeft class="w-6 h-6 text-gray-800" />
          </button>
          <button 
            @click="nextSlide(index)"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 rounded-full p-2 hover:bg-opacity-100 transition-all"
          >
            <ChevronRight class="w-6 h-6 text-gray-800" />
          </button>
          
          <!-- Indicators -->
          <div class="flex justify-center mt-6 space-x-2">
            <button
              v-for="(slide, slideIndex) in section.content.slides"
              :key="slideIndex"
              @click="goToSlide(index, slideIndex)"
              :class="[
                'w-3 h-3 rounded-full transition-all',
                slideIndex === (section.currentSlide || 0) ? 'bg-blue-600 w-6' : 'bg-gray-300'
              ]"
            ></button>
          </div>
        </div>
      </div>
      
      <!-- Text Block Section -->
      <div v-else-if="section.type === 'text_block'" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ section.content.title }}</h2>
        <div class="prose prose-lg text-gray-600 mx-auto" v-html="section.content.content"></div>
      </div>
      
      <!-- Grid Layout Section -->
      <div v-else-if="section.type === 'grid_layout'" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 v-if="section.content.title" class="text-3xl font-bold text-center text-gray-900 mb-8">
          {{ section.content.title }}
        </h2>
        <div 
          class="grid gap-6"
          :class="[
            section.settings.columns === 2 ? 'md:grid-cols-2' : 
            section.settings.columns === 3 ? 'md:grid-cols-3' : 
            section.settings.columns === 4 ? 'md:grid-cols-4' : 'md:grid-cols-3'
          ]"
        >
          <div 
            v-for="(item, index) in section.content.items" 
            :key="index"
            class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow"
          >
            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ item.title }}</h3>
            <p class="text-gray-600">{{ item.description }}</p>
          </div>
        </div>
      </div>
      
      <!-- Features Section -->
      <div v-else-if="section.type === 'features'" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 v-if="section.content.title" class="text-3xl font-bold text-center text-gray-900 mb-8">
          {{ section.content.title }}
        </h2>
        <div 
          class="grid gap-8"
          :class="[
            section.content.features.length === 2 ? 'md:grid-cols-2' : 
            section.content.features.length === 3 ? 'md:grid-cols-3' : 
            section.content.features.length === 4 ? 'md:grid-cols-4' : 'md:grid-cols-3'
          ]"
        >
          <div 
            v-for="(feature, index) in section.content.features" 
            :key="index"
            class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow text-center"
          >
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <component 
                v-if="feature.icon" 
                :is="getFeatureIcon(feature.icon)" 
                class="w-6 h-6 text-blue-600" 
              />
              <Star v-else class="w-6 h-6 text-blue-600" />
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ feature.title }}</h3>
            <p class="text-gray-600">{{ feature.description }}</p>
          </div>
        </div>
      </div>
      
      <!-- Slider Section -->
      <div v-else-if="section.type === 'slider'" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 v-if="section.content.title" class="text-3xl font-bold text-center text-gray-900 mb-8">
          {{ section.content.title }}
        </h2>
        
        <div class="relative">
          <div class="overflow-hidden rounded-xl">
            <div 
              class="flex transition-transform duration-500 ease-in-out"
              :style="{ transform: `translateX(-${(section.currentSlide || 0) * 100}%)` }"
            >
              <div 
                v-for="(slide, slideIndex) in section.content.slides" 
                :key="slideIndex"
                class="w-full flex-shrink-0"
              >
                <div class="relative h-96 md:h-[500px]">
                  <img 
                    v-if="slide.image_url" 
                    :src="slide.image_url" 
                    :alt="slide.alt_text || slide.title" 
                    class="w-full h-full object-cover"
                  >
                  <div v-else class="w-full h-full bg-gradient-to-r from-blue-400 to-indigo-600 flex items-center justify-center">
                    <ImageIcon class="w-16 h-16 text-white" />
                  </div>
                  <div class="absolute inset-0 bg-black bg-opacity-400 flex items-center justify-center">
                    <div class="text-center text-white px-4">
                      <h3 class="text-2xl md:text-4xl font-bold mb-2">{{ slide.title }}</h3>
                      <p class="text-lg md:text-xl mb-4">{{ slide.subtitle }}</p>
                      <p class="mb-6 max-w-2xl mx-auto">{{ slide.description }}</p>
                      <router-link
                        v-if="slide.button_text"
                        :to="slide.button_url || '#' "
                        class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-block"
                      >
                        {{ slide.button_text }}
                      </router-link>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Navigation Arrows -->
          <button 
            @click="prevSlide(index)"
            class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 rounded-full p-2 hover:bg-opacity-100 transition-all"
          >
            <ChevronLeft class="w-6 h-6 text-gray-800" />
          </button>
          <button 
            @click="nextSlide(index)"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 rounded-full p-2 hover:bg-opacity-100 transition-all"
          >
            <ChevronRight class="w-6 h-6 text-gray-800" />
          </button>
          
          <!-- Indicators -->
          <div class="flex justify-center mt-6 space-x-2">
            <button
              v-for="(slide, slideIndex) in section.content.slides"
              :key="slideIndex"
              @click="goToSlide(index, slideIndex)"
              :class="[
                'w-3 h-3 rounded-full transition-all',
                slideIndex === (section.currentSlide || 0) ? 'bg-blue-600 w-6' : 'bg-gray-300'
              ]"
            ></button>
          </div>
        </div>
      </div>
      
      <!-- Grid Section -->
      <div v-else-if="section.type === 'grid'" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 v-if="section.content.grid_title" class="text-3xl font-bold text-center text-gray-900 mb-8">
          {{ section.content.grid_title }}
        </h2>
        <div 
          class="grid gap-6"
          :class="[
            section.content.columns === 2 ? 'md:grid-cols-2' : 
            section.content.columns === 3 ? 'md:grid-cols-3' : 
            section.content.columns === 4 ? 'md:grid-cols-4' : 
            section.content.columns === 5 ? 'md:grid-cols-5' : 
            section.content.columns === 6 ? 'md:grid-cols-6' : 'md:grid-cols-3'
          ]"
        >
          <div 
            v-for="(item, index) in section.content.grid_items" 
            :key="index"
            class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow"
          >
            <img 
              v-if="item.image_url" 
              :src="item.image_url" 
              :alt="item.title" 
              class="w-full h-32 object-cover rounded-md mb-4"
            >
            <div v-else class="w-full h-32 bg-gray-200 rounded-md mb-4 flex items-center justify-center text-gray-400">
              <ImageIcon class="w-8 h-8" />
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ item.title }}</h3>
            <p class="text-gray-600">{{ item.description }}</p>
          </div>
        </div>
      </div>
      
      <!-- Testimonials Section -->
      <div v-else-if="section.type === 'testimonials'" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
              {{ section.content.title }}
            </h2>
            <p class="text-lg text-gray-600">
              {{ section.content.subtitle }}
            </p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div
              v-for="(testimonial, index) in section.content.testimonials"
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
                  <h4 class="font-semibold text-gray-900">{{ testimonial.name }}</h4>
                  <p class="text-sm text-gray-500">{{ testimonial.position }}</p>
                </div>
              </div>
              <p class="text-gray-600 mb-4">{{ testimonial.content }}</p>
              <div class="flex text-yellow-400">
                <Star v-for="star in testimonial.rating" :key="star" class="w-5 h-5 fill-current" />
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Call to Action Section -->
      <div v-else-if="section.type === 'cta'" 
           :style="{ backgroundColor: section.settings?.background_color || '#3b82f6' }" 
           class="py-20 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 
            class="text-3xl font-bold mb-4"
            :style="{ color: section.settings?.text_color || '#ffffff' }">
            {{ section.content.title }}
          </h2>
          <p 
            class="text-xl mb-8"
            :style="{ color: section.settings?.text_color || '#ffffff' }">
            {{ section.content.subtitle }}
          </p>
          <router-link
            :to="section.content.cta_link || '#' "
            class="inline-block px-8 py-4 rounded-lg font-semibold transition-all duration-300"
            :style="{ 
              backgroundColor: section.settings?.button_color || '#ffffff',
              color: section.settings?.button_text_color || '#3b82f6'
            }">
            {{ section.content.cta_text }}
          </router-link>
        </div>
      </div>
      
      <!-- Products Section -->
      <div v-else-if="section.type === 'products'" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ section.content.title }}</h2>
            <p class="text-lg text-gray-600">{{ section.content.subtitle }}</p>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div 
              v-for="n in (section.content.product_count || 4)" 
              :key="n"
              class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow"
            >
              <div class="h-48 bg-gradient-to-r from-gray-200 to-gray-300 flex items-center justify-center">
                <Package class="w-12 h-12 text-gray-400" />
              </div>
              <div class="p-4">
                <h3 class="font-semibold text-gray-900 mb-1">Product {{ n }}</h3>
                <p class="text-sm text-gray-600 mb-2">Product category</p>
                <div class="flex justify-between items-center">
                  <span class="text-lg font-bold text-green-600">${{ 10 + n * 5 }}</span>
                  <span class="text-sm text-gray-500">In Stock</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Navigation Section -->
      <nav 
        v-else-if="section.type === 'navigation'" 
        :style="{ backgroundColor: section.settings?.background_color || '#ffffff', color: section.settings?.text_color || '#1f2937' }"
        class="py-4 sticky top-0 z-50 shadow-md"
      >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between items-center">
            <div class="text-xl font-bold">{{ section.content.title }}</div>
            <div class="hidden md:flex space-x-6">
              <router-link
                v-for="item in section.content.menu_items || []"
                :key="item.label"
                :to="item.url"
                class="hover:opacity-80 transition-opacity"
              >
                {{ item.label }}
              </router-link>
            </div>
            <button class="md:hidden">
              <Menu class="w-6 h-6" />
            </button>
          </div>
        </div>
      </nav>
      
      <!-- Footer Section -->
      <footer 
        v-else-if="section.type === 'footer'" 
        :style="{ backgroundColor: section.settings?.background_color || '#1f2937', color: section.settings?.text_color || '#ffffff' }"
        class="py-12 border-t border-gray-700"
      >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center">
            <div class="text-2xl font-bold mb-4">{{ section.content.title }}</div>
            <p class="mb-6 max-w-2xl mx-auto">{{ section.content.content }}</p>
            
            <div class="flex justify-center space-x-6 mb-6">
              <a 
                v-for="link in section.content.social_links || []"
                :key="link.platform"
                :href="link.url"
                class="text-gray-300 hover:text-white transition-colors"
                target="_blank"
              >
                {{ link.platform }}
              </a>
            </div>
          </div>
        </div>
      </footer>
    </section>
  </div>
  
  <div v-else class="flex justify-center items-center py-20">
    <div class="text-center">
      <div class="text-gray-400 mb-4">
        <FileText class="w-16 h-16 mx-auto" />
      </div>
      <h2 class="text-2xl font-bold text-gray-900 mb-2">Page Not Found</h2>
      <p class="text-gray-600 mb-4">The page you're looking for doesn't exist.</p>
      <router-link 
        to="/" 
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors"
      >
        Back to Home
      </router-link>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'
import { get } from '../lib/api'
import { 
  AlertCircle, 
  FileText, 
  ImageIcon, 
  ChevronLeft, 
  ChevronRight, 
  Star,
  Package,
  Menu
} from 'lucide-vue-next'

const route = useRoute()
const page = ref(null)
const loading = ref(true)
const error = ref(null)
const currentSlide = ref(0)
const slideIntervals = ref({})

onMounted(async () => {
  await loadPage()
})

const loadPage = async () => {
  loading.value = true
  error.value = null
  
  try {
    // Determine the slug from route
    let slug = route.params.slug
    
    // For the home route (root path '/'), use 'home' as the slug
    if (!slug && route.path === '/') {
      slug = 'home'
    } else if (!slug && route.name === 'Home') {
      slug = 'home'
    } else if (!slug) {
      // If still no slug, default to 'home' for the home route
      if (route.path === '/') {
        slug = 'home'
      } else {
        throw new Error('Page slug not provided')
      }
    }
    
    let apiUrl = `/api/public/pages/${slug}`
    
    // For the home page, use the special endpoint that handles fallback to landing sections
    if (slug === 'home') {
      apiUrl = `/api/public/home`
    }
    
    const response = await get(apiUrl)
    
    // Check if the response is JSON by checking content type
    const contentType = response.headers.get('content-type')
    
    // Get response as text first
    const responseText = await response.text()
    
    // If the response is OK and content type indicates JSON, then parse it
    if (response.ok && contentType && contentType.includes('application/json')) {
      const data = JSON.parse(responseText)
      page.value = data.data
      initializeCarousel()
    } else if (!response.ok) {
      // If response is not OK, try to parse as JSON but handle failure gracefully
      try {
        const errorData = JSON.parse(responseText)
        throw new Error(errorData.message || 'Page not found')
      } catch (jsonError) {
        // If error response is not JSON (e.g., HTML error page), provide a generic message
        console.error('API returned non-JSON error response:', responseText.substring(0, 200) + '...')
        throw new Error(`Server error: ${response.status} - ${response.statusText}`)
      }
    } else {
      // If response is OK but not JSON, it's unexpected
      console.error('API returned non-JSON response when JSON was expected:', responseText.substring(0, 200) + '...')
      throw new Error('Server returned unexpected response format')
    }
  } catch (err) {
    // Handle the error appropriately
    error.value = err.message || 'Error loading page'
  } finally {
    loading.value = false
  }
}

const getSectionClasses = (section) => {
  const classes = []
  
  // Add background classes if specified
  if (section.settings?.background) {
    classes.push(section.settings.background)
  }
  
  // Add padding classes
  classes.push('py-12')
  
  return classes.join(' ')
}

const initializeCarousel = () => {
  // Clear any existing intervals
  Object.values(slideIntervals.value).forEach(interval => {
    clearInterval(interval)
  })
  slideIntervals.value = {}
  
  // Set up auto-rotation for each carousel and slider
  page.value?.content.forEach((section, sectionIndex) => {
    if ((section.type === 'carousel' || section.type === 'slider') && section.settings?.autoplay) {
      const speed = section.settings.autoplay_speed || 5000
      slideIntervals.value[sectionIndex] = setInterval(() => {
        nextSlide(sectionIndex)
      }, speed)
    }
  })
}

onUnmounted(() => {
  // Clean up intervals when component is destroyed
  Object.values(slideIntervals.value).forEach(interval => {
    clearInterval(interval)
  })
})

const nextSlide = (sectionIndex) => {
  const section = page.value?.content[sectionIndex]
  if (section && (section.type === 'carousel' || section.type === 'slider')) {
    const totalSlides = section.content.slides.length
    // Create reactive property if it doesn't exist
    if (typeof section.currentSlide === 'undefined') {
      section.currentSlide = 0
    }
    section.currentSlide = (section.currentSlide + 1) % totalSlides
  }
}

const prevSlide = (sectionIndex) => {
  const section = page.value?.content[sectionIndex]
  if (section && (section.type === 'carousel' || section.type === 'slider')) {
    const totalSlides = section.content.slides.length
    // Create reactive property if it doesn't exist
    if (typeof section.currentSlide === 'undefined') {
      section.currentSlide = 0
    }
    section.currentSlide = (section.currentSlide - 1 + totalSlides) % totalSlides
  }
}

const goToSlide = (sectionIndex, index) => {
  const carouselSection = page.value?.content[sectionIndex]
  if (carouselSection && carouselSection.type === 'carousel') {
    // Create reactive property if it doesn't exist
    if (typeof carouselSection.currentSlide === 'undefined') {
      carouselSection.currentSlide = 0
    }
    carouselSection.currentSlide = index
  }
}

const getFeatureIcon = (iconName) => {
  // Map icon names to actual components
  // In a real implementation, you would import these dynamically
  return Star
}
</script>

<template>
  <nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex items-center">
          <div class="flex-shrink-0 flex items-center">
            <span class="text-xl font-bold text-indigo-600">Warehouse Pro</span>
          </div>
          <div class="hidden md:ml-6 md:flex md:space-x-8">
            <a
              v-for="item in navigationItems"
              :key="item.id"
              :href="item.path"
              class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300"
            >
              {{ item.name }}
            </a>
          </div>
        </div>
        <div class="flex items-center">
          <div class="flex space-x-4">
            <router-link 
              to="/login" 
              class="text-sm font-medium text-gray-500 hover:text-gray-900 px-3 py-2 rounded-md hover:bg-gray-100"
            >
              Login
            </router-link>
            <router-link 
              to="/register" 
              class="text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 px-3 py-2 rounded-md"
            >
              Register
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { get } from '../lib/api'

const navigationItems = ref([])

onMounted(async () => {
  try {
    const response = await get('/api/public/navigation')
    
    // Check content type to determine if response is JSON
    const contentType = response.headers.get('content-type')
    
    // Get response as text first
    const responseText = await response.text()
    
    // If response is OK and content type indicates JSON, then parse it
    if (response.ok && contentType && contentType.includes('application/json')) {
      const data = JSON.parse(responseText)
      navigationItems.value = data.data || []
    } else if (!response.ok) {
      // If response is not OK, try to parse as JSON but handle failure gracefully
      try {
        const errorData = JSON.parse(responseText)
        console.error('Failed to fetch navigation:', errorData.message || 'Failed to fetch navigation')
      } catch (jsonError) {
        // If error response is not JSON (e.g., HTML error page), provide a generic message
        console.error('API returned non-JSON error response:', responseText.substring(0, 200) + '...')
        console.error(`Server error: ${response.status} - ${response.statusText}`)
      }
    } else {
      // If response is OK but not JSON, it's unexpected
      console.error('API returned non-JSON response when JSON was expected:', responseText.substring(0, 200) + '...')
      console.error('Server returned unexpected response format')
    }
  } catch (error) {
    console.error('Error fetching navigation:', error)
  }
})
</script>
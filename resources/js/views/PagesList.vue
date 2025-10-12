<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">All Pages</h1>
        <p class="text-gray-600">Manage all your website pages using the unified page builder system</p>
        <div class="mt-2 text-sm text-gray-500">
          Note: Create a page with 'home' slug to use as your homepage
        </div>
      </div>
      <div>
        <router-link
          to="/page-builder"
          class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2"
        >
          <Plus class="w-5 h-5" />
          <span>Create New Page</span>
        </router-link>
      </div>
    </div>

    <!-- Pages Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Title
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Slug
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Last Modified
              </th>
              <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="page in pages" :key="page.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-lg flex items-center justify-center">
                    <FileText class="h-5 w-5 text-white" />
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900 flex items-center">
                      {{ page.title }}
                      <span v-if="page.slug === 'home'" class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Home
                      </span>
                    </div>
                    <div class="text-sm text-gray-500">{{ page.content?.length || 0 }} sections</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ page.slug }}</div>
                <div class="text-sm text-gray-500">
                  <router-link 
                    :to="page.slug === 'home' ? '/' : `/pages/${page.slug}`" 
                    target="_blank" 
                    class="text-blue-600 hover:text-blue-900"
                  >
                    View
                  </router-link>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span 
                  :class="[
                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                    page.is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'
                  ]"
                >
                  {{ page.is_active ? 'Published' : 'Draft' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatDate(page.updated_at) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <router-link 
                  :to="`/page-builder/${page.id}`"
                  class="text-blue-600 hover:text-blue-900 mr-3"
                >
                  Edit
                </router-link>
                <button
                  @click="deletePage(page.id)"
                  class="text-red-600 hover:text-red-900"
                >
                  Delete
                </button>
              </td>
            </tr>
            <tr v-if="pages.length === 0">
              <td colspan="5" class="px-6 py-12 text-center">
                <FileText class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-medium text-gray-900">No pages</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new page.</p>
                <div class="mt-6">
                  <router-link
                    to="/page-builder"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                  >
                    <Plus class="-ml-1 mr-2 h-5 w-5" />
                    Create New Page
                  </router-link>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { usePageStore } from '../stores/page'
import { Plus, FileText } from 'lucide-vue-next'
import { useRouter } from 'vue-router'

const pageStore = usePageStore()
const router = useRouter()
const pages = ref([])

onMounted(async () => {
  await loadPages()
})

const loadPages = async () => {
  try {
    pages.value = await pageStore.getPages()
  } catch (error) {
    console.error('Error loading pages:', error)
  }
}

const deletePage = async (id) => {
  if (confirm('Are you sure you want to delete this page?')) {
    try {
      await pageStore.deletePage(id)
      await loadPages()
    } catch (error) {
      console.error('Error deleting page:', error)
      alert('Error deleting page: ' + error.message)
    }
  }
}

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'short', day: 'numeric' }
  return new Date(dateString).toLocaleDateString(undefined, options)
}
</script>
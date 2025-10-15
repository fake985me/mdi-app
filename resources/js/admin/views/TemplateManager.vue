<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Template Manager</h1>
        <p class="text-gray-600">Create, manage, and use templates for your pages</p>
      </div>
      <button
        @click="openCreateModal"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2"
      >
        <Plus class="w-5 h-5" />
        <span>Create Template</span>
      </button>
    </div>

    <!-- Template Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
      <div class="flex flex-wrap gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
          <select
            v-model="selectedCategory"
            class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            @change="loadTemplates"
          >
            <option value="">All Categories</option>
            <option value="landing">Landing Pages</option>
            <option value="blog">Blog Posts</option>
            <option value="e-commerce">E-commerce</option>
            <option value="portfolio">Portfolio</option>
            <option value="general">General</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
          <select
            v-model="selectedStatus"
            class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            @change="loadTemplates"
          >
            <option value="">All Statuses</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Templates Grid -->
    <div v-if="loading" class="flex justify-center items-center py-20">
      <div class="animate-spin rounded-full h-16 w-16 border-4 border-blue-600 border-t-transparent"></div>
    </div>

    <div v-else-if="templates.length === 0" class="text-center py-20">
      <FileText class="mx-auto h-16 w-16 text-gray-400" />
      <h3 class="mt-4 text-lg font-medium text-gray-900">No templates</h3>
      <p class="mt-1 text-gray-500">Get started by creating a new template.</p>
      <div class="mt-6">
        <button
          @click="openCreateModal"
          class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        >
          <Plus class="-ml-1 mr-2 h-5 w-5" />
          Create New Template
        </button>
      </div>
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="template in templates"
        :key="template.id"
        class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow"
      >
        <div class="p-5">
          <div class="flex justify-between items-start">
            <div>
              <h3 class="text-lg font-medium text-gray-900">{{ template.name }}</h3>
              <p class="text-sm text-gray-500 capitalize">{{ template.category }}</p>
            </div>
            <span
              :class="[
                'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                template.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
              ]"
            >
              {{ template.is_active ? 'Active' : 'Inactive' }}
            </span>
          </div>
          
          <p class="mt-2 text-sm text-gray-500" v-if="template.description">
            {{ template.description }}
          </p>
          
          <div class="mt-4 flex justify-between items-center">
            <span class="text-xs text-gray-500">
              {{ template.content?.length || 0 }} sections
            </span>
            <div class="flex space-x-2">
              <button
                @click="useTemplate(template.id)"
                class="text-blue-600 hover:text-blue-900 text-sm"
                title="Use this template"
              >
                <Copy class="w-4 h-4" />
              </button>
              <button
                @click="editTemplate(template.id)"
                class="text-gray-600 hover:text-gray-900 text-sm"
                title="Edit template"
              >
                <Edit3 class="w-4 h-4" />
              </button>
              <button
                @click="deleteTemplate(template.id)"
                class="text-red-600 hover:text-red-900 text-sm"
                title="Delete template"
              >
                <Trash2 class="w-4 h-4" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Create/Edit Template Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg p-6 w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
          {{ isEditing ? 'Edit Template' : 'Create New Template' }}
        </h3>

        <div class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Template Name</label>
              <input
                v-model="currentTemplate.name"
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                placeholder="Enter template name"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
              <input
                v-model="currentTemplate.slug"
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                placeholder="template-slug"
              />
            </div>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select
              v-model="currentTemplate.category"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="landing">Landing Page</option>
              <option value="blog">Blog Post</option>
              <option value="e-commerce">E-commerce</option>
              <option value="portfolio">Portfolio</option>
              <option value="general">General</option>
            </select>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea
              v-model="currentTemplate.description"
              rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              placeholder="Brief description of the template"
            ></textarea>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
              <label class="inline-flex items-center">
                <input
                  v-model="currentTemplate.is_active"
                  type="checkbox"
                  class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                />
                <span class="ml-2">Active</span>
              </label>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
              <input
                v-model.number="currentTemplate.sort_order"
                type="number"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              />
            </div>
          </div>
        </div>

        <div class="flex justify-end space-x-3 mt-6">
          <button
            @click="closeModal"
            class="px-4 py-2 text-gray-600 hover:text-gray-800"
          >
            Cancel
          </button>
          <button
            @click="saveTemplate"
            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
          >
            {{ isEditing ? 'Update' : 'Create' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useTemplateStore } from '../../stores/template'
import { 
  Plus, 
  FileText, 
  Edit3, 
  Trash2, 
  Copy 
} from 'lucide-vue-next'

const router = useRouter()
const templateStore = useTemplateStore()

const templates = ref([])
const loading = ref(false)
const selectedCategory = ref('')
const selectedStatus = ref('')
const showModal = ref(false)
const isEditing = ref(false)
const currentTemplate = ref({
  name: '',
  slug: '',
  description: '',
  category: 'general',
  is_active: true,
  sort_order: 0,
  content: []
})

onMounted(async () => {
  await loadTemplates()
})

const loadTemplates = async () => {
  loading.value = true
  try {
    let allTemplates = await templateStore.getTemplates()
    
    // Apply filters
    if (selectedCategory.value) {
      allTemplates = allTemplates.filter(t => t.category === selectedCategory.value)
    }
    if (selectedStatus.value) {
      const isActive = selectedStatus.value === 'active'
      allTemplates = allTemplates.filter(t => t.is_active === isActive)
    }
    
    templates.value = allTemplates
  } catch (error) {
    console.error('Error loading templates:', error)
  } finally {
    loading.value = false
  }
}

const openCreateModal = () => {
  isEditing.value = false
  currentTemplate.value = {
    name: '',
    slug: '',
    description: '',
    category: 'general',
    is_active: true,
    sort_order: 0,
    content: []
  }
  showModal.value = true
}

const editTemplate = async (id) => {
  try {
    const template = await templateStore.getTemplate(id)
    currentTemplate.value = { ...template }
    isEditing.value = true
    showModal.value = true
  } catch (error) {
    console.error('Error loading template:', error)
  }
}

const closeModal = () => {
  showModal.value = false
}

const saveTemplate = async () => {
  try {
    if (isEditing.value) {
      await templateStore.updateTemplate(currentTemplate.value.id, currentTemplate.value)
    } else {
      await templateStore.createTemplate(currentTemplate.value)
    }
    closeModal()
    await loadTemplates()
  } catch (error) {
    console.error('Error saving template:', error)
    alert('Error saving template: ' + error.message)
  }
}

const deleteTemplate = async (id) => {
  if (confirm('Are you sure you want to delete this template?')) {
    try {
      await templateStore.deleteTemplate(id)
      await loadTemplates()
    } catch (error) {
      console.error('Error deleting template:', error)
      alert('Error deleting template: ' + error.message)
    }
  }
}

const useTemplate = (id) => {
  // Redirect to page builder with template ID
  router.push(`/page-builder?template=${id}`)
}
</script>
import { defineStore } from 'pinia'
import { get, post, put, del } from '../lib/api'

export const useTemplateStore = defineStore('template', {
  state: () => ({
    templates: [],
    loading: false,
    error: null
  }),

  actions: {
    // Get all templates
    async getTemplates() {
      this.loading = true
      try {
        const response = await get('/api/templates')
        const data = await response.json()
        
        if (response.ok) {
          this.templates = data.data || []
          return data.data
        } else {
          throw new Error(data.message || 'Failed to fetch templates')
        }
      } catch (error) {
        this.error = error.message
        throw error
      } finally {
        this.loading = false
      }
    },

    // Get active templates
    async getActiveTemplates() {
      this.loading = true
      try {
        const response = await get('/api/templates-active')
        const data = await response.json()
        
        if (response.ok) {
          return data.data || []
        } else {
          throw new Error(data.message || 'Failed to fetch active templates')
        }
      } catch (error) {
        this.error = error.message
        throw error
      } finally {
        this.loading = false
      }
    },

    // Get templates by category
    async getTemplatesByCategory(category) {
      this.loading = true
      try {
        const response = await get(`/api/templates/category/${category}`)
        const data = await response.json()
        
        if (response.ok) {
          return data.data || []
        } else {
          throw new Error(data.message || `Failed to fetch templates for category ${category}`)
        }
      } catch (error) {
        this.error = error.message
        throw error
      } finally {
        this.loading = false
      }
    },

    // Get a specific template
    async getTemplate(id) {
      this.loading = true
      try {
        const response = await get(`/api/templates/${id}`)
        const data = await response.json()
        
        if (response.ok) {
          return data.data
        } else {
          throw new Error(data.message || 'Failed to fetch template')
        }
      } catch (error) {
        this.error = error.message
        throw error
      } finally {
        this.loading = false
      }
    },

    // Create a new template
    async createTemplate(template) {
      try {
        const response = await post('/api/templates', template)
        const data = await response.json()
        
        if (response.ok) {
          // Refresh the templates list
          await this.getTemplates()
          return data
        } else {
          throw new Error(data.message || 'Failed to create template')
        }
      } catch (error) {
        this.error = error.message
        throw error
      }
    },

    // Update a template
    async updateTemplate(id, updates) {
      try {
        const response = await put(`/api/templates/${id}`, updates)
        const data = await response.json()
        
        if (response.ok) {
          // Refresh the templates list
          await this.getTemplates()
          return data
        } else {
          throw new Error(data.message || 'Failed to update template')
        }
      } catch (error) {
        this.error = error.message
        throw error
      }
    },

    // Delete a template
    async deleteTemplate(id) {
      try {
        const response = await del(`/api/templates/${id}`)
        const data = await response.json()
        
        if (response.ok) {
          // Refresh the templates list
          await this.getTemplates()
          return data
        } else {
          throw new Error(data.message || 'Failed to delete template')
        }
      } catch (error) {
        this.error = error.message
        throw error
      }
    }
  }
})
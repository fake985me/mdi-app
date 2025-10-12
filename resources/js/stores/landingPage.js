import { defineStore } from 'pinia'
import { get, post, put, del } from '../lib/api'

export const useLandingPageStore = defineStore('landingPage', {
  state: () => ({
    sections: [],
    loading: false,
    error: null
  }),

  actions: {
    // Get all sections
    async getSections() {
      this.loading = true
      try {
        const response = await get('/api/landing-page-settings')
        const data = await response.json()
        
        if (response.ok) {
          this.sections = data.data || []
          return data.data
        } else {
          throw new Error(data.message || 'Failed to fetch sections')
        }
      } catch (error) {
        this.error = error.message
        throw error
      } finally {
        this.loading = false
      }
    },

    // Get active sections
    async getActiveSections() {
      this.loading = true
      try {
        const response = await get('/api/public/landing-sections')
        const data = await response.json()
        
        if (response.ok) {
          return data.data || []
        } else {
          throw new Error(data.message || 'Failed to fetch active sections')
        }
      } catch (error) {
        this.error = error.message
        throw error
      } finally {
        this.loading = false
      }
    },

    // Create a new section
    async createSection(section) {
      try {
        const response = await post('/api/landing-page-settings', section)
        const data = await response.json()
        
        if (response.ok) {
          return data
        } else {
          throw new Error(data.message || 'Failed to create section')
        }
      } catch (error) {
        this.error = error.message
        throw error
      }
    },

    // Update a section
    async updateSection(id, updates) {
      try {
        const response = await put(`/api/landing-page-settings/${id}`, updates)
        const data = await response.json()
        
        if (response.ok) {
          return data
        } else {
          throw new Error(data.message || 'Failed to update section')
        }
      } catch (error) {
        this.error = error.message
        throw error
      }
    },

    // Delete a section
    async deleteSection(id) {
      try {
        const response = await del(`/api/landing-page-settings/${id}`)
        const data = await response.json()
        
        if (response.ok) {
          return data
        } else {
          throw new Error(data.message || 'Failed to delete section')
        }
      } catch (error) {
        this.error = error.message
        throw error
      }
    }
  }
})
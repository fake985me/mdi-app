import { defineStore } from 'pinia'
import { get, post, put, del } from '../lib/api'

export const usePageStore = defineStore('page', {
  state: () => ({
    pages: [],
    loading: false,
    error: null
  }),

  actions: {
    // Get all pages
    async getPages() {
      this.loading = true
      try {
        const response = await get('/api/pages')
        
        // Check content type to determine if response is JSON
        const contentType = response.headers.get('content-type')
        
        // Get response as text first
        const responseText = await response.text()
        
        // If response is OK and content type indicates JSON, then parse it
        if (response.ok && contentType && contentType.includes('application/json')) {
          const data = JSON.parse(responseText)
          this.pages = data.data || []
          return data.data
        } else if (!response.ok) {
          // If response is not OK, try to parse as JSON but handle failure gracefully
          try {
            const errorData = JSON.parse(responseText)
            throw new Error(errorData.message || 'Failed to fetch pages')
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
      } catch (error) {
        this.error = error.message
        throw error
      } finally {
        this.loading = false
      }
    },

    // Get a specific page
    async getPage(id) {
      this.loading = true
      try {
        const response = await get(`/api/pages/${id}`)
        
        // Check content type to determine if response is JSON
        const contentType = response.headers.get('content-type')
        
        // Get response as text first
        const responseText = await response.text()
        
        // If response is OK and content type indicates JSON, then parse it
        if (response.ok && contentType && contentType.includes('application/json')) {
          const data = JSON.parse(responseText)
          return data.data
        } else if (!response.ok) {
          // If response is not OK, try to parse as JSON but handle failure gracefully
          try {
            const errorData = JSON.parse(responseText)
            throw new Error(errorData.message || 'Failed to fetch page')
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
      } catch (error) {
        this.error = error.message
        throw error
      } finally {
        this.loading = false
      }
    },

    // Create a new page
    async createPage(page) {
      try {
        const response = await post('/api/pages', page)
        
        // Check content type to determine if response is JSON
        const contentType = response.headers.get('content-type')
        
        // Get response as text first
        const responseText = await response.text()
        
        // If response is OK and content type indicates JSON, then parse it
        if (response.ok && contentType && contentType.includes('application/json')) {
          const data = JSON.parse(responseText)
          
          // Refresh the pages list
          await this.getPages()
          return data
        } else if (!response.ok) {
          // If response is not OK, try to parse as JSON but handle failure gracefully
          try {
            const errorData = JSON.parse(responseText)
            throw new Error(errorData.message || 'Failed to create page')
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
      } catch (error) {
        this.error = error.message
        throw error
      }
    },

    // Update a page
    async updatePage(id, updates) {
      try {
        const response = await put(`/api/pages/${id}`, updates)
        
        // Check content type to determine if response is JSON
        const contentType = response.headers.get('content-type')
        
        // Get response as text first
        const responseText = await response.text()
        
        // If response is OK and content type indicates JSON, then parse it
        if (response.ok && contentType && contentType.includes('application/json')) {
          const data = JSON.parse(responseText)
          
          // Refresh the pages list
          await this.getPages()
          return data
        } else if (!response.ok) {
          // If response is not OK, try to parse as JSON but handle failure gracefully
          try {
            const errorData = JSON.parse(responseText)
            throw new Error(errorData.message || 'Failed to update page')
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
      } catch (error) {
        this.error = error.message
        throw error
      }
    },

    // Delete a page
    async deletePage(id) {
      try {
        const response = await del(`/api/pages/${id}`)
        
        // Check content type to determine if response is JSON
        const contentType = response.headers.get('content-type')
        
        // Get response as text first
        const responseText = await response.text()
        
        // If response is OK and content type indicates JSON, then parse it
        if (response.ok && contentType && contentType.includes('application/json')) {
          const data = JSON.parse(responseText)
          
          // Refresh the pages list
          await this.getPages()
          return data
        } else if (!response.ok) {
          // If response is not OK, try to parse as JSON but handle failure gracefully
          try {
            const errorData = JSON.parse(responseText)
            throw new Error(errorData.message || 'Failed to delete page')
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
      } catch (error) {
        this.error = error.message
        throw error
      }
    }
  }
})
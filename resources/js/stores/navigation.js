import { defineStore } from 'pinia'
import { get, post, put, del } from '../lib/api'

export const useNavigationStore = defineStore('navigation', {
  state: () => ({
    navigationItems: [],
    loading: false,
    error: null
  }),

  actions: {
    // Get all navigation items
    async getNavigationItems() {
      this.loading = true
      try {
        const response = await get('/api/navigation-items')
        
        // Check content type to determine if response is JSON
        const contentType = response.headers.get('content-type')
        
        // Get response as text first
        const responseText = await response.text()
        
        // If response is OK and content type indicates JSON, then parse it
        if (response.ok && contentType && contentType.includes('application/json')) {
          const data = JSON.parse(responseText)
          this.navigationItems = data.data || []
          return data.data
        } else if (!response.ok) {
          // If response is not OK, try to parse as JSON but handle failure gracefully
          try {
            const errorData = JSON.parse(responseText)
            throw new Error(errorData.message || 'Failed to fetch navigation items')
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

    // Get a specific navigation item
    async getNavigationItem(id) {
      this.loading = true
      try {
        const response = await get(`/api/navigation-items/${id}`)
        
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
            throw new Error(errorData.message || 'Failed to fetch navigation item')
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

    // Create a new navigation item
    async createNavigationItem(item) {
      try {
        const response = await post('/api/navigation-items', item)
        
        // Check content type to determine if response is JSON
        const contentType = response.headers.get('content-type')
        
        // Get response as text first
        const responseText = await response.text()
        
        // If response is OK and content type indicates JSON, then parse it
        if (response.ok && contentType && contentType.includes('application/json')) {
          const data = JSON.parse(responseText)
          
          // Refresh the navigation items list
          await this.getNavigationItems()
          return data
        } else if (!response.ok) {
          // If response is not OK, try to parse as JSON but handle failure gracefully
          try {
            const errorData = JSON.parse(responseText)
            throw new Error(errorData.message || 'Failed to create navigation item')
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

    // Update a navigation item
    async updateNavigationItem(id, updates) {
      try {
        const response = await put(`/api/navigation-items/${id}`, updates)
        
        // Check content type to determine if response is JSON
        const contentType = response.headers.get('content-type')
        
        // Get response as text first
        const responseText = await response.text()
        
        // If response is OK and content type indicates JSON, then parse it
        if (response.ok && contentType && contentType.includes('application/json')) {
          const data = JSON.parse(responseText)
          
          // Refresh the navigation items list
          await this.getNavigationItems()
          return data
        } else if (!response.ok) {
          // If response is not OK, try to parse as JSON but handle failure gracefully
          try {
            const errorData = JSON.parse(responseText)
            throw new Error(errorData.message || 'Failed to update navigation item')
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

    // Delete a navigation item
    async deleteNavigationItem(id) {
      try {
        const response = await del(`/api/navigation-items/${id}`)
        
        // Check content type to determine if response is JSON
        const contentType = response.headers.get('content-type')
        
        // Get response as text first
        const responseText = await response.text()
        
        // If response is OK and content type indicates JSON, then parse it
        if (response.ok && contentType && contentType.includes('application/json')) {
          const data = JSON.parse(responseText)
          
          // Refresh the navigation items list
          await this.getNavigationItems()
          return data
        } else if (!response.ok) {
          // If response is not OK, try to parse as JSON but handle failure gracefully
          try {
            const errorData = JSON.parse(responseText)
            throw new Error(errorData.message || 'Failed to delete navigation item')
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
import axios from 'axios'

// Create axios instance with default config
const apiClient = axios.create({
  baseURL: '/api',
  withCredentials: true,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
})

// Add a request interceptor to include the token
apiClient.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('authToken')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

// Add a response interceptor to handle token refresh and errors
apiClient.interceptors.response.use(
  (response) => {
    return response
  },
  (error) => {
    if (error.response?.status === 401) {
      // Unauthorized, clear token and redirect to login
      localStorage.removeItem('authToken')
      localStorage.removeItem('user')
      window.location.href = '/login'
    }
    return Promise.reject(error)
  }
)

export default {
  // Auth endpoints
  login(credentials) {
    return apiClient.post('/login', credentials)
  },
  
  logout() {
    return apiClient.post('/logout')
  },
  
  getUser() {
    return apiClient.get('/user')
  },
  
  // Dashboard endpoints
  getDashboardData() {
    return apiClient.get('/dashboard')
  },
  
  // Product endpoints
  getProducts(params) {
    return apiClient.get('/products', { params })
  },
  
  getProduct(id) {
    return apiClient.get(`/products/${id}`)
  },
  
  createProduct(data) {
    return apiClient.post('/products', data)
  },
  
  updateProduct(id, data) {
    return apiClient.put(`/products/${id}`, data)
  },
  
  deleteProduct(id) {
    return apiClient.delete(`/products/${id}`)
  },
  
  // Category endpoints
  getCategories(params) {
    return apiClient.get('/categories', { params })
  },
  
  getCategory(id) {
    return apiClient.get(`/categories/${id}`)
  },
  
  createCategory(data) {
    return apiClient.post('/categories', data)
  },
  
  updateCategory(id, data) {
    return apiClient.put(`/categories/${id}`, data)
  },
  
  deleteCategory(id) {
    return apiClient.delete(`/categories/${id}`)
  },
  
  // Subcategory endpoints
  getSubcategories(params) {
    return apiClient.get('/subcategories', { params })
  },
  
  getSubcategory(id) {
    return apiClient.get(`/subcategories/${id}`)
  },
  
  createSubcategory(data) {
    return apiClient.post('/subcategories', data)
  },
  
  updateSubcategory(id, data) {
    return apiClient.put(`/subcategories/${id}`, data)
  },
  
  deleteSubcategory(id) {
    return apiClient.delete(`/subcategories/${id}`)
  },
  
  // Brand endpoints
  getBrands(params) {
    return apiClient.get('/brands', { params })
  },
  
  getBrand(id) {
    return apiClient.get(`/brands/${id}`)
  },
  
  createBrand(data) {
    return apiClient.post('/brands', data)
  },
  
  updateBrand(id, data) {
    return apiClient.put(`/brands/${id}`, data)
  },
  
  deleteBrand(id) {
    return apiClient.delete(`/brands/${id}`)
  },
  
  // Web Settings endpoints
  getWebSettings() {
    return apiClient.get('/web-settings')
  },
  
  updateWebSettings(data) {
    const formData = new FormData()
    
    // Append all data to formData
    for (const key in data) {
      if (data[key] !== null && data[key] !== undefined) {
        if (typeof data[key] === 'object' && !(data[key] instanceof File)) {
          formData.append(key, JSON.stringify(data[key]))
        } else {
          formData.append(key, data[key])
        }
      }
    }
    
    // Set proper headers for multipart form data
    return apiClient.post('/web-settings', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
  }
}
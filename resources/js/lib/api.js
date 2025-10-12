// API utility functions for Laravel backend

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000'

// Token-based API request helper
export const apiRequest = async (endpoint, options = {}) => {
  const headers = {
    'Content-Type': 'application/json',
    ...options.headers
  }

  // Add authorization header if token exists
  const token = localStorage.getItem('auth_token')
  if (token) {
    headers['Authorization'] = `Bearer ${token}`
  }

  const response = await fetch(`${API_BASE_URL}${endpoint}`, {
    ...options,
    headers
  })

  // Handle unauthorized responses
  if (response.status === 401) {
    localStorage.removeItem('auth_token')
    // You might want to redirect to login here
  }

  return response
}

// GET request helper
export const get = async (endpoint) => {
  return apiRequest(endpoint, { method: 'GET' })
}

// POST request helper
export const post = async (endpoint, data) => {
  return apiRequest(endpoint, {
    method: 'POST',
    body: JSON.stringify(data)
  })
}

// PUT request helper
export const put = async (endpoint, data) => {
  return apiRequest(endpoint, {
    method: 'PUT',
    body: JSON.stringify(data)
  })
}

// DELETE request helper
export const del = async (endpoint) => {
  return apiRequest(endpoint, {
    method: 'DELETE'
  })
}
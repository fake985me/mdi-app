import { createRouter, createWebHistory } from 'vue-router'

// Import public routes
import publicRoutes from '../public/router'

// Import admin routes
import adminRoutes from '../admin/router'

// Combine all routes
const routes = [
  ...publicRoutes.options.routes,
  ...adminRoutes.options.routes
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Apply middleware from admin routes (since public routes don't need auth middleware)
router.beforeEach(async (to, from, next) => {
  // Import the auth store only when needed
  const { useAuthStore } = await import('../stores/auth')
  const authStore = useAuthStore()
  
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next('/login')
  } else if (to.meta.requiresSuperadmin && authStore.user?.role !== 'superadmin') {
    next('/dashboard')
  } else {
    next()
  }
})

export default router
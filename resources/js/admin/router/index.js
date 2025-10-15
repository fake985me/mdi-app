import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../../stores/auth'

const routes = [
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: () => import('../views/DashboardPage.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/inventory',
    name: 'Inventory',
    component: () => import('../views/InventoryPage.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/products',
    name: 'Products',
    component: () => import('../views/ProductsPage.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/categories',
    name: 'Categories',
    component: () => import('../views/CategoriesPage.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/stock-movements',
    name: 'StockMovements',
    component: () => import('../views/StockMovementsPage.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/purchases',
    name: 'Purchases',
    component: () => import('../views/PurchasesPage.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/sales',
    name: 'Sales',
    component: () => import('../views/SalesPage.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/warranties',
    name: 'Warranties',
    component: () => import('../views/WarrantiesPage.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/borrowings',
    name: 'Borrowings',
    component: () => import('../views/BorrowingsPage.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/users',
    name: 'Users',
    component: () => import('../views/UsersPage.vue'),
    meta: { requiresAuth: true, requiresSuperadmin: true }
  },
  {
    path: '/page-builder',
    name: 'PageBuilder',
    component: () => import('../views/PageBuilder.vue'),
    meta: { requiresAuth: true, requiresAdmin: true },
    children: [
      {
        path: '',
        name: 'PageBuilderMain',
        component: () => import('../views/PageBuilder.vue'),
        meta: { requiresAuth: true, requiresAdmin: true }
      },
      {
        path: ':id',
        name: 'PageBuilderEdit',
        component: () => import('../views/PageBuilder.vue'),
        props: true,
        meta: { requiresAuth: true, requiresAdmin: true }
      },
      {
        path: 'all-pages',
        name: 'PageBuilderAllPages',
        component: () => import('../views/PagesList.vue'),
        meta: { requiresAuth: true, requiresAdmin: true }
      },
      {
        path: 'templates',
        name: 'PageBuilderTemplates',
        component: () => import('../views/TemplateManager.vue'),
        meta: { requiresAuth: true, requiresAdmin: true }
      },
      {
        path: 'navigation',
        name: 'PageBuilderNavigation',
        component: () => import('../views/NavigationManagement.vue'),
        meta: { requiresAuth: true, requiresAdmin: true }
      }
    ]
  },
  {
    path: '/pages',
    name: 'AllPages',
    component: () => import('../views/PagesList.vue'),
    meta: { requiresAuth: true, requiresAdmin: true }
  },
  {
    path: '/templates',
    name: 'PageTemplates',
    component: () => import('../views/TemplateManager.vue'),
    meta: { requiresAuth: true, requiresAdmin: true }
  },
  {
    path: '/navigation',
    name: 'NavigationManagement',
    component: () => import('../views/NavigationManagement.vue'),
    meta: { requiresAuth: true, requiresAdmin: true }
  },
  {
    path: '/landing-page-settings',
    name: 'LandingPageSettings',
    component: () => import('../views/LandingPageSettings.vue'),
    meta: { requiresAuth: true, requiresAdmin: true }
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach(async (to, from, next) => {
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
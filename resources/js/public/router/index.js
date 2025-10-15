import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('../views/HomePublic.vue'),
    meta: { public: true }
  },
  {
    path: '/catalog',
    name: 'Catalog',
    component: () => import('../views/CatalogPage.vue'),
    meta: { public: true }
  },
  {
    path: '/product',
    name: 'Product',
    component: () => import('../views/ProductPublic.vue'),
    meta: { public: true }
  },
  {
    path: '/products',
    name: 'Products',
    component: () => import('../views/ProductPublic.vue'),
    meta: { public: true }
  },
  {
    path: '/products/:slug',
    name: 'product-detail',
    component: () => import('../views/ProductDetailPublic.vue'),
    props: true,
    meta: { public: true }
  },
  {
    path: '/solutions',
    name: 'Solutions',
    component: () => import('../views/SolutionsPublic.vue'),
    meta: { public: true }
  },
  {
    path: '/projects',
    name: 'Projects',
    component: () => import('../views/ProjectsPublic.vue'),
    meta: { public: true }
  },
  {
    path: '/contact',
    name: 'Contact',
    component: () => import('../views/ContactPublic.vue'),
    meta: { public: true }
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/LoginPage.vue'),
    meta: { public: true }
  },
  {
    path: '/register',
    name: 'Register',
    component: () => import('../views/RegisterPage.vue'),
    meta: { public: true }
  },
  {
    path: '/pages/:slug',
    name: 'PageView',
    component: () => import('../views/PageView.vue'),
    props: true,
    meta: { public: true }
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
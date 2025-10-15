import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Product from '@/views/pages/Product.vue'
import ProductDetail from '@/views/pages/Product/ProductDetail.vue'
import Solutions from '@/views/pages/Solutions.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import('../themes/public/views/HomeView.vue'),
    meta: { layout: 'guest' },
  },
  {
    path: '/product',
    name: 'product',
    component: () => import('../themes/public/views/Product.vue'),
    meta: { layout: 'guest' },
  },
  {
    path: '/product/:slug',
    name: 'product-detail',
    component: () => import('../themes/public/views/ProductDetail.vue'),
    meta: { layout: 'guest' },
  },
  {
    path: '/solutions',
    name: 'solutions',
    component: () => import('../themes/public/views/Solutions.vue'),
    meta: { layout: 'guest' },
  },
  {
    path: '/projects',
    name: 'projects',
    component: () => import('../themes/public/views/Projects.vue'),
    meta: { layout: 'guest' },
  },
  {
    path: '/contact',
    name: 'contact',
    component: () => import('../themes/public/views/Contact.vue'),
    meta: { layout: 'guest' },
  },
  {
  path: '/diagram-fullscreen',
  name: 'DiagramFullscreen',
  component: () => import('@/views/pages/Product/modules/components/DiagramFullscreen.vue'),
  meta: { layout: 'blank' } // ⬅️ ini juga otomatis sembunyikan navbar/footer
}
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
  scrollBehavior(to, from, savedPosition) {
    // Scroll ke atas halaman saat navigasi
    return { top: 0 }
  },
})

export default router

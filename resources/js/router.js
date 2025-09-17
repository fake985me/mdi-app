import { createRouter, createWebHistory } from 'vue-router'
import Landing from './components/Landing.vue'
import Login from './components/auth/Login.vue'
import Register from './components/auth/Register.vue'
import Dashboard from './components/dashboard/Dashboard.vue'
import Products from './components/products/Products.vue'
import ProductDetail from './components/products/ProductDetail.vue'
import ProductImportExport from './components/products/ProductImportExport.vue'
import Welcome from './components/Welcome.vue'
import WebSettings from './components/WebSettings.vue'

const routes = [
  { path: '/', component: Landing },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/dashboard', component: Dashboard },
  { path: '/products', component: Products },
  { path: '/products/:id', component: ProductDetail, props: true },
  { path: '/products/import', component: ProductImportExport },
  { path: '/products/export', component: ProductImportExport },
  { path: '/products/create', component: ProductImportExport },
  { path: '/products/:id/edit', component: ProductImportExport },
  { path: '/welcome', component: Welcome },
  { path: '/settings/web', component: WebSettings }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
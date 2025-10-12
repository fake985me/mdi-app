<template>
  <div class="sidebar-container">
    <!-- Desktop Sidebar -->
    <aside class="hidden lg:flex lg:flex-col lg:fixed lg:inset-y-0 lg:z-50 lg:w-72 bg-white/80 backdrop-blur-xl border-r border-gray-200/50 shadow-xl">
      <!-- User Profile Section -->
      <div class="flex items-center gap-x-4 px-6 py-6 border-b border-gray-200/50">
        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white font-semibold text-lg shadow-lg">
          {{ userInitials }}
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm font-semibold text-gray-900 truncate">
            {{ user?.user_metadata?.full_name || 'User' }}
          </p>
          <p class="text-xs text-gray-500 truncate">
            {{ profile?.role || 'user' }}
          </p>
        </div>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 px-6 py-6">
        <ul class="space-y-2">
          <li v-for="item in navigation" :key="item.name">
            <router-link
              :to="item.href"
              :class="[
                $route.path === item.href
                  ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg'
                  : 'text-gray-700 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 hover:text-indigo-600',
                'group flex gap-x-3 rounded-lg p-3 text-sm font-medium transition-all duration-200'
              ]"
            >
              <component
                :is="item.icon"
                :class="[
                  $route.path === item.href ? 'text-white' : 'text-gray-400 group-hover:text-indigo-600',
                  'h-5 w-5 shrink-0 transition-colors duration-200'
                ]"
              />
              {{ item.name }}
            </router-link>
          </li>
        </ul>
      </nav>

      <!-- Sign Out Button -->
      <div class="px-6 py-4 border-t border-gray-200/50">
        <button
          @click="signOut"
          class="w-full flex items-center gap-x-3 rounded-lg p-3 text-sm font-medium text-gray-700 hover:bg-gradient-to-r hover:from-red-50 hover:to-pink-50 hover:text-red-600 transition-all duration-200"
        >
          <ArrowRightOnRectangleIcon class="h-5 w-5 text-gray-400 group-hover:text-red-600" />
          Sign Out
        </button>
      </div>
    </aside>

    <!-- Mobile Header -->
    <div class="lg:hidden">
      <!-- Top Header -->
      <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200/50 bg-white/80 backdrop-blur-xl px-4 shadow-sm sm:gap-x-6 sm:px-6">
        <button
          type="button"
          @click="showMobileMenu = true"
          class="-m-2.5 p-2.5 text-gray-700 lg:hidden"
        >
          <Bars3Icon class="h-6 w-6" />
        </button>
        
        <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
          <div class="flex items-center">
            <h1 class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
              Warehouse Pro
            </h1>
          </div>
        </div>

        <div class="flex items-center gap-x-4 lg:gap-x-6">
          <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white font-semibold text-sm">
            {{ userInitials }}
          </div>
        </div>
      </div>

      <!-- Bottom Navigation -->
      <div class="fixed bottom-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-xl border-t border-gray-200/50 lg:hidden">
        <div class="grid grid-cols-5 py-2">
          <router-link
            v-for="item in bottomNavigation"
            :key="item.name"
            :to="item.href"
            :class="[
              $route.path === item.href
                ? 'text-indigo-600'
                : 'text-gray-500 hover:text-indigo-600',
              'flex flex-col items-center justify-center px-3 py-2 text-xs font-medium transition-colors duration-200'
            ]"
          >
            <component
              :is="item.icon"
              :class="[
                $route.path === item.href ? 'text-indigo-600' : 'text-gray-400',
                'h-5 w-5 mb-1'
              ]"
            />
            {{ item.name }}
          </router-link>
        </div>
      </div>

      <!-- Mobile Menu Overlay -->
      <div
        v-if="showMobileMenu"
        class="fixed inset-0 z-50 lg:hidden"
        @click="showMobileMenu = false"
      >
        <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm" />
        <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white/95 backdrop-blur-xl px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
          <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
              Navigation
            </h2>
            <button
              type="button"
              @click="showMobileMenu = false"
              class="-m-2.5 rounded-md p-2.5 text-gray-700"
            >
              <XMarkIcon class="h-6 w-6" />
            </button>
          </div>
          <div class="mt-6 flow-root">
            <div class="-my-6 divide-y divide-gray-500/10">
              <div class="space-y-2 py-6">
                <router-link
                  v-for="item in navigation"
                  :key="item.name"
                  :to="item.href"
                  @click="showMobileMenu = false"
                  :class="[
                    $route.path === item.href
                      ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white'
                      : 'text-gray-900 hover:bg-gray-50',
                    'group flex items-center gap-x-3 rounded-lg p-3 text-sm font-medium'
                  ]"
                >
                  <component
                    :is="item.icon"
                    :class="[
                      $route.path === item.href ? 'text-white' : 'text-gray-400',
                      'h-5 w-5'
                    ]"
                  />
                  {{ item.name }}
                </router-link>
              </div>
              <div class="py-6">
                <button
                  @click="signOut"
                  class="flex w-full items-center gap-x-3 rounded-lg p-3 text-sm font-medium text-gray-900 hover:bg-gray-50"
                >
                  <ArrowRightOnRectangleIcon class="h-5 w-5 text-gray-400" />
                  Sign Out
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import {
  HomeIcon,
  CubeIcon,
  TagIcon,
  ShoppingCartIcon,
  CurrencyDollarIcon,
  ClipboardDocumentListIcon,
  ShieldCheckIcon,
  HandRaisedIcon,
  UsersIcon,
  ChartBarIcon,
  Bars3Icon,
  XMarkIcon,
  ArrowRightOnRectangleIcon,
  Squares2X2Icon,
  DocumentTextIcon
} from '@heroicons/vue/24/outline'

const router = useRouter()
const authStore = useAuthStore()

const showMobileMenu = ref(false)

const { user, profile } = authStore

const userInitials = computed(() => {
  const name = user?.user_metadata?.full_name || user?.email || 'U'
  return name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2)
})

const navigation = computed(() => {
  const baseNav = [
    { name: 'Home', href: '/', icon: HomeIcon },
    { name: 'Dashboard', href: '/dashboard', icon: HomeIcon },
    { name: 'Inventory', href: '/inventory', icon: CubeIcon },
    { name: 'Products', href: '/products', icon: TagIcon },
    { name: 'Categories', href: '/categories', icon: ClipboardDocumentListIcon },
    { name: 'Purchases', href: '/purchases', icon: ShoppingCartIcon },
    { name: 'Sales', href: '/sales', icon: CurrencyDollarIcon },
    { name: 'Stock Movements', href: '/stock-movements', icon: ChartBarIcon },
    { name: 'Warranties', href: '/warranties', icon: ShieldCheckIcon },
    { name: 'Borrowings', href: '/borrowings', icon: HandRaisedIcon }
  ]

  // Add Users for superadmin
  if (profile?.role === 'superadmin') {
    baseNav.push({ name: 'Users', href: '/users', icon: UsersIcon })
  }
  
  // Add Page Management for admins (unified approach)
  if (profile?.role === 'admin' || profile?.role === 'superadmin') {
    baseNav.push({ name: 'All Pages', href: '/pages', icon: DocumentTextIcon })
    baseNav.push({ name: 'Page Builder', href: '/page-builder', icon: Squares2X2Icon })
    baseNav.push({ name: 'Page Templates', href: '/templates', icon: DocumentTextIcon })
  }

  return baseNav
})

const bottomNavigation = [
  { name: 'Dashboard', href: '/dashboard', icon: HomeIcon },
  { name: 'Inventory', href: '/inventory', icon: CubeIcon },
  { name: 'Products', href: '/products', icon: TagIcon },
  { name: 'Sales', href: '/sales', icon: CurrencyDollarIcon },
  { name: 'More', href: '/categories', icon: Bars3Icon }
]

const signOut = async () => {
  await authStore.signOut()
  router.push('/')
}
</script>
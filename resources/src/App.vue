<template>
  <!-- Use the new public theme for guest pages -->
  <div v-if="isGuestLayout" class="public-layout">
    <PublicTheme>
      <RouterView />
    </PublicTheme>
  </div>

  <!-- Use the original layout for other pages -->
  <component :is="layoutComp" v-else>
    <div class="app">
      <!-- Navbar & Footer hidden when noLayout/blank -->
      <Navbar v-if="!isNoLayout" />

      <main :class="isNoLayout ? 'min-h-screen' : ''">
        <RouterView />
      </main>

      <CustomerVIew v-if="!isNoLayout" />
      <Footer v-if="!isNoLayout" />
    </div>
  </component>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'

import GuestLayout from './layouts/GuestLayout.vue'
import AuthLayout from './layouts/AuthLayout.vue'
import BlankLayout from './layouts/BlankLayout.vue'

import Navbar from './components/Navbar.vue'
import CustomerVIew from '@/components/partial/CustomerVIew.vue'
import Footer from './components/Footer.vue'

// Import the new public theme
import PublicTheme from './themes/public/PublicTheme.vue'

const route = useRoute()

/**
 * isNoLayout = true if:
 * - route.meta.noLayout === true, OR
 * - route.meta.layout === 'blank'
 */
const isNoLayout = computed(() => route.meta.noLayout === true || route.meta.layout === 'blank')

/**
 * isGuestLayout = true if:
 * - route.meta.layout === 'guest' or route is from public pages
 */
const isGuestLayout = computed(() => route.meta.layout === 'guest' || route.path === '/')

/**
 * Choose layout based on route.meta.layout
 * - 'blank'  -> BlankLayout (empty)
 * - 'auth'   -> AuthLayout
 * - 'guest'  -> Use the new PublicTheme
 * - default  -> GuestLayout (for legacy compatibility)
 */
const layoutComp = computed(() => {
  const name = route.meta.layout || 'guest'
  if (name === 'blank') return BlankLayout
  return name === 'auth' ? AuthLayout : GuestLayout
})
</script>

<style>
/* optional */
html, body, #app {
  height: 100%;
}
</style>

<template>
  <div id="app">
    <LandingNavbar v-if="isPublicRoute" />
    <Sidebar v-if="!isPublicRoute" />
    <main :class="{ 
      'lg:ml-64': !isPublicRoute,
      'pt-16 pb-16 lg:pt-0 lg:pb-0': !isPublicRoute
    }">
      <router-view />
    </main>
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useAuthStore } from './stores/auth'
import Sidebar from "./admin/components/Sidebar.vue"
import LandingNavbar from './public/components/LandingNavbar.vue'

const route = useRoute()
const authStore = useAuthStore()

const isPublicRoute = computed(() => route.meta.public)

onMounted(() => {
  authStore.initialize()
})
</script>
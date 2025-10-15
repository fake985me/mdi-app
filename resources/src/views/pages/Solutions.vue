<script setup>
import { defineAsyncComponent } from 'vue'

// Dynamically import the new theme Solutions view
const SolutionsTheme = defineAsyncComponent(() => 
  import('../../../themes/public/views/Solutions.vue')
)

// Pass all props through to the theme component
</script>

<template>
  <Suspense>
    <SolutionsTheme v-bind="$attrs" />
    <template #fallback>
      <div class="flex justify-center items-center h-64">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
      </div>
    </template>
  </Suspense>
</template>
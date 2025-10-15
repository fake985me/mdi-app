<script setup>
import { defineAsyncComponent } from 'vue'

// Dynamically import the new theme Product Detail view
const ProductDetailTheme = defineAsyncComponent(() => 
  import('../../../themes/public/views/ProductDetail.vue')
)

// Pass all props through to the theme component
</script>

<template>
  <Suspense>
    <ProductDetailTheme v-bind="$attrs" />
    <template #fallback>
      <div class="flex justify-center items-center h-64">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
      </div>
    </template>
  </Suspense>
</template>
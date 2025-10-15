<script setup>
import { defineAsyncComponent } from 'vue'

// Dynamically import the new theme Contact view
const ContactTheme = defineAsyncComponent(() => 
  import('../../../themes/public/views/Contact.vue')
)

// Pass all props through to the theme component
</script>

<template>
  <Suspense>
    <ContactTheme v-bind="$attrs" />
    <template #fallback>
      <div class="flex justify-center items-center h-64">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
      </div>
    </template>
  </Suspense>
</template>
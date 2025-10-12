<!-- resources/js/components/LanguageSelector.vue -->
<template>
  <div class="relative" v-if="showLanguageSelector">
    <button
      @click="toggleDropdown"
      class="flex items-center space-x-1 text-gray-700 hover:text-blue-600 transition-colors focus:outline-none"
      aria-label="Select language"
    >
      <span class="hidden sm:inline">{{ t('language') }}</span>
      <span class="sm:hidden">
        <Globe class="w-5 h-5" />
      </span>
      <ChevronDown class="w-4 h-4" :class="{ 'rotate-180': isOpen }" />
    </button>

    <div
      v-if="isOpen"
      class="absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-md py-2 z-50 border border-gray-200"
    >
      <button
        @click="changeLanguage('en')"
        :class="[
          'block w-full text-left px-4 py-2 text-sm',
          currentLang === 'en' ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100'
        ]"
      >
        {{ t('english') }}
      </button>
      <button
        @click="changeLanguage('id')"
        :class="[
          'block w-full text-left px-4 py-2 text-sm',
          currentLang === 'id' ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100'
        ]"
      >
        {{ t('indonesian') }}
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useLanguage } from '../composables/useLanguage'
import { Globe, ChevronDown } from 'lucide-vue-next'

const { switchLanguage, t, getCurrentLanguage } = useLanguage()

const isOpen = ref(false)
const showLanguageSelector = ref(true) // Always show for now

const currentLang = computed(() => getCurrentLanguage())

const toggleDropdown = () => {
  isOpen.value = !isOpen.value
}

const changeLanguage = (lang) => {
  switchLanguage(lang)
  isOpen.value = false
}

// Close dropdown when clicking outside
const handleClickOutside = (event) => {
  const component = document.querySelector('.relative')
  if (component && !component.contains(event.target)) {
    isOpen.value = false
  }
}

// Add event listener when component mounts
document.addEventListener('click', (event) => {
  handleClickOutside(event)
})
</script>
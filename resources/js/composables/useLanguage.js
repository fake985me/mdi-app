// resources/js/composables/useLanguage.js
import { ref, onMounted } from 'vue'
import languageService from '../services/language'

const currentLanguage = ref(languageService.getCurrentLanguage())

export function useLanguage() {
  const switchLanguage = (lang) => {
    if (languageService.setLanguage(lang)) {
      currentLanguage.value = lang
      // Optionally emit an event or update app state
      window.location.reload() // Simple approach to refresh with new language
    }
  }

  const t = (key, params = {}) => {
    return languageService.t(key, params)
  }

  const getCurrentLanguage = () => {
    return currentLanguage.value
  }

  const isIndonesian = () => {
    return currentLanguage.value === 'id'
  }

  const isEnglish = () => {
    return currentLanguage.value === 'en'
  }

  onMounted(() => {
    // Set the language when the composable is first used
    currentLanguage.value = languageService.getCurrentLanguage()
  })

  return {
    switchLanguage,
    t,
    getCurrentLanguage,
    isIndonesian,
    isEnglish
  }
}
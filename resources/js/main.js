import { createApp } from 'vue'
import { createPinia } from 'pinia'
import router from './router'
import App from './App.vue'
import './style.css'
import languageService from './services/language'

// Set the language based on stored preference or browser language
const storedLang = localStorage.getItem('language')
if (storedLang) {
  languageService.setLanguage(storedLang)
} else {
  // Check browser language and set to Indonesian if it's Indonesian, otherwise default to English
  const browserLang = navigator.language.substring(0, 2)
  // Also check for Laravel locale if available
  const laravelLocale = window.Laravel?.locale
  const initialLang = laravelLocale || (['id', 'en'].includes(browserLang) ? browserLang : 'en')
  languageService.setLanguage(initialLang)
}

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.mount('#app')
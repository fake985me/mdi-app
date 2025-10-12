// resources/js/services/language.js
import en from '../locales/en.js'
import id from '../locales/id.js'

class LanguageService {
  constructor() {
    this.supportedLanguages = ['en', 'id']
    this.currentLanguage = this.getStoredLanguage() || this.getLaravelLocale() || 'en'
    this.messages = {
      en: en,
      id: id
    }
  }

  getLaravelLocale() {
    // Get locale from Laravel if available
    return window.Laravel?.locale || null
  }

  getStoredLanguage() {
    return localStorage.getItem('language') || navigator.language.substring(0, 2)
  }

  setLanguage(lang) {
    if (this.supportedLanguages.includes(lang)) {
      this.currentLanguage = lang
      localStorage.setItem('language', lang)
      
      // Update the backend via API
      this.updateBackendLanguage(lang)
      
      this.updateHtmlLangAttribute(lang)
      return true
    }
    return false
  }

  async updateBackendLanguage(lang) {
    try {
      await fetch('/language/switch', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify({ locale: lang })
      })
    } catch (error) {
      console.error('Error updating backend language:', error)
    }
  }

  getCurrentLanguage() {
    return this.currentLanguage
  }

  t(key, params = {}) {
    const keys = key.split('.')
    let message = this.messages[this.currentLanguage]

    for (const k of keys) {
      if (message && message[k] !== undefined) {
        message = message[k]
      } else {
        return key // Return the key if translation not found
      }
    }

    // Replace parameters if any
    if (typeof message === 'string') {
      Object.keys(params).forEach(param => {
        message = message.replace(`:${param}`, params[param])
      })
    }

    return message
  }

  updateHtmlLangAttribute(lang) {
    document.documentElement.lang = lang
  }

  getAvailableLanguages() {
    return this.supportedLanguages
  }
}

export default new LanguageService()
<template>
  <app-layout :app-name="appName">
    <div class="container mx-auto px-4 py-8">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Web Settings</h1>
      </div>

      <div v-if="loading" class="flex justify-center items-center h-64">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
      </div>

      <div v-else class="bg-white rounded-lg shadow-md overflow-hidden">
        <form @submit.prevent="saveSettings" class="p-6">
          <!-- Site Information -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Site Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="site_name">
                  Site Name
                </label>
                <input
                  id="site_name"
                  v-model="form.site_name"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  required
                />
              </div>
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="site_title">
                  Site Title
                </label>
                <input
                  id="site_title"
                  v-model="form.site_title"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
              <div class="md:col-span-2">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="site_description">
                  Site Description
                </label>
                <textarea
                  id="site_description"
                  v-model="form.site_description"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  rows="3"
                ></textarea>
              </div>
            </div>
          </div>

          <!-- Logo and Favicon -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Logo & Favicon</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="logo">
                  Logo
                </label>
                <input
                  id="logo"
                  type="file"
                  @change="handleLogoUpload"
                  accept="image/*"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <div v-if="form.logo_path || form.logo" class="mt-2">
                  <img :src="logoPreview" alt="Logo Preview" class="h-16" />
                </div>
              </div>
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="favicon">
                  Favicon
                </label>
                <input
                  id="favicon"
                  type="file"
                  @change="handleFaviconUpload"
                  accept="image/*"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <div v-if="form.favicon_path || form.favicon" class="mt-2">
                  <img :src="faviconPreview" alt="Favicon Preview" class="h-8" />
                </div>
              </div>
            </div>
          </div>

          <!-- Home Page Hero Section -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Home Page Hero Section</h2>
            <div class="grid grid-cols-1 gap-6">
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="home_hero_title">
                  Hero Title
                </label>
                <input
                  id="home_hero_title"
                  v-model="form.home_hero_title"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  required
                />
              </div>
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="home_hero_description">
                  Hero Description
                </label>
                <textarea
                  id="home_hero_description"
                  v-model="form.home_hero_description"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  rows="3"
                  required
                ></textarea>
              </div>
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="home_hero_image">
                  Hero Image
                </label>
                <input
                  id="home_hero_image"
                  type="file"
                  @change="handleHeroImageUpload"
                  accept="image/*"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <div v-if="form.home_hero_image_path || form.home_hero_image" class="mt-2">
                  <img :src="heroImagePreview" alt="Hero Image Preview" class="h-32" />
                </div>
              </div>
            </div>
          </div>

          <!-- Home Page Features -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Home Page Features</h2>
            <div v-for="(feature, index) in form.home_features" :key="index" class="mb-4 p-4 border border-gray-200 rounded-md">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                  <label class="block text-gray-700 text-sm font-bold mb-2">Feature Title</label>
                  <input
                    v-model="feature.title"
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                  />
                </div>
                <div>
                  <label class="block text-gray-700 text-sm font-bold mb-2">Feature Icon</label>
                  <input
                    v-model="feature.icon"
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="e.g., fas fa-boxes"
                  />
                </div>
                <div class="flex items-end">
                  <button
                    type="button"
                    @click="removeFeature(index)"
                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500"
                  >
                    Remove
                  </button>
                </div>
              </div>
              <div class="mt-2">
                <label class="block text-gray-700 text-sm font-bold mb-2">Feature Description</label>
                <textarea
                  v-model="feature.description"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  rows="2"
                  required
                ></textarea>
              </div>
            </div>
            <button
              type="button"
              @click="addFeature"
              class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              Add Feature
            </button>
          </div>

          <!-- Colors -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Colors</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="primary_color">
                  Primary Color
                </label>
                <div class="flex items-center">
                  <input
                    id="primary_color"
                    v-model="form.primary_color"
                    type="color"
                    class="w-12 h-12 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  />
                  <input
                    v-model="form.primary_color"
                    type="text"
                    class="ml-2 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  />
                </div>
              </div>
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="secondary_color">
                  Secondary Color
                </label>
                <div class="flex items-center">
                  <input
                    id="secondary_color"
                    v-model="form.secondary_color"
                    type="color"
                    class="w-12 h-12 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  />
                  <input
                    v-model="form.secondary_color"
                    type="text"
                    class="ml-2 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  />
                </div>
              </div>
            </div>
          </div>

          <!-- Footer -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Footer</h2>
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2" for="footer_text">
                Footer Text
              </label>
              <textarea
                id="footer_text"
                v-model="form.footer_text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                rows="3"
              ></textarea>
            </div>
          </div>

          <!-- Social Links -->
          <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Social Links</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="facebook">
                  Facebook
                </label>
                <input
                  id="facebook"
                  v-model="form.social_links.facebook"
                  type="url"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="https://facebook.com/yourpage"
                />
              </div>
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="twitter">
                  Twitter
                </label>
                <input
                  id="twitter"
                  v-model="form.social_links.twitter"
                  type="url"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="https://twitter.com/yourpage"
                />
              </div>
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="instagram">
                  Instagram
                </label>
                <input
                  id="instagram"
                  v-model="form.social_links.instagram"
                  type="url"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="https://instagram.com/yourpage"
                />
              </div>
              <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="linkedin">
                  LinkedIn
                </label>
                <input
                  id="linkedin"
                  v-model="form.social_links.linkedin"
                  type="url"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="https://linkedin.com/company/yourpage"
                />
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="flex justify-end">
            <button
              type="submit"
              :disabled="saving"
              class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50"
            >
              {{ saving ? 'Saving...' : 'Save Settings' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from './layouts/AppLayout.vue';
import api from '../services/api';

export default {
  name: 'WebSettings',
  components: {
    AppLayout
  },
  data() {
    return {
      appName: 'Inventory Management System',
      loading: true,
      saving: false,
      form: {
        site_name: '',
        site_title: '',
        site_description: '',
        logo: null,
        logo_path: null,
        favicon: null,
        favicon_path: null,
        home_hero_title: '',
        home_hero_description: '',
        home_hero_image: null,
        home_hero_image_path: null,
        home_features: [],
        footer_text: '',
        social_links: {
          facebook: '',
          twitter: '',
          instagram: '',
          linkedin: ''
        },
        primary_color: '#3b82f6',
        secondary_color: '#10b981'
      }
    };
  },
  computed: {
    logoPreview() {
      if (this.form.logo) {
        return URL.createObjectURL(this.form.logo);
      } else if (this.form.logo_path) {
        return `/storage/${this.form.logo_path}`;
      }
      return null;
    },
    faviconPreview() {
      if (this.form.favicon) {
        return URL.createObjectURL(this.form.favicon);
      } else if (this.form.favicon_path) {
        return `/storage/${this.form.favicon_path}`;
      }
      return null;
    },
    heroImagePreview() {
      if (this.form.home_hero_image) {
        return URL.createObjectURL(this.form.home_hero_image);
      } else if (this.form.home_hero_image_path) {
        return `/storage/${this.form.home_hero_image_path}`;
      }
      return null;
    }
  },
  mounted() {
    this.fetchSettings();
  },
  methods: {
    async fetchSettings() {
      try {
        const response = await api.getWebSettings();
        const settings = response.data.data;
        
        // Check if settings is defined
        if (!settings) {
          console.error('Settings data is undefined');
          return;
        }
        
        // Populate form with settings
        this.form.site_name = settings.site_name || '';
        this.form.site_title = settings.site_title || '';
        this.form.site_description = settings.site_description || '';
        this.form.logo_path = settings.logo_path || null;
        this.form.favicon_path = settings.favicon_path || null;
        this.form.home_hero_title = settings.home_hero_title || '';
        this.form.home_hero_description = settings.home_hero_description || '';
        this.form.home_hero_image_path = settings.home_hero_image_path || null;
        this.form.home_features = Array.isArray(settings.home_features) ? settings.home_features : [];
        this.form.footer_text = settings.footer_text || '';
        this.form.social_links = settings.social_links && typeof settings.social_links === 'object' ? settings.social_links : {
          facebook: '',
          twitter: '',
          instagram: '',
          linkedin: ''
        };
        this.form.primary_color = settings.primary_color || '#3b82f6';
        this.form.secondary_color = settings.secondary_color || '#10b981';
      } catch (error) {
        console.error('Error fetching settings:', error);
        alert('Failed to load settings');
      } finally {
        this.loading = false;
      }
    },
    async saveSettings() {
      this.saving = true;
      try {
        // Prepare data for submission
        const data = new FormData();
        
        // Append text fields
        data.append('site_name', this.form.site_name);
        data.append('site_title', this.form.site_title);
        data.append('site_description', this.form.site_description);
        data.append('home_hero_title', this.form.home_hero_title);
        data.append('home_hero_description', this.form.home_hero_description);
        data.append('home_features', JSON.stringify(this.form.home_features));
        data.append('footer_text', this.form.footer_text);
        data.append('social_links', JSON.stringify(this.form.social_links));
        data.append('primary_color', this.form.primary_color);
        data.append('secondary_color', this.form.secondary_color);
        
        // Append files if they exist
        if (this.form.logo) {
          data.append('logo', this.form.logo);
        }
        if (this.form.favicon) {
          data.append('favicon', this.form.favicon);
        }
        if (this.form.home_hero_image) {
          data.append('home_hero_image', this.form.home_hero_image);
        }
        
        await api.updateWebSettings(data);
        alert('Settings saved successfully');
      } catch (error) {
        console.error('Error saving settings:', error);
        if (error.response && error.response.data && error.response.data.errors) {
          const errors = error.response.data.errors;
          let errorMessage = 'Validation errors:\n';
          for (const field in errors) {
            errorMessage += `${field}: ${errors[field][0]}\n`;
          }
          alert(errorMessage);
        } else {
          alert('Failed to save settings');
        }
      } finally {
        this.saving = false;
      }
    },
    handleLogoUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.form.logo = file;
      }
    },
    handleFaviconUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.form.favicon = file;
      }
    },
    handleHeroImageUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.form.home_hero_image = file;
      }
    },
    addFeature() {
      this.form.home_features.push({
        title: '',
        description: '',
        icon: ''
      });
    },
    removeFeature(index) {
      this.form.home_features.splice(index, 1);
    }
  }
};
</script>
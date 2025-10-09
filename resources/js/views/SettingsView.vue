<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">{{ t('settings') }}</h1>
    
    <div class="bg-white shadow-md rounded-lg p-6">
      <form @submit.prevent="updateSettings">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="navbar_title">
              {{ t('navbar_title') }}
            </label>
            <input
              type="text"
              v-model="settings.navbar_title"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="hero_title">
              {{ t('hero_title') }}
            </label>
            <input
              type="text"
              v-model="settings.hero_title"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
          
          <div class="md:col-span-2">
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="hero_description">
              {{ t('hero_description') }}
            </label>
            <textarea
              v-model="settings.hero_description"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              rows="3"
            ></textarea>
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="features_title">
              {{ t('features_title') }}
            </label>
            <input
              type="text"
              v-model="settings.features_title"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="features_description">
              {{ t('features_description') }}
            </label>
            <input
              type="text"
              v-model="settings.features_description"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="feature1_title">
              {{ t('feature1_title') }}
            </label>
            <input
              type="text"
              v-model="settings.feature1_title"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="feature1_description">
              {{ t('feature1_description') }}
            </label>
            <input
              type="text"
              v-model="settings.feature1_description"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="feature2_title">
              {{ t('feature2_title') }}
            </label>
            <input
              type="text"
              v-model="settings.feature2_title"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="feature2_description">
              {{ t('feature2_description') }}
            </label>
            <input
              type="text"
              v-model="settings.feature2_description"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="feature3_title">
              {{ t('feature3_title') }}
            </label>
            <input
              type="text"
              v-model="settings.feature3_title"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="feature3_description">
              {{ t('feature3_description') }}
            </label>
            <input
              type="text"
              v-model="settings.feature3_description"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="feature4_title">
              {{ t('feature4_title') }}
            </label>
            <input
              type="text"
              v-model="settings.feature4_title"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="feature4_description">
              {{ t('feature4_description') }}
            </label>
            <input
              type="text"
              v-model="settings.feature4_description"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="products_title">
              {{ t('products_title') }}
            </label>
            <input
              type="text"
              v-model="settings.products_title"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="products_description">
              {{ t('products_description') }}
            </label>
            <input
              type="text"
              v-model="settings.products_description"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
          
          <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" :for="company_name">
              {{ t('company_name') }}
            </label>
            <input
              type="text"
              v-model="settings.company_name"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
        </div>
        
        <div class="flex items-center justify-between">
          <button
            type="submit"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
          >
            {{ t('save') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import axios from 'axios';

export default {
  name: 'SettingsView',
  setup() {
    const { t } = useI18n();
    const settings = ref({
      navbar_title: '',
      hero_title: '',
      hero_description: '',
      features_title: '',
      features_description: '',
      feature1_title: '',
      feature1_description: '',
      feature2_title: '',
      feature2_description: '',
      feature3_title: '',
      feature3_description: '',
      feature4_title: '',
      feature4_description: '',
      products_title: '',
      products_description: '',
      company_name: ''
    });

    const fetchSettings = async () => {
      try {
        const response = await axios.get('/api/settings', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        // Map the settings from the API response
        response.data.forEach(setting => {
          settings.value[setting.key] = setting.value;
        });
      } catch (error) {
        console.error('Error fetching settings:', error);
      }
    };

    const updateSettings = async () => {
      try {
        // Prepare settings data for API
        const settingsData = Object.keys(settings.value).map(key => ({
          key: key,
          value: settings.value[key],
          type: 'text'
        }));
        
        // Update each setting individually
        for (const setting of settingsData) {
          await axios.put(`/api/settings/${setting.key}`, setting, {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
          });
        }

        alert(t('settings_updated_successfully'));
      } catch (error) {
        console.error('Error updating settings:', error);
      }
    };

    onMounted(() => {
      fetchSettings();
    });

    return {
      t,
      settings,
      updateSettings
    };
  }
};
</script>
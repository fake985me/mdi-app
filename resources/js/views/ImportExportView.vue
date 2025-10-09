<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">{{ t('import_export') }}</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Import Section -->
      <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">{{ t('import_data') }}</h2>
        
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" :for="import_type">
            {{ t('select_import_type') }}
          </label>
          <select 
            v-model="importType"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          >
            <option value="items">{{ t('items') }}</option>
            <option value="categories">{{ t('categories') }}</option>
            <option value="subcategories">{{ t('subcategories') }}</option>
            <option value="brands">{{ t('brands') }}</option>
            <option value="suppliers">{{ t('suppliers') }}</option>
            <option value="customers">{{ t('customers') }}</option>
            <option value="purchases">{{ t('purchases') }}</option>
            <option value="sales">{{ t('sales') }}</option>
          </select>
        </div>
        
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" :for="import_file">
            {{ t('select_file') }}
          </label>
          <input
            type="file"
            ref="importFileInput"
            @change="handleFileUpload"
            accept=".xlsx,.xls,.csv"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          />
        </div>
        
        <div class="flex items-center justify-between">
          <button
            @click="downloadTemplate"
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
          >
            {{ t('download_template') }}
          </button>
          <button
            @click="importData"
            :disabled="!selectedFile"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline disabled:opacity-50"
          >
            {{ t('import') }}
          </button>
        </div>
        
        <div v-if="importProgress > 0" class="mt-4">
          <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div 
              class="bg-blue-600 h-2.5 rounded-full" 
              :style="{ width: importProgress + '%' }"
            ></div>
          </div>
          <p class="text-sm text-gray-600 mt-1">{{ importProgress }}% {{ t('completed') }}</p>
        </div>
        
        <div v-if="importResult" class="mt-4 p-3 rounded" :class="{
          'bg-green-100 text-green-800': importResult.success,
          'bg-red-100 text-red-800': !importResult.success
        }">
          <p>{{ importResult.message }}</p>
          <p v-if="importResult.errors && importResult.errors.length > 0">
            {{ t('errors_found') }}:
            <ul class="list-disc pl-5">
              <li v-for="(error, index) in importResult.errors" :key="index">{{ error }}</li>
            </ul>
          </p>
        </div>
      </div>
      
      <!-- Export Section -->
      <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">{{ t('export_data') }}</h2>
        
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" :for="export_type">
            {{ t('select_export_type') }}
          </label>
          <select 
            v-model="exportType"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          >
            <option value="items">{{ t('items') }}</option>
            <option value="categories">{{ t('categories') }}</option>
            <option value="subcategories">{{ t('subcategories') }}</option>
            <option value="brands">{{ t('brands') }}</option>
            <option value="suppliers">{{ t('suppliers') }}</option>
            <option value="customers">{{ t('customers') }}</option>
            <option value="purchases">{{ t('purchases') }}</option>
            <option value="sales">{{ t('sales') }}</option>
            <option value="stock_movements">{{ t('stock_movements') }}</option>
            <option value="loans">{{ t('loans') }}</option>
            <option value="returns">{{ t('returns') }}</option>
            <option value="warranties">{{ t('warranties') }}</option>
          </select>
        </div>
        
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" :for="date_range">
            {{ t('date_range') }}
          </label>
          <div class="grid grid-cols-2 gap-2">
            <input
              type="date"
              v-model="exportStartDate"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
            <input
              type="date"
              v-model="exportEndDate"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
          </div>
        </div>
        
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" :for="export_format">
            {{ t('export_format') }}
          </label>
          <select 
            v-model="exportFormat"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          >
            <option value="xlsx">Excel (.xlsx)</option>
            <option value="csv">CSV (.csv)</option>
          </select>
        </div>
        
        <div class="flex items-center justify-between">
          <button
            @click="exportData"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
          >
            {{ t('export') }}
          </button>
        </div>
        
        <div v-if="exportProgress > 0" class="mt-4">
          <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div 
              class="bg-green-600 h-2.5 rounded-full" 
              :style="{ width: exportProgress + '%' }"
            ></div>
          </div>
          <p class="text-sm text-gray-600 mt-1">{{ exportProgress }}% {{ t('completed') }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import axios from 'axios';

export default {
  name: 'ImportExportView',
  setup() {
    const { t } = useI18n();
    
    // Import variables
    const importType = ref('items');
    const selectedFile = ref(null);
    const importFileInput = ref(null);
    const importProgress = ref(0);
    const importResult = ref(null);
    
    // Export variables
    const exportType = ref('items');
    const exportStartDate = ref('');
    const exportEndDate = ref('');
    const exportFormat = ref('xlsx');
    const exportProgress = ref(0);

    const handleFileUpload = (event) => {
      const file = event.target.files[0];
      if (file) {
        selectedFile.value = file;
      }
    };

    const downloadTemplate = () => {
      // In a real implementation, this would download a template file
      // For now, we'll just show an alert
      alert(t('template_download_instruction'));
    };

    const importData = async () => {
      if (!selectedFile.value) {
        alert(t('please_select_a_file'));
        return;
      }
      
      const formData = new FormData();
      formData.append('file', selectedFile.value);
      formData.append('type', importType.value);
      
      try {
        importProgress.value = 0;
        importResult.value = null;
        
        const response = await axios.post('/api/import', formData, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Content-Type': 'multipart/form-data'
          },
          onUploadProgress: (progressEvent) => {
            if (progressEvent.lengthComputable) {
              importProgress.value = Math.round(
                (progressEvent.loaded * 100) / progressEvent.total
              );
            }
          }
        });
        
        importResult.value = {
          success: true,
          message: t('import_completed_successfully'),
          data: response.data
        };
        
        // Reset file input
        if (importFileInput.value) {
          importFileInput.value.value = '';
        }
        selectedFile.value = null;
      } catch (error) {
        importResult.value = {
          success: false,
          message: t('import_failed'),
          errors: error.response?.data?.errors || [error.message]
        };
        console.error('Import error:', error);
      } finally {
        importProgress.value = 0;
      }
    };

    const exportData = async () => {
      try {
        exportProgress.value = 0;
        
        const response = await axios.get('/api/export', {
          params: {
            type: exportType.value,
            start_date: exportStartDate.value,
            end_date: exportEndDate.value,
            format: exportFormat.value
          },
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          },
          responseType: 'blob',
          onDownloadProgress: (progressEvent) => {
            if (progressEvent.lengthComputable) {
              exportProgress.value = Math.round(
                (progressEvent.loaded * 100) / progressEvent.total
              );
            }
          }
        });
        
        // Create a download link
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', `${exportType.value}_${new Date().toISOString().split('T')[0]}.${exportFormat.value}`);
        document.body.appendChild(link);
        link.click();
        
        // Clean up
        document.body.removeChild(link);
        window.URL.revokeObjectURL(url);
      } catch (error) {
        console.error('Export error:', error);
        alert(t('export_failed'));
      } finally {
        exportProgress.value = 0;
      }
    };

    return {
      t,
      importType,
      selectedFile,
      importFileInput,
      importProgress,
      importResult,
      exportType,
      exportStartDate,
      exportEndDate,
      exportFormat,
      exportProgress,
      handleFileUpload,
      downloadTemplate,
      importData,
      exportData
    };
  }
};
</script>
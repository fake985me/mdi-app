<template>
  <app-layout :app-name="appName">
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-3xl font-bold mb-6">Import Products</h1>
      
      <div v-if="importResult" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        <p>Import completed successfully!</p>
        <p>Imported: {{ importResult.imported }} records</p>
        <p v-if="importResult.errors && importResult.errors.length > 0" class="mt-2">Errors: {{ importResult.errors.length }}</p>
      </div>
      
      <div class="bg-white rounded-lg shadow-md p-6">
        <form @submit.prevent="importProducts">
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="csv_file">
              CSV File
            </label>
            <input 
              type="file" 
              name="csv_file" 
              id="csv_file" 
              @change="handleFileChange"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              accept=".csv,.txt"
              required
            >
            <p v-if="fileError" class="text-red-500 text-xs italic mt-2">{{ fileError }}</p>
          </div>
          
          <div class="flex items-center justify-between">
            <button 
              type="submit" 
              :disabled="loading"
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline disabled:opacity-50"
            >
              {{ loading ? 'Importing...' : 'Import Products' }}
            </button>
            
            <button 
              type="button"
              @click="exportProducts"
              :disabled="loading"
              class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline disabled:opacity-50"
            >
              Export Products
            </button>
          </div>
        </form>
      </div>
      
      <div class="mt-8 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold mb-4">CSV Format Instructions</h2>
        <p class="mb-2">The CSV file should have the following columns:</p>
        <ul class="list-disc list-inside">
          <li><strong>name</strong> - Product name (required)</li>
          <li><strong>description</strong> - Product description</li>
          <li><strong>sku</strong> - Stock Keeping Unit (required, unique)</li>
          <li><strong>price</strong> - Product price (required)</li>
          <li><strong>stock_quantity</strong> - Current stock quantity</li>
          <li><strong>category_id</strong> - Category ID (must exist in categories table)</li>
          <li><strong>subcategory_id</strong> - Subcategory ID (must exist in subcategories table)</li>
          <li><strong>brand_id</strong> - Brand ID (must exist in brands table)</li>
        </ul>
        <p class="mt-4">Make sure the first row contains the column headers.</p>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '../layouts/AppLayout.vue';
import api from '../../services/api';

export default {
  name: 'ProductImportExport',
  components: {
    AppLayout
  },
  data() {
    return {
      appName: 'Inventory Management System',
      loading: false,
      csvFile: null,
      fileError: '',
      importResult: null
    };
  },
  methods: {
    handleFileChange(event) {
      this.csvFile = event.target.files[0];
      this.fileError = '';
      
      // Validate file type
      if (this.csvFile && !['text/csv', 'text/plain'].includes(this.csvFile.type)) {
        this.fileError = 'Please select a valid CSV file.';
        this.csvFile = null;
      }
    },
    
    async importProducts() {
      if (!this.csvFile) {
        this.fileError = 'Please select a CSV file to import.';
        return;
      }
      
      this.loading = true;
      this.importResult = null;
      
      try {
        // In a real application, you would make an API call here
        // For now, we'll simulate this with a timeout
        await new Promise(resolve => setTimeout(resolve, 2000));
        
        // Simulate successful import
        this.importResult = {
          imported: 25,
          errors: []
        };
        
        console.log('Products imported successfully');
      } catch (error) {
        console.error('Import error:', error);
        this.fileError = 'Failed to import products. Please try again.';
      } finally {
        this.loading = false;
      }
    },
    
    async exportProducts() {
      this.loading = true;
      
      try {
        // In a real application, you would make an API call here
        // For now, we'll simulate this with a timeout
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Simulate file download
        console.log('Products exported successfully');
        alert('Products exported successfully! In a real application, a CSV file would be downloaded.');
      } catch (error) {
        console.error('Export error:', error);
        alert('Failed to export products. Please try again.');
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>
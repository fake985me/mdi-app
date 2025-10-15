<template>
  <div class="py-12 px-4">
    <!-- Header -->
    <div class="max-w-5xl mx-auto mb-16 text-center">
      <h1 class="text-4xl font-bold text-gray-900 mb-4">Our Projects</h1>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto">
        Explore our portfolio of successful implementations across various industries. 
        From ISP partnerships to large-scale infrastructure projects, we deliver exceptional results.
      </p>
    </div>

    <!-- ISP Customer Section -->
    <div class="max-w-5xl mx-auto mb-20">
      <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center border-b pb-4">ISP Customer</h2>
      
      <div class="space-y-16">
        <article v-for="(item, index) in ispCustomers" :key="index" 
                 class="flex flex-col md:flex-row gap-8 items-start border-b border-gray-200 pb-12"
                 :class="index === ispCustomers.length - 1 ? 'border-b-0' : ''">
          <!-- Image -->
          <div class="md:w-2/5">
            <img :src="item.img" :alt="item.title" 
                 class="w-full h-64 object-cover rounded-lg shadow-md" />
          </div>
          
          <!-- Content -->
          <div class="md:w-3/5">
            <a :href="item.link" class="text-blue-600 hover:underline">
              <h3 class="text-2xl font-bold mb-4">{{ item.title }}</h3>
            </a>
            <p class="text-gray-700 text-lg leading-relaxed">
              {{ item.text }}
              <span v-if="item.hoverText" class="text-sky-500 hover:text-sky-700">{{ item.hoverText }}</span>
            </p>
          </div>
        </article>
      </div>
    </div>

    <!-- Managed Services Section -->
    <div class="max-w-7xl mx-auto mb-20 bg-gray-50 py-16 px-4 sm:px-6 lg:px-8 rounded-xl">
      <h2 class="text-3xl font-bold text-gray-900 mb-16 text-center">Managed Services Project</h2>
      
      <div v-for="(project, index) in managedServices" :key="index"
           class="flex flex-col lg:flex-row items-center gap-12 mb-20"
           :class="[index % 2 !== 0 ? 'lg:flex-row-reverse' : '', index === managedServices.length - 1 ? '' : 'border-b border-gray-200 pb-20']">
        <!-- Text -->
        <div class="w-full lg:w-1/2 max-w-xl">
          <p class="text-xl font-bold italic text-sky-900 mb-3">Managed Services Project</p>
          <h3 class="text-2xl font-bold text-gray-800 mb-3 underline underline-offset-auto">{{ project.title }}</h3>
          <p class="text-base text-gray-700">{{ project.address }}</p>
        </div>
        
        <!-- Image -->
        <div class="w-full lg:w-1/2 max-w-md">
          <img :src="project.image" :alt="project.title"
               class="w-full h-64 object-cover rounded-xl shadow-xl" />
        </div>
      </div>
    </div>

    <!-- FTTx Project Section -->
    <div class="max-w-7xl mx-auto">
      <h2 class="text-3xl font-bold text-gray-900 mb-16 text-center">FTTx Project</h2>
      
      <div v-for="(fttx, index) in fttProjects" :key="index"
           class="flex flex-col lg:flex-row items-center gap-12 mb-20"
           :class="[index % 2 !== 0 ? 'lg:flex-row-reverse' : '', index === fttProjects.length - 1 ? '' : 'border-b border-gray-200 pb-20']">
        <!-- Text -->
        <div class="w-full lg:w-1/2 max-w-xl">
          <p class="text-xl font-bold italic text-sky-900 mb-3">FTTx Project</p>
          <h3 class="text-2xl font-bold text-gray-800 mb-3 underline underline-offset-auto">{{ fttx.title }}</h3>
          <p class="text-base text-gray-700">{{ fttx.address }}</p>
        </div>
        
        <!-- Image -->
        <div class="w-full lg:w-1/2 max-w-md">
          <img :src="fttx.image" :alt="fttx.title"
               class="w-full h-64 object-cover rounded-xl shadow-xl" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

// Placeholder images - replace with your actual images
import placeholder from '@/assets/placeholder-project.jpg'

// Data for sections
const ispCustomers = ref([
  {
    img: placeholder,
    title: 'ISP Partner 1',
    text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
    link: '#',
    hoverText: ''
  },
  {
    img: placeholder,
    title: 'ISP Partner 2',
    text: 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
    link: '#',
    hoverText: ''
  }
])

const managedServices = ref([
  {
    title: 'Managed Services Project 1',
    address: 'Jl. Example No.123, Jakarta',
    image: placeholder,
  },
  {
    title: 'Managed Services Project 2',
    address: 'Jl. Another No.456, Bandung',
    image: placeholder,
  }
])

const fttProjects = ref([
  {
    title: 'FTTx Project 1',
    address: 'Area Example, Surabaya',
    image: placeholder,
  },
  {
    title: 'FTTx Project 2',
    address: 'Location Example, Bali',
    image: placeholder,
  }
])
</script>

<style scoped>
/* Add any specific styles for the projects page */
</style>
<template>
  <div class="py-12 px-4 max-w-7xl mx-auto">
    <div class="text-center mb-16">
      <h1 class="text-4xl font-bold text-gray-900 mb-4">Solutions & Services</h1>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto">
        Discover how Moimstone Dasan Indonesia empowers businesses with cutting-edge networking solutions tailored to your needs.
      </p>
    </div>

    <div class="mb-20">
      <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Product Solutions</h2>
      
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <div v-for="(solution, index) in solutions" :key="index"
          class="bg-gray-50 shadow rounded-lg p-6 hover:shadow-md transition cursor-pointer border border-gray-200"
          @click="() => router.push(`/product?category=${solution.title.toUpperCase()}`)">
          <img v-if="solution.image" :src="solution.image" :alt="solution.title"
            class="w-full h-64 object-contain mb-6" />
          <h3 class="text-xl font-semibold mb-3 text-gray-800">{{ solution.title }}</h3>
          <p class="text-gray-600 mb-4 text-sm">{{ solution.desc || 'No description available.' }}</p>
          <router-link :to="`/product?category=${solution.title.toUpperCase()}`"
            class="text-blue-600 hover:underline text-sm font-medium flex items-center">
            View Product
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </router-link>
        </div>
      </div>
    </div>

    <!-- Services Section -->
    <div class="py-16">
      <div class="text-center mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Services</h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
          Beyond products, we offer comprehensive services to ensure your network operates at peak efficiency.
        </p>
      </div>
      
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-24">
        <!-- Service 1 -->
        <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-12">
          <img src="@/assets/static/solutions/managed.png"
            class="w-full h-80 object-cover rounded-xl shadow-xl ring-1 ring-black ring-opacity-5" alt="Managed Services">
          <div class="text-center md:text-left">
            <h3 class="text-2xl font-bold text-gray-700 italic">Managed Services</h3>
            <p class="mt-4 text-lg text-gray-600">
              We offer managed services with clear SLAs to help your business operate efficiently and scale effectively.
            </p>
          </div>
        </div>

        <!-- Service 2 -->
        <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-12">
          <div class="md:order-last">
            <img src="@/assets/static/solutions/Remote.jpg"
              class="w-full h-80 object-cover rounded-xl shadow-xl ring-1 ring-black ring-opacity-5"
              alt="Maintenance and Support">
          </div>
          <div class="text-center md:text-left">
            <h3 class="text-2xl font-bold text-gray-700 italic">Maintenance and Support</h3>
            <p class="mt-4 text-lg text-gray-600">
              Regular maintenance and audits ensure smooth operations, minimize downtime, and protect your systems from threats.
            </p>
          </div>
        </div>

        <!-- Service 3 -->
        <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-12">
          <img src="@/assets/static/solutions/cable.jpg"
            class="w-full h-80 object-cover rounded-xl shadow-xl ring-1 ring-black ring-opacity-5"
            alt="Design and Build">
          <div class="text-center md:text-left">
            <h3 class="text-2xl font-bold text-gray-700 italic">Design and Build</h3>
            <p class="mt-4 text-lg text-gray-600">
              From network design to deployment, our team handles consultation, planning, and installation to meet your needs.
            </p>
          </div>
        </div>

        <!-- Service 4 -->
        <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-12">
          <div class="md:order-last">
            <img src="@/assets/static/solutions/training.jpg"
              class="w-full h-80 object-cover rounded-xl shadow-xl ring-1 ring-black ring-opacity-5"
              alt="Training DASAN Product">
          </div>
          <div class="text-center md:text-left">
            <h3 class="text-2xl font-bold text-gray-700 italic">
              <span class="font-normal">Training</span> 
              <span class="text-blue-700 font-extrabold">DASAN</span> 
              <span class="font-normal">Product</span>
            </h3>
            <p class="mt-4 text-lg text-gray-600">
              This training provides a comprehensive understanding of GPON technology, from basic theory to hands-on configuration.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import xgspon from '@/assets/static/solutions/xgspon.png'
import gpon from '@/assets/static/solutions/gpon.png'
import lswitch from '@/assets/static/solutions/switch.png'
import wireless from '@/assets/static/solutions/wireless.png'

const router = useRouter()

// Data berdasarkan isi dari dokumen solutions.pdf
const solutions = ref([
  {
    title: 'XGSPON',
    image: xgspon,
    desc: 'XGSPON is a next-generation fiber access technology that provides high-speed broadband services.',
    features: ['EPON / 10GE-PON', 'GPON / XGS-PON', 'L2, L3 Access Switch', 'Copper Access'],
  },
  {
    title: 'GPON',
    image: gpon,
    desc: 'GPON is a widely deployed fiber access technology that delivers high-speed internet and voice services.',
    features: [
      'O-RAN Compliant Fronthaul Switch',
      'M-series Any-haul Switch',
      'PON based Mobile Transport',
    ],
  },
  {
    title: 'SWITCH',
    image: lswitch,
    desc: 'Switches for various applications including residential, enterprise, and mobile networks.',
    features: [
      'Fiber Termination Points – ONT (xPON)',
      'Wi-Fi Residential Gateways',
      'Enterprise / Mobile ONTs',
      'Fixed Wireless Access',
    ],
  },
  {
    title: 'WIRELESS',
    image: wireless,
    desc: 'Wireless solutions for broadband access and mobile transport.',
    features: ['NMS/EMS', 'SDN Controller & Orchestrator', 'CPE Management System'],
  },
])
</script>

<style scoped>
/* opsional */
</style>
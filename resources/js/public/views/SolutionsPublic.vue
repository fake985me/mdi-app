<template>
  <div class="public-theme">
    <!-- Header -->
    <header class="bg-gray-800 text-white sticky top-0 z-50">
      <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
          <div class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true" class="w-16 h-16" viewBox="0 0 2 2">
              <path fill="#3636e0" d="M.892 1.548H.678v-.296q0-.034-.008-.047t-.027-.013q-.036 0-.036.061v.296H.394v-.296q0-.034-.008-.047t-.027-.014q-.036 0-.036.061v.296H.11V1.21q0-.092.064-.157T.331.988q.095 0 .17.077Q.585.988.669.988q.107 0 .172.075.051.058.051.17zM1.374.8h.214v.458q0 .126-.069.205-.04.046-.1.073t-.125.027q-.128 0-.215-.083t-.088-.202q0-.116.087-.201t.206-.085l.057.003v.227q-.026-.02-.053-.02-.033 0-.057.023t-.024.056q0 .032.024.055t.059.023q.082 0 .082-.11zm.578.199v.549h-.214V.999zM1.926.786q-.032-.03-.075-.03t-.075.03-.032.07q0 .014.003.026l.006.016q.007.016.021.028.03.028.077.028c.047 0 .057-.009.077-.028q.014-.013.021-.029l.002-.005q.006-.017.006-.037 0-.04-.032-.07m.065.016Q1.973.754 1.928.729T1.834.717q-.046.011-.068.048L1.763.77l-.001.002q.02-.036.066-.045.048-.01.092.014t.064.069q.017.042.001.077.021-.04.004-.087m.043-.02Q2.011.722 1.955.692c-.056-.03-.076-.025-.116-.015q-.056.014-.083.058l-.004.006-.001.002Q1.775.7 1.832.689q.058-.012.114.018t.078.085q.021.051.002.094.025-.049.004-.106"/>
            </svg>
            <span class="text-xl font-semibold">Moimstone Dasan Indonesia</span>
          </div>
          
          <nav class="hidden md:flex space-x-6">
            <router-link to="/" class="hover:text-blue-400 transition">Home</router-link>
            <router-link to="/products" class="hover:text-blue-400 transition">Product</router-link>
            <router-link to="/solutions" class="hover:text-blue-400 transition">Solutions</router-link>
            <router-link to="/projects" class="hover:text-blue-400 transition">Projects</router-link>
            <router-link to="/contact" class="hover:text-blue-400 transition">Contact</router-link>
          </nav>
          
          <div class="md:hidden">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </button>
          </div>
        </div>
      </div>
      
      <!-- Mobile menu -->
      <div v-if="mobileMenuOpen" class="md:hidden bg-gray-700">
        <div class="px-2 pt-2 pb-3 space-y-1">
          <router-link to="/" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-600">Home</router-link>
          <router-link to="/products" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-600">Product</router-link>
          <router-link to="/solutions" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-600">Solutions</router-link>
          <router-link to="/projects" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-600">Projects</router-link>
          <router-link to="/contact" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-600">Contact</router-link>
        </div>
      </div>
    </header>

    <main>
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
              @click="() => $router.push(`/products?category=${solution.title.toUpperCase()}`)">
              <div class="w-full h-64 bg-gray-200 flex items-center justify-center mb-6">
                <span class="text-gray-500">{{ solution.title }} Image</span>
              </div>
              <h3 class="text-xl font-semibold mb-3 text-gray-800">{{ solution.title }}</h3>
              <p class="text-gray-600 mb-4 text-sm">{{ solution.desc || 'No description available.' }}</p>
              <router-link :to="`/products?category=${solution.title.toUpperCase()}`"
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
              <div class="w-full h-80 bg-gray-200 flex items-center justify-center rounded-xl shadow-xl ring-1 ring-black ring-opacity-5">
                <span class="text-gray-500">Managed Services Image</span>
              </div>
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
                <div class="w-full h-80 bg-gray-200 flex items-center justify-center rounded-xl shadow-xl ring-1 ring-black ring-opacity-5">
                  <span class="text-gray-500">Maintenance and Support Image</span>
                </div>
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
              <div class="w-full h-80 bg-gray-200 flex items-center justify-center rounded-xl shadow-xl ring-1 ring-black ring-opacity-5">
                <span class="text-gray-500">Design and Build Image</span>
              </div>
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
                <div class="w-full h-80 bg-gray-200 flex items-center justify-center rounded-xl shadow-xl ring-1 ring-black ring-opacity-5">
                  <span class="text-gray-500">Training DASAN Product Image</span>
                </div>
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
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 py-10 px-2">
      <div class="max-w-screen-xl mx-auto px-6 flex flex-col md:flex-row md:justify-between gap-4">
        <!-- Logo & Description -->
        <div class="w-full md:w-1/3">
          <a href="/" class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true" class="mb-3 w-16 h-16" viewBox="0 0 2 2">
              <path fill="#3636e0" d="M.892 1.548H.678v-.296q0-.034-.008-.047t-.027-.013q-.036 0-.036.061v.296H.394v-.296q0-.034-.008-.047t-.027-.014q-.036 0-.036.061v.296H.11V1.21q0-.092.064-.157T.331.988q.095 0 .17.077Q.585.988.669.988q.107 0 .172.075.051.058.051.17zM1.374.8h.214v.458q0 .126-.069.205-.04.046-.1.073t-.125.027q-.128 0-.215-.083t-.088-.202q0-.116.087-.201t.206-.085l.057.003v.227q-.026-.02-.053-.02-.033 0-.057.023t-.024.056q0 .032.024.055t.059.023q.082 0 .082-.11zm.578.199v.549h-.214V.999zM1.926.786q-.032-.03-.075-.03t-.075.03-.032.07q0 .014.003.026l.006.016q.007.016.021.028.03.028.077.028c.047 0 .057-.009.077-.028q.014-.013.021-.029l.002-.005q.006-.017.006-.037 0-.04-.032-.07m.065.016Q1.973.754 1.928.729T1.834.717q-.046.011-.068.048L1.763.77l-.001.002q.02-.036.066-.045.048-.01.092.014t.064.069q.017.042.001.077.021-.04.004-.087m.043-.02Q2.011.722 1.955.692c-.056-.03-.076-.025-.116-.015q-.056.014-.083.058l-.004.006-.001.002Q1.775.7 1.832.689q.058-.012.114.018t.078.085q.021.051.002.094.025-.049.004-.106"/>
            </svg>
            <span class="text-[24px] font-semibold text-nowrap text-pretty-blue">Moimstone Dasan Indonesia</span>
          </a>
          <a class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#3636e0" class="w-24 h-16" viewBox="0 0 172.85 26.63">
              <g>
                <path class="cls-1" d="M102.02 17.63v2.15c0 3.64-2.95 6.58-6.58 6.58H74.97c-1.5 0-2.71-1.22-2.71-2.71 0-1.5 1.22-2.71 2.71-2.71h19.22a2.4 2.4 0 0 0 2.4-2.4v-.23a2.4 2.4 0 0 0-2.4-2.4H77.8c-3.51 0-6.35-2.84-6.35-6.35V7.59c0-4.19 3.39-7.58 7.58-7.58h19.22c1.5 0 2.71 1.22 2.71 2.71 0 1.5-1.22 2.71-2.71 2.71H79.21c-1.28 0-2.32 1.04-2.32 2.32v.4c0 1.28 1.04 2.32 2.32 2.32h15.66a7.16 7.16 0 0 1 7.16 7.16Zm70.83-10.67v17.09c0 1.28-1.04 2.32-2.32 2.32h-.78c-1.29 0-2.33-1.04-2.33-2.32V7.79c0-1.13-.92-2.04-2.04-2.04h-16.13c-1.13 0-2.04.92-2.04 2.04v16.25c0 1.28-1.05 2.33-2.33 2.33h-.78c-1.29 0-2.33-1.04-2.33-2.33V6.96c0-3.67 2.97-6.64 6.64-6.64h17.81c3.67 0 6.64 2.97 6.64 6.64ZM55.37 26.4h-8.9c-.86 0-1.36-.98-.86-1.68l2.54-3.51 1.88-2.59c.42-.57 1.27-.58 1.69-.01l1.86 2.53 2.63 3.58c.51.7.02 1.68-.85 1.68Z"/>
                <path class="cls-1" d="m67.82 25.67-.63.46c-1.03.76-2.49.54-3.25-.5l-6.48-8.82-3.87-5.26-1.86-2.53c-.42-.57-1.27-.56-1.69.01l-1.88 2.59-3.76 5.19-6.41 8.86a2.333 2.333 0 0 1-3.25.52l-.63-.46a2.333 2.333 0 0 1-.52-3.25l4.13-5.7 7.47-10.32 3.33-4.59h.01c.41-.63 1.13-1.05 1.95-1.05h.79c.83 0 1.56.44 1.97 1.09l3.35 4.55L62 13.82l6.32 8.6c.76 1.03.54 2.49-.5 3.25m58.48.73h-8.9c-.86 0-1.36-.98-.86-1.68l2.54-3.51 1.88-2.59c.42-.57 1.27-.58 1.69-.01l1.86 2.53 2.63 3.58c.51.7.02 1.68-.85 1.68Z"/>
                <path class="cls-1" d="m138.75 25.67-.63.46c-1.03.76-2.49.54-3.25-.5l-6.48-8.82-3.87-5.26-1.86-2.53c-.42-.57-1.27-.56-1.69.01l-1.88 2.59-3.76 5.19-6.41 8.86a2.333 2.333 0 0 1-3.25.52l-.63-.46a2.333 2.333 0 0 1-.52-3.25l4.13-5.7 7.47-10.32 3.33-4.59h.01c.41-.63 1.13-1.05 1.95-1.05h.79c.83 0 1.56.44 1.97 1.09l3.35 4.55 5.41 7.36 6.32 8.6c.76 1.03.54 2.49-.5 3.25M27.69 4.76a12.64 12.64 0 0 0-8.96-3.71H3.19C1.43 1.05 0 2.48 0 4.24v18.97c0 1.76 1.43 3.19 3.19 3.19h15.54c7 0 12.67-5.67 12.67-12.67 0-3.5-1.42-6.67-3.71-8.97M17.68 22.02H5.42V5.43h12.26c2.3 0 4.37.93 5.87 2.43s2.43 3.58 2.43 5.87c0 4.58-3.71 8.29-8.3 8.29"/>
              </g>
            </svg>
            <span class="text-xl font-semibold">Networks</span>
          </a>
          <p class="mt-4 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
            Provide your network connectivity solutions. Trusted distributor and experienced technical
            support for DASAN equipment in Indonesia. Offers something that is beyond your reach.
          </p>
        </div>

        <!-- Dynamic 5 Column Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 w-full text-sm">
          <div>
            <h3 class="text-gray-900 dark:text-gray-100 font-semibold uppercase tracking-tight mb-2 border-b-2 border-gray-300 dark:border-gray-700 pb-2">
              LINKS
            </h3>
            <ul class="space-y-1">
              <li><router-link to="/" class="hover:underline">Home</router-link></li>
              <li><router-link to="/products" class="hover:underline">Products</router-link></li>
              <li><router-link to="/solutions" class="hover:underline">Service & Solutions</router-link></li>
              <li><router-link to="/projects" class="hover:underline">Projects</router-link></li>
              <li><router-link to="/contact" class="hover:underline">Contact Us</router-link></li>
            </ul>
          </div>
          <div>
            <h3 class="text-gray-900 dark:text-gray-100 font-semibold uppercase tracking-tight mb-2 border-b-2 border-gray-300 dark:border-gray-700 pb-2">
              Product
            </h3>
            <ul class="space-y-1">
              <li><router-link to="/products" class="hover:underline">OLT</router-link></li>
              <li><router-link to="/products" class="hover:underline">ONU</router-link></li>
              <li><router-link to="/products" class="hover:underline">ONU PoE</router-link></li>
              <li><router-link to="/products" class="hover:underline">ONT</router-link></li>
              <li><router-link to="/products" class="hover:underline">SWITCH</router-link></li>
              <li><router-link to="/products" class="hover:underline">PoE Switch</router-link></li>
              <li><router-link to="/products" class="hover:underline">Wireless</router-link></li>
            </ul>
          </div>
          <div>
            <h3 class="text-gray-900 dark:text-gray-100 font-semibold uppercase tracking-tight mb-2 border-b-2 border-gray-300 dark:border-gray-700 pb-2">
              Service & Solutions
            </h3>
            <ul class="space-y-1">
              <li><router-link to="/solutions" class="hover:underline">Managed Services</router-link></li>
              <li><router-link to="/solutions" class="hover:underline">Maintenance and Support</router-link></li>
              <li><router-link to="/solutions" class="hover:underline">Design and Build</router-link></li>
              <li><router-link to="/solutions" class="hover:underline">Training Dasan Product</router-link></li>
            </ul>
          </div>
          <div>
            <h3 class="text-gray-900 dark:text-gray-100 font-semibold uppercase tracking-tight mb-2 border-b-2 border-gray-300 dark:border-gray-700 pb-2">
              Our Projects
            </h3>
            <ul class="space-y-1">
              <li><router-link to="/projects?id=ispcustomer" class="hover:underline">ISP Partner</router-link></li>
              <li><router-link to="/projects?id=managedservices" class="hover:underline">Managed Service</router-link></li>
              <li><router-link to="/projects?id=fttxproject" class="hover:underline">FTTx Project</router-link></li>
            </ul>
          </div>
          <div>
            <h3 class="text-gray-900 dark:text-gray-100 font-semibold uppercase tracking-tight mb-2 border-b-2 border-gray-300 dark:border-gray-700 pb-2">
              Contact Us
            </h3>
            <ul class="space-y-2 text-xs text-gray-700 dark:text-gray-400 text-nowrap">
              <li><strong>Address:</strong><br>Gedung Tifa Arum Realty<br> 3th Floor Suite 301<br>Kuningan Barat<br> Jakarta Selatan 12710</li>
              <li><strong>Phone:</strong><br>+62 21 2930-6714</li>
              <li><strong>Email:</strong><br>info@mdi-solutions.com<br>support@mdi-solutions.com</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Bottom Footer -->
      <div class="max-w-screen-xl mx-auto mt-10 pt-6 border-t border-gray-300 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-4 text-sm px-4">
        <p class="text-gray-600 dark:text-gray-400 text-center md:text-left">
          &copy; {{ new Date().getFullYear() }} Moimstone Dasan Indonesia. All rights reserved.
        </p>
        <div class="flex space-x-4">
          <a href="#" aria-label="Facebook" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition">
            <svg fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5 text-gray-600 dark:text-gray-300">
              <path d="M22 12A10 10 0 1 0 10 21.9V14.89h-2.5v-3H10V9.75c0-2.5 1.49-3.88 3.77-3.88 1.09 0 2.24.19 2.24.19v2.47h-1.26c-1.25 0-1.64.78-1.64 1.57v1.88h2.78l-.44 3H13.1v7.01A10 10 0 0 0 22 12Z"/>
            </svg>
          </a>
          <a href="#" aria-label="Instagram" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition">
            <svg fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5 text-gray-600 dark:text-gray-300">
              <path d="M12 2.2c3.2 0 3.6 0 4.9.1..."/>
            </svg>
          </a>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const solutions = ref([
  {
    title: 'XGSPON',
    image: null,
    desc: 'XGSPON is a next-generation fiber access technology that provides high-speed broadband services.',
    features: ['EPON / 10GE-PON', 'GPON / XGS-PON', 'L2, L3 Access Switch', 'Copper Access'],
  },
  {
    title: 'GPON',
    image: null,
    desc: 'GPON is a widely deployed fiber access technology that delivers high-speed internet and voice services.',
    features: [
      'O-RAN Compliant Fronthaul Switch',
      'M-series Any-haul Switch',
      'PON based Mobile Transport',
    ],
  },
  {
    title: 'SWITCH',
    image: null,
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
    image: null,
    desc: 'Wireless solutions for broadband access and mobile transport.',
    features: ['NMS/EMS', 'SDN Controller & Orchestrator', 'CPE Management System'],
  },
])
</script>

<style scoped>
/* Add any specific styles for the solutions page */
</style>
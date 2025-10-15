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

    <main class="py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
          <button @click="goBack" class="flex items-center text-blue-600 hover:underline">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Back to Products
          </button>
        </div>

        <div v-if="!loading && product" class="bg-white rounded-lg shadow-md overflow-hidden">
          <div class="md:flex">
            <!-- Product Image -->
            <div class="md:w-1/2 p-8 flex items-center justify-center">
              <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-96 flex items-center justify-center">
                <span class="text-gray-500">Product Image: {{ product.title }}</span>
              </div>
            </div>

            <!-- Product Details -->
            <div class="md:w-1/2 p-8">
              <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ product.title }}</h1>
              
              <div class="mb-4">
                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full uppercase tracking-wide">
                  {{ product.category }} - {{ product.subCategory }}
                </span>
              </div>

              <div class="mb-6">
                <p class="text-2xl font-bold text-green-600">${{ product.price }}</p>
                <p v-if="product.cost_price" class="text-sm text-gray-500 line-through">${{ product.cost_price }}</p>
              </div>

              <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                <p class="text-gray-600">{{ product.description || 'Detailed description of this product will be displayed here.' }}</p>
              </div>

              <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Specifications</h3>
                <ul class="space-y-1">
                  <li v-if="product.spec1" class="flex justify-between border-b border-gray-100 py-1">
                    <span class="text-gray-600">Specification 1:</span>
                    <span class="font-medium">{{ product.spec1 }}</span>
                  </li>
                  <li v-if="product.spec2" class="flex justify-between border-b border-gray-100 py-1">
                    <span class="text-gray-600">Specification 2:</span>
                    <span class="font-medium">{{ product.spec2 }}</span>
                  </li>
                  <li v-if="product.spec3" class="flex justify-between border-b border-gray-100 py-1">
                    <span class="text-gray-600">Specification 3:</span>
                    <span class="font-medium">{{ product.spec3 }}</span>
                  </li>
                  <li v-if="product.spec4" class="flex justify-between border-b border-gray-100 py-1">
                    <span class="text-gray-600">Specification 4:</span>
                    <span class="font-medium">{{ product.spec4 }}</span>
                  </li>
                  <li v-if="product.spec5" class="flex justify-between border-b border-gray-100 py-1">
                    <span class="text-gray-600">Specification 5:</span>
                    <span class="font-medium">{{ product.spec5 }}</span>
                  </li>
                </ul>
              </div>

              <div class="flex space-x-4">
                <button class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                  Contact Sales
                </button>
                <button class="flex-1 border border-blue-600 text-blue-600 py-3 px-6 rounded-lg hover:bg-blue-50 transition-colors">
                  Add to Inquiry
                </button>
              </div>
            </div>
          </div>

          <!-- Product Module Component -->
          <div class="p-8 border-t border-gray-200">
            <component 
              :is="detailComponent" 
              v-if="detailComponent && product" 
              :product="product" 
            />
          </div>

          <!-- Additional Information -->
          <div class="p-8 border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Features</h3>
                <ul class="list-disc pl-5 space-y-2">
                  <li v-for="(feature, index) in features" :key="index" class="text-gray-600">{{ feature }}</li>
                  <li v-if="features.length === 0" class="text-gray-600">No specific features listed for this product.</li>
                </ul>
              </div>
              
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Applications</h3>
                <ul class="list-disc pl-5 space-y-2">
                  <li v-for="n in 5" :key="n" class="text-gray-600">Application example {{ n }}</li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Loading State -->
        <div v-else-if="loading" class="flex justify-center items-center py-20">
          <div class="animate-spin rounded-full h-16 w-16 border-4 border-blue-600 border-t-transparent"></div>
        </div>

        <!-- Product Not Found -->
        <div v-else class="text-center py-20">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h3 class="mt-2 text-lg font-medium text-gray-900">Product not found</h3>
          <p class="mt-1 text-gray-500">The product you are looking for does not exist or may have been removed.</p>
          <div class="mt-6">
            <router-link to="/products" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
              Browse Products
            </router-link>
          </div>
        </div>

        <!-- Related Products -->
        <section v-if="relatedProducts.length > 0" class="mt-16">
          <h2 class="text-2xl font-bold mb-6 text-gray-900 text-center">Related Products</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="item in relatedProducts" :key="item.id"
              class="bg-white border border-gray-200 shadow-md rounded-lg hover:scale-105 duration-300 hover:shadow-xl">
              <router-link :to="{
                name: 'product-detail',
                params: { slug: item.slug },
                query: {
                  category: item.category,
                  sub: item.subCategory
                }
              }">
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center p-4">
                  <span class="text-gray-500">Product: {{ item.title }}</span>
                </div>
              </router-link>
              <div class="px-4 py-3 text-center">
                <h3 class="text-md font-semibold text-gray-900 truncate">
                  <router-link :to="{
                    name: 'product-detail',
                    params: { slug: item.slug },
                    query: {
                      category: item.category,
                      sub: item.subCategory
                    }
                  }" class="hover:underline">
                    {{ item.title }}
                  </router-link>
                </h3>
                <p class="text-sm text-gray-500" v-if="item.spec1">{{ item.spec1 }}</p>
                <p class="text-sm text-gray-500" v-if="item.spec2">{{ item.spec2 }}</p>
                <p class="text-lg font-bold text-green-600 mt-2">${{ item.price }}</p>
              </div>
            </div>
          </div>
        </section>
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
import { ref, computed, onMounted, defineAsyncComponent } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const loading = ref(true)
const mobileMenuOpen = ref(false)

// Mock data for products - in a real app, this would come from an API
const mockProducts = [
  {
    id: 1,
    title: 'XGS-PON OLT',
    category: 'XGSPON',
    subCategory: 'OLT',
    spec1: '24-port GPON',
    spec2: '4-port XGS-PON',
    spec3: 'L2, L3 Access Switch',
    spec4: 'Copper Access',
    spec5: 'Advanced Management',
    slug: 'xgs-pon-olt',
    price: 4500,
    cost_price: 5000,
    description: 'High-performance XGS-PON OLT with advanced management capabilities for next-generation access networks.',
    module: 'A'
  },
  {
    id: 2,
    title: 'XGS-PON ONU',
    category: 'XGSPON',
    subCategory: 'ONU',
    spec1: '4-port Gigabit',
    spec2: 'PoE Support',
    spec3: 'WiFi 6 Ready',
    spec4: 'Voice Support',
    spec5: 'Dying Gasp',
    slug: 'xgs-pon-onu',
    price: 250,
    cost_price: 300,
    description: 'Versatile XGS-PON ONU with multiple Gigabit ports, PoE support, and integrated WiFi 6.',
    module: 'B'
  },
  {
    id: 3,
    title: 'GPON OLT',
    category: 'GPON',
    subCategory: 'OLT',
    spec1: '48-port GPON',
    spec2: '2-port 10G uplink',
    spec3: 'L2/L3 Switch',
    spec4: 'Advanced Security',
    spec5: 'Centralized Management',
    slug: 'gpon-olt',
    price: 3800,
    cost_price: 4200,
    description: 'High-density GPON OLT with up to 48 GPON ports and advanced security features.',
    module: 'C'
  },
  {
    id: 4,
    title: 'GPON ONU',
    category: 'GPON',
    subCategory: 'ONU',
    spec1: '4-port Gigabit',
    spec2: 'WiFi 6 Support',
    spec3: 'Voice POTS',
    spec4: 'USB 3.0',
    spec5: 'Bluetooth LE',
    slug: 'gpon-onu',
    price: 180,
    cost_price: 220,
    description: 'Feature-rich GPON ONU with WiFi 6, voice support, and multiple connectivity options.',
    module: 'D'
  },
  {
    id: 5,
    title: 'L2/L3 Switch',
    category: 'SWITCH',
    subCategory: 'L2/L3',
    spec1: '48-port Gigabit',
    spec2: '4-port 10G uplink',
    spec3: 'Layer 3 Routing',
    spec4: 'PoE+ Support',
    spec5: 'SDN Ready',
    slug: 'l2l3-switch',
    price: 1200,
    cost_price: 1400,
    description: 'Advanced L2/L3 switch with 48 Gigabit ports and 4 10G uplinks, ready for SDN.',
    module: 'A'
  },
  {
    id: 6,
    title: 'PoE Switch',
    category: 'SWITCH',
    subCategory: 'PoE',
    spec1: '24-port PoE+',
    spec2: '370W Power Supply',
    spec3: 'Smart Management',
    spec4: 'IEEE 802.3af/at',
    spec5: 'Energy Efficient',
    slug: 'poe-switch',
    price: 650,
    cost_price: 750,
    description: 'Intelligent PoE+ switch with 24 ports and up to 370W total power budget.',
    module: 'B'
  },
  {
    id: 7,
    title: 'Wireless Access Point',
    category: 'WIRELESS',
    subCategory: 'Access Point',
    spec1: 'WiFi 6 1800Mbps',
    spec2: 'MU-MIMO',
    spec3: 'OFDMA',
    spec4: '8 SSIDs',
    spec5: 'Cloud Management',
    slug: 'wireless-ap',
    price: 350,
    cost_price: 400,
    description: 'High-performance WiFi 6 access point with MU-MIMO and OFDMA for dense environments.',
    module: 'C'
  },
  {
    id: 8,
    title: 'Wireless Router',
    category: 'WIRELESS',
    subCategory: 'Router',
    spec1: 'AC1200 Dual Band',
    spec2: '4 Port Gigabit',
    spec3: 'VPN Support',
    spec4: 'Parental Controls',
    spec5: 'Guest Network',
    slug: 'wireless-router',
    price: 120,
    cost_price: 150,
    description: 'AC1200 dual-band wireless router with 4 Gigabit ports and advanced security features.',
    module: 'D'
  }
]

// Find the current product based on the slug parameter
const product = computed(() => {
  return mockProducts.find(p => p.slug === route.params.slug)
})

// Get related products (same category and subcategory)
const relatedProducts = computed(() => {
  if (!product.value) return []
  return mockProducts.filter(p => 
    p.slug !== product.value.slug && 
    p.category === product.value.category && 
    p.subCategory === product.value.subCategory
  ).slice(0, 3) // Limit to 3 related products
})

// Extract features from product (in a real app, this would come from the API)
const features = computed(() => {
  if (!product.value) return []
  // In a real app, features would be a specific field in the product data
  const featureList = [
    "High Performance Processing",
    "Advanced Security Features", 
    "Energy Efficient Design",
    "Scalable Architecture",
    "Comprehensive Management Tools"
  ]
  return featureList
})

// Define the dynamic component based on product module
const detailComponent = computed(() => {
  if (!product.value) return null
  switch (product.value.module) {
    case 'A':
      return defineAsyncComponent(() => import('./modules/ProductModuleA.vue'))
    case 'B':
      return defineAsyncComponent(() => import('./modules/ProductModuleB.vue'))
    case 'C':
      return defineAsyncComponent(() => import('./modules/ProductModuleC.vue'))
    case 'D':
      return defineAsyncComponent(() => import('./modules/ProductModuleD.vue'))
    default:
      return null
  }
})

// Simulate loading
onMounted(() => {
  // Simulate API call delay
  setTimeout(() => {
    loading.value = false
  }, 500)
})

const goBack = () => {
  const category = route.query.category
  const subCategory = route.query.sub

  router.push({
    name: 'Products',
    query: {
      ...(category ? { category } : {}),
      ...(subCategory ? { sub: subCategory } : {}),
    },
  })
}
</script>

<style scoped>
/* Add any specific styles for the product detail page */
</style>
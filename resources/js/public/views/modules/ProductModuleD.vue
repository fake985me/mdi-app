<template>
  <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="w-full mx-auto py-8 lg:py-16">
      <div class="max-w-6xl mx-auto">
        <!-- Judul Produk -->
        <h3 class="text-2xl text-center font-bold mb-4 text-gray-900 pt-20 sm:pt-10">
          {{ effectiveProduct?.title || product.title }}
        </h3>

        <!-- Gambar Produk -->
        <Transition name="fade-scale">
          <div v-if="effectiveProduct?.image || product.image" class="w-full flex justify-center">
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-lg p-4">
              <span class="text-gray-500">Product Image: {{ product.title }}</span>
            </div>
          </div>
        </Transition>

        <!-- Overview -->
        <Transition name="fade-slide-up">
          <div class="w-full mt-8 px-2 sm:px-4">
            <h2 class="text-lg sm:text-xl text-center font-semibold mb-2">Overview</h2>
            <p class="text-gray-800 text-sm sm:text-base text-justify leading-relaxed">
              This is the overview for Product Module D. Detailed product specifications and features would be displayed here.
            </p>
          </div>
        </Transition>

        <!-- Features & Specification -->
        <div class="flex flex-col lg:flex-row gap-8 pt-8">
          <!-- Features -->
          <Transition name="fade-slide-left">
            <div class="flex-1">
              <div v-if="features.length">
                <h3 class="text-lg sm:text-2xl font-bold mb-4 text-gray-900">Features</h3>
                <div class="overflow-x-auto">
                  <table class="table-auto w-full text-sm text-gray-700 border-collapse">
                    <tbody>
                      <tr v-for="(feature, index) in features" :key="index">
                        <td class="border-b border-gray-800 px-3 py-2">{{ feature }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </Transition>

          <!-- Divider -->
          <div class="hidden lg:block w-px bg-gray-800"></div>

          <!-- Specification -->
          <Transition name="fade-slide-right">
            <div class="flex-1">
              <h2 class="text-lg sm:text-2xl font-bold mb-4 text-gray-900">Specification</h2>
              <div class="overflow-x-auto">
                <table class="table-auto w-full text-sm text-gray-700 border-collapse">
                  <tbody>
                    <tr>
                      <td class="font-semibold border-b border-r border-gray-800 px-2 py-2">Bandwidth</td>
                      <td class="border-b border-gray-800 px-2 py-2">Up to 10Gbps symmetric</td>
                    </tr>
                    <tr>
                      <td class="font-semibold border-b border-r border-gray-800 px-2 py-2">Coverage</td>
                      <td class="border-b border-gray-800 px-2 py-2">Indoor/Outdoor deployment</td>
                    </tr>
                    <tr>
                      <td class="font-semibold border-b border-r border-gray-800 px-2 py-2">Security</td>
                      <td class="border-b border-gray-800 px-2 py-2">WPA3, AES encryption</td>
                    </tr>
                    <tr>
                      <td class="font-semibold border-b border-r border-gray-800 px-2 py-2">Management</td>
                      <td class="border-b border-gray-800 px-2 py-2">Cloud-based controller</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </Transition>
        </div>

        <!-- Diagram Section -->
        <div class="w-full mt-10 px-2 sm:px-4">
          <h2 class="text-lg sm:text-xl font-semibold text-center mb-2">
            {{ effectiveProduct.title || product.title }}<br />
            {{ effectiveProduct.category }} {{ effectiveProduct.subCategory }} Network Diagram
          </h2>
          <Transition name="fade-scale">
            <template v-if="effectiveProduct">
              <NetworkDiagram 
                diagram-type="wireless" 
                :title="`${effectiveProduct.title || product.title} Network Diagram`"
                class="bg-white rounded shadow p-4" />
              <!-- Tombol Fullscreen -->
              <button
                class="top-2 right-2 bg-white text-sm px-3 py-1 rounded shadow hover:bg-gray-100 border border-gray-300 mt-2"
                @click.stop="openFullscreenTab">
                Lihat Penuh ⤢
              </button>
            </template>
            <div v-else class="text-center text-gray-500 mt-4">
              Diagram belum tersedia untuk produk ini.
            </div>
          </Transition>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed, ref } from 'vue'
import NetworkDiagram from './components/NetworkDiagram.vue'

const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
})

// Compute effective product
const effectiveProduct = computed(() => {
  return props.product || null
})

// Extract features
const features = computed(() => {
  const featureList = [
    "High-Speed Wireless Connectivity",
    "Seamless Roaming",
    "Advanced Security Protocols",
    "Easy Deployment",
    "Centralized Management",
    "QoS Support"
  ]
  return featureList
})

// Function to open fullscreen tab
function openFullscreenTab() {
  const product = props.product
  const diagram = props.diagram || product?.diagram || ''
  const slug = encodeURIComponent(product?.slug || '') // jika kamu pakai slug di route
  const url = `/diagram-fullscreen?slug=${slug}&diagram=${diagram}`
  window.open(url, '_blank')
}
</script>

<style scoped>
/* Animasi Fade + Scale */
.fade-scale-enter-active,
.fade-scale-leave-active {
  transition: all 0.4s ease;
}

.fade-scale-enter-from,
.fade-scale-leave-to {
  opacity: 0;
  transform: scale(0.95);
}

/* Slide Up */
.fade-slide-up-enter-active {
  transition: all 0.5s ease;
}

.fade-slide-up-enter-from {
  opacity: 0;
  transform: translateY(20px);
}

/* Slide Left */
.fade-slide-left-enter-active {
  transition: all 0.5s ease;
}

.fade-slide-left-enter-from {
  opacity: 0;
  transform: translateX(-30px);
}

/* Slide Right */
.fade-slide-right-enter-active {
  transition: all 0.5s ease;
}

.fade-slide-right-enter-from {
  opacity: 0;
  transform: translateX(30px);
}

/* SVG Line Animation */
.svg {
  width: 100%;
  height: auto;
}

.line {
  fill: none;
  stroke-dasharray: 20, 5;
  stroke-dashoffset: 1000;
  animation: dashLoop 4s linear infinite;
}

.black {
  stroke: #020202;
  stroke-width: 1.5px;
}

.blues {
  stroke: #64abf9;
  stroke-width: 2px;
}

.green {
  stroke: #32f93c;
  stroke-width: 3px;
}

.line.blues {
  animation-duration: 14s;
}

.line.green {
  animation-duration: 10s;
}

.line.black {
  animation-duration: 14s;
}

@keyframes dashLoop {
  0% {
    stroke-dashoffset: 1000;
  }
  100% {
    stroke-dashoffset: 0;
  }
}
</style>
<template>
  <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="w-full mx-auto py-8 lg:py-16">
      <div class="max-w-6xl mx-auto">
        <!-- Judul Produk -->
        <h3 class="text-2xl text-center font-bold mb-4 text-gray-900 pt-20 sm:pt-10">
          {{ selectedProduct?.title || product.title }}
        </h3>

        <!-- Gambar Produk -->
        <Transition name="fade-scale">
          <div v-if="selectedProduct?.image || product.image" class="w-full flex justify-center">
            <img :src="selectedProduct?.image || product.image" :alt="selectedProduct?.title || product.title"
              class="w-full max-w-xs sm:max-w-sm md:max-w-md object-contain" />
          </div>
        </Transition>

        <!-- Overview -->
        <Transition name="fade-slide-up">
          <div class="w-full mt-8 px-2 sm:px-4">
            <h2 class="text-lg sm:text-xl text-center font-semibold mb-2">Overview</h2>
            <p class="text-gray-800 text-sm sm:text-base text-justify leading-relaxed">
              {{ selectedProduct?.descriptions || product.descriptions }}
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
                      <tr v-for="(fitur, index) in features" :key="index">
                        <td class="border-b border-gray-800 px-3 py-2">{{ fitur }}</td>
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
                    <tr v-for="(spec, idx) in specificationList" :key="idx">
                      <td class="font-semibold border-b border-r border-gray-800 px-2 py-2">{{ spec.label }}</td>
                      <td class="border-b border-gray-800 px-2 py-2">
                        <div v-if="Array.isArray(spec.value)">
                          <ul class="list-disc pl-4 space-y-1">
                            <li v-for="(val, i) in spec.value" :key="i">{{ val }}</li>
                          </ul>
                        </div>
                        <span v-else>{{ spec.value }}</span>
                      </td>
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
            {{ selectedProduct.title || product.title }}<br />
            {{ selectedProduct.category }} {{ selectedProduct.subCategory }} Network Diagram
          </h2>
          <Transition name="fade-scale">
            <template v-if="effectiveProduct">
              <OpticLine v-if="diagramType === 'opticalline'" :product="effectiveProduct"
                :diagram="effectiveProduct.diagram" />
              <GponLine v-else-if="diagramType === 'gponline'" :product="effectiveProduct"
                :diagram="effectiveProduct.diagram" />
              <SwitchLine v-else-if="diagramType === 'switchline'" :product="effectiveProduct"
                :diagram="effectiveProduct.diagram" />
              <div v-else class="text-center text-gray-500 mt-4">
                Diagram belum tersedia untuk produk ini.
              </div>
            </template>
            <div v-else class="text-center text-gray-500 mt-4">
              Diagram belum tersedia untuk produk ini.
            </div>
          </Transition>
          <!-- Tombol Fullscreen -->
          <button
            class="top-2 right-2 bg-white text-sm px-3 py-1 rounded shadow hover:bg-gray-100 border border-gray-300"
            @click.stop="openFullscreenTab">
            Lihat Penuh ⤢
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import { useProducts } from '@/composable/useProducts'
import OpticLine from './components/xgsponLine.vue'
import SwitchLine from './components/SwitchLine.vue'
import GponLine from './components/GponLine.vue'

const route = useRoute()

const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
})

const { products } = useProducts()

const selectedProduct = computed(() => {
  const slug = route.params.slug
  if (!slug) return props.product || null
  const list = products?.value || []
  return list.find((p) => p.slug === slug) || props.product || null
})

const effectiveProduct = computed(() => selectedProduct.value || props.product || null)

const diagramType = computed(() =>
  (effectiveProduct.value?.networkDIagram || '').toString().trim().toLowerCase()
)

const features = computed(() =>
  Array.from({ length: 15 }, (_, i) => props.product?.[`fitur${i + 1}`]).filter((f) => f && f !== 'null')
)

const specificationList = computed(() => {
  const p = selectedProduct.value || props.product || {}
  return [
    { label: 'Flash Memory', value: p.flashmemory },
    { label: 'SDRAM Memory', value: p.sdrammemory },
    { label: 'Interface', value: [p.Interface1, p.Interface2, p.Interface3, p.Interface4].filter((i) => i) },
    { label: 'Operating Temp', value: p.operatingtemperature },
    { label: 'Power', value: [p.power1, p.power2].filter((i) => i) },
  ]
})

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
</style>

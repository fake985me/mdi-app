<template>
  <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <!-- Tombol Back -->
    <div
      class="flex flex-col sm:flex-row items-center justify-between border-b border-black pb-4 pt-4 bg-gradient-to-r bg-slate-400 fixed left-0 w-full z-10 px-4">
      <button @click="goBack"
        class="text-base sm:text-lg text-sky-800 tracking-tight hover:underline self-start sm:self-auto">
        ← Back
      </button>
      <h2 class="text-3xl lg:mr-[860px] sm:mr-0 font-bold tracking-tight text-gray-900 sm:justify-between">
        Product Detail
      </h2>
    </div>
    <component :is="detailComponent" v-if="detailComponent && product" :product="product" />
    <!-- Related Products -->
    <section class="mt-16 w-full max-w-7xl px-4" v-if="relatedProducts.length">
      <h2 class="text-2xl font-bold mb-6 text-gray-900 text-center">Related Products</h2>
      <div class="flex-grid md:flex lg:grid-cols-3 sm:grid-cols-1 gap-6">
        <div v-for="item in relatedProducts" :key="item.id"
          class="w-full bg-white border border-slate-900 shadow-md rounded-xl hover:scale-105 duration-300 hover:shadow-xl">
          <RouterLink :to="{
            name: 'product-detail',
            params: { slug: item.slug },
            query: {
              category: item.category,
              sub: item.subCategory
            }
          }">
            <img :src="item.image" :alt="item.title" class="w-full h-44 object-contain rounded-t-lg p-4" />
          </RouterLink>
          <div class="px-4 py-3 text-center">
            <h3 class="text-md font-semibold text-gray-900 truncate">
              <RouterLink :to="{
                name: 'product-detail',
                params: { slug: item.slug },
                query: {
                  category: item.category,
                  sub: item.subCategory
                }
              }" class="hover:underline">
                {{ item.title }}
              </RouterLink>
            </h3>
            <p class="text-sm text-gray-500" v-if="product.spec1">{{ product.spec1 }}</p>
            <p class="text-sm text-gray-500" v-if="product.spec2">{{ product.spec2 }}</p>
          </div>
        </div>
      </div>
    </section>
    <div v-else class="p-8 text-center text-gray-500">
      Produk tidak ditemukan atau tipe tidak dikenali.
    </div>
  </section>
</template>

<script setup>
import { computed, watchEffect, defineAsyncComponent } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import products from '@/composable/useProducts'


const route = useRoute()
const router = useRouter()
const slug = computed(() => route.params.slug)
watchEffect(() => {
  // No need to set product.value here, handled by computed below
})
const product = computed(() => {
  const list = Array.isArray(products?.value) ? products.value : []
  return list.find(p => p.slug === slug.value) ||
    list.find(p => String(p.id) === String(slug.value)) ||
    null
})

const relatedProducts = computed(() => {
  if (!product.value) return []
  return products.value.filter(
    (p) =>
      p.slug !== product.value.slug &&
      p.category === product.value.category &&
      p.subCategory === product.value.subCategory
  )
})

const features = computed(() => {
  if (!product.value) return []
  return Array.from({ length: 15 }, (_, i) => product.value[`fitur${i + 1}`]).filter(
    (f) => f && f !== 'null'
  )
})

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
    case 'E':
      return defineAsyncComponent(() => import('./modules/ProductModuleE.vue'))
    case 'F':
      return defineAsyncComponent(() => import('./modules/ProductModuleF.vue'))
    case 'G':
      return defineAsyncComponent(() => import('./modules/ProductModuleG.vue'))
    case 'H':
      return defineAsyncComponent(() => import('./modules/ProductModuleH.vue'))
    default:
      return null
  }
})

const goBack = () => {
  const category = route.query.category
  const subCategory = route.query.sub

  router.push({
    name: 'product',
    query: {
      ...(category ? { category } : {}),
      ...(subCategory ? { sub: subCategory } : {}),
    },
  })
}
</script>
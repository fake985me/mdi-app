<template>
  <div id="hero" class="bg-white text-white py-10 relative overflow-hidden">
    <Transition name="fade" mode="out-in">
      <div
        :key="currentIndex"
        class="absolute inset-0"
      >
        <component
          v-if="slides[currentIndex].component"
          :is="slides[currentIndex].component"
          class="absolute inset-0 w-full h-full bg-white object-cover z-0"
        />
        <div
          v-else
          class="absolute inset-0 bg-cover bg-center z-0"
          :style="{ backgroundImage: `url(${slides[currentIndex].bg})` }"
        ></div>

        <div class="bg-slate-300/20 absolute inset-0 z-0"></div>

        <!-- Konten -->
        <div
          class="relative z-10 h-full flex flex-col justify-center items-center text-center px-4 m-4"
        >
          <div
            v-if="slides[currentIndex].imgLeft || slides[currentIndex].midLeft || slides[currentIndex].midRight || slides[currentIndex].imgRight"
            class="flex flex-col md:flex-row items-center justify-center gap-6 w-full max-w-6xl mx-auto"
          >
            <img
              v-if="slides[currentIndex].imgLeft"
              :src="slides[currentIndex].imgLeft"
              class="w-25 max-w-[220px] h-auto animate-fadeInLeft"
            />
            <img
              v-if="slides[currentIndex].midLeft"
              :src="slides[currentIndex].midLeft"
              class="w-70 max-w-[140px] h-auto animate-fadeInLeft"
            />
            <img
              v-if="slides[currentIndex].midRight"
              :src="slides[currentIndex].midRight"
              class="w-80 max-w-[160px] h-auto animate-fadeInRight"
            />
            <img
              v-if="slides[currentIndex].imgRight"
              :src="slides[currentIndex].imgRight"
              class="w-90 max-w-[180px] h-auto animate-fadeInRight"
            />
          </div>

          <div v-if="slides[currentIndex].centerImg" class="mb-4">
            <img
              :src="slides[currentIndex].centerImg"
              class="w-90 md:w-[620px] mx-auto animate-fadeInDown"
            />
          </div>

          <p
            class="text-2xl mt-4 animate-fadeInUp max-w-2xl mx-auto drop-shadow-[0_2px_3px_rgba(101,101,223,0.8)] text-shadow-xl text-shadow-sky-300"
          >
            {{ slides[currentIndex].text }}
          </p>
        </div>
      </div>
    </Transition>


    <!-- Navigasi -->
    <button @click="prevSlide"
      class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-800/50 hover:bg-gray-700/80 text-white p-3 rounded-full z-20">
      ❮
    </button>
    <button @click="nextSlide"
      class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-800/50 hover:bg-gray-700/80 text-white p-3 rounded-full z-20">
      ❯
    </button>

    <!-- Dots -->
    <div class="absolute bottom-6 flex gap-2 justify-center w-full z-20">
      <button v-for="(slide, index) in slides" :key="index"
        class="w-2 h-2 rounded-full bg-gray-300 transition-all duration-300"
        :class="{ 'bg-blue-500 scale-125': index === currentIndex }" @click="goToSlide(index)"></button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import LineAnimationSVG from '@/components/icons/LineAnimationSVG.vue'

const currentIndex = ref(0)
let intervalId = null

const slides = [
  {
    useComponent: true,
    component: LineAnimationSVG,
    centerImg: new URL('@/assets/static/carousel/mdi.png', import.meta.url).href,
    centerImgWidth: 500,
    centerImgHeight: 250,
    text: 'Trusted distributor and Experienced technical support for DASAN equipment in Indonesia',
  },
  {
    bg: new URL('@/assets/static/carousel/2.jpg', import.meta.url).href,
    centerImg: new URL('@/assets/static/carousel/dasan.png', import.meta.url).href,
    centerImgWidth: 500,
    centerImgHeight: 250,
    text: 'Provide conectivity solutions to your network',
  },
  {
    bg: new URL('@/assets/static/carousel/3.jpg', import.meta.url).href,
    imgLeft: new URL('@/assets/static/carousel/hero_1.png', import.meta.url).href,
    midLeft: new URL('@/assets/static/carousel/hero_2.png', import.meta.url).href,
    midRight: new URL('@/assets/static/carousel/hero_3.png', import.meta.url).href,
    imgRight: new URL('@/assets/static/carousel/hero_4.png', import.meta.url).href,
    text: 'Offers something that is beyond your reach',
  },
]

const nextSlide = () => {
  currentIndex.value = (currentIndex.value + 1) % slides.length
}

const prevSlide = () => {
  currentIndex.value = (currentIndex.value - 1 + slides.length) % slides.length
}

const goToSlide = (index) => {
  currentIndex.value = index
}

const startAutoSlide = () => {
  if (intervalId) clearInterval(intervalId)
  intervalId = setInterval(nextSlide, 7500) // ganti interval ke 5 detik agar tidak terlalu cepat
}

onMounted(() => {
  startAutoSlide()
})

onUnmounted(() => {
  if (intervalId) clearInterval(intervalId)
})
</script>

<style scoped>
#hero {
  height: 80vh;
  background: #000;
  position: relative;
}

@media (max-height: 500px) {
  #hero {
    height: 150vh;
  }
}

/* Animasi sederhana */
@keyframes fadeInLeft {
  from {
    opacity: 0;
    transform: translateX(-20px);
  }

  to {
    opacity: 1;
    transform: translateX(0);
  }
}

@keyframes fadeInRight {
  from {
    opacity: 0;
    transform: translateX(20px);
  }

  to {
    opacity: 1;
    transform: translateX(0);
  }
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fadeInLeft {
  animation: fadeInLeft 2s ease-in-out;
}

.animate-fadeInRight {
  animation: fadeInRight 2s ease-in-out;
}

.animate-fadeInUp {
  animation: fadeInUp 2s ease-in-out;
}

.animate-fadeInDown {
  animation: fadeInDown 2s ease-in-out;
}


.emboss {
  background: rgb(196, 196, 196);
  color: rgba(0, 0, 0, 0.6);
  text-shadow:
    2px 8px 6px rgba(0, 0, 0, 0.2),
    0px -5px 16px rgba(43, 42, 42, 0.3);
}
</style>

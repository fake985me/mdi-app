<template>
  <div class="relative w-full" :style="`aspect-ratio: ${viewBoxWidth} / ${viewBoxHeight};`">
    <!-- Background Diagram -->
    <div class="absolute top-0 left-0 w-full h-auto object-contain pointer-events-none bg-gray-100 flex items-center justify-center rounded">
      <span class="text-gray-500">{{ diagramTitle }}</span>
    </div>
    
    <!-- SVG Overlay -->
    <div class="svg">
      <svg :key="svgKey" id="Layer_1" xmlns="http://www.w3.org/2000/svg" :viewBox="`0 0 ${viewBoxWidth} ${viewBoxHeight}`">
        <!-- Lines based on diagram type -->
        <line 
          v-for="(line, index) in lines" 
          :key="`line-${index}`"
          :x1="line.x1" 
          :y1="line.y1" 
          :x2="line.x2" 
          :y2="line.y2" 
          fill="none" 
          :class="`line ${line.class}`" 
          stroke-linecap="round"
          stroke-linejoin="round" 
          :stroke-width="line.strokeWidth" 
        />
        
        <!-- Rectangles for devices -->
        <rect 
          v-for="(rect, index) in rectangles" 
          :key="`rect-${index}`"
          :x="rect.x" 
          :y="rect.y" 
          :width="rect.width" 
          :height="rect.height" 
          :fill="rect.fill" 
        />
        
        <!-- Polygon for special shapes -->
        <polygon 
          v-for="(poly, index) in polygons" 
          :key="`poly-${index}`"
          :points="poly.points" 
          :fill="poly.fill" 
        />
        
        <!-- Border rectangle -->
        <rect 
          x="0.5" 
          y="0.5" 
          :width="viewBoxWidth - 0.5" 
          :height="viewBoxHeight + 39" 
          fill="none" 
          opacity="0" 
          stroke="#f5f5f5"
          stroke-miterlimit="10" 
        />
      </svg>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

const props = defineProps({
  diagramType: {
    type: String,
    default: 'default'
  },
  title: {
    type: String,
    default: 'Network Diagram'
  },
  viewBoxWidth: {
    type: Number,
    default: 815.1
  },
  viewBoxHeight: {
    type: Number,
    default: 538.2
  }
})

const svgKey = ref(0)
const diagramTitle = computed(() => props.title || 'Network Diagram')

// Define lines based on diagram type
const lines = computed(() => {
  switch (props.diagramType) {
    case 'xgspon':
      return [
        { x1: 53.3, y1: 335.3, x2: 90, y2: 391.7, class: 'green', strokeWidth: 3 },
        { x1: 110.2, y1: 417.9, x2: 164.7, y2: 456.1, class: 'green', strokeWidth: 3 },
        { x1: 172.1, y1: 453.7, x2: 226.8, y2: 427.8, class: 'blues', strokeWidth: 3 },
        { x1: 248.1, y1: 421.1, x2: 453.1, y2: 324.2, class: 'blues', strokeWidth: 2 },
        { x1: 486, y1: 341, x2: 495.2, y2: 460.2, class: 'black', strokeWidth: 1 },
        // Add more lines as needed
      ]
    case 'gpon':
      return [
        { x1: 100, y1: 200, x2: 300, y2: 250, class: 'blues', strokeWidth: 3 },
        { x1: 300, y1: 250, x2: 500, y2: 300, class: 'green', strokeWidth: 3 },
        { x1: 500, y1: 300, x2: 700, y2: 350, class: 'black', strokeWidth: 3 },
        // Add more lines as needed
      ]
    case 'switch':
      return [
        { x1: 200, y1: 100, x2: 400, y2: 200, class: 'blues', strokeWidth: 3 },
        { x1: 400, y1: 200, x2: 600, y2: 100, class: 'green', strokeWidth: 3 },
        { x1: 300, y1: 150, x2: 500, y2: 250, class: 'black', strokeWidth: 2 },
        // Add more lines as needed
      ]
    default:
      return [
        { x1: 150, y1: 150, x2: 350, y2: 200, class: 'blues', strokeWidth: 3 },
        { x1: 350, y1: 200, x2: 550, y2: 250, class: 'green', strokeWidth: 3 },
        { x1: 550, y1: 250, x2: 750, y2: 300, class: 'black', strokeWidth: 3 },
      ]
  }
})

// Define rectangles for devices
const rectangles = computed(() => {
  switch (props.diagramType) {
    case 'xgspon':
      return [
        { x: 50, y: 150, width: 100, height: 50, fill: '#6b6c6d' },
        { x: 650, y: 300, width: 100, height: 50, fill: '#6b6c6d' },
        // Add more rectangles as needed
      ]
    case 'gpon':
      return [
        { x: 150, y: 200, width: 100, height: 50, fill: '#6b6c6d' },
        { x: 550, y: 350, width: 100, height: 50, fill: '#6b6c6d' },
        // Add more rectangles as needed
      ]
    case 'switch':
      return [
        { x: 100, y: 50, width: 100, height: 50, fill: '#6b6c6d' },
        { x: 600, y: 50, width: 100, height: 50, fill: '#6b6c6d' },
        { x: 350, y: 150, width: 100, height: 100, fill: '#6b6c6d' },
        // Add more rectangles as needed
      ]
    default:
      return [
        { x: 100, y: 100, width: 100, height: 50, fill: '#6b6c6d' },
        { x: 600, y: 250, width: 100, height: 50, fill: '#6b6c6d' },
        // Add more rectangles as needed
      ]
  }
})

// Define polygons for special shapes
const polygons = computed(() => {
  switch (props.diagramType) {
    case 'xgspon':
      return [
        { points: '261.8 428.2 261.8 439.8 213.4 439.8 213.4 428.2 227.7 404.9 261.8 428.2', fill: '#6b6c6d' },
        // Add more polygons as needed
      ]
    case 'gpon':
      return [
        { points: '300 200 320 220 280 240 260 220', fill: '#6b6c6d' },
        // Add more polygons as needed
      ]
    case 'switch':
      return [
        { points: '400 100 420 120 380 140 360 120', fill: '#6b6c6d' },
        // Add more polygons as needed
      ]
    default:
      return [
        { points: '200 150 220 170 180 190 160 170', fill: '#6b6c6d' },
        // Add more polygons as needed
      ]
  }
})

const restartAnimation = () => {
  svgKey.value += 1
}

onMounted(() => {
  // Restart animation on mount
  restartAnimation()
})
</script>

<style scoped>
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
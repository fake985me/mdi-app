<template>
  <div class="p-6 min-h-screen">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
      <p class="text-gray-600">Welcome back, {{ authStore.profile?.full_name }}!</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="card card-hover p-6 fade-in">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Total Products</p>
            <p class="text-2xl font-bold text-gray-900">{{ stats.totalProducts }}</p>
          </div>
          <div class="w-12 h-12 bg-gradient-primary rounded-xl flex items-center justify-center shadow-lg">
            <Package class="w-6 h-6 text-white" />
          </div>
        </div>
      </div>

      <div class="card card-hover p-6 fade-in" style="animation-delay: 0.1s">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Low Stock Items</p>
            <p class="text-2xl font-bold text-red-600">{{ stats.lowStockItems }}</p>
          </div>
          <div class="w-12 h-12 bg-gradient-secondary rounded-xl flex items-center justify-center shadow-lg">
            <AlertTriangle class="w-6 h-6 text-white" />
          </div>
        </div>
      </div>

      <div class="card card-hover p-6 fade-in" style="animation-delay: 0.2s">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Active Borrowings</p>
            <p class="text-2xl font-bold text-orange-600">{{ stats.activeBorrowings }}</p>
          </div>
          <div class="w-12 h-12 bg-gradient-to-r from-orange-400 to-pink-400 rounded-xl flex items-center justify-center shadow-lg">
            <ArrowLeftRight class="w-6 h-6 text-white" />
          </div>
        </div>
      </div>

      <div class="card card-hover p-6 fade-in" style="animation-delay: 0.3s">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Total Sales</p>
            <p class="text-2xl font-bold text-green-600">${{ stats.totalSales.toFixed(2) }}</p>
          </div>
          <div class="w-12 h-12 bg-gradient-success rounded-xl flex items-center justify-center shadow-lg">
            <DollarSign class="w-6 h-6 text-white" />
          </div>
        </div>
      </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
      <!-- Stock Candlestick Chart -->
      <div class="card p-6 slide-up">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Stock Levels</h3>
        <div class="h-64">
          <Bar v-if="stockChartData.labels.length" :data="stockChartData" :options="stockChartOptions" />
          <div v-else class="h-full flex items-center justify-center text-gray-500">
            No data available
          </div>
        </div>
      </div>

      <!-- Sales Pie Chart -->
      <div class="card p-6 slide-up" style="animation-delay: 0.2s">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Most Sold Items</h3>
        <div class="h-64">
          <Pie v-if="salesPieData.labels.length" :data="salesPieData" :options="pieChartOptions" />
          <div v-else class="h-full flex items-center justify-center text-gray-500">
            No data available
          </div>
        </div>
      </div>
    </div>

    <!-- Sales Line Chart -->
    <div class="card p-6 slide-up" style="animation-delay: 0.4s">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Sales Trend</h3>
      <div class="h-64">
        <Line v-if="salesLineData.labels.length" :data="salesLineData" :options="lineChartOptions" />
        <div v-else class="h-full flex items-center justify-center text-gray-500">
          No data available
        </div>
      </div>
    </div>

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
      <div class="card p-6 slide-up" style="animation-delay: 0.6s">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Stock Movements</h3>
        <div class="space-y-4">
          <div
            v-for="movement in recentMovements"
            :key="movement.id"
            class="flex items-center justify-between p-3 glass rounded-lg hover:bg-gray-100 transition-colors"
          >
            <div class="flex items-center space-x-3">
              <div
                class="w-8 h-8 rounded-full flex items-center justify-center shadow-md"
                :class="movement.movement_type === 'incoming' ? 'bg-gradient-success' : 'bg-gradient-secondary'"
              >
                <TrendingUp
                  v-if="movement.movement_type === 'incoming'"
                  class="w-4 h-4 text-white"
                />
                <TrendingDown v-else class="w-4 h-4 text-white" />
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">{{ movement.products?.name }}</p>
                <p class="text-xs text-gray-500">{{ movement.movement_type }}</p>
              </div>
            </div>
            <div class="text-right">
              <p class="text-sm font-medium text-gray-900">{{ movement.quantity }}</p>
              <p class="text-xs text-gray-500">{{ formatDate(movement.created_at) }}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="card p-6 slide-up" style="animation-delay: 0.8s">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Sales</h3>
        <div class="space-y-4">
          <div
            v-for="sale in recentSales"
            :key="sale.id"
            class="flex items-center justify-between p-3 glass rounded-lg hover:bg-gray-100 transition-colors"
          >
            <div class="flex items-center space-x-3">
              <div class="w-8 h-8 bg-gradient-success rounded-full flex items-center justify-center shadow-md">
                <DollarSign class="w-4 h-4 text-white" />
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">{{ sale.customer_name || 'Anonymous' }}</p>
                <p class="text-xs text-gray-500">{{ formatDate(sale.sale_date) }}</p>
              </div>
            </div>
            <div class="text-right">
              <p class="text-sm font-medium text-gray-900">${{ sale.total_amount }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useAuthStore } from '../../stores/auth'
import { useWarehouseStore } from '../../stores/warehouse'
import { Bar, Pie, Line } from 'vue-chartjs'
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  BarElement,
  ArcElement,
  LineElement,
  PointElement,
  Title,
  Tooltip,
  Legend
} from 'chart.js'
import {
  Package, AlertTriangle, ArrowLeftRight, DollarSign,
  TrendingUp, TrendingDown
} from 'lucide-vue-next'

ChartJS.register(
  CategoryScale,
  LinearScale,
  BarElement,
  ArcElement,
  LineElement,
  PointElement,
  Title,
  Tooltip,
  Legend
)

const authStore = useAuthStore()
const warehouseStore = useWarehouseStore()

const stats = computed(() => {
  return {
    totalProducts: warehouseStore.products.length,
    lowStockItems: warehouseStore.products.filter(p => p.current_stock <= p.minimum_stock).length,
    activeBorrowings: warehouseStore.borrowings.filter(b => b.status === 'active').length,
    totalSales: warehouseStore.sales.reduce((sum, sale) => sum + parseFloat(sale.total_amount || 0), 0)
  }
})

const stockChartData = computed(() => {
  const products = warehouseStore.products.slice(0, 10)
  return {
    labels: products.map(p => p.name),
    datasets: [{
      label: 'Current Stock',
      data: products.map(p => p.current_stock),
      backgroundColor: 'rgba(59, 130, 246, 0.5)',
      borderColor: 'rgba(59, 130, 246, 1)',
      borderWidth: 1
    }]
  }
})

const salesPieData = computed(() => {
  // Mock data for most sold items
  const mostSold = warehouseStore.products.slice(0, 5)
  return {
    labels: mostSold.map(p => p.name),
    datasets: [{
      data: mostSold.map(() => Math.floor(Math.random() * 100) + 10),
      backgroundColor: [
        '#3B82F6',
        '#10B981',
        '#F59E0B',
        '#EF4444',
        '#8B5CF6'
      ]
    }]
  }
})

const salesLineData = computed(() => {
  // Mock data for sales trend
  const last7Days = Array.from({ length: 7 }, (_, i) => {
    const date = new Date()
    date.setDate(date.getDate() - i)
    return date.toLocaleDateString()
  }).reverse()

  return {
    labels: last7Days,
    datasets: [{
      label: 'Sales',
      data: last7Days.map(() => Math.floor(Math.random() * 1000) + 100),
      borderColor: '#10B981',
      backgroundColor: 'rgba(16, 185, 129, 0.1)',
      tension: 0.4
    }]
  }
})

const stockChartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false
    }
  },
  scales: {
    y: {
      beginAtZero: true
    }
  }
}

const pieChartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'bottom'
    }
  }
}

const lineChartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false
    }
  },
  scales: {
    y: {
      beginAtZero: true
    }
  }
}

const recentMovements = computed(() => {
  return warehouseStore.stockMovements.slice(0, 5)
})

const recentSales = computed(() => {
  return warehouseStore.sales.slice(0, 5)
})

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString()
}

onMounted(async () => {
  await Promise.all([
    warehouseStore.fetchProducts(),
    warehouseStore.fetchStockMovements(),
    warehouseStore.fetchSales(),
    warehouseStore.fetchBorrowings()
  ])
})
</script>
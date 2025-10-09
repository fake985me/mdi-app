<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">{{ t('dashboard') }}</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-700">{{ t('items') }}</h3>
        <p class="text-3xl font-bold mt-2">{{ dashboardData.total_items }}</p>
      </div>
      
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-700">{{ t('current_stock') }}</h3>
        <p class="text-3xl font-bold mt-2">{{ dashboardData.total_stock }}</p>
      </div>
      
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-700">{{ t('sales') }}</h3>
        <p class="text-3xl font-bold mt-2">Rp {{ dashboardData.total_sales.toLocaleString() }}</p>
      </div>
      
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-700">{{ t('total_sales_count') }}</h3>
        <p class="text-3xl font-bold mt-2">{{ dashboardData.total_sales_count }}</p>
      </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ t('stock_candlestick') }}</h3>
        <canvas ref="stockCandlestickChart"></canvas>
      </div>
      
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ t('top_selling_items') }}</h3>
        <canvas ref="topSellingChart"></canvas>
      </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow">
      <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ t('sales_trend') }}</h3>
      <canvas ref="salesTrendChart"></canvas>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue';
import { useI18n } from 'vue-i18n';
import axios from 'axios';
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  Title,
  Tooltip,
  Legend,
  ArcElement,
} from 'chart.js';
import { CandlestickController, CandlestickElement } from 'chartjs-chart-financial';
import 'chartjs-adapter-date-fns';

// Register Chart.js components
ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  BarElement,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  CandlestickController,
  CandlestickElement
);

export default {
  name: 'DashboardView',
  setup() {
    const { t } = useI18n();
    const dashboardData = ref({
      total_items: 0,
      total_stock: 0,
      total_sales: 0,
      total_sales_count: 0
    });
    
    const stockCandlestickChart = ref(null);
    const topSellingChart = ref(null);
    const salesTrendChart = ref(null);
    
    let stockChartInstance = null;
    let pieChartInstance = null;
    let lineChartInstance = null;

    onMounted(async () => {
      try {
        // Fetch dashboard data
        const response = await axios.get('/api/dashboard', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        dashboardData.value = response.data;
        
        // Fetch chart data
        const chartResponse = await axios.get('/api/dashboard/charts', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        });
        
        const chartData = chartResponse.data;
        
        // Render candlestick chart
        renderStockCandlestickChart(chartData.stock_candlestick);
        
        // Render pie chart
        renderTopSellingChart(chartData.top_selling_items);
        
        // Render line chart
        renderSalesTrendChart(chartData.sales_trend);
        
      } catch (error) {
        console.error('Error fetching dashboard data:', error);
      }
    });
    
    const renderStockCandlestickChart = (data) => {
      if (stockChartInstance) {
        stockChartInstance.destroy();
      }
      
      const ctx = stockCandlestickChart.value.getContext('2d');
      stockChartInstance = new ChartJS(ctx, {
        type: 'candlestick',
        data: {
          labels: data.map(item => item.item_name),
          datasets: [{
            label: t('current_stock'),
            data: data.map(item => ({
              x: item.item_name,
              o: item.open,
              h: item.high,
              l: item.low,
              c: item.close
            })),
            color: {
              up: 'rgba(0, 150, 0, 1)',
              down: 'rgba(255, 0, 0, 1)',
              unchanged: 'rgba(100, 100, 100, 1)',
            },
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
              type: 'category',
              title: {
                display: true,
                text: t('items')
              }
            },
            y: {
              title: {
                display: true,
                text: t('stock_level')
              }
            }
          },
          plugins: {
            legend: {
              display: true,
              position: 'top',
            },
            tooltip: {
              mode: 'index',
              intersect: false,
            },
          }
        }
      });
    };
    
    const renderTopSellingChart = (data) => {
      if (pieChartInstance) {
        pieChartInstance.destroy();
      }
      
      const ctx = topSellingChart.value.getContext('2d');
      pieChartInstance = new ChartJS(ctx, {
        type: 'pie',
        data: {
          labels: data.labels,
          datasets: [{
            label: t('quantity_sold'),
            data: data.data,
            backgroundColor: [
              'rgba(255, 99, 132, 0.8)',
              'rgba(54, 162, 235, 0.8)',
              'rgba(255, 205, 86, 0.8)',
              'rgba(75, 192, 192, 0.8)',
              'rgba(153, 102, 255, 0.8)',
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 205, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
            ],
            borderWidth: 1,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'top',
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  const label = context.label || '';
                  const value = context.parsed || 0;
                  return `${label}: ${value} ${t('items')}`;
                }
              }
            }
          }
        }
      });
    };
    
    const renderSalesTrendChart = (data) => {
      if (lineChartInstance) {
        lineChartInstance.destroy();
      }
      
      const ctx = salesTrendChart.value.getContext('2d');
      lineChartInstance = new ChartJS(ctx, {
        type: 'line',
        data: {
          labels: data.labels,
          datasets: [{
            label: t('sales'),
            data: data.data,
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    };

    onUnmounted(() => {
      // Clean up chart instances when component is unmounted
      if (stockChartInstance) stockChartInstance.destroy();
      if (pieChartInstance) pieChartInstance.destroy();
      if (lineChartInstance) lineChartInstance.destroy();
    });

    return {
      t,
      dashboardData,
      stockCandlestickChart,
      topSellingChart,
      salesTrendChart
    };
  }
};
</script>
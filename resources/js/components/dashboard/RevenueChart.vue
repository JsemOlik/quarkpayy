// @ts-expect-error: chartjs-plugin-crosshair has no types
declare module 'chartjs-plugin-crosshair';

<template>
  <div class="rounded-xl bg-neutral-900/80 dark:bg-neutral-900 shadow p-6 border border-neutral-800">
    <div class="flex items-center justify-between mb-2">
      <div class="font-semibold text-white">Revenue</div>
      <select v-model="selectedRange" class="bg-neutral-800 text-neutral-200 text-xs rounded px-2 py-1">
        <option value="7">Last 7 days</option>
        <option value="30">Last 30 days</option>
      </select>
    </div>
    <div class="mb-2 text-sm text-neutral-300">
      Total New Orders: <span class="font-bold text-white">{{ totalNewOrders }}</span>
    </div>
    <Line :data="chartData" :options="chartOptions" height="180" />
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { Line } from 'vue-chartjs';
import {
  Chart,
  LineElement,
  PointElement,
  LinearScale,
  Title,
  CategoryScale,
  Tooltip,
  Legend
} from 'chart.js';
import crosshairPlugin from 'chartjs-plugin-crosshair';

Chart.register(LineElement, PointElement, LinearScale, Title, CategoryScale, Tooltip, Legend, crosshairPlugin);

const selectedRange = ref('7');

const mockData = {
  labels: Array.from({ length: 7 }, (_, i) => {
    const d = new Date();
    d.setDate(d.getDate() - (6 - i));
    return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
  }),
  revenue: [180, 220, 150, 300, 250, 400, 350],
  netRevenue: [150, 200, 120, 270, 230, 370, 320],
  newOrders: [2, 3, 1, 4, 3, 5, 4],
};

const totalNewOrders = computed(() => mockData.newOrders.reduce((a, b) => a + b, 0));

const chartData = computed(() => ({
  labels: mockData.labels,
  datasets: [
    {
      label: 'Revenue',
      data: mockData.revenue,
      borderColor: '#38bdf8',
      backgroundColor: 'rgba(56,189,248,0.1)',
      tension: 0.4,
      fill: false,
      pointRadius: 4,
      pointHoverRadius: 6,
    },
    {
      label: 'Net Revenue',
      data: mockData.netRevenue,
      borderColor: '#4ade80',
      backgroundColor: 'rgba(74,222,128,0.1)',
      tension: 0.4,
      fill: false,
      pointRadius: 4,
      pointHoverRadius: 6,
    },
    {
      label: 'New Orders',
      data: mockData.newOrders,
      borderColor: '#f87171',
      backgroundColor: 'rgba(248,113,113,0.1)',
      tension: 0.4,
      fill: false,
      pointRadius: 4,
      pointHoverRadius: 6,
      yAxisID: 'y1',
    },
  ],
}));

const chartOptions = {
  responsive: true,
  plugins: {
    legend: {
      labels: { color: '#fff', font: { size: 12 } },
    },
    tooltip: {
      enabled: true,
      mode: 'index' as const,
      intersect: false,
      backgroundColor: '#18181b',
      borderColor: '#38bdf8',
      borderWidth: 1,
      titleColor: '#fff',
      bodyColor: '#fff',
      callbacks: {
        label: function(context: any) {
          if (context.dataset.label === 'New Orders') {
            return `${context.dataset.label}: ${context.parsed.y} orders`;
          }
          return `${context.dataset.label}: $${context.parsed.y}`;
        }
      }
    },
    crosshair: {
      line: {
        color: '#38bdf8', // cyan/blue
        width: 1
      },
      sync: {
        enabled: false
      },
      zoom: {
        enabled: false
      },
      snap: {
        enabled: true,
        animation: {
          enabled: true,
          duration: 200 // ms, adjust for smoothness
        }
      }
    }
  },
  hover: {
    mode: 'nearest' as const,
    intersect: false,
  },
  interaction: {
    mode: 'nearest' as const,
    intersect: false,
  },
  scales: {
    x: {
      ticks: { color: '#a3a3a3' },
      grid: { color: 'rgba(255,255,255,0.05)' },
    },
    y: {
      ticks: { color: '#a3a3a3' },
      grid: { color: 'rgba(255,255,255,0.05)' },
      beginAtZero: true,
      min: 0,
      max: 500,
      title: {
        display: true,
        text: 'Amount ($)',
        color: '#a3a3a3',
      },
    },
    y1: {
      position: 'right' as const,
      beginAtZero: true,
      min: 0,
      max: 10,
      grid: { drawOnChartArea: false },
      ticks: { color: '#f87171' },
      title: {
        display: true,
        text: 'New Orders',
        color: '#f87171',
      },
    },
  },
};
</script> 
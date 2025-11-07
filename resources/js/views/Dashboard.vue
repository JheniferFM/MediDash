<template>
  <div>
    <h2 class="text-xl font-semibold">Welcome to MediDash</h2>
    <p class="mt-2 text-gray-600">System KPIs:</p>
    <div class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-4">
      <!-- Pacientes -->
      <div class="group relative overflow-hidden rounded-xl bg-white border border-gray-200 shadow-sm p-4">
        <span class="absolute inset-x-0 top-0 h-1 brand-topbar-primary" aria-hidden="true"></span>
        <div class="flex items-center gap-3">
          <div class="flex h-10 w-10 items-center justify-center rounded-md bg-gray-100 text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
              <circle cx="8" cy="7" r="3" />
              <circle cx="16" cy="7" r="3" />
              <path d="M4 20c0-3 2.5-5 6-5s6 2 6 5" />
            </svg>
          </div>
          <div class="flex-1">
            <div class="text-xs uppercase tracking-wide text-gray-500">Patients</div>
            <div class="text-3xl font-semibold tracking-tight text-gray-900">{{ formatNumber(kpis.patients) }}</div>
          </div>
        </div>
      </div>

      <!-- Médicos -->
      <div class="group relative overflow-hidden rounded-xl bg-white border border-gray-200 shadow-sm p-4">
        <span class="absolute inset-x-0 top-0 h-1 brand-topbar-secondary" aria-hidden="true"></span>
        <div class="flex items-center gap-3">
          <div class="flex h-10 w-10 items-center justify-center rounded-md bg-gray-100 text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
              <circle cx="12" cy="8" r="3" />
              <rect x="6" y="14" width="12" height="6" rx="3" />
              <path d="M18 6l2 0M4 6l2 0" />
            </svg>
          </div>
          <div class="flex-1">
            <div class="text-xs uppercase tracking-wide text-gray-500">Doctors</div>
            <div class="text-3xl font-semibold tracking-tight text-gray-900">{{ formatNumber(kpis.doctors) }}</div>
          </div>
        </div>
      </div>

      <!-- Consultas Agendadas -->
      <div class="group relative overflow-hidden rounded-xl bg-white border border-gray-200 shadow-sm p-4">
        <span class="absolute inset-x-0 top-0 h-1 brand-topbar-warning" aria-hidden="true"></span>
        <div class="flex items-center gap-3">
          <div class="flex h-10 w-10 items-center justify-center rounded-md bg-gray-100 text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
              <rect x="3" y="5" width="18" height="16" rx="2" />
              <path d="M3 9h18M8 3v4M16 3v4" />
            </svg>
          </div>
          <div class="flex-1">
            <div class="text-xs uppercase tracking-wide text-gray-500">Scheduled Appointments</div>
            <div class="text-3xl font-semibold tracking-tight text-gray-900">{{ formatNumber(kpis.appointments.scheduled) }}</div>
          </div>
        </div>
      </div>

      <!-- Consultas Hoje com progresso -->
      <div class="group relative overflow-hidden rounded-xl bg-white border border-gray-200 shadow-sm p-4">
        <span class="absolute inset-x-0 top-0 h-1 brand-topbar-success" aria-hidden="true"></span>
        <div class="flex items-center gap-3">
          <div class="flex h-10 w-10 items-center justify-center rounded-md bg-gray-100 text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
              <circle cx="12" cy="12" r="9" />
              <path d="M12 7v5l3 2" />
            </svg>
          </div>
          <div class="flex-1">
            <div class="flex items-center justify-between">
              <div class="text-xs uppercase tracking-wide text-gray-500">Appointments Today</div>
              <span class="text-xs text-gray-600">{{ activityPercent }}%</span>
            </div>
            <div class="text-3xl font-semibold tracking-tight text-gray-900">{{ formatNumber(kpis.appointments.today) }}</div>
            <div class="mt-2 h-2 bg-gray-100 rounded">
              <div class="h-2 rounded bg-emerald-600" :style="{ width: activityPercent + '%' }"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Exames Pendentes com progresso -->
      <div class="group relative overflow-hidden rounded-xl bg-white border border-gray-200 shadow-sm p-4">
        <span class="absolute inset-x-0 top-0 h-1 brand-topbar-danger" aria-hidden="true"></span>
        <div class="flex items-center gap-3">
          <div class="flex h-10 w-10 items-center justify-center rounded-md bg-gray-100 text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
              <path d="M9 3h6v4l-3 12-3-12V3z" />
              <path d="M9 7h6" />
            </svg>
          </div>
          <div class="flex-1">
            <div class="flex items-center justify-between">
              <div class="text-xs uppercase tracking-wide text-gray-500">Pending Exams</div>
              <span class="text-xs text-gray-600">{{ examPendingPercent }}%</span>
            </div>
            <div class="text-3xl font-semibold tracking-tight text-gray-900">{{ formatNumber(kpis.exams.pending) }}</div>
            <div class="mt-2 h-2 bg-gray-100 rounded">
              <div class="h-2 rounded bg-rose-600" :style="{ width: examPendingPercent + '%' }"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Exames Agendados -->
      <div class="group relative overflow-hidden rounded-xl bg-white border border-gray-200 shadow-sm p-4">
        <span class="absolute inset-x-0 top-0 h-1 brand-topbar-info" aria-hidden="true"></span>
        <div class="flex items-center gap-3">
          <div class="flex h-10 w-10 items-center justify-center rounded-md bg-gray-100 text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
              <rect x="6" y="4" width="12" height="16" rx="2" />
              <path d="M9 8h6M9 12h6M9 16h6" />
            </svg>
          </div>
          <div>
            <div class="text-xs uppercase tracking-wide text-gray-500">Scheduled Exams</div>
            <div class="text-3xl font-semibold tracking-tight text-gray-900">{{ formatNumber(kpis.exams.scheduled) }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Creative charts -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="p-4 bg-white shadow rounded overflow-hidden">
        <h3 class="text-sm text-gray-600 mb-2">Exam Distribution</h3>
        <v-chart class="w-full" :option="examPieOption" autoresize style="aspect-ratio:1/1;height:auto;min-height:280px;" />
      </div>
      <div class="p-4 bg-white shadow rounded overflow-hidden">
        <h3 class="text-sm text-gray-600 mb-2">Overview</h3>
        <v-chart class="w-full" :option="overviewBarOption" autoresize style="aspect-ratio:2/1;height:auto;min-height:280px;" />
      </div>
      <div class="p-4 bg-white shadow rounded md:col-span-2 overflow-hidden">
        <h3 class="text-sm text-gray-600 mb-2">Today's Activity Rate</h3>
        <v-chart class="w-full" :option="todayGaugeOption" autoresize style="aspect-ratio:2/1;height:auto;min-height:280px;" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import { use } from 'echarts/core';
import { CanvasRenderer } from 'echarts/renderers';
import { PieChart, BarChart, GaugeChart } from 'echarts/charts';
import { TitleComponent, TooltipComponent, LegendComponent, GridComponent } from 'echarts/components';

// Registrar módulos do ECharts (tree-shaking)
use([CanvasRenderer, PieChart, BarChart, GaugeChart, TitleComponent, TooltipComponent, LegendComponent, GridComponent]);

const kpis = ref({ patients: 0, doctors: 0, appointments: { scheduled: 0, today: 0 }, exams: { pending: 0, scheduled: 0 } });
const load = async () => {
  const { data } = await axios.get(window.location.origin + '/dashboard');
  kpis.value = data;
};
onMounted(load);

// Display helpers
const formatNumber = (n) => new Intl.NumberFormat('en-US').format(Number(n || 0));

// Activity percentage of the day (today vs scheduled)
const activityPercent = computed(() => {
  const scheduled = kpis.value.appointments?.scheduled || 0;
  const today = kpis.value.appointments?.today || 0;
  return scheduled > 0 ? Math.min(100, Math.round((today / scheduled) * 100)) : 0;
});

// Percentage of pending exams in total
const totalExams = computed(() => (kpis.value.exams?.pending || 0) + (kpis.value.exams?.scheduled || 0));
const examPendingPercent = computed(() => {
  const total = totalExams.value;
  const pending = kpis.value.exams?.pending || 0;
  return total > 0 ? Math.round((pending / total) * 100) : 0;
});

// Palette based on brand tokens
const getBrandColor = (tokenName, fallback) => {
  const value = getComputedStyle(document.documentElement).getPropertyValue(tokenName).trim();
  return value || fallback;
};
const palette = [
  getBrandColor('--brand-primary', '#2E5AAC'),
  getBrandColor('--brand-warning', '#F59E0B'),
  getBrandColor('--brand-success', '#10B981'),
  getBrandColor('--brand-danger', '#EF4444'),
  getBrandColor('--brand-secondary', '#7C3AED'),
  getBrandColor('--brand-info', '#06B6D4'),
];

// Pie chart for exam status
const examPieOption = computed(() => ({
  backgroundColor: '#ffffff',
  tooltip: { trigger: 'item' },
  legend: { top: 'bottom' },
  series: [{
    name: 'Exams',
    type: 'pie',
    radius: ['40%', '70%'],
    center: ['50%', '50%'],
    avoidLabelOverlap: false,
    itemStyle: { borderRadius: 6, borderColor: '#fff', borderWidth: 2 },
    color: [palette[1], palette[2], palette[0], palette[3]],
    label: { show: true, formatter: '{b}: {c}' },
    data: [
      { value: kpis.value.exams.pending || 0, name: 'Pending' },
      { value: kpis.value.exams.scheduled || 0, name: 'Scheduled' },
      { value: 0, name: 'Performed' },
      { value: 0, name: 'Cancelled' },
    ],
  }],
}));

// Bars for overview
const overviewBarOption = computed(() => ({
  tooltip: { trigger: 'axis' },
  grid: { left: '3%', right: '3%', bottom: '3%', containLabel: true },
  xAxis: { type: 'category', data: ['Patients', 'Doctors', 'Scheduled Appts', 'Appointments Today'] },
  yAxis: { type: 'value' },
  color: [palette[0], palette[5], palette[1], palette[2]],
  series: [{
    type: 'bar',
    data: [
      kpis.value.patients || 0,
      kpis.value.doctors || 0,
      kpis.value.appointments.scheduled || 0,
      kpis.value.appointments.today || 0,
    ],
    itemStyle: { borderRadius: [6, 6, 0, 0] },
  }],
}));

// Gauge for today's activity rate (today / scheduled)
const todayGaugeOption = computed(() => {
  const scheduled = kpis.value.appointments.scheduled || 0;
  const today = kpis.value.appointments.today || 0;
  const percent = scheduled > 0 ? Math.min(100, Math.round((today / scheduled) * 100)) : 0;
  return {
    tooltip: { formatter: '{a}<br/>{c}%' },
    series: [{
      name: "Today's Activity",
      type: 'gauge',
      center: ['50%', '55%'],
      radius: '95%',
      progress: { show: true, width: 12 },
      axisLine: { lineStyle: { width: 12 } },
      axisTick: { show: true },
      splitLine: { length: 12, lineStyle: { width: 2 } },
      axisLabel: { color: '#6B7280' },
      anchor: { show: true, showAbove: true, size: 12, itemStyle: { color: palette[2] } },
      pointer: { width: 5 },
      title: { show: true, offsetCenter: [0, '85%'] },
      detail: { valueAnimation: true, formatter: '{value}%', color: '#111827' },
      itemStyle: { color: palette[2] },
      data: [{ value: percent, name: 'Today/Scheduled' }],
    }],
  };
});
</script>
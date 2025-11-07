<template>
  <div class="min-h-screen hospital-bg text-primary">
    <header class="bg-surface shadow border-b border-token">
      <div class="max-w-6xl mx-auto px-4 py-3 flex gap-6 items-center">
        <div class="flex items-center gap-2">
          <span class="inline-flex items-center justify-center" style="color: var(--brand-primary)">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <circle cx="12" cy="12" r="11" fill="currentColor" opacity="0.12"/>
              <rect x="4" y="10" width="16" height="4" rx="1" fill="currentColor"/>
              <rect x="10" y="4" width="4" height="16" rx="1" fill="currentColor"/>
            </svg>
          </span>
          <h1 class="text-xl font-semibold text-primary">MediDash</h1>
        </div>
        <nav class="flex gap-4 text-sm">
          <router-link
            to="/"
            :class="linkClass(canDashboard)"
            :title="canDashboard ? '' : 'Faça login para acessar'"
          >Dashboard</router-link>

          <router-link
            to="/patients"
            :class="linkClass(canPatients)"
            :title="canPatients ? '' : 'Requer papel admin ou receptionist'"
          >Patients</router-link>

          <router-link
            to="/doctors"
            :class="linkClass(canDoctors)"
            :title="canDoctors ? '' : 'Requer papel admin'"
          >Doctors</router-link>

          <router-link
            to="/appointments"
            :class="linkClass(canAppointments)"
            :title="canAppointments ? '' : 'Requer admin, receptionist ou doctor'"
          >Appointments</router-link>

          <router-link
            to="/exams"
            :class="linkClass(canExams)"
            :title="canExams ? '' : 'Requer admin ou doctor'"
          >Exams</router-link>

          <router-link
            to="/prescriptions"
            :class="linkClass(canPrescriptions)"
            :title="canPrescriptions ? '' : 'Requer admin ou doctor'"
          >Prescriptions</router-link>
        </nav>
        <div class="ml-auto">
          <AuthBar />
        </div>
      </div>
    </header>
    <main class="max-w-6xl mx-auto p-6">
      <router-view />
    </main>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import AuthBar from './components/AuthBar.vue';
import { useAuthStore } from './stores/auth';

const store = useAuthStore();
const isAuth = computed(() => store.isAuthenticated);
const roles = computed(() => store.roles || []);
const has = (role) => roles.value.includes(role);

// Permissões por item
const canDashboard = computed(() => isAuth.value);
const canPatients = computed(() => isAuth.value);
const canDoctors = computed(() => isAuth.value);
const canAppointments = computed(() => isAuth.value);
const canExams = computed(() => isAuth.value);
const canPrescriptions = computed(() => isAuth.value);

// Helpers de UI
const baseLinkClass = 'text-secondary hover:text-[color:var(--brand-primary)]';
const linkClass = (allowed) => allowed ? baseLinkClass : baseLinkClass + ' opacity-50';
</script>

<style>
/* estilos adicionais opcionais */
</style>
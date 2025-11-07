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
          <router-link to="/" class="text-secondary hover:text-[color:var(--brand-primary)]">Dashboard</router-link>
          <router-link to="/patients" class="text-secondary hover:text-[color:var(--brand-primary)]">Patients</router-link>
          <router-link to="/doctors" class="text-secondary hover:text-[color:var(--brand-primary)]">Doctors</router-link>
          <router-link to="/appointments" class="text-secondary hover:text-[color:var(--brand-primary)]">Appointments</router-link>
          <router-link to="/exams" class="text-secondary hover:text-[color:var(--brand-primary)]">Exams</router-link>
          <router-link to="/prescriptions" class="text-secondary hover:text-[color:var(--brand-primary)]">Prescriptions</router-link>
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
import AuthBar from './components/AuthBar.vue';
</script>

<style>
/* estilos adicionais opcionais */
</style>
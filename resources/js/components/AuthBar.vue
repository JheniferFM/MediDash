<template>
  <div class="flex items-center gap-3 text-sm">
    <template v-if="isAuthenticated">
      <span class="text-gray-600">{{ user?.name }}</span>
      <button class="px-2 py-1 border rounded" @click="logout">Sair</button>
    </template>
    <template v-else>
      <router-link to="/login" class="px-2 py-1 border rounded">Entrar</router-link>
      <router-link to="/register" class="px-2 py-1 border rounded">Cadastrar</router-link>
    </template>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { useAuthStore } from '../stores/auth';
import axios from 'axios';

const store = useAuthStore();
const isAuthenticated = computed(() => store.isAuthenticated);
const user = computed(() => store.user);

const logout = async () => {
  try {
    await axios.post('/logout');
  } catch {}
  store.clear();
  window.location.href = '/login';
};
</script>
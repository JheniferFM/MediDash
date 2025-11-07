<template>
  <div class="flex items-center gap-3 text-sm">
    <template v-if="isAuthenticated">
      <span class="text-gray-600">{{ user?.name }}</span>
      <span v-if="roles.length" class="px-2 py-0.5 text-xs rounded bg-gray-100 text-gray-700 border">
        {{ roles.join(', ') }}
      </span>
      <span v-else class="px-2 py-0.5 text-xs rounded bg-yellow-100 text-yellow-800 border border-yellow-300">
        sem papéis
      </span>
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
const roles = computed(() => store.roles || []);

const logout = async () => {
  try {
    await axios.post('/logout');
  } catch {}
  store.clear();
  window.location.href = '/login';
};
</script>
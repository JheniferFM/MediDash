<template>
  <div class="max-w-sm mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-xl font-semibold">Entrar</h2>
    <form class="mt-4 space-y-3" @submit.prevent="onSubmit">
      <div>
        <label class="block text-sm">Email</label>
        <input v-model="email" type="email" class="mt-1 w-full border rounded p-2" required />
      </div>
      <div>
        <label class="block text-sm">Senha</label>
        <input v-model="password" type="password" class="mt-1 w-full border rounded p-2" required />
      </div>
      <button class="mt-2 px-4 py-2 bg-blue-600 text-white rounded" :disabled="loading">
        {{ loading ? 'Entrando...' : 'Entrar' }}
      </button>
      <p v-if="error" class="text-red-600 text-sm">{{ error }}</p>
  </form>
  <p class="mt-2 text-sm">
    Não tem conta? <router-link to="/register" class="text-blue-600">Cadastrar</router-link>
  </p>
  </div>
  </template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useAuthStore } from '../stores/auth';
import { useRouter, useRoute } from 'vue-router';

const email = ref('');
const password = ref('');
const loading = ref(false);
const error = ref(null);
const router = useRouter();
const route = useRoute();
const store = useAuthStore();

const onSubmit = async () => {
  loading.value = true; error.value = null;
  try {
    const { data } = await axios.post('/login', { email: email.value, password: password.value });
    store.setToken(data.token);
    store.setUser(data.user);
    const redirect = route.query.redirect || '/';
    router.replace(redirect);
  } catch (e) {
    error.value = e?.response?.data?.message || 'Falha ao entrar';
  } finally {
    loading.value = false;
  }
};
</script>
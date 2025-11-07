<template>
  <div class="max-w-sm mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-xl font-semibold">Criar conta</h2>
    <form class="mt-4 space-y-3" @submit.prevent="onSubmit">
      <div>
        <label class="block text-sm">Nome</label>
        <input v-model="name" type="text" class="mt-1 w-full border rounded p-2" required />
      </div>
      <div>
        <label class="block text-sm">Email</label>
        <input v-model="email" type="email" class="mt-1 w-full border rounded p-2" required />
      </div>
      <div>
        <label class="block text-sm">Senha</label>
        <input v-model="password" type="password" class="mt-1 w-full border rounded p-2" required />
      </div>
      <div>
        <label class="block text-sm">Confirmar senha</label>
        <input v-model="passwordConfirm" type="password" class="mt-1 w-full border rounded p-2" required />
      </div>
      <button class="mt-2 px-4 py-2 bg-green-600 text-white rounded" :disabled="loading">
        {{ loading ? 'Cadastrando...' : 'Cadastrar' }}
      </button>
      <p v-if="error" class="text-red-600 text-sm">{{ error }}</p>
    </form>
    <p class="mt-2 text-sm">
      Já tem conta? <router-link to="/login" class="text-blue-600">Entrar</router-link>
    </p>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useAuthStore } from '../stores/auth';
import { useRouter, useRoute } from 'vue-router';

const name = ref('');
const email = ref('');
const password = ref('');
const passwordConfirm = ref('');
const loading = ref(false);
const error = ref(null);
const router = useRouter();
const route = useRoute();
const store = useAuthStore();

const onSubmit = async () => {
  error.value = null;
  if (password.value !== passwordConfirm.value) {
    error.value = 'As senhas não conferem';
    return;
  }
  loading.value = true;
  try {
    const { data } = await axios.post('/register', {
      name: name.value,
      email: email.value,
      password: password.value,
    });
    store.setToken(data.token);
    store.setUser(data.user);
    const redirect = route.query.redirect || '/';
    router.replace(redirect);
  } catch (e) {
    error.value = e?.response?.data?.message || 'Falha ao cadastrar';
  } finally {
    loading.value = false;
  }
};
</script>
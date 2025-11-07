import axios from 'axios';
import { useAuthStore } from './stores/auth';

window.axios = axios;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.baseURL = '/api';

// Inicializa Authorization a partir do localStorage para persistência após reload
try {
  const savedToken = typeof localStorage !== 'undefined' ? localStorage.getItem('auth.token') : null;
  if (savedToken) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${savedToken}`;
  }
} catch {}

axios.interceptors.request.use((config) => {
  try {
    const store = useAuthStore();
    if (store.token) {
      config.headers = config.headers || {};
      config.headers.Authorization = `Bearer ${store.token}`;
    }
    // Fallback: se o store ainda não estiver disponível, usa token do localStorage
    if (!config.headers?.Authorization) {
      const savedToken = typeof localStorage !== 'undefined' ? localStorage.getItem('auth.token') : null;
      if (savedToken) {
        config.headers = config.headers || {};
        config.headers.Authorization = `Bearer ${savedToken}`;
      }
    }
  } catch {}
  return config;
});

axios.interceptors.response.use(
  (resp) => resp,
  (error) => {
    if (error?.response?.status === 401) {
      try {
        const store = useAuthStore();
        store.clear();
        // Remove Authorization default para evitar requisições subsequentes sem token
        try { delete axios.defaults.headers.common['Authorization']; } catch {}
        try { if (typeof localStorage !== 'undefined') localStorage.removeItem('auth.token'); } catch {}
        window.location.href = '/login';
      } catch {}
    }
    return Promise.reject(error);
  }
);

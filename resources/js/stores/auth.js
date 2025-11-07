import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: typeof localStorage !== 'undefined' ? localStorage.getItem('auth.token') : null,
    user: typeof localStorage !== 'undefined' ? JSON.parse(localStorage.getItem('auth.user') || 'null') : null,
    loading: false,
    error: null,
  }),
  getters: {
    isAuthenticated: (state) => !!state.token,
    roles: (state) => {
      const list = Array.isArray(state.user?.roles) ? state.user.roles : [];
      // Suporta bancos sem coluna 'slug' (usa name como fallback) e normaliza valores
      return list
        .map(r => r?.slug || (r?.name ? String(r.name).toLowerCase() : null))
        .map(s => (s === 'administrator' ? 'admin' : s))
        .filter(Boolean);
    },
  },
  actions: {
    setToken(token) {
      this.token = token;
      try { localStorage.setItem('auth.token', token || ''); } catch {}
    },
    setUser(user) {
      this.user = user;
      try { localStorage.setItem('auth.user', JSON.stringify(user || null)); } catch {}
    },
    clear() {
      this.token = null;
      this.user = null;
      try {
        localStorage.removeItem('auth.token');
        localStorage.removeItem('auth.user');
      } catch {}
    },
  }
});
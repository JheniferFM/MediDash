import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const Dashboard = () => import('../views/Dashboard.vue');
const Login = () => import('../views/Login.vue');
const Register = () => import('../views/Register.vue');
const Patients = () => import('../views/Patients.vue');
const Doctors = () => import('../views/Doctors.vue');
const Appointments = () => import('../views/Appointments.vue');
const Exams = () => import('../views/Exams.vue');
const Prescriptions = () => import('../views/Prescriptions.vue');

const routes = [
  { path: '/', name: 'dashboard', component: Dashboard, meta: { requiresAuth: true } },
  { path: '/login', name: 'login', component: Login, meta: { guestOnly: true } },
  { path: '/register', name: 'register', component: Register, meta: { guestOnly: true } },
  { path: '/patients', name: 'patients', component: Patients, meta: { requiresAuth: true } },
  { path: '/doctors', name: 'doctors', component: Doctors, meta: { requiresAuth: true } },
  { path: '/appointments', name: 'appointments', component: Appointments, meta: { requiresAuth: true } },
  { path: '/exams', name: 'exams', component: Exams, meta: { requiresAuth: true } },
  { path: '/prescriptions', name: 'prescriptions', component: Prescriptions, meta: { requiresAuth: true } },
];

export const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const store = useAuthStore();
  if (to.meta.requiresAuth && !store.isAuthenticated) {
    // Opcional: feedback de login necessário
    try { window.alert('Faça login para acessar esta página.'); } catch {}
    return next({ name: 'login', query: { redirect: to.fullPath } });
  }
  if (to.meta.guestOnly && store.isAuthenticated) {
    return next({ name: 'dashboard' });
  }
  next();
});
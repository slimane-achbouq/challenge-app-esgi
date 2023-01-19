import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '@/views/LoginView.vue';
import DashboardView from '@/views/DashboardView.vue';
import AccountVerificationView from '@/views/AccountVerificationView.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'home', redirect: '/login' },
    { path: '/login', name: 'login', component: LoginView, meta: { requiresUnauth: false } },
    { path: '/dashboard', name: 'dashboard', component: DashboardView, meta: { requiresUnauth: true } },
    { path: '/account-verification/:userId/:token', name: 'account-verification', component: AccountVerificationView , meta: { requiresUnauth: false } }
  ]
})

export default router

import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '@/views/LoginView.vue';
import DashboardView from '@/views/DashboardView.vue';
import AccountVerificationView from '@/views/AccountVerificationView.vue';
import ResetPassword from '@/views/ResetPasswordView.vue';
import ResetPasswordSuccessView from '@/views/ResetPasswordSuccessView.vue';
import ResetPasswordInputView from '@/views/ResetPasswordInputView.vue';
import ResetPasswordModificationMessageView from '@/views/ResetPasswordModificationMessageView.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'home', redirect: '/login' },
    { path: '/login', name: 'login', component: LoginView, meta: { requiresUnauth: false } },
    { path: '/dashboard', name: 'dashboard', component: DashboardView, meta: { requiresUnauth: true } },
    { path: '/account-verification/:userId/:token', name: 'account-verification', component: AccountVerificationView , meta: { requiresUnauth: false } },
    { path: '/reset-password', name: 'reset-password', component: ResetPassword, meta: { requiresUnauth: false }},
    { path: '/reset-password-success', name: 'reset-password-success', component: ResetPasswordSuccessView, meta: { requiresUnauth: false }},
    { path: '/reset-password-input/:token', name: 'reset-password-input', component: ResetPasswordInputView, meta: { requiresUnauth: false }},
    { path: '/reset-password-modification-message', name: 'reset-password-modification-message', component: ResetPasswordModificationMessageView, meta: { requiresUnauth: false }},
  ]
})

export default router

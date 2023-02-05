import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '@/views/LoginView.vue';

import UserList from '@/views/UserList.vue';
import AnnouncesList from '@/views/AnnouncesList.vue';
import Announce from '@/views/Announce.vue';
import NewAnnounce from '@/views/NewAnnounce.vue';
import AccountVerificationView from '@/views/AccountVerificationView.vue';
import ResetPassword from '@/views/ResetPasswordView.vue';
import successMessageView from '@/views/successMessageView.vue';
import ResetPasswordInputView from '@/views/ResetPasswordInputView.vue';
import DashboardView from '@/views/DashboardView.vue';
import OrganizmeView from '@/views/OrganismeView.vue';

import RegisterView from '@/views/RegisterView.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'home', redirect: '/login' },
    { path: '/login', name: 'login', component: LoginView, meta: { requiresUnauth: false } },
    { path: '/dashboard/users', name: 'users', component: UserList, meta: { requiresUnauth: false } },
    { path: '/register', name: 'register', component: RegisterView, meta: { requiresUnauth: false } },
    { path: '/organisme', name: 'organisme', component: OrganizmeView, meta: { requiresUnauth: false } },
    { path: '/dashboard', name: 'dashboard', component: DashboardView, meta: { requiresUnauth: true } },
    { path: '/dashboard/announces', name: 'announces', component: AnnouncesList, meta: { requiresUnauth: false } },
    { path: '/announce', name: 'announce', component: Announce, meta: { requiresUnauth: false } },
    { path: '/newannounce', name: 'newannounce', component: NewAnnounce, meta: { requiresUnauth: false } },
    { path: '/account-verification/:userId/:token', name: 'account-verification', component: AccountVerificationView , meta: { requiresUnauth: false } },
    { path: '/reset-password', name: 'reset-password', component: ResetPassword, meta: { requiresUnauth: false }},
    { path: '/reset-password-success', name: 'reset-password-success', component: successMessageView, meta: { requiresUnauth: false }},
    { path: '/reset-password-input/:token', name: 'reset-password-input', component: ResetPasswordInputView, meta: { requiresUnauth: false }},
  ]
})

export default router

import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '@/views/LoginView.vue';
import DashboardView from '@/views/DashboardView.vue';
import UserList from '@/views/UserList.vue';
import AnnouncesList from '@/views/AnnouncesList.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', redirect: '/login' },
    { path: '/login', name: 'login', component: LoginView, meta: { requiresUnauth: false } },
    { path: '/dashboard', name: 'dashboard', component: DashboardView, meta: { requiresUnauth: false } },
    { path: '/dashboard/users', name: 'users', component: UserList, meta: { requiresUnauth: false } },
    { path: '/dashboard/announces', name: 'announces', component: AnnouncesList, meta: { requiresUnauth: false } },
  ]
})

export default router

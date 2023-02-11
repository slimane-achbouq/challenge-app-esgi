import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '@/views/LoginView.vue';

import UserList from '@/views/UserList.vue';
import AnnouncesList from '@/views/AnnouncesList.vue';
import Announce from '@/views/Announce.vue';
import NewAnnounce from '@/views/NewAnnounce.vue';
import MyAnnounce from '@/views/MyAnnounces.vue';
import AccountVerificationView from '@/views/AccountVerificationView.vue';
import ResetPassword from '@/views/ResetPasswordView.vue';
import successMessageView from '@/views/successMessageView.vue';
import ResetPasswordInputView from '@/views/ResetPasswordInputView.vue';
import DashboardView from '@/views/DashboardView.vue';
import OrganizmeView from '@/views/OrganismeView.vue';
import UserProfile from '@/views/UserProfile.vue';

import RegisterView from '@/views/RegisterView.vue';
import RequestsList from "@/views/RequestsList.vue";
import DemandeHistory from "@/views/DemandeHistory.vue";
import Request from "@/views/Request.vue";
import PaymentSuccess from "@/components/PaymentSuccess.vue";
import NewLitige from "@/views/NewLitige.vue";
import DisputesList from "@/views/DisputesList.vue";
import Litige from "@/views/Litige.vue";
import signOut from "@/components/logout/lougout.vue"
import contact from "@/views/ContactView.vue"

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
    { path: '/announces/:id', name: 'announce', component: Announce, meta: { requiresUnauth: false } },
    { path: '/announces/new', name: 'newannounce', component: NewAnnounce, meta: { requiresUnauth: false } },
    { path: '/account-verification/:userId/:token', name: 'account-verification', component: AccountVerificationView , meta: { requiresUnauth: false } },
    { path: '/reset-password', name: 'reset-password', component: ResetPassword, meta: { requiresUnauth: false }},
    { path: '/reset-password-success', name: 'reset-password-success', component: successMessageView, meta: { requiresUnauth: false }},
    { path: '/reset-password-input/:token', name: 'reset-password-input', component: ResetPasswordInputView, meta: { requiresUnauth: false }},
    { path: '/dashboard/requests', name: 'requests', component: RequestsList, meta: { requiresUnauth: false } },
    { path: '/demandes/:id', name: 'show-demande', meta: { requiresUnauth: false }},
    { path: '/requests/:id', name: 'show-request', component: Request, meta: { requiresUnauth: false }},
    { path: '/requests/pay/success/:token/:id', name: 'success-payment', component: PaymentSuccess, meta: { requiresUnauth: false }},
    { path: '/requests/history/:id', name: 'show-demande-histories', component: DemandeHistory, meta: { requiresUnauth: false }},
    { path: '/disputes/new/:id', name: 'new-dispute', component: NewLitige, meta: { requiresUnauth: false }},
    { path: '/dashboard/disputes', name: 'disputes', component: DisputesList, meta: { requiresUnauth: false }},
    { path: '/disputes/:id', name: 'show-dispute', component: Litige, meta: { requiresUnauth: false }},
    { path: '/demande_histories/:id', name: 'show-demande-histories', meta: { requiresUnauth: false }},
    { path: '/userprofile/:id', name: 'user-profile', component: UserProfile, meta: { requiresUnauth: false }},
    { path: '/userannounces/:lastName', name: 'userannounces', component: MyAnnounce, meta: { requiresUnauth: false } },
    { path: '/signout', name: 'signout', component: signOut, meta: { requiresUnauth: false } },
    { path: '/contact', name: 'contact', component: contact, meta: { requiresUnauth: false } },
  ]
})

export default router

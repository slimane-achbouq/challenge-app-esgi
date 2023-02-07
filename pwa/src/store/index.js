import { createStore } from 'vuex';

import authModule from '@/store/modules/auth/index.js';
import registerModule from '@/store/modules/register/index.js';
import createPersistedState from 'vuex-persistedstate';

const store = createStore({
  modules: {
    auth: authModule,
    register: registerModule
  },
  plugins: [
    createPersistedState(),
  ],
});

export default store;

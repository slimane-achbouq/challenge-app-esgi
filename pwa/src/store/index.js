import { createStore } from 'vuex';

import authModule from '@/store/modules/auth/index.js';
import registerModule from '@/store/modules/register/index.js';

const store = createStore({
  modules: {
    auth: authModule,
    register: registerModule
  }
});

export default store;
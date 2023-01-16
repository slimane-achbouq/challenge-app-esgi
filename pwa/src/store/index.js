import { createStore } from 'vuex';

import authModule from '@/store/modules/auth/index.js';
import registModule from '@/store/modules/register/index.js';

const store = createStore({
  modules: {
    auth: authModule,
    regist: registModule
  }
});

export default store;
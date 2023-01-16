import mutations from './mutations.js';
import actions from './actions.js';
import getters from './getters.js';

export default {
    namespaced: true,
    state() {
        return {
          token: null,
          firstName: '',
          lastName: '',
          email: '',
          role: '',
          id: '',
        };
      },
    mutations,
    actions,
    getters
};
export default {
    setUser(state, payload) {
        state.token = payload.token;
        state.firstName = payload.firstName;
        state.lastName = payload.lastName;
        state.email = payload.email;
        state.roles = payload.roles;
        state.id = payload.id
    }
};
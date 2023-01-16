export default {
    setUser(state, payload) {
        state.firstName = payload.firstName;
        state.lastName = payload.lastName;
        state.email = payload.email;
        state.role = payload.role;
        state.id = payload.id
    }
};
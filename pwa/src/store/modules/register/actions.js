export default {
    setSituation(context, payload) {
        context.commit('setSituation', {
            situation: payload
        });
    }
}
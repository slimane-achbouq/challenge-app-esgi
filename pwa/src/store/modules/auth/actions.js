import VueJwtDecode from 'vue-jwt-decode';

export default {
    async login(context, payload) {
        try {
            const response = await fetch('https://localhost/auth', {
                headers: {
                    'Content-Type': 'application/json',
                },
                method: 'POST',
                body: JSON.stringify({
                    email: payload.email,
                    password: payload.password
                }),
            });
            if (!response.ok) {
                console.log(responseData);
                const error = new Error(responseData.message || 'Failed to authenticate. Check your login data.');
                throw error;
            }

            const responseData = await response.json();
            localStorage.setItem('esgi-ws-token', responseData.token);
            const userInfos = VueJwtDecode.decode(responseData.token);
            context.commit('setUser', {
                token: responseData.token,
                firstName: userInfos.firstName,
                lastName: userInfos.lastName,
                email: userInfos.email,
                role: userInfos.role,
                id: userInfos.id
            });
        } catch (ex) {
            const error = new Error(ex || 'Failed to authenticate. Check your login data.');
            throw error;
        }   

    },
    tryLogin(context) {
        const token = localStorage.getItem('esgi-ws-token');
        if (token) {
            const userInfos = VueJwtDecode.decode(token);
            context.commit('setUser', {
                token: token,
                firstName: userInfos.firstName,
                lastName: userInfos.lastName,
                email: userInfos.email,
                role: userInfos.role,
                id: userInfos.id
            });
        }
    },
}
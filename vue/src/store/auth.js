import axios from "axios";
import store from "./index";
export default {
    namespaced: true,
    state: () => ({
        authenticated: false,
        user: null,
    }),

    getters: {
        authenticated(state) {
            return state.authenticated;
        },
        user(state) {
            return state.user;
        },
    },

    mutations: {
        SET_AUTHENTICATED(state, value) {
            state.authenticated = value;
        },

        SET_USER(state, value) {
            if (state.authenticated) {
                value.avatar = "https://ui-avatars.com/api/?background=7843E9&color=fff&name=" + value.name;
            }
            state.user = value;
        },
    },

    actions: {
        async signIn({ dispatch }, credentials) {
            console.log(credentials);
            await axios.get("sanctum/csrf-cookie").then((res) => console.log(res));
            await axios
                .post(
                    "api/v1/login",
                    credentials,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                .then((res) => console.log(res));
            return dispatch("me");
        },

        async register({ dispatch }, register) {
            await axios.get("sanctum/csrf-cookie").then((res) => console.log(res));
            const response = await axios
                .post(
                    "api/v1/register",
                    register,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });
            if (response.data.user) {
                await dispatch('signIn', {
                    email: response.data.user.email,
                    password: register.password,
                })
            } else {
                console.log(response.errors);
            }
            return dispatch("me");
        },

        async signOut({ dispatch }) {
            await axios.post("api/v1/logout").then((res) => console.log(res));
            return dispatch("me");
        },
        async me({ commit }) {
            try {
                const response = await axios.get("/api/v1/user");
                const authenticated = !!response.data.id;
                commit("SET_AUTHENTICATED", authenticated);
                if (authenticated) {
                    commit("SET_USER", response.data);
                }
            } catch {
                commit("SET_AUTHENTICATED", false);
                commit("SET_USER", null);
            }
        },
    },
};

import Vue from 'vue'
import Vuex from 'vuex'
import Cookies from 'js-cookie'
import axios from 'axios'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        user: null,
        token: null,
        is_auth: false,
        version: '1.0'
    },
    mutations: {
        setUser(state, auth) {
            state.user = auth
        },
        setOnAuth(state) {
            state.is_auth = true;
        },
        setOffAuth(state) {
            state.is_auth = false;
        },
        setToken(state, data) {
            state.token = data.token
            Cookies.set('token', data.token, {expires: null})
        },
        removeToken(state) {
            state.user = null
            state.token = null
            Cookies.remove('token');
        }
    },
    actions: {
        async setUser({commit}) {
            try {
                const {data} = await axios.get('/api/user')
                commit('setUser', data)
                commit('setOnAuth')
            } catch (e) {
                commit('removeToken')
            }
        },
        setAuthUserDetail({commit}, auth) {
            commit('setAuthUserDetail', auth);
        },
        setToken({commit}, data) {
            commit('setToken', data)
            commit('setUser')
        },
        logout({commit}) {
            commit('removeToken')
            commit('setOffAuth')
        },
    },
    getters: {
        getAuthUser: (state) => {
            return state.user;
        },
        getAuthStatus: (state) => {
            return state.is_auth;
        },
        getToken: (state) => {
            return state.token
        },
        isAdmin: (state) => {
            return (state.user.role.indexOf('admin') > -1) ? true : false
        },
        getVersion: (state) => {
            return state.version
        }
    },
    plugins: [
        createPersistedState({storage: window.sessionStorage})
    ]
});

export default store;

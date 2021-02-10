import {getToken, removeToken, setToken} from "@/utils/token";
import AuthService from '@/services/auth.service'
import {AUTH_LOGIN, AUTH_LOGOUT, AUTH_REGISTER, GET_USER} from "@/store/actions/auth";
import {SET_ERRORS, SET_LOADING} from "@/store/actions/other";
import alert from '@/utils/alert'

export default {
    state: {
        token: getToken() || "",
        user: null,
    },
    getters: {
        isAuth: state => !!state.token,
        getUser: state => state.user,
    },
    actions: {
        [AUTH_LOGIN]: ({commit}, [email, password]) => {
            commit(SET_ERRORS, {});
            commit(SET_LOADING, true)
            return AuthService.login(email, password)
                .then(response => {

                    commit(SET_LOADING, false)

                    if (response.data.access_token !== undefined) {
                        commit(AUTH_LOGIN, response.data.access_token)
                    }
                    if (response.data.user !== undefined) {
                        commit(GET_USER, response.data.user)
                    }
                    return Promise.resolve(response)
                }).catch(error => {
                    commit(SET_LOADING, false)
                    alert.error(error)
                    return Promise.reject(error)
                })
        },
        [AUTH_REGISTER]: ({commit}, data) => {
            commit(SET_ERRORS, {});
            commit(SET_LOADING, true)
            return AuthService.register(data).then(response => {

                commit(SET_LOADING, false)

                if (response.data.access_token !== undefined) {
                    commit(AUTH_LOGIN, response.data.access_token)
                }
                if (response.data.user !== undefined) {
                    commit(GET_USER, response.data.user)
                }
                alert.success(response)

                return Promise.resolve(response)
            }).catch(error => {
                commit(SET_LOADING, false)
                alert.error(error)
                return Promise.reject(error)
            })
        },
        [AUTH_LOGOUT]: ({commit}) => {
            // commit(SET_LOADING, true)
            // return AuthService.logout().then(response => {
            //     commit(SET_LOADING, false)
            //    commit(AUTH_LOGOUT)
            //     return Promise.resolve(response)
            // })

            commit(AUTH_LOGOUT)
        },
        [GET_USER]: ({commit}) => {
            return AuthService.fetchUser()
                .then(response => {
                    commit(GET_USER, response.data)
                }).catch(error => alert.error(error))
        }
    },
    mutations: {
        [AUTH_LOGIN]: (state, token) => {
            state.token = token
            setToken(token)
        },
        [AUTH_LOGOUT]: (state, token) => {
            state.token = ''
            removeToken(token)
        },
        [GET_USER]: (state, user) => {
            state.user = user
        },
    }
}
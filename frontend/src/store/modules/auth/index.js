import {getToken, setToken} from "@/utils/token";
import AuthService from '@/services/auth.service'
import {AUTH_REGISTER} from "@/store/actions/auth";

function initialState() {
    return {
        token: getToken() || "",
        user: null,
    };
}

export default {
    state: () => initialState(),
    getters: {
        isAuth: state => !!state.token,
    },
    actions: {
        [AUTH_REGISTER]: ({commit}, data) => {

            return AuthService.register(data)
                .then(response => {

                    console.log('AuthService', response)

                    if (response.data.access_token) {
                        setToken(response.data.access_token)
                    }

                    return Promise.resolve(response)

                })
                .catch(error => {
                    console.log('AuthService catch error', error.response)
                })
        }
    },
    mutations: {}
}
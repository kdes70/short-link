import axios from 'axios'
import {makeTokenHeader} from './make-token-header'
import {getToken} from './token'
import router from "@/router";
import {SET_ERRORS} from "@/store/actions/other";
import store from '../store'
// create axios instance
const api = axios.create({
    baseURL: process.env.VUE_APP_API_URL,
    headers: {
        'Accept': `application/json, text/plain, */*`,
        'Content-type': `application/json;charset=utf-8`
    },
    withCredentials: true
})

// request interceptor
api.interceptors.request.use(
    config => {
        const token = getToken()

        if (token) {
            config.headers.authorization = makeTokenHeader(token)
        }
        return config
    },
    error => {
        Promise.reject(error)
    }
)

api.interceptors.response.use(
    response => {
        return response;
    },
    error => {

        if (error.response && error.response.status !== undefined) {
            if (error.response.status === 401) {
                // echo.error(error);
                // store.dispatch("auth/logout");
                return router.push("/");
            }

            if (error.response.status === 422) {
                console.log('api interceptors error', error.response.data)
                console.log('api interceptors error', error.response.data.errors)
                store.dispatch(SET_ERRORS, error.response.data.errors)
            }
        }


        Promise.reject(error);
    }
);

export default api


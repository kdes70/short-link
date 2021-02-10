import Vue from 'vue'
import Vuex from 'vuex'
import auth from './modules/auth'
import links from './modules/links'
import {GET_IP, MODAL_SHOW, SET_ERRORS, SET_LOADING} from "@/store/actions/other";
import Errors from "@/utils/errors.js";
import axios from "axios";

const debug = process.env.NODE_ENV !== 'production'
Vue.config.debug = debug

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        loading: false,
        errors: new Errors(),
        openModal: false,
        ipAddress: null,
    },
    getters: {
        loading: state => state.loading,
        getErrors: state => state.errors,
        openModal: state => state.openModal,
        getIpAddress: state => state.ipAddress,
    },
    actions: {
        [SET_LOADING]: ({commit}, payload) => {
            commit(SET_LOADING, payload)
        },
        [SET_ERRORS]: ({commit}, errors) => {
            console.log('SET_ERRORS', errors)
            commit(SET_ERRORS, errors);
        },
        [MODAL_SHOW]: ({commit}) => {
            commit(MODAL_SHOW)
        },
        [GET_IP]: ({commit}) => {
            return axios("https://api.ipify.org/?format=json")
                .then(response => {
                    if (response.data.ip) {
                        commit(GET_IP)
                    }

                    return response.data.ip
                })
        },
    },
    mutations: {
        [SET_LOADING]: (state, payload) => {
            state.loading = payload
        },
        [SET_ERRORS]: (state, errors) => {
            state.errors.record(errors)
        },
        [MODAL_SHOW]: state => {
            state.openModal = !state.openModal
        },
        [GET_IP]: (state, ip) => {
            state.ipAddress = ip
        },
    },
    modules: {
        auth,
        links
    }
})

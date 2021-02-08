import Vue from 'vue'
import Vuex from 'vuex'
import auth from './modules/auth'
import {SET_ERRORS} from "@/store/actions/other";
import Errors from "@/utils/errors.js";

const debug = process.env.NODE_ENV !== 'production'
Vue.config.debug = debug

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        loading: false,
        errors: new Errors(),
    },
    getters: {
        getErrors: state => state.errors,
    },
    actions: {
        [SET_ERRORS]: ({commit}, errors) => {
            console.log('SET_ERRORS', errors)
            commit(SET_ERRORS, errors);
        }
    },
    mutations: {
        [SET_ERRORS]: (state, errors) => {
            state.errors.record(errors)
        },
    },
    modules: {
        auth
    }
})

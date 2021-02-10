import {ADD_LINK, DELETE_LINK, EDIT_LINK, GET_LINKS, VISIT_LINK} from "@/store/actions/links";
import {SET_LOADING} from "@/store/actions/other";
import LinksService from '@/services/links.service'
import alert from '@/utils/alert'

export default {
    state: {
        links: {
            data: [],
            meta: {},
        }
    },
    getters: {
        getLinks: state => state.links,
    },
    actions: {
        [GET_LINKS]: ({commit}, page) => {
            return LinksService.list(page).then(response => {
                commit(GET_LINKS, response.data)
            })
        },
        [ADD_LINK]: ({commit}, data) => {
            commit(SET_LOADING, true)
            return LinksService.add(data)
                .then(response => {
                    console.log('ADD_LINK', response)
                    commit(ADD_LINK, response.data.data)
                    commit(SET_LOADING, false)
                    alert.success(response)
                }).catch(error => {
                    console.log('ADD_LINK error', error)
                    commit(SET_LOADING, false)
                })
        },
        [EDIT_LINK]: ({commit}, [link, data]) => {
            commit(SET_LOADING, true)
            return LinksService.edit(link, data)
                .then(response => {
                    console.log('EDIT_LINK', response)
                    commit(EDIT_LINK, response.data.data)
                    commit(SET_LOADING, false)
                    alert.success(response)
                }).catch(error => {
                    console.log('EDIT_LINK error', error)
                    commit(SET_LOADING, false)
                })
        },
        [DELETE_LINK]: ({commit}, linkId) => {
            commit(SET_LOADING, true)
            return LinksService.delete(linkId)
                .then(response => {
                    console.log('DELETE_LINK', response)
                    commit(DELETE_LINK, linkId)
                    commit(SET_LOADING, false)
                    alert.success(response)
                }).catch(error => {
                    console.log('DELETE_LINK error', error)
                    commit(SET_LOADING, false)
                })
        },
        [VISIT_LINK]: ({commit}, [code, referrer, ip]) => {
            commit(SET_LOADING, true)
            return LinksService.visit(code, referrer, ip)
                .then(response => {
                    console.log('VISIT_LINK', response)
                    commit(SET_LOADING, false)
                    return Promise.resolve(response)
                }).catch(error => {
                    console.log('VISIT_LINK error', error)
                    commit(SET_LOADING, false)
                    return Promise.reject(error)
                })
        }
    },
    mutations: {
        [GET_LINKS]: (state, links) => {
            state.links = links
        },
        [ADD_LINK]: (state, link) => {
            state.links.data.push(link)
            state.links.meta.total++
        },
        [EDIT_LINK]: (state, payload) => {
            let index = state.links.data.findIndex(link => link.id === payload.id)
            state.links.data[index] = payload
        },
        [DELETE_LINK]: (state, linkId) => {
            let index = state.links.data.findIndex(link => link.id === linkId)
            state.links.data.splice(index, 1)
            state.links.meta.total--
        },
    }
}
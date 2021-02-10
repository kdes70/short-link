import Vue from 'vue'

function error(e) {
    if (e.response && e.response.data && e.response.data.message) {
        Vue.swal('Oops...', e.response.data.message, 'error')
    } else if (e.response && e.response.data && e.response.data.error) {
        Vue.swal('Oops...', e.response.data.error, 'error')
    } else {
        Vue.swal('Oops...', 'Server return error.', 'error')
    }
}

function success(response) {
    if (response && response.data && response.data.message) {
        Vue.swal('Ok', response.data.message, 'success')
    } else {
        Vue.swal('Ok', 'Success', 'success')
    }
}

export default {
    error,
    success
};
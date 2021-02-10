import request from "@/utils/request";

export function ApiLogin(email, password) {
    return request.post('api/auth/login', {
        email: email,
        password: password
    })
}

export function ApiRegister(name, email, password, confirm) {
    return request.post('api/auth/register', {
        name: name,
        email: email,
        password: password,
        password_confirmation: confirm
    })
}

export function ApiLogout() {
    return request.post('api/auth/logout')
}

export function ApiGetUser() {
    return request.get('api/auth/user');
}

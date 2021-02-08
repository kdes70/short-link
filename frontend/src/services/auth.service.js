import {ApiLogin, ApiRegister} from '@/api/Auth'

class AuthService {
    login(user) {
        return ApiLogin(user.username, user.password)
            .then(response => {
                if (response.data.accessToken) {
                    localStorage.setItem('user', JSON.stringify(response.data))
                }

                return response.data
            })
    }

    logout() {
        localStorage.removeItem('user')
    }

    register(data) {
        return ApiRegister(data.name, data.email, data.password, data.password_confirm)
    }
}

export default new AuthService()

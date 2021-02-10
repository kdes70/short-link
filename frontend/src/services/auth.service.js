import {ApiGetUser, ApiLogin, ApiLogout, ApiRegister} from '@/api/Auth'

class AuthService {
    login(email, password) {
        return ApiLogin(email, password)
    }

    register(data) {
        return ApiRegister(data.name, data.email, data.password, data.password_confirm)
    }

    logout() {
        return ApiLogout()
    }

    fetchUser() {
        return ApiGetUser()
    }
}

export default new AuthService()

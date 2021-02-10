import store from "@/store";
import {GET_USER} from "@/store/actions/auth";

export default function auth({next, router}) {
    if (!store.state.auth.token) {
        router.push({name: "Login"});
    } else if (!store.state.auth.user) {
        store.dispatch(GET_USER);
    }
    return next();
}
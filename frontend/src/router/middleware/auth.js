import store from "@/store";

export default function auth({next, router}) {
    if (!store.state.auth.token) {
        router.push({name: "Login"});
    }
    // else if (!store.state.auth.user) {
    //     store.dispatch("auth/fetchUser");
    // }
    return next();
}
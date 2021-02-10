import store from "@/store";

export default function guest({next, router}) {

    const publicPages = ['login', '/register'];
    const authRequired = !publicPages.includes(router.history.current.path);
    const loggedIn = store.state.auth.token;

    if (authRequired && loggedIn) {
        router.push({name: "Home"});
    }

    return next();
}
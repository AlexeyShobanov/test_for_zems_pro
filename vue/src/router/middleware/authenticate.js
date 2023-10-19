export default function authenticate({ to, next, store }) {
    if (to.meta.requiresAuth && !store.state.auth.authenticated) {
        return next({
            name: "Login",
        });
    } else if (store.state.auth.authenticated && to.meta.isGuest) {
        next({
            name: "Project"
        });
    }

    return next();
}

import { createWebHistory, createRouter } from "vue-router";
import Home from "./components/Home.vue";
import Note from "./components/User/Note.vue";
import UserNotes from "./components/User/Notes.vue";
import Error404 from "./components/Error404.vue";
import Login from "./components/Login.vue";
import Register from "./components/Register.vue";
import AdminNotes from "./components/Admin/Notes.vue";
import path from "path";

const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
        meta: {
            requiresGuest: true
        },
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
    },
    {
        path: "/notes",
        name: "UserNotes",
        component: UserNotes,
    },
    {
        path: "/admin/notes",
        name: "AdminNotes",
        component: AdminNotes,
    },
    {
        path: "/note/:id",
        name: "Note",
        component: Note,
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'Error404',
        component: Error404,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {

    if (['/login', '/register'].includes(to.path) && isAuthenticated()) {
        return next({path: '/'})
    }
    if (['/notes', '/note/:id', '/admin/notes'].includes(to.path) && !isAuthenticated()) {
        return next({path: '/'})
    }

    return next()
})

function isAuthenticated() {
    return Boolean(localStorage.getItem('user_authenticated'))
}

export default router;

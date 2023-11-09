<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <router-link class="navbar-brand" to="/">{{ app_name }}</router-link>
            <router-link v-if="isAuthenticated() && !isAdmin()" class="nav-link" to="/notes">Notes</router-link>
            <router-link v-if="isAuthenticated() && isAdmin()" class="nav-link" to="/admin/notes">Notes for admin</router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                </ul>
                <!-- Right Side Of Navbar -->
                <ul v-if="!isAuthenticated()" class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/login">Login</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/register">Register</router-link>
                    </li>
                </ul>
                <ul v-else class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           {{ user ? user.name : '' }}
                        </a>
                        <div v-if="isAuthenticated()" class="dropdown-menu dropdown-menu-end"
                             aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#"
                               v-on:click="logout()">Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <router-view :user-authenticated="user_authenticated"/>
</template>
<script>
import axios from 'axios';
export default {
    data() {
        return {
            app_name: import.meta.env.VITE_APP_NAME,
            api_token: localStorage.getItem('TOKEN_FROM_API'),
            user_authenticated: localStorage.getItem('user_authenticated'),
            user_id: localStorage.getItem('user_id'),
            is_admin: localStorage.getItem('is_admin'),
            user: null,
        }
    },
    created() {
        if (this.user_id) {
            axios.get('/api/v1/user/' + this.user_id, {
                    headers: {
                        'Authorization': this.api_token,
                    }
                }
            ).then(response => {
                this.user = response.data;
            })
                .catch((error) => {
                    console.log(error);
                })
        }

    },
    methods: {
        isAuthenticated() {
            return this.api_token !== null && this.user_authenticated !== false;
        },
        isAdmin() {
            return this.is_admin === 'true';
        },
        logout() {
            const headers = {
                "Authorization": this.api_token,
            };
            axios.post('/api/v1/logout', null, {headers}
            ).then(response => {
                localStorage.clear();
                this.api_token = null;
                this.user_id = null;
                this.user = null;
                window.location.reload();
            })
                .catch((error) => {
                    console.log(error);
                })
        }
    }
}
</script>

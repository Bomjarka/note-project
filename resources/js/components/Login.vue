<template>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 v-if="errors" class="text-danger">{{ errors['message'] }}</h4>
                    </div>
                    <form method="post" @submit.prevent="handleLogin">
                        <div class="card-body">
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           placeholder="your@gmail.com"
                                           class="form-control" name="email"
                                           required autocomplete="email"
                                           v-model="formData.email" autofocus>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           placeholder="12345678"
                                           class="form-control" name="password"
                                           required autocomplete="current-password"
                                           v-model="formData.password">

                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="button" class="btn btn-primary" v-on:click="login()">
                                        Login
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {reactive, ref} from 'vue';
import axios from 'axios';

export default {
    data() {
        return {
            formData: {
                email: null,
                password: null,
            },
            data: null,
            errors: null,
        }
    },
    methods: {
        login() {
            axios.post('/api/v1/login', this.formData
            ).then(response => {
                if (response.status === 200 && response.data && response.data.token && response.data.user) {
                    this.data = response.data
                    localStorage.setItem('TOKEN_FROM_API', 'Bearer ' + this.data.token);
                    localStorage.setItem('user_id', this.data.user.id);
                    if (Boolean(this.data.is_admin) === true) {
                        localStorage.setItem('is_admin', 'true');
                    } else {
                        localStorage.setItem('is_admin', 'false')
                    }
                    localStorage.setItem('user_authenticated', 'true');
                    window.location.reload();
                }
            })
                .catch((error) => {
                    console.log(error.response);
                    this.errors = error.response.data;
                })
        }
    }
}
</script>

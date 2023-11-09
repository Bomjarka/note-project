<template>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-header">Welcome</div>
                    <div class="card-body">
                        <h5 class="card-title">This is Notes Project</h5>
                        <p class="card-text">This project allows you to create and manage your Notes</p>
                        <p v-if="isAuthenticated()">
                            <router-link to="/notes">Here is all your Notes</router-link>
                        </p>
                        <p v-else>
                            <a href="" class="card-text">Login</a> or <a  class="card-text" href="">Register</a>
                            to start using this AWESOME service
                        </p>
                        <div>
                            <p class="card-text">Anyway you can just enjoy watching random kittens pictures below</p>
                            <img class="card-img" src="https://loremflickr.com/320/240/kitten/">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            api_token: localStorage.getItem('TOKEN_FROM_API'),
        }
    },
    methods: {
        isAuthenticated() {
            return this.api_token !== null;
        },
    }

}
</script>

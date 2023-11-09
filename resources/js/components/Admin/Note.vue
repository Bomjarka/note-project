<template>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div v-if="note" class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5>{{ note.topic }}</h5>
                            <router-link to="/notes">Back to Notes</router-link>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Content: {{ note.content }}</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Created: {{ new Date(note.created_at).toDateString() }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import axios from "axios";

export default {
    data() {
        return {
            api_token: localStorage.getItem('TOKEN_FROM_API'),
            note: null,
        }
    },
    created() {
        axios.get('/api/v1/note/' + this.$route.params.id, {
                headers: {
                    'Authorization': this.api_token,
                }
            }
        ).then(response => {
            this.note = response.data;
        })
            .catch((error) => {
                console.log(error);
            })
    }
};
</script>

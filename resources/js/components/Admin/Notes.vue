<template>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5>ToDo Lists</h5>
                        <!--                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"-->
                        <!--                                data-bs-target="#createListModal">Create New Note-->
                        <!--                        </button>-->
                    </div>
                    <div class="card-body">
                        <h2 v-if="isNotesEmpty()">No notes</h2>
                        <div class="card-deck">
                            <div v-for="note in notes" class="card my-2">
                                <div class="card-header">
                                    <a :href="`/note/${note.id}`"><h5
                                        class="card-title">{{ note.topic }}</h5></a>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Content: {{ note.content }}</p>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">Created:
                                        {{ new Date(note.created_at).toDateString() }}</small>
                                </div>
                            </div>
                            <br>
                        </div>
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
            notes: [],
            new_note: {
                topic: null,
                content: null,
            },
        }
    },
    created() {
        axios.get('/api/v1/admin/note/', {
                headers: {
                    'Authorization': this.api_token,
                }
            }
        ).then(response => {
            this.notes = response.data;
        })
            .catch((error) => {
                console.log(error);
            })
    },
    methods: {
        isNotesEmpty() {
            return this.notes.length === 0;
        }
    }
}
</script>

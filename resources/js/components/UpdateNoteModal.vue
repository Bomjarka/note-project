<template>
    <div v-if="openClose" class="modal fade show"
         tabindex="-1" aria-labelledby="defaultModalLabel" aria-modal="true" role="dialog"
         style="display:block">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ action }}</h5>
                    <button type="button" class="btn-close" @click="openCloseModal()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="list-name">Topic</label>
                        <p class="text-danger" v-if="this.errors.topic">{{ this.errors.topic }}</p>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control required" id="note-topic"
                                   aria-describedby="basic-addon3"
                                   v-model="note.topic"
                                   placeholder="First note">
                        </div>
                        <label>Content</label>
                        <p class="text-danger" v-if="this.errors.content">{{ this.errors.content }}</p>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control required" id="note-content"
                                   aria-describedby="basic-addon3"
                                   v-model="note.content"
                                   placeholder="Here is some text">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="openCloseModal()" :class="'btn btn-' + variant">Close</button>
                    <button type="button" @click="updateNote()" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <button type="button" @click="openCloseModal()" :class="'btn btn-' + variant">
        {{ action }}
    </button>
</template>

<script>
import axios from "axios";

export default {
    name: 'UpdateNoteModal',
    props: {
        visible: Boolean,
        variant: String,
        action: String,
        editable_note: Object,
    },
    data() {
        return {
            api_token: localStorage.getItem('TOKEN_FROM_API'),
            note: Object,
            openClose: this.visible,
            errors: [],
        }
    },
    created() {
        this.note = this.editable_note;
    },
    methods: {
        openCloseModal() {
            this.openClose = !this.openClose;
        },
        updateNote() {
            this.errors = [];
            const headers = {
                "Authorization": this.api_token,
            };
            axios.put('/api/v1/note/' + this.note.id, this.note, {headers}
            ).then(response => {
                window.location.reload();
            })
                .catch((error) => {
                    let errors = error.response.data.errors;
                    Object.keys(error.response.data.errors).forEach(error => {
                        this.errors[error] = errors[error][0]
                    });
                })
        }
    },
    watch: {
        visible: function (newVal, oldVal) {
            this.openClose = newVal;
        }
    }
}
</script>

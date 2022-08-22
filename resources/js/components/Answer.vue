<template>
<div class="d-flex bd-highlight post">
        <div class="p-2 flex-grow-2 bd-highlight">
           
            <vote :model= "answer" name="answer"></vote>
            </div>
        <div class="p-2 flex-grow-1 bd-highlight">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea class="form-control" v-model="body" rows="10" required></textarea>
                </div>
                <div class="mt-3">
                    <button  type="submit" class="btn btn-lg btn-outline-primary" :disabled="IsValid">Update</button>
                    <button @click = "cancel" class="btn btn-lg btn-outline-secondary">Cancel</button>
                </div>
            </form>
            <div v-else>
            <div v-html="bodyHtml"></div>
           
            <div class="row">
                <div class="col-4">
                    <div class="ml-auto" style="margin-left: auto">
                        <a v-if="authorize('modify',answer)" @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
                        <button v-if="authorize('modify',answer)" @click.prevent="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
                       
                    </div>
                </div>
                <div class="col-4">
                </div>
                <div class="col-4">
                    <user-info :model="answer" label="Answered by"></user-info>
                </div>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import Vote from './Vote.vue';
import UserInfo from './UserInfo.vue';
import modifications from '../mixins/modifications';
export default {
    props: ['answer'],
    mixins: [modifications],
    components: {Vote, UserInfo},
    data () {
        return {
            // editing: false, defined in mixins.
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            id: this.answer.id,
            questionId: this.answer.question_id,
            editBodyCache: null
        }
    },

    computed: {
        IsValid ( ) {
            return this.body.length < 10;
        },
        endpoint () {
            return `${this.questionId}/answers/${this.id}`;
        }
    },

    methods: {
        setEditCache() {
            this.editBodyCache = this.body;
        },
        getEditCache() {
            this.body = this.editBodyCache;
        },
        payload () {
            return {
                body: this.body
            }
        },
        delete() {
            axios.delete(this.endpoint)
                 .then( (res) => {
                    this.$emit('delete');
                    this.$toast.success(res.data.message, 'Success', { timeout: 3000 });
                 });
        }
    }
}
</script>
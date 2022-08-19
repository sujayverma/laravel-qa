<template>
    <div class="row justify-content-center">
        <div class="col-md-126">
            <div class="card">
                <form class="card-body" v-if="editing" @submit.prevent="update">
                    <div class="card-title">
                        <input type="text" class="form-control form-control-lg" name="title" v-model="title" />
                        
                    </div>
                <hr>
                    <div class="d-flex bd-highlight">
                        <div class="p-2 flex-grow-1 bd-highlight"> 
                            <div class="form-group">
                                <textarea class="form-control" v-model="body" rows="10" required></textarea>
                            </div>
                            <div class="mt-3">
                                <button  type="submit" class="btn btn-lg btn-outline-primary" :disabled="IsValid">Update</button>
                                <button @click = "cancel" class="btn btn-lg btn-outline-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="card-body" v-else>
                    <div class="card-title">
                        <div class="d-flex align-items-center" style="align-items: center">
                            <h2>{{title}}</h2>
                            <div class="ml-auto" style="margin-left: auto">
                                <a href="/question" class="btn btn-outline-secondary">Back to All Questions</a>
                            </div>
                        </div>
                        
                    </div>
                <hr>
                    <div class="d-flex bd-highlight">
                        <div class="p-2 flex-grow-2 bd-highlight">
                            <vote :model="question" name="question"></vote>
                        </div>
                    <div class="p-2 flex-grow-1 bd-highlight"> 
                                <div v-html="bodyHtml"></div>
                                <div class="ml-auto">
                                    <a v-if="authorize('modify',question)" @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
                                    <button v-if="authorize('deleteQuestion',question)" @click.prevent="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
                                </div>
                                <div class="float-end">
                                    <user-info :model="question" label="Asked by"></user-info>
                                </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Vote from './Vote.vue';
import UserInfo from './UserInfo.vue';
export default {
    props: ['question'],

    components: {Vote, UserInfo},

    data() {
        return {
            title: this.question.title,
            body: this.question.body,
            bodyHtml: this.question.body_html,
            editing: false,
            id: this.question.id,
            beforeEditCache: {}
        }
    },

    computed: {
        IsValid() {
            return this.body.length < 10 || this.title.length < 10;
        },
        endpoint() {
            return `${this.id}`;
        }
    },

    methods: {
        edit() {
            this.beforeEditCache = {
                body: this.body,
                title: this.title
            }
            this.editing = true;
        },

        cancel() {
            alert(this.beforeEditCache.body)
            this.body = this.beforeEditCache.body;
            this.title = this.beforeEditCache.title;
            this.editing = false;
        },
         
        update() {
            axios.put(this.endpoint, {
                body: this.body,
                title: this.title
            })
            .catch(({response}) => {
                this.$toast.error(response.data.message, "Error", { timeout: 3000});
            })
            .then(({data}) => {
                this.bodyHtml = data.body_html;
                this.$toast.success(data.message, "Success", { timeout: 3000 });
                this.editing = false;
            })
        },

        destroy () {
              this.$toast.question( 'Are you sure about this?', 'confirm', {
                    timeout: 2000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    title: 'Hey',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>',  (instance, toast) => {
                
                             axios.delete(this.endpoint)
                                .then( ({data}) => {
                                   this.$toast.success(data.message, "Success", { timeout: 2000})
                                });
                             
                             setTimeout(() => {
                                window.location.href= "/question";
                             }, 3000);
                
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {
                
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                
                        }],
                    ],
                    onClosing: function(instance, toast, closedBy){
                        console.info('Closing | closedBy: ' + closedBy);
                    },
                    onClosed: function(instance, toast, closedBy){
                        console.info('Closed | closedBy: ' + closedBy);
                    }
            });
        }
    },

    
}
</script>
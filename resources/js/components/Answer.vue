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

export default {
    props: ['answer'],
    data () {
        return {
            editing: false,
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
        edit () {
            this.editBodyCache = this.body;
            this.editing = true;
        },
        cancel () {
            this.body = this.editBodyCache;
            this.editing = false;
        },
        update () {
            axios.patch( this.endpoint,{
                body: this.body
            })
            .then((res) => {
                this.editing = false;
                console.log(res);
                this.bodyHtml = res.data.body_html;
                this.$toast.success(res.data.message, 'Success', { timeout: 3000 });
            })
            .catch((err) => {
                this.$toast.error(err.response.data.message,'Error', { timeout: 3000 });
                console.log(err.response);
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
                                .then( (res) => {
                                    // alert(this.$el);
                                    // this.$el.fadeout(3000);
                                    //  this.$toast.success(res.data.message, 'Success', { timeout: 3000 });
                                    this.$emit('delete');
                                });
                
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
    }
}
</script>
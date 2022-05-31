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
                    timeout: 3000,
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
                                     this.$toast.success(res.data.message, 'Success', { timeout: 3000 });
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
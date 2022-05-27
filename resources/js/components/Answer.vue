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
                alert(res.data.message);
            })
            .catch((err) => {
                alert(err.response.data.message);
                console.log(err.response);
            })
        },
        destroy () {
            if(confirm('Are you sure?'))
            {
                axios.delete(this.endpoint)
                .then( (res) => {
                    jQuery(this.$el).fadeOut(1000, () => { alert(res.data.message) });
                });
            }
        }
    }
}
</script>
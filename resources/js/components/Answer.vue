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
            axios.patch(`${this.questionId}/answers/${this.id}`,{
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
        }
    }
}
</script>
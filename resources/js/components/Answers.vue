<template>
 
    <div>
        <div class="row mt-4" v-cloak v-if="count">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h2>
                                {{ title }}
                            </h2>
                        </div>
                        <hr>
                        <answer @delete="remove(index)" v-for=" (answer, index) in answers" :answer="answer" :key="answer.id"></answer>
                        <div class="text-center mt-3">
                            <button @click.prevent="fetch(nextUrl)" class="btn btn-outline-secondary" v-if="nextUrl">Load more answers</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <new-answer @created= "add" :question-id= "question.id"></new-answer>
    </div>
</template>

<script>
import axios from 'axios';
import Answer from './Answer.vue'
import NewAnswer from './NewAnswer.vue';
export default {
    components: { Answer, NewAnswer },
    props: ['question'],
    data() {
        return {
            questionId: this.question.id,
            count: this.question.answers_count,
            answers: [],
            nextUrl: null
        }
    },
    created() {
        this.fetch(`${this.questionId}/answers`);
    },
    methods: {
        add(answer) {
            this.answers.push(answer);
            this.count++;
        },
        fetch(endpoint) {
            axios.get(endpoint)
            .then(({data}) => {
                this.answers.push(... data.data);
                this.nextUrl = data.next_page_url;
            });
        },

        remove(index) {
            this.answers.splice(index, 1);
            this.count--;
        }
    },
    computed: {
        title () {
            return this.count + " " + ((this.count > 1) ? 'Answers' : 'Answer')
        }
    }
}
</script>

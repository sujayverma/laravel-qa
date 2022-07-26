<template>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Your Answer</h3>
                    </div>
                    <hr>
                    <form @submit.prevent="create">
                       
                        <div class="mb-3">
                            <textarea name="body" rows="7" class="form-control" v-model="body" required></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="submit" :disabled="isInvalid" class="btn btn-lg btn-outline-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios';
export default {
    props: ['questionId'],

    data() {
        return {
            body: ''
        }
    },

    computed: {
        isInvalid() {
            return !this.signedIn || this.body.length < 10;
        }
    },

    methods: {
        create() {
            axios.post(`${this.questionId}/answers`, {
                body: this.body
            })
            .catch( error => {
                this.$toast.error(error.response.data.message, "Error");
            })
            .then( ({data}) => {
                this.$toast.success(data.message, 'Success');
                this.body = '';
                this.$emit('created', data.answer);
            })
        }
    }
}
</script>

<style>

</style>
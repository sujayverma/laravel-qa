<template>
    <div class="d-flex flex-column vote-controls">
        <a @click.prevent="voteUp" :title="vote('up')" 
            class="vote-up" :class="classes">
            <i class="fas fa-caret-up fa-3x"></i>
        </a>
        
        <span class="votes-count"> {{ count }} </span>
        <a @click.prevent="voteDown" class="vote-down" :class="classes" 
            :title="vote('down')">
            <i class="fas fa-caret-down fa-3x"></i>
        </a>
        
        
        <favorite v-if="name === 'question'" :question="model"></favorite>        
        <accept v-else :answer="model"></accept>  
    </div>
</template>

<script>
import Favorite from './Favorite.vue';
import Accept from './Accept.vue';
import axios from 'axios';
export default {
    props: ['name', 'model'],

    computed: {
        classes () {
            return this.signedIn ? '' : 'off';
        },

        endpoint () {
            if(this.name === 'question')
                return `/${this.name}/${this.id}/vote`;
            else
               return `/${this.name}s/${this.id}/vote`; 
        }
    },

    components: {
        Favorite,
        Accept
    },

    data () {
        return {
            count: this.model.votes_count || 0,
            id: this.model.id
        }
    },
    methods: {
        vote(voteType) {
            let titles = {
                up: `This ${this.name} is usefull`,
                down: `This ${this.name} is not usefull`
            }
            return titles[voteType];
        },

        voteUp () {
            this._vote(1);
        },
        voteDown () {
            this._vote(-1);
        },
        _vote (vote) {
            if( ! this.signedIn) {
                this.$toast.warning(`Please login to vote the ${this.name}`, "Warning", {
                    timeout: 3000,
                    position: "bottomRight"
                });
                return;
            }

            axios.post(this.endpoint, { vote })
            .then( res => {
                this.$toast.success(res.data.message, "Success", {
                    timeout: 3000,
                    position: "bottomLeft"
                });
                this.count = res.data.voteCount;
            })
        }
    }
}

</script>
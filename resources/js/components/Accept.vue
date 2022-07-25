<template>
    <div>
        <a v-if="canAccept" :class="classes" 
            title="Mark this answer as best answer" 
            @click.prevent="create">
            <i class="fas fa-check fa-2x"></i>
        </a>   
                
        <a v-if="isAccepted" :class="classes" title="The question owner accepted this as best answer" >
            <i class="fas fa-check fa-2x"></i>
        </a>
    </div>     
</template>

<script>
import eventBus from '../event-bus';
import axios from 'axios'
export default {
  props: ["answer"],

  data() {
    return {
        isBest: this.answer.is_best,
        id: this.answer.id
    };
  },

  created () {
    eventBus.$on('accepted', id => {
        this.isBest = (id === this.id);
    });
  },

  methods: {
    create () {
        axios.post(`/answers/${this.id}/accept`)
        .then(
            res => {
                this.$toast.success(res.data.message, 'Success', {
                    timeout:3000,
                    position: 'bottomLeft'
                })
                this.isBest = true;

                eventBus.$emit('accepted', this.id);
            });

    }
  },

  computed: {

    canAccept () {
        return  this.authorize('accept', this.answer);
    },
    isAccepted () {
        return !this.canAccept && this.isBest; 
    },
    classes () {
        return [
            'mt-2',
            this.isBest ? 'vote-accepted' : ''
        ];
    }
  },
};
</script>
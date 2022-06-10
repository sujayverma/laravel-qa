<template>
   <a 
    :class="classes" 
    title="Click to mark as favorite Question (Click again to undo)"
    @click.prevent="toggle"
    >
        <i class="fas fa-star fa-2x"></i>
        <span class="favorites-count">{{ count }}</span>
    </a> 
</template>

<script>
import axios from 'axios';
export default {
    props: ['question'],
    data() {
        return {
            isFavorited: this.question.is_favorited,
            count: this.question.favorite_count,
            id: this.question.id
        }
    },
    computed: {
        classes () {
            return [
                'favorite', 'mt-2',
                ! this.signedIn ? 'off' : (this.isFavorited ? 'favorited' : '' )
            ];
        },

        endpoint () {
            return `${this.id}/favorites`;
        },

        signedIn () {
            return window.Auth.signedIn;
        }
    },
    methods: {
        toggle () {
            if( ! this.signedIn )
            {
                this.$toast.warning('Please sign in to favorite this question', 'Warning', {
                    timeout: 3000,
                    position: 'bottomLeft'
                });
                return;
            }
                
           this.isFavorited ? this.destroy() : this.create();
        },

        destroy () {
            axios.delete(this.endpoint)
            .then( res => {
                this.count--;
                this.isFavorited = false;
            });
            
        },

        create () {
            axios.post(this.endpoint)
            .then( res => {
                this.count++;
                this.isFavorited = true;
                this.$toast.success('You have favorited the question.', 'Success', { timeout: 3000 });
            });
        }
    }

}
</script>

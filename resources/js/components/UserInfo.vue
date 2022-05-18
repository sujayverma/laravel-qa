<templete>
    <div>
        <span class="text-muted">{{postDate}}</span>
        <div class="media mt-2">
            <a :href="user.url" class="pr-2">
                <img :src="user.avatar" />
            </a>
            <div class="media-body">
                <a :href="user.url">
                    {{ user.name }}
                </a>
            </div>
        </div>
    </div>
</templete>
<script>
export default {
    // name: 'user-info',
    props: ['model', 'label'],
    computed: {
        postDate: function(){
            return this.label + " " + this.model.created_date;
        }
    },
    data () {
        return {
            user: this.model.user
        }
    }
}
</script>
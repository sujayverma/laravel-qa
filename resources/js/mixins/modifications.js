export default {
    data () {
        return {
            editing: false
        }
    },

    methods: {
        edit () {
            this.setEditCache();
            this.editing = true;
        },
        cancel () {
            this.getEditCache();
            this.editing = false;
        },
        setEditCache() {},
        getEditCache() {},
        update () {
            axios.patch( this.endpoint, this.payload())
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
        payload() {},
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
              
                        //    axios.delete(this.endpoint)
                        //       .then( (res) => {
                        //           // alert(this.$el);
                        //           // this.$el.fadeout(3000);
                        //           //  this.$toast.success(res.data.message, 'Success', { timeout: 3000 });
                        //           this.$emit('delete');
                        //       });
                        this.delete()
              
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
      },
      delete() {}
    }
}
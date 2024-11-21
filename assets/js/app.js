
console.log('bazinga');

var app = new Vue({
el: '#v-app',
    data:{
        modal: null,
        // modal: 'vkit',
        panel: null,
        dropdown: null,
        display: true,
        
    },
    methods: {
        showModal(el){
            this.modal = el;
        },
        showPanel(el){
            this.panel = el;
        },
        showDropdown(el){
            this.dropdown = el;
        },
        closeAll(){
            this.modal = null;
            this.panel = null;
            this.dropdown = null;
        },
        displayWin(){
            if (this.panel || this.modal) {
                return 'display: block;';
            }
        },
    },
    // created() {},
}) 





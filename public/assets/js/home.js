
/*VUE INSTANCE*/
let vm = new Vue({
    vuetify,
    el: '#full-learning-container',
    data: {
      tab: null,
      nav_tab: null,
      loading: false,
      search: '',
      notifications: [],
      selection: 1,
      skills_container: true
    },

    computed: {
    },

    created () {
      check_google_user()
    },

    mounted () {
    },

    methods: {
      hideSkills () {
        this.skills_container = false;
      }
  	}
});
<template>
  <div id="app">
    <top-bar v-if="authenticated" />
    <profile-banner v-if="authenticated" />
    <tabbed-nav v-if="authenticated" />
    
    <router-view @authenticated="setAuthenticated" ></router-view>
  </div>
</template>

<script>
import ProfileBanner from '@/components/ProfileBanner.vue'
import TopBar from '@/components/TopBar.vue'
import TabbedNav from '@/components/TabbedNav.vue'
import Profile from '@/components/Profile.vue'
import Invest from '@/components/Invest.vue'
import Login from '@/components/Login.vue'


export default {
  name: 'app',
  components: {
    ProfileBanner,
    TopBar,
    TabbedNav,
    Profile,
    Invest,
    Login
  },
  data () {
    return {
      msg: 'Welcome to Your Vue.js App',
      authenticated: false,
      mockAccount: {
        username: "testuser1",
        password: "pass"
      }
    }
  },
  mounted() {
    if(!this.authenticated) {
        this.$router.replace({ name: "login" });
      }
    },
    methods: {
      setAuthenticated(status) {
        this.authenticated = status;
      },
      logout() {
        this.authenticated = false;
      }
    }
}
</script>

<style>
#app-2 {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

h1, h2 {
  font-weight: normal;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  display: inline-block;
  margin: 0 10px;
}

a {
  color: #42b983;
}
</style>

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
      authenticated: true,
      mockAccount: {
        username: "testuser1",
        password: "pass",
        currentBalance : 1500,
      },
      url: "https://min-api.cryptocompare.com/data/top/totalvolfull?limit=75&tsym=USD",
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
    },
    hasEnoughBalance(amt) {
      if (this.mockAccount.currentBalance >= amt) {
        return true;
      }
      return false;
    },
    addToBalance(amt) {
      this.mockAccount.currentBalance += amt;
      this.mockAccount.currentBalance = Math.round(this.mockAccount.currentBalance * 100) / 100

      // Update in database
        

      // Fire event
      //console.log("emiting event");
      this.$vueEventBus.$emit('balance-updated', this.mockAccount.currentBalance)
    },
    getBalance() {
      return this.mockAccount.currentBalance;
    },
    makeToast() {
      this.$bvToast.toast(`This is toast number 5`, {
        title: 'BootstrapVue Toast',
        autoHideDelay: 5000,
        appendToast: append
      })
    },
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

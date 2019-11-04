<template>
  <div id="app">
    <top-bar v-if="this.$store.state.authenticated"/>
    <profile-banner v-if="this.$store.state.authenticated"/>
    <tabbed-nav v-if="this.$store.state.authenticated"/>

    <router-view @authenticated="setAuthenticated"></router-view>
  </div>
</template>

<script>
import ProfileBanner from "@/components/ProfileBanner.vue";
import TopBar from "@/components/TopBar.vue";
import TabbedNav from "@/components/TabbedNav.vue";
import Profile from "@/components/Profile.vue";
import Invest from "@/components/Invest.vue";
import Login from "@/components/Login.vue";
import Register from "@/components/Register.vue";

const axios = require("axios");
export default {
  name: "app",
  components: {
    ProfileBanner,
    TopBar,
    TabbedNav,
    Profile,
    Invest,
    Login,
    Register
  },
  data() {
    return {
      msg: "Welcome to Your Vue.js App",
      authenticated: false,
      mockAccount: {
        username: "testuser1",
        password: "pass",
        currentBalance: 1500
      },
      url:
        "https://min-api.cryptocompare.com/data/top/totalvolfull?limit=75&tsym=USD"
    };
  },
  mounted() {
    //Taj
    if (!this.$store.state.authenticated) {
        console.log("not authenticated");
        this.$router.replace({ name: "login" });
      }
  },
  methods: {
    setAuthenticated(status) {
      this.authenticated = status;
    },
    makeToast() {
      this.$bvToast.toast(`This is toast number 5`, {
        title: "BootstrapVue Toast",
        autoHideDelay: 5000,
        appendToast: append
      });
    }
  }
};
</script>

<style>
@import url("https://fonts.googleapis.com/css?family=Overpass:400,800&display=swap");
#app-2 {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

h1,
h2 {
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

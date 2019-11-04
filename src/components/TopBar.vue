<template>
    <div id="container">
        <router-link v-if="$store.state.authenticated" class="logout" to="/login" v-on:click.native="logout()" replace>Logout</router-link>
    </div>
</template>

<script>
    export default {
        name: 'top-bar',
        props: {
        },
        methods: {
            logout() {
                this.$store.dispatch('doLogout');
                //this.$router.replace({ name: "login" });
            }
        },
    }
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css?family=Muli&display=swap');
  #container {
    width: 100%;
    height: 50px;
    background-color: #373737;
    font-family: 'Muli', sans-serif;
  }
  .logout {
      color: white;
      float:right;
      padding-right: 28px;
      padding-top: 10px;
      font-size: 16px;
      font-family: 'Muli', sans-serif;
  }
</style>
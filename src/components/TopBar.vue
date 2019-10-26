<template>
    <div id="container">
        <router-link v-if="$parent.authenticated" class="logout" to="/login" v-on:click.native="$parent.logout()" replace>Logout</router-link>
    </div>
</template>

<script>
    export default {
        name: 'top-bar',
        props: {
            employees: Array,
        },
    }
</script>

<style scoped>
  #container {
    width: 100%;
    height: 50px;
    background-color: #373737;
  }
  .logout {
      color: white;
      float:right;
      padding-right: 28px;
      padding-top: 10px;
      font-size: 16px;
  }
</style>
<template>
    <div id="container">
        <h3 class="simple-text">Invest</h3>
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
    background-color: white;
  }
.simple-text {
      font-size: 25px;
      color: grey;
      padding-left: 67px;
      padding-top: 30px;
  }
</style>
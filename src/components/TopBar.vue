<template>
    <div id="container">
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
</style>
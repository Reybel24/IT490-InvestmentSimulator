<template>
    <div id="container">
        <h3 class="simple-text">YOUR PORTFOLIO</h3>

        <b-card-group deck>
            <b-card bg-variant="success" text-variant="white" header="AVAILABLE BALANCE" class="col-sm-7 text-center card-stat">
                <b-card-text>$47.50</b-card-text>
            </b-card>

            <b-card bg-variant="primary" text-variant="white" header="PORTFOLIO VALUE" class="text-center">
                <b-card-text>$7.13</b-card-text>
            </b-card>
        
    </b-card-group>
    </div>
</template>

<script>
    export default {
        name: 'top-bar',
        props: {
        },
    }
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css?family=Muli&display=swap');
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
      font-family: 'Muli', sans-serif;
  }
  .card-stat {
      margin-left: 50px;
  }
</style>
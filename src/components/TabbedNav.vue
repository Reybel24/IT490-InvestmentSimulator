<template>
    <div id="container">

      <router-link to="/profile">
      <div class="tab-button col-10 col-sm-10 col-lg-3">
        <img class="tab-icon" src="@/assets/img/briefcase.png" />
        <span class="tab-text">MY PORTFOLIO</span>
      </div>
      </router-link>

      <router-link to="/invest">
      <div class="tab-button col-10 col-sm-10 col-lg-3">
        <img class="tab-icon" src="@/assets/img/stock.png" />
        <span class="tab-text">INVEST</span>
      </div>
      </router-link>
      
    </div>
</template>

<script>
    export default {
        name: 'tabbed-nav',
        props: {
        },
    }
</script>

<style scoped>
  #container {
    width: 100%;
    background-color: #f8f8f8;
    margin-top:10px;
    padding-left: 30px;
    padding-top: 24px;
  }
  .tab-button {
    height: 50px;
    border-radius: 7px;
    cursor: pointer;
    border: dashed 4px #d5d5d5;
    display: inline-block;
    margin-left: 1%;
    opacity: .5;
    margin-bottom: 20px;
  }
  .tab-button:hover {
    opacity: 1;
  }
  .tab-icon {
    width: 28px;
    height: 28px;
    margin-top: 7px;
    margin-left: 15px;
    display: inline-block;
    vertical-align: top;
  }
  .tab-text {
    color: #7e7e7e;
    font-size: 20px;
    padding-left: 10px;
    display: inline-block;
    padding-top: 6px;
  }
</style>
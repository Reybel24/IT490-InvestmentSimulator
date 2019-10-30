<template>
  <div id="banner">
    <div class="content">
      <div class="avatar-mask">
        <img src="@/assets/img/profile_avatar_1.jpg" class="avatar">
      </div>
      <div class="info-top">
        <span class="name">{{ this.$store.state.user_data.fullName }}</span>
        <span class="badge">{{ this.$store.state.user_data.badge }}</span>
      </div>
      <div class="info-bottom">
        <div class="data-display">
          <img src="@/assets/img/profits.png" class="img-icon">
          <span
            class="text-small"
          >${{ Math.round(this.$store.getters.getUserBalance * 100) / 100 }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const axios = require("axios");
export default {
  name: "profile-banner",
  props: {
    employees: Array
  },
  data() {
    return {};
  },
  components: {},
  methods: {
    updateBalance(payload) {}
  },
  created() {
    // Subscribe to relevant events
    //this.$vueEventBus.$on('balance-updated', this.updateBalance);
    // Display name
  },
  beforeDestroy() {
    // Unscubscribe events
    //this.$vueEventBus.$off('balance-updated');
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css?family=Overpass:400,800&display=swap');
#banner {
  width: 100%;
  height: 220px;
  background-color: #64ccda;
  border-bottom: 12px solid #52acd2;
  box-shadow: 5px 10px #dfdfdf;
}
.content {
  padding-left: 5%;
  padding-top: 2%;
  font-family: 'Overpass', sans-serif;
}
.info-top {
  width: 70%;
  height: 30px;
  border-bottom: 3px solid #52acd2;
  padding-top: 5px;
  padding-bottom: 45px;
  margin-left: 170px;
  margin-bottom: 8px;
}
.name {
  color: white;
  font-size: 25px;
}
.badge {
  padding-top: 8px;
  padding-bottom: 5px;
  padding-left: 30px;
  padding-right: 30px;
  height: 28px;
  background-color: #e3b04b;
  border-radius: 20px;
  margin-left: 10px;
  margin-top: 0px;
  color: #8a6c31;
  font-size: 15px;
  box-shadow: 2px 3px #66666678;
}
.text-white {
  color: white;
  font-size: 15px;
}
.avatar-mask {
  width: 135px;
  height: 135px;
  border-radius: 50%;
  overflow: hidden;
  float: left;
  box-shadow: 6px 8px #5555552e;
}
.avatar {
  width: 100%;
  height: 100%;
}

.info-bottom {
  width: 70%;
  height: 30px;
  padding-top: 10px;
  padding-bottom: 45px;
  margin-left: 170px;
}
.data-display {
  width: 200px;
  height: 50px;
  background-color: white;
  box-shadow: 6px 8px #5555552e;
  border-radius: 7px;
  cursor: default;
}
.img-icon {
  width: 32px;
  height: 32px;
  margin-top: 8px;
  margin-left: 15px;
  display: inline-block;
  vertical-align: top;
}
.text-small {
  color: #52acd2;
  font-size: 25px;
  padding-left: 12px;
  display: inline-block;
  padding-top: 7px;
}
</style>
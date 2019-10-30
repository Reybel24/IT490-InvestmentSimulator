<template>
    <div id="banner">
      <div class="content">
        <div class="avatar-mask">
          <img src="@/assets/img/profile_avatar_1.jpg" class="avatar" />
        </div>
        <div class="info-top">
          <span class="name">Reybel Candelaria</span>
          <span class="badge text-white">NOVICE INVESTOR</span>
        </div>
        <div class="info-bottom">
          <div class="data-display">
            <img src="@/assets/img/profits.png" class="img-icon" />
            <span class="text-small">{{ this.$parent.mockAccount.currentBalance }}</span>
          </div>
        </div>
      </div>
  </div>
</template>

<script>
const axios = require('axios')
    export default {
        name: 'profile-banner',
        props: {
            employees: Array,
        },
        components: {
        },
        methods: {
          updateBalance(payload) {
            console.log(this.$store.getters.getUserBalance);
            // Endpoint
            let scriptURL_auth = this.$store.state.url_backend_base + "testRabbitMQClient.php";
            
            // Payload
            const options = {
              method: 'POST',
              headers: { 'content-type': 'application/form-data' },
              data: {
                type: 'login',
                username: 'testUser1',
                password: 'myPassword123'
              },
              url: scriptURL_auth,
            };

            // Send
            axios(options).then(response => {
              console.log(response.data);
            });
          },
        },
        created() {
            // Subscribe to relevant events
            this.$vueEventBus.$on('balance-updated', this.updateBalance);
          },
          beforeDestroy() {
            // Unscubscribe events
            this.$vueEventBus.$off('balance-updated');
          }
    }
</script>

<style scoped>
  #banner {
    width: 100%;
    height: 220px;
    background-color: #65c6ef;
    border-bottom: 12px solid #52acd2;
    box-shadow: 5px 10px #dfdfdf;
  }
  .content {
    padding-left: 5%;
    padding-top: 2%;
  }
  .info-top {
    width:70%;
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
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 30px;
    padding-right: 30px;
    height: 22px;
    background-color: #52acd2;
    border-radius: 20px;
    margin-left: 20px;
    margin-top:0px;
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
    width:70%;
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
    padding-top: 4px;
  }
</style>
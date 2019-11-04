<template>
  <div id="login">
    <b-form inline>
      <div class="field row">
        <label for="feedback-user" class="label">Username</label>
        <b-input
          id="inline-form-input-name"
          class="mb-2 mr-sm-2 mb-sm-0"
          v-model="input.username"
          placeholder="johnSmith"
          :state="validation"
        ></b-input>

        <b-form-valid-feedback :state="validation">Looks Good.</b-form-valid-feedback>
      </div>

      <div class="field row">
        <label for="feedback-user" class="label">Password</label>
        <b-input-group prepend="@" class="mb-2 mr-sm-2 mb-sm-0">
          <b-input
            type="password"
            id="text-password"
            aria-describedby="password-help-block"
            v-model="input.password"
          ></b-input>
        </b-input-group>
        <b-button variant="primary" v-on:click="login()">Login</b-button>
      </div>
    </b-form>
  </div>
</template>

<script>
export default {
  name: "login",
  data() {
    return {
      input: {
        username: "",
        password: ""
      }
    };
  },
  computed: {
    validation() {
      return this.input.username.length > 4 && this.input.username.length < 13;
    }
  },
  methods: {
    login() {
      if (this.input.username != "" && this.input.password != "") {
          this.$store.dispatch('doAuthenticate', [this.input.username, this.input.password]).then(response => {
              //console.log("creds valid: " + response.success);
              if (response.success) {
                  // Send to home page
                  this.$router.replace({ name: "profile" });
              } else {
                  // Not successful

              }
          });
        };
    }
  },
}
</script>

<style scoped>
#login {
  width: 500px;
  border: 1px solid #cccccc;
  background-color: #ffffff;
  margin: auto;
  margin-top: 200px;
  padding: 20px;
}
.field {
  padding-bottom: 20px;
}
.label {
  padding-right: 20px;
}
</style>
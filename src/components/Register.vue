<template>
  <div id="register">
    <h1>Create Account</h1>
    <b-form @submit="onSubmit">
      <b-form-group id="input-group-2" label="First Name:" label-for="input-2">
        <b-form-input id="input-1" v-model="form.firstName" required placeholder="Dwight"></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-2" label="Last Name:" label-for="input-2">
        <b-form-input id="input-2" v-model="form.lastName" required placeholder="Schrute"></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-3" label="Username:" label-for="input-3">
        <b-form-input id="input-3" v-model="form.username" required></b-form-input>
      </b-form-group>

      <b-form-group id="input-group-3" label="Password:" label-for="input-3">
        <b-form-input id="input-4" v-model="form.password" required></b-form-input>
      </b-form-group>

      <b-button type="submit" variant="primary">Submit</b-button>
    </b-form>
  </div>
</template>

<script>
export default {
  name: "register",
  data() {
    return {
      form: {
        firstName: "",
        lastName: "",
        username: "",
        password: ""
      }
    };
  },
  computed: {
    validation() {
      return this.input.username.length > 4;
      // && this.input.password.length < 13
    },
    validation2() {
      return this.input.password.length > 8;
    }
  },
  methods: {
    register() {
      if (this.input.username != "" && this.input.password != "") {
        if (
          this.input.username != this.$parent.mockAccount.username &&
          this.input.password != this.$parent.mockAccount.password
        ) {
          this.$emit("accountCreate", true);

          this.$router.replace({ name: "login" });
        } else {
          console.log("The username field incorrect");
        }
      } else {
        console.log("A username and password must be present");
      }
    },
    onSubmit(evt) {
        evt.preventDefault();
        this.$store.dispatch('doRegister', [this.form.firstName, this.form.lastName, this.form.username, this.form.password]).then(response => {
            console.log(response);
            console.log("registered successfully");

            // Cookie
            this.$cookie.set('authenticated', response.userID, 1); // cookie, expires in one day
            let cookie_auth = this.$cookie.get('authenticated');
            this.$store.dispatch('doAuthenticateWithCookie', cookie_auth);

            // Navigate to profile page
            this.$router.replace({ name: "profile" });
        })
      },
  }
};
</script>

<style scoped>
#register {
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
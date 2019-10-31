<template>
    <div id="register">
        <b-form inline>
             <h1>Create Account</h1>
            <div class="field row">
                <label for="feedback-user" class="label">Username</label>
                <b-input id="inline-form-input-name" class="mb-2 mr-sm-2 mb-sm-0" v-model="input.username" placeholder="Enter Username" :state="validation"></b-input>
            
                <b-form-valid-feedback :state="validation">Valid Input</b-form-valid-feedback>
            </div>

            <div class="field row">
                <label for="feedback-user" class="label">Password</label>
                <b-input-group prepend="@" class="mb-2 mr-sm-2 mb-sm-0">
                    <b-input type="password" id="text-password" aria-describedby="password-help-block" v-model="input.password" placeholder="Enter Password" :state="validation2"></b-input>
                    <b-form-valid-feedback :state="validation2">Valid Input</b-form-valid-feedback>
                </b-input-group>
                <b-button variant="primary" v-on:click="register()">Register</b-button>
            </div>
        </b-form>
    </div>

</template>

<script>
    export default {
        name: 'Register',
        data() {
            return {
                input: {
                    username: "",
                    password: ""
                }
            }
        },
        computed: {
      validation() {
        return this.input.username.length > 4 
        // && this.input.password.length < 13
      },
      validation2(){
return this.input.password.length >8

      },
    },
        methods: {
            register() {
                if(this.input.username != "" && this.input.password != "") {
                    if(this.input.username != this.$parent.mockAccount.username && this.input.password != this.$parent.mockAccount.password) {
                        this.$emit("accountCreate", true);

                        this.$router.replace({ name: "login" });
                    } else {
                        console.log("The username field incorrect");
                    }
                } else {
                    console.log("A username and password must be present");
                }
            }
        }
    }
</script>

<style scoped>
    #register {
        width: 500px;
        border: 1px solid #CCCCCC;
        background-color: #FFFFFF;
        margin: auto;
        margin-top: 200px;
        padding: 20px;
    }
    .field {
        padding-bottom: 20px;
    }
    .label {
        padding-right:20px;
    }
</style>
<template>
    <div id="login">
        <b-form inline>
            <div class="field row">
                <label for="feedback-user" class="label">Username</label>
                <b-input id="inline-form-input-name" class="mb-2 mr-sm-2 mb-sm-0" v-model="input.username" placeholder="johnSmith" :state="validation"></b-input>
            
                <b-form-valid-feedback :state="validation">Looks Good.</b-form-valid-feedback>
            </div>

            <div class="field row">
                <label for="feedback-user" class="label">Password</label>
                <b-input-group prepend="@" class="mb-2 mr-sm-2 mb-sm-0">
                    <b-input type="password" id="text-password" aria-describedby="password-help-block" v-model="input.password"></b-input>
                </b-input-group>
                <b-button variant="primary" v-on:click="login()">Login</b-button>
            </div>
        </b-form>
    </div>

</template>

<script>
    export default {
        name: 'Login',
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
        return this.input.username.length > 4 && this.input.username.length < 13
      }
    },
        methods: {
            login() {
                if(this.input.username != "" && this.input.password != "") {
                    if(this.input.username == this.$parent.mockAccount.username && this.input.password == this.$parent.mockAccount.password) {
                        this.$emit("authenticated", true);
                        this.$router.replace({ name: "profile" });
                    } else {
                        console.log("The username and / or password is incorrect");
                    }
                } else {
                    console.log("A username and password must be present");
                }
            }
        }
    }
</script>

<style scoped>
    #login {
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
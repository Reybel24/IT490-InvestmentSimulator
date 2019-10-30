// Vuex
import Vue from "vue"
import Vuex from 'vuex';

Vue.use(Vuex);
const axios = require('axios')

// Helper functions
function getUserBalance() {
    
}

export const store = new Vuex.Store({
    state: {
        url_backend_base: "http://localhost:3307/sim/back-end/",
        balance: 50
    },
    mutations: {
        transaction (state, amt) {
            //console.log(amt);
            // Update in database
            // Payload
            const options = {
                method: 'POST',
                headers: { 'content-type': 'application/form-data' },
                data: {
                    type: 'transaction',
                    userID: 'testUserID_1',
                    amount: amt
                },
                url: state.url_backend_base + "testRabbitMQClient.php"
            };

            // Send
            axios(options).then(response => {
                //console.log("had enough for transaction: " + response.data.payload.wasSuccess);
                console.log("transaction successful: " + response.data.payload.wasSuccess);
                state.balance = response.data.payload.new_balance;
            });
        }
    },
    getters: {
        getUserBalance: function () {
            return getUserBalance();
        }
    }
})
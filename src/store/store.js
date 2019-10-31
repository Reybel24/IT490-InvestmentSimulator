// Vuex
import Vue from "vue"
import Vuex from 'vuex';

Vue.use(Vuex);
const axios = require('axios')

// Helper functions
function getAccountDetails(type) {
    return new Promise(function (resolve) {
        // Prepare request
        const options = {
            method: 'POST',
            headers: { 'content-type': 'application/form-data' },
            data: {
                type: 'account',
                userID: 'testUserID_1',
            },
            url: store.state.url_backend_base + "testRabbitMQClient.php"
        };

        // Send
        axios(options).then(response => {
            // Returned type of information asked for from the response array
            resolve(response.data.payload[type]);
        });
    })
}

function transaction(amt) {
    return new Promise(function (resolve) {
        const options = {
            method: 'POST',
            headers: { 'content-type': 'application/form-data' },
            data: {
                type: 'transaction',
                userID: 'testUserID_1',
                amount: amt
            },
            url: store.state.url_backend_base + "testRabbitMQClient.php"
        };

        // Send
        axios(options).then(response => {
            //console.log("had enough for transaction: " + response.data.payload.wasSuccess);
            //console.log("transaction successful: " + response.data.payload.wasSuccess);
            resolve(response.data.payload.new_balance);
        });
    });
}

export const store = new Vuex.Store({
    state: {
        url_backend_base: "http://localhost:3307/sim/back-end/",
        user_data: {
            id: "",
            fullName: "",
            balance: 500,
            badge: "EXPERT INVESTOR"
        },
    },
    mutations: {
        setUserFullName(state, payload) {
            //console.log("setting userID to: " + payload);
            state.user_data.fullName = payload;
        },
        setBalance(state, payload) {
            //console.log("transaction: " + payload);
            state.user_data.balance = payload;
        }
        
    },
    getters: {
        getUserBalance: state => {
            return state.user_data.balance
        },
        //getAccountDetails: state => req => getAccountDetails(req),
        haveEnough: state => amt => {
            return (state.user_data.balance >= amt);
        }
    },
    actions: {
        setUserFullName({ commit }) {
            getAccountDetails("fullName").then(response => {
                // Update property
                commit('setUserFullName', response);
            })
        },
        doTransaction({ commit }, amt) {
            transaction(amt).then(response => {
                // Update property
                commit('setBalance', response);
            })
        }
    }
})
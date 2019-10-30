// Vuex
import Vue from "vue"
import Vuex from 'vuex';

Vue.use(Vuex);

// Helper functions
function getUserBalance() {
    return "test";
}

export const store = new Vuex.Store({
    state: {
        url_backend_base: "http://localhost:3307/sim/back-end/",
    },
    mutations: {

    },
    getters: {
        getUserBalance: function () {
            return getUserBalance();
        }
    }
})
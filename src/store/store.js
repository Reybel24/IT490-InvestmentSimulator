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
                userID: store.state.user_data.id,
            },
            url: store.state.url_backend_base + "testRabbitMQClient.php"
        };

        // Send
        axios(options).then(response => {
            // Returned type of information asked for from the response array
            //console.log("type: " + type);
            //console.log(response.data.payload[type]);
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
                userID: store.state.user_data.id,
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

function testRequest() {
    return new Promise(function (resolve) {
        const options = {
            method: 'POST',
            headers: { 'content-type': 'application/form-data' },
            data: {
                type: 'test',
                userID: 'testUserID_1',
            },
            url: store.state.url_backend_base + "testRabbitMQClient.php",
        };

        // Send
        axios(options).then(response => {
            resolve(response.data.payload);
        });
    });
}
function getCurrencyWorth(symbol, exchange) {
    return new Promise(function (resolve) {
        // Send
        axios(store.state.exchanges[exchange]).then(response => {
            // Returned type of information asked for from the response array
            resolve(response.data.payload[type]);
        });
    })
}

// Returns the current top crypto currencies
function cryptoFetch_TopList(exchange) {

    // Build url
    // ex: https://min-api.cryptocompare.com/data/top/totalvolfull?limit=75&tsym=USD&e=LakeBTC
    let _url = store.state.crypto_base_url +
        "/top/totalvolfull?limit=75" +     // top list with limit
        "&tsym=USD" +                      // currency
        store.state.exchanges[exchange]    // exchange

    // New list to store data
    let _list = [];

    console.log("url: " + _url);

    return new Promise(function (resolve) {
        // Send
        axios(_url).then(response => {
            // Response. Format it nicely.
            Object.keys(response.data.Data).map((key) => {
                let item = {
                    name: response.data.Data[key].CoinInfo.FullName,
                    symbol: response.data.Data[key].CoinInfo.Name,
                    value: response.data.Data[key].RAW.USD.PRICE,
                    string_value: "$" + response.data.Data[key].RAW.USD.PRICE.toFixed(2),
                    change: response.data.Data[key].RAW.USD.CHANGEPCT24HOUR,
                    string_change: (response.data.Data[key].RAW.USD.CHANGEPCT24HOUR).toFixed(2) + "%",
                };

                // Add to list
                _list.push(item);
            });
            resolve(_list);
        })
    });
}

// Returns the current top crypto currencies
function cryptoFetch_price(exchange, symbols) {
    //console.log("syms:" + symbols);
    // Format symbols nicely for URL
    let formatted_symbols = "";
    for (let i = 0; i < symbols.length; i++) {
        formatted_symbols += symbols[i] + ',';
    }
    //console.log(formatted_symbols);

    // Build url
    // ex: https://min-api.cryptocompare.com/data/top/totalvolfull?limit=75&tsym=USD&e=LakeBTC
    let _url = store.state.crypto_base_url +
        "/pricemulti?fsyms=" +              // price, multi
        formatted_symbols +                 // symbols
        "&tsyms=USD" +                       // currency
        store.state.exchanges[exchange]     // exchange

    // New list to store data
    let _list = [];

    //console.log("url: " + _url);

    return new Promise(function (resolve) {
        // Send
        axios(_url).then(response => {
            // Response. Format it nicely.
            Object.keys(response.data).map((key) => {
                let item = {
                    symbol: response.data[key],
                    price: response.data[key].USD,
                };
                // Add to list
                _list.push(item);
            });
            resolve(_list);
        })
    });
}

export const store = new Vuex.Store({
    state: {
        url_backend_base: "http://localhost:3307/sim/back-end/",
        user_data: {
            id: "2",
            fullName: "",
            balance: 0,
            badge: "EXPERT INVESTOR",
            testData: ""
        },
        crypto_base_url: "https://min-api.cryptocompare.com/data",
        exchanges: {
            a: "&e=Kraken",
            b: "&e=LakeBTC",
            c: "&e=Coinmate",
        }
    },
    mutations: {
        setUserFullName(state, payload) {
            //console.log("setting userID to: " + payload);
            state.user_data.fullName = payload;
        },
        setUserBalance(state, payload) {
            //console.log("transaction: " + payload);
            state.user_data.balance = payload;
        },
        setTestData(state, payload) {
            //console.log("transaction: " + payload);
            state.user_data.testData = payload;
        },
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
        setUserBalance({ commit }) {
            getAccountDetails("current_balance").then(response => {
                // Update property
                commit('setUserBalance', response);
            })
        },
        doTransaction({ commit }, amt) {
            transaction(amt).then(response => {
                // Update property
                commit('setUserBalance', response);
            })
        },
        doTest({ commit }) {
            testRequest().then(response => {
                // Update property
                console.log(response);
                commit('setTestData', response);
            })
        },
        crypto_getTopList({ commit }, exchange) {
            return new Promise(function (resolve) {
                cryptoFetch_TopList(exchange).then(response => {
                    resolve(response);
                })
            });
        },
        crypto_getPrice({ commit }, op) {
            return new Promise(function (resolve) {
                //console.log("syms: " + op[1]);
                cryptoFetch_price(op[0], op[1]).then(response => {
                    //console.log(response);
                    resolve(response);
                })
            });
        },
    },
})

// Immedtaily grab current balance
store.dispatch('setUserBalance');
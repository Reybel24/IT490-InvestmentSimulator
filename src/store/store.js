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
            if (type == "all") {
                //console.log(response);
                resolve(response.data.payload);
            } else {
                resolve(response.data.payload[type]);
            }
        });
    })
}

function authenticateCredentials(_username, _password) {
    return new Promise(function (resolve) {
        // Prepare request
        const options = {
            method: 'POST',
            headers: { 'content-type': 'application/form-data' },
            data: {
                type: 'login',
                username: _username,
                password: _password
            },
            url: store.state.url_backend_base + "testRabbitMQClient.php"
        };

        // Send
        axios(options).then(response => {
            //console.log(response);
            resolve(response.data.payload);
        });
    })
}

function registerNewUser(_firstName, _lastName, _username, _password) {
    console.log("f name: " + _firstName);
    return new Promise(function (resolve) {
        // Prepare request
        const options = {
            method: 'POST',
            headers: { 'content-type': 'application/form-data' },
            data: {
                type: 'register',
                firstName: _firstName,
                lastName: _lastName,
                username: _username,
                password: _password,
            },
            url: store.state.url_backend_base + "testRabbitMQClient.php"
        };

        // Send
        axios(options).then(response => {
            console.log(response);
            resolve(response.data.payload);
        });
    })
}

function transaction(base_currency, target_currency, coinAmount, amount) {
    return new Promise(function (resolve) {
        const options = {
            method: 'POST',
            headers: { 'content-type': 'application/form-data' },
            data: {
                type: 'transaction',
                userID: store.state.user_data.id,
                details: {
                    base_currency: base_currency,
                    target_currency: target_currency,
                    coinAmount: coinAmount,
                    amount: amount,
                }
            },
            url: store.state.url_backend_base + "testRabbitMQClient.php"
        };

        //console.log(base_currency);
        //console.log(target_currency);
        //console.log(amount);

        // Send
        axios(options).then(response => {
            //console.log("had enough for transaction: " + response.data.payload.wasSuccess);
            //console.log("transaction successful: " + response.data.payload.wasSuccess);
            //console.log(response.data);
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

    //console.log("url: " + _url);

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

// Returns the crypto price on specidfied exchange
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

function calcPortfolioValue(investments, currency) {
    let _value = 0;
    for (let i = 0; i < investments.length; i++) {
        // Calculate value
        _value = investments[i]
    }
}

export const store = new Vuex.Store({
    state: {
        url_backend_base: "http://localhost:3307/sim/back-end/",
        authenticated: false,
        user_data: {
            id: null,
            fullName: "",
            balance: 0,
            badge: "EXPERT INVESTOR",
            testData: "",
            portfolioValue: "",
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
        doTransaction({ commit }, details) {
            transaction(details.base_currency, details.target_currency, details.coinAmount, details.amount).then(response => {
                // Update property
                commit('setUserBalance', response);
            })
        },
        getInvestments({ commit }) {
            return new Promise(function (resolve) {
                getAccountDetails("investments").then(response => {
                    //console.log(response);
                    // Calc portfolio value using investments
                    calcPortfolioValue(response);
                    resolve(response);
                })
            });
        },
        doTest({ commit }) {
            testRequest().then(response => {
                // Update property
                //console.log(response);
                commit('setTestData', response);
            })
        },
        doAuthenticate({ commit }, details) {
            let self = this;
            return new Promise(function (resolve) {
                authenticateCredentials(details[0], details[1]).then(response => {
                    let success = response.success;
                    //console.log(self.state.authenticated);
                    self.state.authenticated = (success) ? true : false;

                    if (success) {
                        // Set user ID for session
                        self.state.user_data.id = response.userID;
                        // Grab user details
                        store.dispatch('setUserBalance');
                        store.dispatch('setUserFullName');
                        //console.log("user id is: " + response.userID);
                    }
                    resolve(response);
                })
            });
        },
        doAuthenticateWithCookie({ commit }, userID) {
            // Set user ID for session
            this.state.authenticated = true;
            this.state.user_data.id = userID;
            // Grab user details
            store.dispatch('setUserBalance');
            store.dispatch('setUserFullName');
        },
        doLogout({ commit }) {
            this.state.authenticated = false;
            this.state.user_data.fullName = "";
        },
        doRegister({ commit }, details) {
            let self = this;
            console.log(details[2]);
            return new Promise(function (resolve) {
                registerNewUser(details[0], details[1], details[2], details[3]).then(response => {
                    console.log(response);
                    resolve(response);
                })
            });
        },
        crypto_getTopList({ commit }, exchange) {
            return new Promise(function (resolve) {
                cryptoFetch_TopList(exchange).then(response => {
                    resolve(response);
                })
            });
        },
        crypto_getPrice({ commit }, details) {
            return new Promise(function (resolve) {
                //console.log("syms: " + details[1]);
                cryptoFetch_price(details[0], details[1]).then(response => {
                    //console.log(response);
                    resolve(response);
                })
            });
        },
    },
})
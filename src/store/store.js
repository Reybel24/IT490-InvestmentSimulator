// Vuex
import Vue from "vue"
import Vuex from 'vuex';

Vue.use(Vuex);
const axios = require('axios')

// Get user details (name, balance, etc.)
function getAccountDetails(type) {
    // Local
    if (store.state.env == 0) {
        return new Promise(function (resolve) {
            console.log("fetching user data locally")
            // Create some mock data

            if (type == "all") {
                //console.log(response);
                resolve(store.state.mock_user);
            } else {
                resolve(store.state.mock_user[type]);
            }
        });
    }

    // Production
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
    // Local
    if (store.state.env == 0) {
        return new Promise(function (resolve) {
            console.log("authenticating locally")
            // Create some mock data
            let mock_data = {
                success: true
            }
            resolve(mock_data);
        });
    }

    // Production
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
            timeout: 5000,
            url: store.state.url_backend_base + "testRabbitMQClient.php"
        };

        // Send
        axios(options).then(response => {
            console.log(response);
            resolve(response.data.payload);
        });
    })
}

// User registration
function registerNewUser(_firstName, _lastName, _username, _password) {
    // Local
    if (store.state.env == 0) {
        return new Promise(function (resolve) {
            console.log("registering locally (but not really)")
            resolve(store.state.mock_user);
        });
    }

    // Production
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

// Invest: buy, sell
function transaction(base_currency, target_currency, coinAmount, amount) {
    // Local
    if (store.state.env == 0) {
        let _investments = store.state.mock_user.investments;
        // Insert into mock database
        let _exists = false;
        // for (coin in store.state.mock_user.investments) {
        for (let i = 0; i < _investments.length; i++) {
            // console.log(_investments[i])
            if (_investments[i].base_currency == base_currency) {
                // Exists, update it
                // console.log("updating coin bc it exists in db")
                _investments[i].amount_invested += coinAmount;
                _exists = true;
            }
        }
        // Create new entry
        if (!_exists) {
            let _newInvestment = {
                base_currency: base_currency,
                target_currency: target_currency,
                amount_invested: coinAmount
            }
            _investments.push(_newInvestment);
            // console.log(_investments)
            store.state.mock_user.investments = _investments;
        }
        return new Promise(function (resolve) {
            console.log("making local transaction")
            // console.log("amount being subtracted from " + store.state.mock_user.current_balance + " is " + amount);
            store.state.mock_user.current_balance = store.state.mock_user.current_balance + amount;
            resolve(store.state.mock_user.current_balance);
        });
    }

    // Production
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
function cryptoFetch_price(exchange, symbols, currency) {
    //console.log("syms:" + symbols);
    // Format symbols nicely for URL
    let formatted_symbols = "";
    for (let i = 0; i < symbols.length; i++) {
        formatted_symbols += symbols[i] + ',';
    }
    //console.log(formatted_symbols);

    let _exchange = (exchange == "default") ? "" : store.state.exchanges[exchange];

    // Build url
    // ex: https://min-api.cryptocompare.com/data/top/totalvolfull?limit=75&tsym=USD&e=LakeBTC
    let _url = store.state.crypto_base_url +
        "/pricemulti?fsyms=" +              // price, multi
        formatted_symbols +                 // symbols
        "&tsyms=" + currency +              // currency
        _exchange    // exchange

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
                    price: response.data[key][currency],
                    target_currency: currency,
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

function cryptoFetch_history(symbol, currency, date) {

    // Build url
    // ex: https://min-api.cryptocompare.com/data/dayAvg?fsym=BTC&tsym=USD&toTs=1570579200
    let _url = store.state.crypto_base_url +
        "/dayAvg?" +                       // day average
        "fsym=" + symbol +                 // symbol, can only do one at a time
        "&tsym=" + currency +              // currency
        "&toTs=" + date                 // epoch timestamp
    // store.state.exchanges[exchange]    // exchange

    console.log("url: " + _url);

    return new Promise(function (resolve) {
        // Send
        axios(_url).then(response => {
            resolve(response.data[currency])
        });
    });
}

// Creates a mock user for local development
class MockUser {
    constructor(user) {
        this.firstName = 'Local';
        this.lastname = 'User';
        this.fullName = 'Local User';
        this.userID = '555';
        this.username = 'pacman';
        this.password = 'password';
        this.current_balance = 1873;
        this.investments = [
            {
                base_currency: "BTC",
                target_currency: "USD",
                amount_invested: 29.09
            },
            {
                base_currency: 'BCH',
                target_currency: 'USD',
                amount_invested: 3.52
            },
            {
                base_currency: 'QTUM',
                target_currency: 'USD',
                amount_invested: 4
            }
        ]
    }
}

export const store = new Vuex.Store({
    state: {
        env: 0, // set to '0' for local development to bypass rabbitmq and database, '1' for production
        url_backend_base: "http://localhost:3307/sim/back-end/",
        //url_backend_base: "http://25.44.117.162/sim/back-end/",
        // url_backend_base: "http://localhost/sim/back-end/",
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
        },
        mock_user: new MockUser("Fin"),
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
                    // console.log(response);
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
                cryptoFetch_price(details[0], details[1], details[2]).then(response => {
                    //console.log(response);
                    resolve(response);
                })
            });
        },
        crypto_getHistory({ commit }, details) {
            return new Promise(function (resolve) {
                console.log("history for : " + details[1]);
                cryptoFetch_history(details[0], details[1], details[2]).then(response => {
                    // console.log(response);
                    resolve(response);
                })
            });
        },
    },
})

<template>
    <div id="container">
        <div class="button-group button-group-exchange">
          <b-button-group size="sm">
            <b-button size="sm" :pressed.sync="exchange_a" @click="switchExchange('a')">Exchange A</b-button>
            <b-button size="sm" :pressed.sync="exchange_b" @click="switchExchange('b')">Exchange B</b-button>
            <b-button size="sm" :pressed.sync="exchange_b" @click="switchExchange('c')">Exchange C</b-button>
          </b-button-group>
        </div>

        <h3 class="simple-text head">Invest <span class="text-highlight">({{this.activeExchangeName}})</span></h3>
        <trade-popup v-if="showPopup_trade" :coinData="focusedCoin"></trade-popup>
        <Historical v-if="showPopup_historical" :coinData="focusedCoin"></Historical>

        <div class="row">
        <b-table v-if="this.isDataReady"
            class="col-sm-7 table-index"
            :fields="tableFields"
            :striped="true"
            :items="this.responseData"
        >
        
            <template slot="actions" slot-scope="data">
                <b-button size="sm" @click="trade(data.item)" class="mr-1 button-buy">
                    Trade
                </b-button>
                <b-button size="sm" @click="viewHistory(data.item)" class="mr-1 button-buy history">
                    History
                </b-button>
            </template>
        </b-table>

        </div>

          

    </div>
</template>

<script>
import TradePopup from "@/components/TradePopup.vue";
import Historical from "@/components/Historical.vue";

const axios = require('axios')
    export default {
        name: 'invest',
        props: {
        },
        components: {
            TradePopup,
            Historical,
        },
        data () {
            return {
                responseData: [],
                tableFields: [
                    { key: 'symbol', label: 'Symbol' },
                    { key: 'name', label: 'Name' },
                    { key: 'string_value', label: 'Price' },
                    { key: 'string_change', label: 'Change' },
                    { key: 'actions', label: 'Trade' },
                ],
                isDataReady: false,
                focusedCoin: "",
                showPopup_trade: false,
                showPopup_historical: false,
                activeExchangeURL: this.$store.state.exchanges.a,
                activeExchangeName: "",
                exchange_a: true,
                exchange_b: false,
                exchange_c: false,
            }
        },
        methods: {
            pullData() {
                let list = [];
                axios.get(this.$parent.url).then(response => {
                    console.log("pulling data from: " + this.activeExchangeURL);
                    // Create object
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
                        list.push(item);
                    })
                });
                return list;
            },
            buildDataChart() {
                this.responseData = this.pullData();
                this.isDataReady = true;
            },
            info(item, index, button) {
                this.infoModal.title = `Row index: ${index}`
                this.infoModal.content = JSON.stringify(item, null, 2)
                this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            },
            buyCrypto(data_symbol) {
                //console.log(data_symbol);

                // Build query and get price
                let url = "https://min-api.cryptocompare.com/data/price?fsym=" + data_symbol + "&tsyms=USD";
                let price = 0;
                axios.get(url).then(response => {
                    price = response.data.USD
                    if (this.$store.getters.haveEnough(price)) {
                        // Make a transaction
                        this.$store.dispatch("doTransaction", price);

                        // Toast notification
                        this.$toasted.global.purchase_complete({
                            message : 'PURCHASED 1 ' + data_symbol + ' for $' + price
                        });
                    }
                    else {
                        //console.log("Not enough money");
                        this.$toasted.global.fail({
                            message : 'NOT ENOUGH MONEY'
                        });
                    }
                });
            },
            trade(coin) {
                console.log("investing for " + coin.symbol);
                this.focusedCoin = coin;
                this.showPopup_trade = true;
            },
            viewHistory(coin) {
                this.focusedCoin = coin;
                this.showPopup_historical = true;
            },
            switchExchange(exchange) {
                if (exchange == 'a') {
                    this.exchange_a = true;
                    this.exchange_b = false;
                    this.exchange_c = false;
                }
                else if (exchange == 'b')
                {
                    this.exchange_a = false;
                    this.exchange_b = true;
                    this.exchange_c = false;
                }
                else
                {
                    this.exchange_a = false;
                    this.exchange_b = false;
                    this.exchange_c = true;
                }
                this.activeExchangeURL = this.$store.state.exchanges[exchange]
                console.log("switched to: " + this.activeExchangeURL);

                // Refresh data
                this.buildDataChart();

                this.getNameOfExchange(this.activeExchangeURL);
            },
            getNameOfExchange(url) {
                // Very sloppy but oh well, it works...
                let end = url.length;
                let name = "";
                for (let i = end; i--; i >= 0) {
                    if (url[i] == "=") {
                        name = url.substring(i+1, end);
                        break;
                    }
                }
                this.activeExchangeName = name;
            },
        },
        created: function () {
            this.buildDataChart();
            this.getNameOfExchange(this.activeExchangeURL);
        }
    }
</script>

<style scoped>
  #container {
    width: 100%;
    height: 50px;
    background-color: white;
  }
.simple-text {
      font-size: 25px;
      color: grey;
      padding-left: 58px;
      padding-top: 30px;
      font-family: 'Overpass', sans-serif;
  }
  .table-index {
      margin-left: 5%;
      font-size: 17px;
      font-family: 'Overpass', sans-serif;
  }
  .button-buy {
      width: 80%;
      height: 40px;
      background-color: #05b169;
      border: none;
      margin-bottom: 10px;
      display: inline-block;
  }
    .button-buy:hover {
      background-color: #02995a;
      border: none;
  }
  .button-group-exchange {
      padding-top: 20px;
      padding-left: 56px;
  }
  .text-highlight {
      font-size: 24px;
      color: #b18905;
  }
  .history {
      background-color: #57bdec
  }
</style>
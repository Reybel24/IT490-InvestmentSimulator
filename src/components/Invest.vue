<template>
    <div id="container">
        <h3 class="simple-text">Invest</h3>

        <div class="row">
        <b-table v-if="this.isDataReady"
            class="col-sm-7 table-index"
            :fields="tableFields"
            :striped="true"
            :items="this.responseData"
        >
        
            <template slot="actions" slot-scope="data">
                <b-button size="sm" @click="buyCrypto(data.item.symbol)" class="mr-1 button-buy">
                    Trade
                </b-button>
            </template>
        </b-table>

        </div>

          

    </div>
</template>

<script>
const axios = require('axios')
    export default {
        name: 'invest',
        props: {
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
            }
        },
        methods: {
            pullData() {
                let list = [];
                axios.get(this.$parent.url).then(response => {
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
                console.log(data_symbol);

                // Build query and get price
                let url = "https://min-api.cryptocompare.com/data/price?fsym=" + data_symbol + "&tsyms=USD";
                let price = 0;
                axios.get(url).then(response => {
                    price = response.data.USD
                    
                    if (this.$parent.hasEnoughBalance(price)) {
                        this.$parent.addToBalance(-price);
                        console.log("Purchased " + data_symbol + " for " + price);
                        console.log("New balance: " + this.$parent.getBalance());
                        this.$toasted.global.purchase_complete({
                            message : 'PURCHASED 1 ' + data_symbol + ' for $' + price
                        });
                    }
                    else {
                        console.log("Not enough money for ");
                        this.$toasted.global.fail({
                            message : 'NOT ENOUGH MONEY'
                        });
                    }
                });
            },
        },
        created: function () {
            this.buildDataChart();
        }
    }
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css?family=Muli&display=swap');
  #container {
    width: 100%;
    height: 50px;
    background-color: white;
  }
.simple-text {
      font-size: 25px;
      color: grey;
      padding-left: 67px;
      padding-top: 30px;
  }
  .table-index {
      margin-left: 5%;
      font-size: 17px;
      font-family: 'Muli', sans-serif;
  }
  .button-buy {
      width: 80%;
      height: 40px;
      background-color: #05b169;
      border: none;
  }
    .button-buy:hover {
      background-color: #02995a;
      border: none;
  }
</style>
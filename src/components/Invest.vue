<template>
    <div id="container">
        <h3 class="simple-text">Invest</h3>
        <b-button variant="primary" v-on:click="buildDataChart()">Create</b-button>

        <b-table v-if="this.isDataReady"
            class="sm"
            :fields="tableFields"
            :striped="true"
            :items="this.responseData"
        >
        
            <template slot="actions" slot-scope="data">
                <b-button size="sm" @click="buyCrypto(data.item.FROMSYMBOL)" class="mr-1">
                     BUY
                </b-button>
            </template>
        </b-table>
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
                    { key: 'FROMSYMBOL', label: 'NAME' },
                    { key: 'PRICE', label: 'PRICE' },
                    { key: 'actions', label: 'ACTIONS' },
                ],
                isDataReady: false,
            }
        },
        methods: {
            
            pullData() {
                axios.get(this.$parent.url).then(response => {
                    this.responseData = Object.keys(response.data.RAW).map((key) => {
                        return response.data.RAW[key].USD;
                    })
                });
                return this.responseData;
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
                    
                    if (this.$parent.hasEnoughBalance(price)) {
                        this.$parent.addToBalance(-price);
                        console.log("Purchased " + data_symbol + " for " + price);
                        console.log("New balance: " + this.$parent.getBalance());
                        this.$toasted.global.purchase_complete({
                            message : 'PURCHASED 1 ' + data_symbol + ' for $' + price
                        });
                    }
                    else {
                        console.log("Not enough money!");
                        this.$toasted.global.fail({
                            message : 'NOT ENOUGH MONEY'
                        });
                    }
                });
            },
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
      padding-left: 67px;
      padding-top: 30px;
  }
</style>
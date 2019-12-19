<template>
  <div id="container">
    <h3 class="simple-text">YOUR PORTFOLIO</h3>

    <b-card-group deck class="card-wrapper">
      <b-card
        bg-variant="success"
        text-variant="white"
        header="AVAILABLE BALANCE"
        class="col-sm-10 text-center card-stat"
      >
        <span class="value-text">${{ Math.round(this.$store.getters.getUserBalance * 100) / 100 }}</span>
      </b-card>

      <b-card
        bg-variant="primary"
        text-variant="white"
        header="PORTFOLIO VALUE"
        class="col-sm-10 text-center card-stat"
      >
        <span class="value-text">{{ Math.round(this.portfolio_value * 100) / 100 }} ({{this.target_currency}})</span>
      </b-card>
    </b-card-group>

    <b-form-select v-model="target_currency" :options="target_currency_dropdown" class="dropdown_currency"></b-form-select>

    <h4 class="loading" v-if="!this.isDataReady">JUST ONE SECOND...</h4>

    <div class="row table_investments">
      <b-table
        v-if="this.isDataReady"
        class="col-sm-7 table-index"
        :fields="tableFields"
        :striped="true"
        :items="this.investmentData"
      ></b-table>
    </div>
  </div>
</template>

<script>
export default {
  name: "top-bar",
  props: {},
  data() {
    return {
      target_currency: 'USD',
      investmentData: null,
      isDataReady: false,
      portfolio_value: 0,
      tableFields: [
        { key: "base_currency", label: "Base Currency" },
        { key: "amount_invested", label: "Wallet" },
        { key: "target_currency", label: "Target Currency" },
        { key: "value", label: "Value" }
      ],
      target_currency_dropdown: [
          { value: 'USD', text: 'USD' },
          { value: 'EUR', text: 'EUR' },
          { value: 'JPY', text: 'JPY' },
          { value: 'GBP', text: 'GBP' },
          { value: 'CAD', text: 'CAD' },
          { value: 'AUD', text: 'AUD' },
          { value: 'NZD', text: 'NZD' },
        ]
    };
  },
  methods: {
    clickMe() {
      this.$store.dispatch("doTest");
    },
    calcWalletValue(target_currency, coins) {
      //console.log(this.$store.state.exchanges['a']);

      let self = this;
      return new Promise(function(resolve) {
        // Fetch price using default exchange (a)
        self.$store
          .dispatch("crypto_getPrice", ["default", coins, target_currency])
          .then(response => {
            //let _price = response[0].price;
            //console.log(response[0].price);
            resolve(response);
          });
      });
    },
    showInvestments() {
      this.$store.dispatch("getInvestments").then(response => {
        this.investmentData = response;
        // console.log(this.investmentData);

        let _coins = [];
        // Put coin symbols into array
        for (let j = 0; j < this.investmentData.length; j++) {
          _coins.push(this.investmentData[j].base_currency);
        }

        // Single API call for all coin values
        let _valuaData = null;
        this.calcWalletValue(this.target_currency, _coins).then(response => {
          _valuaData = response;
          //console.log(_valuaData);

          // Assign values
          this.portfolio_value = 0;
          let wallet_value = 0;
          for (let k = 0; k < this.investmentData.length; k++) {
            //console.log(_valuaData[k].symbol);
            //console.log(this.investmentData[k].base_currency);

            
            wallet_value = _valuaData[k].symbol[this.target_currency] * this.investmentData[k].amount_invested;
            this.portfolio_value = this.portfolio_value + wallet_value;

            // Target currency
            Object.defineProperty(this.investmentData[k], "target_currency", {
              value:
                this.target_currency,
            });
            // console.log((this.investmentData[k]));
            // Calculated value
            Object.defineProperty(this.investmentData[k], "value", {
              configurable: true,
              value:
                Math.round(wallet_value * 100) / 100
            });
          }
        });
      });
    }
  },
  created: function() {
    this.showInvestments();
    // Very bad, but I give up. Just wait 2 seconds and hope the data is done loading from the
    // API by then :/
    setTimeout(() => (this.isDataReady = true), 1500);
  },
  mounted () {
    //console.log("the cookie: " + this.$cookie.get('test'));
  },
  watch: {
    target_currency: function() {
      console.log("changed to: " + this.target_currency);
      // Re-fetch list
      this.isDataReady = false;

      this.showInvestments();
    // Very bad, but I give up. Just wait 2 seconds and hope the data is done loading from the
    // API by then :/
    setTimeout(() => (this.isDataReady = true), 1500);
    },
  }
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css?family=Muli&display=swap");
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
  font-family: "Muli", sans-serif;
}
.card-wrapper {
  width: 100%;
  margin-right: 0px;
}
.card-stat {
  width: 90%;
  margin-left:30px;
}
.table_investments {
  padding-left: 50px;
  padding-top: 30px;
}
.loading {
  font-size: 24px;
  font-family: "Overpass", sans-serif;
  color: #28a745;
  padding-left: 35px;
  padding-top: 30px;
}
.value-text {
    font-size: 22px;
    font-family: "Overpass", sans-serif;
    color: white;
}
.dropdown_currency {
  width:50%;
  margin-left: 35px;
  margin-top:20px;
}
</style>
<template>
  <div id="container">
    <h3 class="simple-text">YOUR PORTFOLIO</h3>

    <b-card-group deck>
      <b-card
        bg-variant="success"
        text-variant="white"
        header="AVAILABLE BALANCE"
        class="col-sm-7 text-center card-stat"
      >
        <span class="value-text">${{ Math.round(this.$store.getters.getUserBalance * 100) / 100 }}</span>
      </b-card>

      <b-card
        bg-variant="primary"
        text-variant="white"
        header="PORTFOLIO VALUE"
        class="text-center"
      >
        <span class="value-text">${{ Math.round(this.portfolio_value * 100) / 100 }}</span>
      </b-card>
    </b-card-group>

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
      investmentData: null,
      isDataReady: false,
      portfolio_value: 0,
      tableFields: [
        { key: "base_currency", label: "Base Currency" },
        { key: "amount_invested", label: "Wallet" },
        { key: "target_currency", label: "Target Currency" },
        { key: "value", label: "Value" }
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
          .dispatch("crypto_getPrice", ["a", coins, target_currency])
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
        //console.log(this.investmentData);

        let _coins = [];
        // Put coin symbols into array
        for (let j = 0; j < this.investmentData.length; j++) {
          _coins.push(this.investmentData[j].base_currency);
        }

        // Single API call for all coin values
        let _valuaData = null;
        this.calcWalletValue("USD", _coins).then(response => {
          _valuaData = response;
          //console.log("here");
          //console.log(_valuaData);

          // Assign values
          this.portfolio_value = 0;
          let wallet_value = 0;
          for (let k = 0; k < this.investmentData.length; k++) {
            //console.log(_valuaData[k].symbol);
            //console.log(this.investmentData[k].base_currency);

            
            wallet_value = _valuaData[k].symbol.USD * this.investmentData[k].amount_invested;
            this.portfolio_value = this.portfolio_value + wallet_value;

            Object.defineProperty(this.investmentData[k], "value", {
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
.card-stat {
  margin-left: 50px;
}
.table_investments {
  padding-left: 50px;
  padding-top: 30px;
}
.loading {
  font-size: 24px;
  font-family: "Overpass", sans-serif;
  color: #28a745;
  padding-left: 30px;
  padding-top: 10px;
}
.value-text {
    font-size: 22px;
    font-family: "Overpass", sans-serif;
    color: white;
}
</style>
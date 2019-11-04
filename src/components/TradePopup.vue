<template>
  <div class="modal-mask">
    <div class="modal-wrapper">
      <div class="modal-container">
        <b-button variant="outline-danger" class="button-close" @click="close()">X</b-button>
        <h3 class="header">{{ coinData.name.toUpperCase() }}</h3>
        <h3 class="header-sub">YOU OWN {{ this.owned }}</h3>

        <div class="button-group">
          <b-button-group size="sm">
            <b-button size="sm" :pressed.sync="option_buy" @click="toggleButton('buy')">BUY</b-button>
            <b-button size="sm" :pressed.sync="option_sell" @click="toggleButton('sell')">SELL</b-button>
          </b-button-group>
        </div>

        <!--<b-form-input id="range-1" v-model="amount" type="range" min="0" max="10" step="0.001"></b-form-input>-->
        <b-row class="my-1">
          <b-col sm="3">
            <label for="input-valid">AMOUNT</label>
          </b-col>
          <b-col sm="9">
            <b-form-input
              id="input-valid"
              v-model="userInput"
              :state="this.inputValid"
              placeholder="1.5"
            ></b-form-input>
          </b-col>
        </b-row>
        <span class="small-text">{{ profit_text }}: ${{ Math.round(this.price * 100) / 100 }} USD</span>

        <b-button
          :variant="option_buy ? 'outline-success' : 'outline-secondary'"
          class="button_purchase"
          @click="pressButton()"
        >{{ this.actionButton_text }}</b-button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "trade-popup",
  props: ["coinData"],
  methods: {
    close() {
      this.$parent.showPopup_trade = false;
    },
    calcPrice() {
      this.$store
        .dispatch("crypto_getPrice", [
          this.$parent.activeExchange,
          [this.coinData.symbol]
        ])
        .then(response => {
          let _price = response[0].price * this.amount;
          //console.log("price: " + _price);
          this.price = _price;
          this.setInputBox();
          this.canContinue = true;
        });
    },
    toggleButton(option) {
      if (option == "buy") {
        this.option_buy = true;
        this.option_sell = false;
        this.actionButton_text = "PURCHASE";
        this.profit_text = "PRICE";
      } else {
        this.option_buy = false;
        this.option_sell = true;
        this.actionButton_text = "SELL";
        this.profit_text = "PROFIT";
      }

      // Refresh box
      this.setInputBox();
    },
    pressButton() {
      if (this.canContinue == false) {
        this.$toasted.global.fail({
            message: "Please wait a moment..."
          });
        return;
      }

      if (this.option_buy) {
        // Valid?
        if (this.$store.getters.haveEnough(this.price)) {
          // Make transaction
          let _details = {
            base_currency: this.coinData.symbol,
            target_currency: "USD",
            coinAmount: this.amount,
            amount: -this.price
          };
          this.$store.dispatch("doTransaction", _details);

          // Close popup
          this.$parent.showPopup_trade = false;

          // Success toast notification
          // Toast notification
          let action = "PURCHASED";
          this.$toasted.global.purchase_complete({
            message:
              action +
              " " +
              this.amount +
              " " +
              this.coinData.name +
              " for $" +
              Math.round(this.price * 100) / 100
          });
        } else {
          //console.log("Not enough money");
          this.$toasted.global.fail({
            message: "BALANCE TOO LOW"
          });
        }
      } else {
        // Check if user has enough of this curreny here
        if (this.inputValid) {
          // Selling, add cash as profit
        let _details = {
          base_currency: this.coinData.symbol,
          target_currency: "USD",
          coinAmount: -this.amount,
          amount: this.price
        };
        this.$store.dispatch("doTransaction", _details);

        // Close popup
        this.$parent.showPopup_trade = false;

        // Toast notification
        let action = "SOLD";
        this.$toasted.global.purchase_complete({
          message:
            action +
            " " +
            this.amount +
            " " +
            this.coinData.name +
            " for $" +
            this.price
        });
        }
      }
    },
    setInputBox() {
      if (this.option_buy) {
        // Is this purchase valid?
        if (this.$store.getters.haveEnough(this.price)) {
          //console.log("has enough");
          this.inputValid = true;
        } else {
          //console.log("NOT enough. amount is " + this.amount + " and total is " + this.price);
          this.inputValid = false;
        }
      } else if (this.option_sell) {
        // Doe user have enough to sell?
        if (this.amount <= this.owned) {
          this.inputValid = true;
        } else {
          this.inputValid = false;
        }
      }
    }
  },
  data() {
    return {
      show: false,
      amount: "0",
      price: "",
      owned: 0,
      option_buy: true,
      option_sell: false,
      actionButton_text: "PURCHASE",
      profit_text: "PRICE",
      button_variant: "outline-success",
      timer: "",
      userInput: "",
      inputValid: null,
      canContinue: false,
    };
  },
  watch: {
    userInput: function(newVal) {
      this.amount = this.userInput;
      this.canContinue = false;
    },
    amount: function(newVal) {
      // Clear any previous timers
      clearTimeout(this.timer);

      this.timer = setTimeout(
        () =>
          // Get new amount (using API)
          this.calcPrice(),
        1000
      );
    }
  },
  computed: {},
  created() {
    // Grab owned amount from database
    let self = this;
    this.$store.dispatch("getInvestments").then(response => {
      this.investmentData = response;
      let _symbol = "";
      for (let i = 0; i < this.investmentData.length; i++) {
        _symbol = this.investmentData[i].base_currency;
        if (_symbol == this.coinData.symbol) {
          // Owns some
          let _resOwned = this.investmentData[i].amount_invested;
          this.owned = _resOwned;
          console.log("matched: " + _symbol + " and you own " + this.owned);

          // Exit
          break;
        } else {
          // Own 0
          this.owned = 0;
        }
      }
    });
  },
  mounted() {
    // Default
    this.option_buy = true;
    this.option_sell = false;
    this.calcPrice();
  }
};
</script>

<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}
.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 500px;
  margin: 0px auto;
  padding: 30px 35px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
  border-radius: 10px;
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
.button_purchase {
  display: block;
  margin-left: auto;
}
.header {
  font-size: 25px;
  font-family: "Overpass", sans-serif;
  color: #28a745;
}
.header-sub {
  font-size: 14px;
  font-family: "Overpass", sans-serif;
  color: #28a745;
  margin-top: -6px;
}
.button-group {
  display: block;
  margin-left: auto;
  float: right;
}
.button-close {
  display: block;
  float: right;
}
</style>
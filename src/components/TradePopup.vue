<template>
  <div class="modal-mask">
    <div class="modal-wrapper">
      <div class="modal-container">
        <b-button variant="outline-danger" class="button-close" @click="close()">X</b-button>
        <h3 class="header">{{ coinData.name.toUpperCase() }}</h3>
        <h3 class="header-sub">YOU OWN {{ owned }}</h3>

        <div class="button-group">
          <b-button-group size="sm">
            <b-button size="sm" :pressed.sync="option_buy" @click="toggleButton('buy')">BUY</b-button>
            <b-button size="sm" :pressed.sync="option_sell" @click="toggleButton('sell')">SELL</b-button>
          </b-button-group>
        </div>

        <div class="mt-2">AMOUNT: {{ amount }}</div>
        <b-form-input id="range-1" v-model="amount" type="range" min="1" max="50"></b-form-input>
        <span class="small-text">{{ profit_text }}: ${{ Math.round(this.price * 100) / 100 }} USD</span>

        <b-button
          :variant="option_buy ? 'outline-success' : 'outline-danger'"
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
      this.$store.dispatch("crypto_getPrice", [
          this.$parent.activeExchange,
          [this.coinData.symbol]
        ]).then(response => {
          let _price = response[0].price * this.amount;
          //console.log("price: " + _price);
          this.price = _price;
        });
    },
    toggleButton(option) {
      if (option == "buy") {
        this.option_buy = true;
        this.option_sell = false;
        this.actionButton_text = "PURCHASE";
        this.profit_text = "PROFIT";
      } else {
        this.option_buy = false;
        this.option_sell = true;
        this.actionButton_text = "SELL";
        this.profit_text = "PRICE";
      }
    },
    pressButton() {
      if (this.option_buy) {
        // Subtract cash
        this.$store.dispatch("doTransaction", -this.price);
      } else {
        // Add cash
        this.$store.dispatch("doTransaction", this.price);
      }

      this.$parent.showPopup_trade = false;

      // Toast notification
      let action = this.option_buy ? "PURCHASED" : "SOLD";
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
  },
  data() {
    return {
      show: false,
      amount: "1",
      price: "",
      owned: 7,
      option_buy: true,
      option_sell: false,
      actionButton_text: "PURCHASE",
      profit_text: "PROFIT",
      button_variant: "outline-success",
      timer: "",
    }
  },
  watch: {
    amount: function(newVal) {
      // Clear any previous timers
      clearTimeout(this.timer);

      this.timer = setTimeout(() =>
        // Get new amount (using API)
        this.calcPrice()
      , 1500);
    }
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
  display: inline-block;
  float: right;
}
</style>
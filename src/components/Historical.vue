<template>
  <div class="modal-mask">
    <div class="modal-wrapper">
      <div class="modal-container">
        <h3 class="header">{{ coinData.name.toUpperCase() }}</h3>
        <b-button variant="outline-danger" class="button-close" @click="close()">X</b-button>
        <h3 class="header-sub">Historical View</h3>
        <chart :chartdata="historicalData" :options="chartOptions"/>
      </div>
    </div>
  </div>
</template>

<script>
import Chart from "@/components/Chart.vue";

export default {
  name: "historical",
  props: ["coinData"],
  components: {
    Chart
  },
  methods: {
    close() {
      this.$parent.showPopup_historical = false;
    },
    calcPrice() {
      return 59 * this.amount;
    },
    toggleButton(option) {
      if (option == "buy") {
        this.option_sell = false;
        this.actionButton_text = "PURCHASE";
        this.profit_price = "PROFIT";
      } else {
        this.option_buy = false;
        this.actionButton_text = "SELL";
        this.profit_price = "PRICE";
      }
    },
    fetchHistoricalData() {
      console.log("Fetching historical data for " + this.coinData.name);
    }
  },
  data() {
    return {
      historicalData: {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [
          {
            label: "Data One",
            backgroundColor: "#f87979",
            data: [40, 20, 50, 43, 71, 12, 56]
          }
        ]
      },
      chartOptions: {
          fill: false,
          borderWidth: 7
          
      }
    };
  },
  mounted() {
    // Grab data from API
    this.historicalData = this.fetchHistoricalData();
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
  width: 800px;
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
  display: inline-block;
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
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
  data() {
    return {
      historicalData: {
        labels: [],
        datasets: [
          {
            label: "Data One",
            backgroundColor: "#f87979",
            data: [this.chartValues]
          }
        ]
      },
      chartOptions: {
        fill: false,
        borderWidth: 7
      },
      chartValues: [17, 19]
    };
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
      // console.log("Fetching historical data for " + this.coinData.name);

      const today = new Date();
      // console.log('current epoch time is: ' + now);

      // Hold time + price pairs
      let _history = [];

      // Add today
      // _history.push(now);

      // Fill with last 7 days
      let _numDays = 2;
      for (let i = 0; i <= _numDays; i++) {
        // Add last 7 days
        let _date = new Date(today);
        _date.setDate(_date.getDate() - i);

        let _pointInTime = {};

        // Day in normal english
        _pointInTime.day = _date;

        // Day in epoch
        _pointInTime.epoch = this.dateToEpoch(_date);

        // Add to history
        _history.push(_pointInTime);
      }

      console.log(_history);

      // Get price for every point in time
      var _histData = this.historicalData;
      let _promises = []
      for (let item of _history) {
        _promises.push(this.$store.dispatch("crypto_getHistory", [this.coinData.symbol, "USD", item.epoch]));
        // console.log('recieved ' + _val);
      }

      // All promises have resolved
      Promise.all(_promises).then((values) => {
          // console.log(values);

          // Enter into list
          for (let i = _numDays; i >= 0; i--) {
            _history[i].value = values[i]
          }

          // console.log(_history);
          // Show graph after data has been fetched
          this.buildGraph(_history, _histData);
      })
      
    },
    buildGraph(history, histData) {
      console.log(history);
      let _dataSet = [];
      for (let i = 0; i < history.length; i++) {
        // console.log(history[i].value);
        console.log('Inserting ' + history[i].day.getDate() + ' and ' + history[i].value);
        histData.labels.push(history[i].day.getDate());
        _dataSet.push(history[i].value);
      }
      histData.datasets.data = _dataSet
      console.log(histData);
    },
    dateToEpoch(date) {
      return date.getTime();
    }
  },
  mounted() {
    // Grab data from API
    this.historicalData = this.fetchHistoricalData();
  },
  watch: {
    historicalData () {
      this.renderChart(this.chartValues, this.chartOptions);
    }
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
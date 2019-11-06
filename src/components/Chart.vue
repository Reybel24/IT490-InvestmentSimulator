<script>
import { Line } from 'vue-chartjs'
export default {
  name: "chart",
  extends: Line,
  props: {
    chartdata: {
      type: Object,
      default: null
    },
    options: {
      type: Object,
      default: null
    }
  },
  mounted () {
    this.renderChart(this.chartdata, this.options)
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
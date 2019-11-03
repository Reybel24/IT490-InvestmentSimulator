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
        <span>$47.50</span>
      </b-card>

      <b-card
        bg-variant="primary"
        text-variant="white"
        header="PORTFOLIO VALUE"
        class="text-center"
      >
        <span>$7.13</span>
      </b-card>
    </b-card-group>

    <div class="row table_investments">
      <b-table
        v-if="this.isDataReady"
        class="col-sm-7 table-index"
        :fields="tableFields"
        :striped="true"
        :items="this.investmentData"
      >
      </b-table>
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
      tableFields: [
        { key: "base_currency", label: "Base Currency" },
        { key: "target_currency", label: "Target Currency" },
        { key: "amount_invested", label: "Amount Invested" },
      ]
    };
  },
  methods: {
    clickMe() {
      this.$store.dispatch("doTest");
    },
    showInvestments() {
      this.$store.dispatch("getInvestments").then(response => {
        this.investmentData = response;
        console.log(this.investmentData);

        /*
        for (let i = 0; i < this.investments.length; i++) {
          console.log(this.investments[i].target_currency);
        }
        */

        // Show table
        this.isDataReady = true;
      });
    }
  },
  created: function() {
    this.showInvestments();
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
    padding-top:30px;
}
</style>
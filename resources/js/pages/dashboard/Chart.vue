<template>
  <div class="card h-100">
    <div class="card-body position-relative">
      <LoadingComponent v-if="loadingGraph" />
      <apexchart
        type="line"
        :options="chartOptions"
        :series="series"
      ></apexchart>
    </div>
  </div>
</template>
<script>
import VueApexCharts from "vue3-apexcharts";
import Utils from "../../store/services/utils";
import LoadingComponent from "../../components/LoadingComponent.vue";
export default {
  components: {
    apexchart: VueApexCharts,
    LoadingComponent,
  },
  data() {
    return {
      loadingGraph: false,
      series: [
        {
          name: "Pengeluaran",
          data: [],
        },
        {
          name: "Pemasukan",
          data: [],
        },
      ],
      chartOptions: {
        chart: {
          height: 450,
          type: "line",

          dropShadow: {
            enabled: true,
            color: "#000",
            top: 18,
            left: 7,
            blur: 10,
            opacity: 0.1,
          },
          toolbar: {
            show: true,
            offsetX: -10,
            offsetY: -10,
            tools: {
              pan: false,
              zoom: true,
              selection: false,
            },
          },
        },
        colors: ["#FF3F3B", "#0AF761"],
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "smooth",
        },
        title: {
          text: "Statistik Pengeluaran dan Pemasukan",
          align: "left",
        },
        // grid: {
        //   borderColor: "#e7e7e7",
        //   row: {
        //     colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
        //     opacity: 0.5,
        //   },
        // },
        markers: {
          size: 5,
        },
        xaxis: {
          categories: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "Mei",
            "Jun",
            "Jul",
            "Ags",
            "Sep",
            "Okt",
            "Nov",
            "Des",
          ],
          title: {
            text: "Bulan",
          },
        },
        yaxis: {
          title: {
            // text: "Rate",
          },
          labels: {
            formatter: function (val) {
              return Utils.formatRupiah(val, "Rp. ");
            },
          },
        },
        legend: {
          position: "top",
          horizontalAlign: "center",
          floating: true,
          offsetY: -25,
          offsetX: -5,
        },
      },
      income: [
        {
          name: "Pemasukan",
          data: [
            20000, 120000, 120000, 300000, 3230003, 400000, 500000, 600000,
            700000, 800000, 900000, 1000000, 1400000,
          ],
        },
      ],
    };
  },
  mounted() {
    this.getGraph();
  },
  methods: {
    getGraph() {
      const self = this;
      this.loadingGraph = true;
      const params = [].join("&");
      self.$store
        .dispatch("getData", ["dashboard/graph", params])
        .then((response) => {
          this.loadingGraph = false;
          for (let i = 0; i < 12; i++) {
            let month = i < 9 ? "0" + (i + 1) : i + 1;
            this.series[1].data.push(response.data[month].income);
            this.series[0].data.push(response.data[month].expense);
          }
        })
        .catch((err) => {
          this.loadingGraph = false;
        });
    },
  },
};
</script>
<style></style>

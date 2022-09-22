<template >
  <div class="card">
    <div class="card-body">
      <apexchart
        type="line"
        height="450"
        :options="chartOptions"
        :series="series"
      ></apexchart>
    </div>
  </div>
</template>
<script>
import VueApexCharts from "vue3-apexcharts";
export default {
  components: {
    apexchart: VueApexCharts,
  },
  data() {
    return {
      series: [
        {
          name: "Pengeluaran",
          data: [
            2000000, 4000000, 5000000, 6000000, 7000000, 8000000, 9000000,
            10000000, 11000000, 3000000, 12000000, 13000000,
          ],
        },
        {
          name: "Pemasukan",
          data: [
            //make 12 random data min 1000000 max 10000000
            2000000, 3000000, 13000000, 4000000, 5000000, 6000000,
            7000000, 8000000, 9000000, 10000000, 11000000,12000000,
          ],
        },
      ],
      chartOptions: {
        chart: {
          height: 350,
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
          size: 1,
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
            text: "Temperature",
          },
        },
        legend: {
          position: "top",
          horizontalAlign: "right",
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
};
</script>
<style >
</style>

<template>
  <section class="section">
    <div class="section-header">
      <h4>Dashboard</h4>
    </div>
    <div class="row">
      <div class="col-lg-8">
        <div class="row">
          <div class="col-lg-6">
            <CardStatistic tittle=" Pegawai" count="99" />
          </div>
          <div class="col-lg-6">
            <CardStatistic tittle=" Customer" count="99" />
          </div>
          <div class="col-lg-6">
            <CardStatistic tittle=" Pemborong" count="99" />
          </div>
          <div class="col-lg-6">
            <CardStatistic tittle=" Kavling" count="99" />
          </div>
          <div class="col-lg-12">
            <CardStatistic tittle=" Tipe Rumah" count="99" />
          </div>
          <div class="col-lg-12">
            <Chart />
          </div>
        </div>
      </div>
      <div class="col-lg-4" >
        <RecentActivity style="position:sticky; top:0; " />
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8 col-md-12 col-12 col-sm-12"></div>
    </div>
  </section>
</template>
<script>
import CardStatistic from "./CardStatistic.vue";
import RecentActivity from "./RecentActivity.vue";
import Chart from "./Chart.vue";
export default { components: { CardStatistic, RecentActivity, Chart } };
</script>
<style>
</style>

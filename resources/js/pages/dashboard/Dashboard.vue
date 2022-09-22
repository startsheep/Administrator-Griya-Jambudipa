<template>
  <section class="section">
    <div class="section-header">
      <h4>Dashboard</h4>
    </div>
    <div class="row">
      <div class="col-lg-8">
        <div class="row">
          <div class="col-lg-6">
            <CardStatistic tittle="Pegawai" count="99" />
          </div>
          <div class="col-lg-6">
            <CardStatistic
              tittle="Customer"
              backgroundColor="success"
              icon="fas fa-people-roof"
              :count="count.customerActive"
            />
          </div>
          <div class="col-lg-6">
            <CardStatistic tittle="Pemborong" count="99" />
          </div>
          <div class="col-lg-6">
            <CardStatistic
              tittle="Borongan Pekerjaan"
              icon="fas fa-briefcase"
              :count="count.job"
              backgroundColor="warning"
            />
          </div>
          <div class="col-lg-4">
            <CardStatistic tittle=" Kavling" count="99" />
          </div>
          <div class="col-lg-4">
            <CardStatistic tittle=" Tipe Rumah" count="99" />
          </div>
          <div class="col-lg-4">
            <CardStatistic tittle="Transaksi" icon="fas fa-wallet" backgroundColor="info" :count="count.transaction" />
          </div>
          <div class="col-lg-12">
            <Chart />
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <RecentActivity style="position: sticky; top: 0" />
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
export default {
  components: { CardStatistic, RecentActivity, Chart },
  data() {
    return {
      count: {
        customerActive: 0,
        customerInactive: 0,
        employeeActive: 0,
        employeeInactive: 0,
        contractorActive: 0,
        contractorInactive: 0,
        houseTypeActive: 0,
        houseTypeInactive: 0,
        kavlingActive: 0,
        kavlingInactive: 0,
        transaction: 0,
        job: 0,
      },
    };
  },
  mounted() {
    this.getCount();
  },
  methods: {
    getCountCustomer() {
      const self = this;
      this.isLoading = true;
      const params = [].join("&");
      self.$store
        .dispatch("getData", ["dashboard/count-customer", params])
        .then((response) => {
          this.count.customerActive = response.data.customerActive;
          this.count.customerInactive = response.data.customerNoActive;
        });
    },
    getCountWholeJob() {
      const self = this;
      this.isLoading = true;
      const params = [].join("&");
      self.$store
        .dispatch("getData", ["dashboard/count-whole-job", params])
        .then((response) => {
          this.count.job = response.data.wholeJob;
        });
    },
    getCountTransaction() {
      const self = this;
      this.isLoading = true;
      const params = [].join("&");
      self.$store
        .dispatch("getData", ["dashboard/count-transaction", params])
        .then((response) => {
          this.count.transaction = response.data.transaction;
        });
    },
    getCount() {
      this.getCountCustomer();
      this.getCountWholeJob();
      this.getCountTransaction();
    },
  },
};
</script>
<style>
</style>

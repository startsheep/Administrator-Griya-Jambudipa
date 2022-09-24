<template >
  <section class="section">
    <!-- <div class="section-header">
        <h1>Detail {{ id }}</h1>
    </div> -->
    <div class="row mt-4">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h4>Rincian Borongan</h4>
          </div>
          <div class="card-body position-relative">
            <LoadingComponent v-if="isLoading" />
            <div class="row">
              <div class="col-12">
                <div class="area-body d-flex">
                  <div class="area-tittle mr-3">
                    <strong class="d-block">Nama PIC / Perusahaan</strong>
                    <span v-if="contract != null"
                      >{{ contract.contractor.picName }} -
                      {{ contract.contractor.companyName }}</span
                    >
                  </div>
                  <div class="area-tittle mr-3">
                    <strong class="d-block">Nama Customer</strong>
                    <span v-if="contract != null">{{
                      contract.customer.name
                    }}</span>
                  </div>
                  <div class="area-tittle mr-3">
                    <strong class="d-block">Nama Borongan</strong>
                    <span v-if="contract != null"
                      >Rumah TIpe {{ contract.houseType.houseType }}</span
                    >
                  </div>
                  <div class="area-tittle mr-3">
                    <strong class="d-block">Tanggal Pengerjaan</strong>
                    <span v-if="contract != null"
                      >{{ formatDate(contract.startDate) }} -
                      {{ formatDate(contract.endDate) }}</span
                    >
                  </div>
                  <div class="area-tittle mr-3">
                    <strong class="d-block">Tipe Pembayaran</strong>
                    <span v-if="contract != null"
                      >{{ contract.paymentType }}
                    </span>
                  </div>
                </div>
              </div>

              <div class="col-lg-8">
                <div class="area-body pt-0 mt-3">
                  <div class="area-tittle">
                    <h4>Total Biaya</h4>
                    <h6 v-if="contract">{{ cost }}</h6>
                  </div>
                  <div>
                    <div class="boxes">
                      <strong>Uang Muka : </strong>
                      <span>20%</span>
                      <span >{{ calcPercentage(20) }}</span>
                      <i class="fas fa-check-circle text-success fa-lg"></i>
                      <span>Lihat Bukti Pembayaran</span>
                    </div>
                    <div class="boxes">
                      <strong>Progress 50% : </strong>
                      <span>40%</span>
                      <span>{{ calcPercentage(40) }}</span>
                      <i class="fas fa-check-circle text-success fa-lg"></i>
                      <span>Lihat Bukti Pembayaran</span>
                    </div>
                    <div class="boxes">
                      <strong>Progress 50% : </strong>
                      <span>40%</span>
                      <span>{{ calcPercentage(40) }}</span>
                      <i class="fas fa-check-circle text-success fa-lg"></i>
                      <span>Lihat Bukti Pembayaran</span>
                    </div>
                    <div class="boxes">
                      <strong>Progress 100% : </strong>
                      <span>20%</span>
                      <span>Rp.20.000.000</span>
                      <i class="fas fa-check-circle text-success fa-lg"></i>
                      <span>Lihat Bukti Pembayaran</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="area-body mt-3">
                  <div class="area-tittle">
                    <h6>Deskripsi Borongan</h6>
                    <div
                      v-if="contract != null"
                      v-html="contract.description"
                    ></div>
                  </div>
                  <!-- <div v-html=""></div> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import LoadingComponent from "../../components/LoadingComponent.vue";
import Utils from "../../store/services/utils";
export default {
  props: ["id"],
  data() {
    return {
      contract: null,
      isLoading: false,
    };
  },
  watch: {
    id() {
      this.getContract();
    },
    immediate: true,
    deep: true,
  },
  mounted() {
    if (this.id != null) {
      this.getContract();
    }
  },
  computed: {
    cost() {
      return Utils.formatRupiah(this.contract.totalCost, "Rp.");
    },
  },
  methods: {
    formatRupiah(num){
         return Utils.formatRupiah(num, "Rp.");
    },
    formatDate(date) {
      return Utils.formateDateLocale(date);
    },
    calcPercentage(percent)
    {
      if(this.contract) return this.formatRupiah((this.contract.totalCost * percent) / 100);

    },
    getContract() {
      const self = this;
      this.isLoading = true;
      self.$store
        .dispatch("showData", ["whole-job/" + this.id])
        .then((response) => {
          this.contract = response.data;
          console.log(this.contract);
          this.isLoading = false;
        })
        .catch((error) => {
          this.isLoading = false;
        });
    },
  },
  components: { LoadingComponent },
};
</script>
<style scoped>
.area-body {
  /* align-items: center; */
  /* width: 100%; */
  /* height: 100px; */
  background-color: #fff;
  border-radius: 10px;
  padding: 10px;
  border: 1px solid #e4e4e4;
}
.area-tittle {
  width: 200px;
  padding: 15px;
  /* align-items: flex-start; */
  /* background-color: aliceblue; */
  /* box-shadow: inset 0px; */
  /* make shadow bottom rigth */
  /* box-shadow: 0px 0px 0px 1px #000000; */
}
.boxes {
  font-size: 20px;
  display: flex;
  gap: 15px;
  align-items: center;
  padding: 10px;
  border-radius: 10px;
  border: 1px solid #e4e4e4;
}
</style>

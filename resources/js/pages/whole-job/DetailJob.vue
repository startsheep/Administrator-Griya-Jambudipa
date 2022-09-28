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
                  <div v-if="contract != null && contract.customer" class="area-tittle mr-3">
                    <strong  class="d-block">Nama Customer</strong>
                    <span >{{
                      contract.customer.name
                    }}</span>
                  </div>
                  <div class="area-tittle mr-3">
                    <strong class="d-block">Nama Borongan</strong>
                    <span v-if="contract != null && contract.customer"
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

              <div v-if="contract" class="col-lg-8">
                <div
                  class="area-body pt-0 mt-2"
                >
                  <div class="area-tittle">
                    <h4>Total Biaya</h4>
                    <h5 v-if="contract">{{ cost }}</h5>
                  </div>
                  <div v-if="contract.paymentType == 'Termin'">
                    <div class="boxes">
                      <strong>Uang Muka : </strong>
                      <span>20%</span>
                      <span>{{ calcPercentage(20) }}</span>
                      <div v-if="true">
                        <i class="fa-solid fa-check-circle text-success fa-lg mr-2"></i>
                        <strong class="cursor">Lihat Bukti</strong>
                      </div>
                      <div v-else>
                        <i class="fa-solid fa-times-circle text-danger fa-lg mr-2"></i>
                        <span>Belum di bayar</span>
                      </div>
                    </div>
                    <div class="boxes">
                      <strong>Progress 50% : </strong>
                      <span>40%</span>
                      <span>{{ calcPercentage(40) }}</span>
                      <div v-if="true">
                        <i class="fa-solid fa-check-circle text-success fa-lg mr-2"></i>
                        <strong class="cursor">Lihat Bukti</strong>
                      </div>
                      <div v-else>
                        <i class="fa-solid fa-times-circle text-danger fa-lg mr-2"></i>
                        <span>Belum di bayar</span>
                      </div>
                    </div>
                    <div class="boxes">
                      <strong>Progress 50% : </strong>
                      <span>40%</span>
                      <span>{{ calcPercentage(40) }}</span>
                     <div v-if="false">
                        <i class="fa-solid fa-check-circle text-success fa-lg mr-2"></i>
                        <strong class="cursor">Lihat Bukti</strong>
                      </div>
                      <div v-else>
                        <i class="fa-solid fa-times-circle text-danger fa-lg mr-2"></i>
                        <span>Belum di bayar</span>
                      </div>
                    </div>
                    <div class="boxes">
                      <strong>Progress 100% : </strong>
                      <span>20%</span>
                      <span>{{ calcPercentage(20) }}</span>
                      <div v-if="false">
                        <i class="fa-solid fa-check-circle text-success fa-lg mr-2"></i>
                        <strong class="cursor">Lihat Bukti</strong>
                      </div>
                      <div v-else>
                        <i class="fa-solid fa-times-circle text-danger fa-lg mr-2"></i>
                        <span>Belum di bayar</span>
                      </div>
                    </div>
                    <div class="boxes">
                      <strong>Retensi : </strong>
                      <span>10%</span>
                      <span>{{ calcPercentage(10) }}</span>
                      <div v-if="false">
                        <i class="fa-solid fa-check-circle text-success fa-lg mr-2"></i>
                        <strong class="cursor">Lihat Bukti</strong>
                      </div>
                      <div v-else>
                        <i class="fa-solid fa-times-circle text-danger fa-lg mr-2"></i>
                        <span>Belum di bayar</span>
                      </div>
                    </div>
                  </div>
                  <!-- Upah -->
                  <div  v-if="contract.paymentType == 'Upah Kerja'">
                    <div class="boxes">
                      <strong>Minggu Ke 1 : </strong>
                      <!-- <span>20%</span> -->
                      <span>Rp. 21.100.000</span>
                      <div v-if="true">
                        <i class="fa-solid fa-check-circle text-success fa-lg mr-2"></i>
                        <strong class="cursor">Lihat Bukti</strong>
                      </div>
                      <div v-else>
                        <i class="fa-solid fa-times-circle text-danger fa-lg mr-2"></i>
                        <span>Belum di bayar</span>
                      </div>
                    </div>
                    <div class="boxes">
                      <strong>Minggu Ke 2 : </strong>
                      <!-- <span>20%</span> -->
                      <span>Rp. 20.100.000</span>
                      <div v-if="false">
                        <i class="fa-solid fa-check-circle text-success fa-lg mr-2"></i>
                        <strong class="cursor">Lihat Bukti</strong>
                      </div>
                      <div v-else>
                        <i class="fa-solid fa-times-circle text-danger fa-lg mr-2"></i>
                        <span>Belum di bayar</span>
                      </div>
                    </div>
                  </div>
                  <!-- full finance -->
                   <div v-if="contract.paymentType == 'Bayar Setelah Kerja'">
                    <div class="boxes">
                      <!-- <strong>Uang Muka : </strong> -->
                      <div v-if="true">
                        <div class="mr-2 d-inline">
                          <Strong class="d-block">Sudah Lunas</Strong>
                          <span>Pada tanggal </span>
                        </div>
                        <i
                          class="fa-solid fa-check-circle text-success fa-lg"
                        ></i>
                        <span class="cursor ml-3">Lihat Bukti</span>
                      </div>
                      <div v-else>
                        <i
                          class="fa-solid fa-times-circle text-danger fa-lg"
                        ></i>
                        <span class="ml-3">Belum Dilakukan Pembayaran</span>
                      </div>
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
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="area-body d-flex">
                  <div class="area-tittle mr-3">
                    <strong class="d-block">Status</strong>
                    <div v-if="contract != null">
                      <div
                        v-html="
                          checkStatus(contract.startDate, contract.endDate)
                        "
                      ></div>
                    </div>
                  </div>
                  <div class="area-tittle mr-3">
                    <strong class="d-block">Tanggal Dibuat</strong>
                    <span v-if="contract != null">{{
                      formatDate(contract.createdAt)
                    }}</span>
                  </div>
                  <div class="area-tittle mr-3">
                    <strong class="d-block">Tanggal Diperbarui</strong>
                    <span v-if="contract != null">{{
                      formatDate(contract.updatedAt)
                    }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button class="btn-block btn btn-primary" @click="$router.back">
              Kembali
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import LoadingComponent from "../../components/LoadingComponent.vue";
import Utils from "../../store/services/utils";
import moment from "moment";
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
    checkStatus(s, e) {
      let start = moment(s);
      let end = moment(e);
      let now = moment();
      if (moment().isBetween(start, end)) {
        return ` <span class="badge badge-info">Sedang Dikerjakan</span>`;
      } else if (now.isAfter(end)) {
        return ` <span class="badge badge-success">Selesai Dikerjakan</span>`; //Selesai Dikerjakan
      } else {
        return ` <span class="badge badge-warning">Belum Dikerjakan</span>`; //Belum dikerjakan
      }
    },
    formatRupiah(num) {
      return Utils.formatRupiah(num, "Rp.");
    },
    formatDate(date) {
      return Utils.formateDateLocale(date);
    },
    calcPercentage(percent) {
      if (this.contract)
        return this.formatRupiah((this.contract.totalCost * percent) / 100);
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
  border-bottom: 1px solid #e4e4e4;
}
</style>

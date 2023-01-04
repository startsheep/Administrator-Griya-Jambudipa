<template>
  <Modal
    tittle="Detail Transaksi"
    idModal="detailPayment"
    :confirmBtn="false"
    displayBtn="btn-block"
  >
    <template v-slot:body>
      <!-- <div class="alert alert-primary alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    <b>Info!</b> Dibawah ini merupakan hasil rekapitulasi
                    pembayaran
                </div>
            </div> -->
      <div class="card" v-if="transaction != null">
        <LoadingComponent v-if="isLoading" />
        <div class="card-body">
          <div class="summary">
            <div
              class="summary-info bg-white"
              v-if="transaction.customer != null"
            >
              <div class="my-2">
                <img
                  :src="'storage/' + transaction.customer.image"
                  alt=""
                  class="avatar avatar-lg"
                />
              </div>
              <h5>{{ transaction.customer.name }}</h5>
              <strong class="d-block"
                >Tipe Pembayaran {{ transaction.type }}</strong
              >
              <strong
                >Kavling Block {{ transaction.kavling.block }}, Nomor
                {{ transaction.kavling.numberKavling }}</strong
              >
              <strong class="d-block"
                >Tipe Rumah
                {{ transaction.kavling.houseType.houseType }}</strong
              >
            </div>
            <div class="summary-item">
              <h6>
                Total
                <span v-if="transaction.paymentPrice != null" class="text-muted"
                  >({{ transaction.paymentPrice.length }} Transaksi)</span
                >
              </h6>

              <ul class="list-unstyled list-unstyled-border">
                <div class="overflow-auto" style="height: 150px">
                  <li
                    class="media"
                    v-for="(history, index) in transaction.paymentPrice"
                  >
                    <a href="#">
                      <div class="numeric-counter mr-2">
                        {{ index + 1 }}
                      </div>
                    </a>
                    <div class="media-body">
                      <div class="media-right">
                        <i
                          @click="
                            toDoc(
                              filterDocByDate(history.createdAt)[0].documentPath
                            )
                          "
                          class="fa-solid fa-info-circle fa-lg cursor"
                        ></i>
                      </div>
                      <div class="media-title">
                        {{ formatRupiah(history.price) }}
                      </div>
                      <div class="text-muted text-small">
                        {{ formatDateTime(history.createdAt) }}
                      </div>
                    </div>
                  </li>
                </div>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </template>
  </Modal>
</template>
<script>
import Modal from "../../components/Modal.vue";
import Axios from "axios";
import Utils from "../../store/services/utils";
import LoadingComponent from "../../components/LoadingComponent.vue";
export default {
  props: ["id"],
  data() {
    return {
      transaction: null,
      isLoading: false,
    };
  },
  watch: {
    id: function (val) {
      this.getTransaction();
    },
  },
  mounted() {
    this.getTransaction();
  },
  methods: {
    filterDocByDate(date) {
      return this.transaction.document.filter((item) => {
        return item.createdAt == date;
      });
    },
    toDoc(path) {
      console.log(path);
      // this.$router.push('storage/'+path)
      // to blank page with tag a
      window.open("storage/" + path, "_blank");
    },
    randomColor() {
      // create and calculate random color
      let r = Math.floor(Math.random() * 255);
      let g = Math.floor(Math.random() * 255);
      let b = Math.floor(Math.random() * 255);
      let a = 0.5;
      return `rgba(${r},${g},${b},${a})`;
    },
    formatDateTime(date) {
      return Utils.formateDateTimeLocale(date);
    },
    formatRupiah(number) {
      return Utils.formatRupiah(number, "Rp. ");
    },
    getTransaction() {
      this.isLoading = true;
      this.$store
        .dispatch("getData", ["transaction/" + this.id])
        .then((response) => {
          this.transaction = response.data;
          this.isLoading = false;
        });
    },
  },
  components: { Modal, LoadingComponent },
};
</script>
<style>
.numeric-counter {
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  color: black;
  /* border radius circle */
  border-radius: 50%;
  /* border */
  border: 1px solid #ccc;
  /* font size */
  font-size: 20px;
  /* font weight */
  font-weight: bold;
  background-color: rgb(236, 236, 236);
}
</style>

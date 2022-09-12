<template>
  <div class="collapse" id="formCreate">
    <div class="row d-flex justify-content-center">
      <div class="card" style="width: 80%">
        <div class="card-header">
          <h4>Formulir Pembayaran / Setoran</h4>
        </div>
        <div class="card-body">
          <div class="alert alert-primary alert-dismissible show fade mb-4">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>×</span>
              </button>
              <b>Info!</b> Form ini merupakan untuk penyetoran / Pembayaran
              customer.
            </div>
          </div>
          <div class="form-col">
            <div class="row">
              <div class="col" :class="{ 'col-12': !selectedCustomer }">
                <div class="form-group">
                  <label>Nama</label>
                  <select
                    @change="selectCustomer(this)"
                    ref="fieldCustomer"
                    class="form-control"
                    v-model="payment.customerId"
                  >
                    <option
                      :key="customer.id"
                      v-for="customer in customers"
                      :value="customer.id"
                    >
                      {{ customer.name }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="col">
                <div v-if="selectedCustomer" class="form-group">
                  <label>Blok / Kavling </label>
                  <select
                    class="form-control"
                    @change="getHouse"
                    v-model="selectedKavling"
                  >
                    <option
                      v-for="kavling in selectedCustomer.customerKavling"
                      :value="kavling.kavling"
                      :key="kavling"
                    >
                      {{ kavling.kavling.block }} -
                      {{ kavling.kavling.numberKavling }}
                    </option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row" v-if="house">
              <div class="col">
                <!-- <div class="form-group">
                            <label>Referral</label>
                            <select class="form-control" v-model="payment.type">
                                <option value="Cash Keras">G0323J-Ahmad</option>
                                <option value="Cash Keras">G0323J-Ahmad</option>
                                <option value="Cash Keras">G0323J-Ahmad</option>
                            </select>
                          </div> -->
              </div>
              <div class="col m-auto">
                <div class="box d-flex">
                  <div class="mr-5">
                    <span> Tipe Rumah : </span>
                    <Span>
                      {{ house.houseType }}
                    </Span>
                  </div>
                  <div>
                    <span> Harga : </span>
                    <Span>
                      {{ formatRupiah(house.price) }}
                    </Span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label>Jenis Pembayaram</label>
                  <select class="form-control" v-model="payment.type">
                    <option value="Cash Keras">Cash Keras</option>
                    <option value="Cash Bertahap">Cash Bertahap</option>
                    <option value="KPR">KPR</option>
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label>Setoran</label>
                  <!-- <input
                            v-model="payment.price"
                            type="text"
                            class="form-control"
                            @change="formatRupiah(payment.price)"
                            /> -->
                  <InputCurrency
                    :value="payment.price"
                    v-model="payment.price"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <button class="btn btn-primary btn-block" @click="createPayment()">
            Simpan
          </button>
          <button
            data-toggle="collapse"
            data-target="#formCreate"
            class="btn btn-danger btn-block"
            @click="resetForm"
          >
            Batal
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Cookie from "js-cookie";
import InputCurrency from "../../components/InputCurrency.vue";
import Utils from "../../store/services/utils";
import iziToast from "izitoast";
export default {
  data() {
    return {
      payment: {
        id: "",
        customerId: "",
        employeeId: "",
        type: "",
        price: "",
      },
      customers: [],
      house: null,
      selectedCustomer: null,
      selectedKavling: null,
      house: null,
    };
  },
  watch: {
    // watch selected kavling for change

  },
  computed: {
    submit() {
      this.$emit("onSubmit", [this.payment, this.selectedKavling]);
    },
    idEmployee() {
      return Cookie.get("id");
    },
  },
  mounted() {
    this.getCustomers();
  },

  methods: {
    formatRupiah(value) {
      return Utils.formatRupiah(value, "Rp. ");
    },
    createPayment() {
      const self = this;
      const url = [
        "payment",
        {
          customer_id: this.payment.customerId,
          employee_id: this.idEmployee,
          houseTypeId: this.selectedKavling.houseTypeId,
          type: this.payment.type,
          price: Utils.currencyToNumber(this.payment.price),
        },
      ];
      self.$store
        .dispatch("postData", url)
        .then((res) => {
          this.$emit("onSuccess");
          $("#formCreate").collapse("hide");
          this.resetForm();
        })
        .catch((err) => {
          let messages = err.response.data.meta.message;
          Object.entries(messages).forEach(([key, value]) => {
            iziToast.warning({
              title: "Warning",
              message: value,
              position: "topRight",
            });
          });
        });
    },
    selectCustomer() {
      this.customers.filter((cs) => {
        if (cs.id == this.$refs["fieldCustomer"].value) {
          this.selectedCustomer = cs;
        }
      });
    },
    showNameCustomer(id) {
      let name = "";
      this.customers.forEach((customer) => {
        if (customer.id == id) {
          name = customer.name;
        }
      });
      return name;
    },

    getHouse() {
      this.$store
        .dispatch("getData", ["house-type/" + this.selectedKavling.houseTypeId])
        .then((res) => {
          this.house = res.data;
        });
    },
    getCustomers() {
      const self = this;
      self.$store.dispatch("getData", ["customer"]).then((res) => {
        self.customers = res.data;
      });
    },
    resetForm() {
      this.payment = {
        id: "",
        customerId: "",
        employeeId: "",
        type: "",
        price: "",
      };
      this.selectedCustomer = null;
      this.selectedKavling = null;
      this.house = null;
    },
  },
  components: { InputCurrency },
};
</script>
<style>
</style>

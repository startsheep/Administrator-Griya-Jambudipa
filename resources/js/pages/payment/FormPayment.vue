<template>
    <div class="collapse" id="formCreate">
      <div class="row d-flex justify-content-center">
        <div class="card" style="width: 80%">
          <LoadingComponent1 v-if="isLoading" />
          <div class="card-header">
            <h4>Formulir Pembayaran</h4>
          </div>
          <!-- <LoadingComponent v-if="isLoading" /> -->
          <div class="card-body">
            <div class="alert alert-primary alert-dismissible show fade mb-4">
              <div class="alert-body">
                <button class="close" data-dismiss="alert">
                  <span>×</span>
                </button>
                <b>Info!</b> Form ini merupakan untuk Penyetoran / Pembayaran
                Customer, Pastikan data yang masukan sudah benar
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
                        v-for="kavling in customerKavling"
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
  
              <div class="row">
                <div class="col-3">
                  <div class="form-group">
                    <label>Jenis Pembayaran</label>
                    <select class="form-control" v-model="payment.type">
                      <option value="Cash Keras">Cash Keras</option>
                      <option value="Cash Bertahap">Cash Bertahap</option>
                      <option value="KPR">KPR</option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Diskon</label>
                    <small>(Rentang 1 - 100%)</small>
                    <input
                      v-model="payment.discount"
                      type="text"
                      class="form-control"
                              />
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Pembangunan Lainnya</label>
                    <input
                      v-model="payment.developName"
                      type="text"
                      class="form-control"
                      placeholder="Pembangunan lain "
                              />
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Biaya Tambahan</label>
                    <InputCurrency 
                      :value="payment.developPrice"
                      v-model="payment.developPrice"/>
                  </div>
                </div>
                <div class="col is-full mb-2">
                  <div class="box d-flex justify-content-start mb-2">
                    <div class="row">
                      <div class="ml-4">
                        <strong> Tipe Rumah : </strong>
                        <strong v-if="house">
                          {{ house.houseType }}
                        </strong>
                      </div>
                      <div class="ml-5">
                        <strong> Harga : </strong>
                        <strong v-if="house">
                          {{ formatRupiah(house.price) }}
                        </strong>
                      </div>
                      <div class="ml-5">
                        <strong> Diskon : </strong>
                        <strong v-if="house">{{formatRupiah(countDiscount())}}</strong>
                      </div>
                      <div class="ml-5">
                        <strong> Total : </strong>
                        <strong v-if="house">{{formatRupiah(countPayment())}}</strong>
                      </div>
                    </div>
                    <!-- <div class="column">
                      <div class="ml-5 mb-2">
                        <strong> Harga : </strong>
                        <strong v-if="house">
                          {{ formatRupiah(house.price) }}
                        </strong>
                      </div>
                      <div class="ml-5">
                        <strong> Total : </strong>
                        <strong v-if="house">{{formatRupiah(countPayment())}}</strong>
                      </div>
                    </div> -->
                  </div>
                </div>
              </div>
              <!-- <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label>Pembangunan Lainnya</label>
                    <input
                      v-model="payment.developName"
                      type="text"
                      class="form-control"
                      placeholder="Pembangunan Lainnya"
                              />
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Biaya Tambahan</label>
                    <InputCurrency 
                      :value="payment.developPrice"
                      v-model="payment.developPrice"/>
                  </div>
                </div>
              </div> -->
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Referral</label>
                    <select class="form-control" v-model="payment.employeeId">
                      <option
                        v-for="employee in employees"
                        :key="employee"
                        :value="employee.id"
                      >
                        <span
                          >{{ employee.referalCode }} || {{ employee.name }}</span
                        >
                      </option>
                    </select>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Uang Masuk</label>
                    <InputCurrency
                      :value="payment.price"
                      v-model="payment.price"
                    />
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label>Komisi</label>
                    <InputCurrency
                      :value="payment.commission"
                      v-model="payment.commission"
                    />
                  </div>
                </div>
                <div class="col-6">
                  <div class="custom-file form-group">
                    <input
                      @change="selectDocuments"
                      type="file"
                      class="custom-file-input"
                      multiple
                    />
                    <label class="custom-file-label" for="customFile"
                      >Pilih Dokumen</label
                    >
                  </div>
                </div>
                <div class="col-6">
                  <span class="d-block">Dokumen</span>
                  <div
                    v-for="document in payment.documents"
                    :key="document"
                    class="badge badge-primary m-1 p-2"
                  >
                    {{ document.name }}
                    <i
                      class="fas fa-times sortable"
                      @click="removeDocument(document)"
                    ></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <button
              class="btn btn-primary btn-block"
              @click="createPayment()"
              :class="{ 'disabled btn-progress': isSubmit }"
            >
              Simpan
            </button>
            <button
              data-toggle="collapse"
              data-target="#formCreate"
              class="btn btn-danger btn-block"
              @click="resetForm"
              :disabled="isSubmit"
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
  import LoadingComponent from "../../components/LoadingComponent.vue";
  import LoadingComponent1 from "../../components/LoadingComponent.vue";
  
  export default {
    data() {
      return {
        payment: {
          id: "",
          customerId: "",
          employeeId: "",
          type: "",
          price: "",
          commission: "",
          documents: [],
          developName: null,
          developPrice: null,
          discount:"",
        },
        // discount:'',
        customers: [],
        employees: [],
        previewImages: [],
        customerKavling: [],
        house: null,
        selectedCustomer: null,
        selectedKavling: null,
        house: {
            price:'',
        },
        isLoading: false,
        isSubmit: false,
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
      formData() {
        const formData = new FormData();
        formData.append("customer_id", this.payment.customerId);
        formData.append("employee_id", this.payment.employeeId);
        formData.append(
          "commission",
          Utils.currencyToNumber(this.payment.commission)
        );
        if (this.selectedKavling) {
          formData.append("kavling_id", this.selectedKavling.id);
        }
  
        formData.append("type", this.payment.type);
        formData.append("price", Utils.currencyToNumber(this.payment.price));
        formData.append("discount", this.payment.discount);
        formData.append("develop_name", this.payment.developName);
        if(this.payment.developPrice != null){
            formData.append("develop_price", Utils.currencyToNumber(this.payment.developPrice )  );
        }
        this.payment.documents.forEach((document, index) => {
          formData.append("documents[" + index + "]", document);
        });
        return formData;
      },
    },
    mounted() {
      this.getCustomers();
      this.getEmployees();
    },
  
    methods: {
      countPayment(){
        let result = Utils.currencyToNumber(this.house.price ?? 'Rp. 0') + Utils.currencyToNumber(this.payment.developPrice ?? 'Rp. 0') - this.house.price * this.payment.discount / 100;
        // let result = this.house.price + this.payment.developPrice - this.house.price * this.payment.discount / 100;
        return result;
      },
    countDiscount(){
        let results = this.house.price * this.payment.discount / 100;
        return results;
    },
      removeDocument(doc) {
        this.payment.documents.splice(this.payment.documents.indexOf(doc), 1);
      },
      formatRupiah(value) {
        return Utils.formatRupiah(value, "Rp. ");
      },
      formatPercent(number, float) {
        //    percent = parseFloat(number * 100).toFixed(float) + "%";
        //    percent = number * 100 + "%";
           percent = number *100 /100 + "%";
          return percent;
      },
      checkIsDocument(file) {
        return Utils.checkIsDocument(file);
      },
  
      selectDocuments(e) {
        const files = e.target.files;
        for (let i = 0; i < files.length; i++) {
          if (this.checkIsDocument(files[i])) {
            this.payment.documents.push(files[i]);
          } else {
            iziToast.warning({
              title: "Peringatan",
              message: "File harus berupa dokumen",
              position: "topRight",
            });
          }
        }
      },
  
      createPayment() {
        const self = this;
        let type = "postDataUploadPayment";
        this.isLoading = true;
        this.isSubmit = true;

        if(this.payment.developPrice != null && this.payment.developName === null){
            this.isLoading =false
            this.isSubmit = false;
           iziToast.warning({
                title: "Peringatan",
                message: "Deskripsi Pembangunan Lainnya Harap Diisi",
                position: "topRight",
              });
        }else{
            self.$store
          .dispatch(type, this.formData, "payment")
          .then((res) => {
            this.$emit("onSuccess");
            $("#formCreate").collapse("hide");
            this.resetForm();
            this.isLoading = false;
            this.isSubmit = false;
        })
        .catch((err) => {
              this.isSubmit = false;
            this.isLoading = false;
            let messages = err.response.data.meta.message;
            Object.entries(messages).forEach(([key, value]) => {
              iziToast.warning({
                title: "Peringatan",
                message: value,
                position: "topRight",
              });
              this.isLoading = false;
              this.isSubmit = false;
            });
          });
        }
       
      },
      selectCustomer() {
        this.customers.filter((cs) => {
          if (cs.id == this.$refs["fieldCustomer"].value) {
            this.selectedCustomer = cs;
          }
        });
        this.getKavling(this.selectedCustomer.id);
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
      getEmployees() {
        const self = this;
        const params = ["position=Marketing"].join("&");
        self.$store.dispatch("getData", ["employee", params]).then((res) => {
          self.employees = res.data;
        });
      },
      getKavling(id) {
        const self = this;
        self.$store.dispatch("getData", ["kavling/check/" + id]).then((res) => {
          this.customerKavling = res.data;
        });
      },
      resetForm() {
        this.payment = {
          id: "",
          customerId: "",
          employeeId: "",
          type: "",
          price: "",
          discount:"",
          developName: "",
          developPrice: null,

          documents: [],
        };
        this.selectedCustomer = null;
        this.selectedKavling = null;
        this.house = null;
      },
    },
    components: { InputCurrency, LoadingComponent, LoadingComponent1 },
  };
  </script>
  <style></style>
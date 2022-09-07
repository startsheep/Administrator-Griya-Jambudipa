<template>
  <section class="section">
    <div class="section-header">
      <h4>Pembayaran</h4>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <span class="badge badge-danger"> .</span>
              <span style="font-weight: bold"> Belum Lunas </span>
            </div>
            <div class="col-12 mt-2">
              <span class="badge badge-success"> .</span>
              <span style="font-weight: bold"> Sudah Lunas </span>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="collapse " id="formCreate">
            <div class="row d-flex justify-content-center">
                  <div class="card" style="width:80%">
              <div class="card-header">
                <h4>Formulir Pembayaran / Setoran </h4>
              </div>
              <div class="card-body">
                <div class="alert alert-primary alert-dismissible show fade mb-4">
                      <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                          <span>×</span>
                        </button>
                        <b>Info!</b> Form ini merupakan untuk penyetoran / Pembayaram customer.
                      </div>
                    </div>
                <div class="form-col">
                    <div class="row">
                        <div class="col" :class="{'col-12': !selectedCustomer}">

                            <div class="form-group">
                              <label>Nama</label>
                              <select @change="selectCustomer(this)" ref="fieldCustomer" class="form-control" v-model="payment.customerId">
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
                        <select class="form-control"  @change="getHouse" v-model="selectedKavling">
                          <option v-for="kavling in selectedCustomer.customerKavling"  :value="kavling.kavling" :key="kavling">{{ kavling.kavling.block }} - {{ kavling.kavling.numberKavling }}</option>
                        </select>
                      </div>
                        </div>
                    </div>

                  <div class="row " v-if="house">
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
                                <span>
                                Tipe Rumah :
                            </span>
                            <Span>
                                {{ house.houseType }}
                            </Span>
                            </div>
                            <div>
                             <span>
                                Harga :
                            </span>
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
                            <input
                            v-model="payment.price"
                            type="text"
                            class="form-control"
                            @change="formatRupiah(payment.price)"
                            />
                          </div>
                      </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <button
                  class="btn btn-primary btn-block"
                  @click="createPayment"
                >
                  Simpan
                </button>
                <button
                  data-toggle="collapse"
                  data-target="#formCreate"
                  class="btn btn-danger btn-block"
                  @click="reset"
                >
                  Batal
                </button>
              </div>
            </div>
            </div>

          </div>
          <div class="card">
            <div class="card-header">
              <Button
                data-toggle="collapse"
                data-target="#formCreate"
                class="btn btn-primary"
              >
                Tambah Pembayaran
              </Button>
            </div>
            <div class="card-body">
              <div class="row mb-2 d-flex justify-content-between" >
                <div class="col-lg-6">
                 <ButtonsExport :printData="false" />
                </div>
                <div class="col-lg-4">
                  <input
                    v-on:keyup="search"
                    class="form-control"
                    placeholder="Search"
                  />
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-striped" style="font-size:12px">
                  <thead>
                    <tr>
                      <th >Nama</th>
                      <th >Nomor telepon</th>
                      <th >Blok / Kavling</th>
                      <th >Tipe Rumah</th>
                      <th >Harga Rumah</th>
                      <th >Sisa Angsuran</th>
                      <th >Tipe Pembayaran</th>
                      <th class="text-center" >Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="payment in payments" :key="payment">
                      <td>
                        <div class="media">
                          <figure class="avatar mr-2 avatar-md">
                            <img
                              :src="'storage/' + payment.customer.image"
                              alt="..."
                            />
                            <i
                              v-if="payment.reminderPayment > 0"
                              class="avatar-presence busy"
                            ></i>
                            <i v-else class="avatar-presence online"></i>
                          </figure>

                          <div class="media-body">
                            <div class="media-title">
                              {{ payment.customer.name }}
                            </div>
                            <div class="text-job text-muted">
                              <span>{{
                                showLogUpdate(payment.updatedAt)
                              }}</span>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td>{{ payment.customer.phone }}</td>
                      <td>{{ payment.block.block}}-{{ payment.block.numberKavling }}</td>
                      <td>{{ payment.houseType.houseType}}</td>
                      <td>{{ formatRupiah(payment.houseType.price) }}</td>
                      <td>{{  formatRupiah(payment.reminderPayment)}}</td>
                      <td>
                        <span
                          :class="
                            'badge badge-' + showTypePayment(payment.type)
                          "
                        >
                          {{ payment.type }}
                        </span>
                      </td>
                      <td class="align-middle text-center">
                        <div class="show">
                          <button
                            data-toggle="dropdown"
                            class="btn btn-transparent"
                          >
                            <i
                              class="
                                fa-solid fa-ellipsis-vertical
                                dropdown-toggle
                              "
                              aria-expanded="true"
                            ></i>
                          </button>
                          <div class="dropdown-menu action">
                            <button
                              class="dropdown-item action sortable"
                              data-toggle="collapse"
                              data-target="#formCreate"
                              @click="sendEdit(payment)"
                            >
                              Setor
                            </button>
                            <button class="dropdown-item action sortable">
                              Detail
                            </button>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <CircleLoader v-if="isLoading" />
              </div>
            </div>
            <div class="card-footer">
              <Pagination
                :currentPage="pagination.currentPage"
                :rowsTotal="pagination.total"
                :lastPage="pagination.lastPage"
                @onPageChange="onPageChange($event)"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import moment from "moment";
import Cookie from "js-cookie";
import iziToast from "izitoast";
import Pagination from "../../components/Pagination.vue";
import CircleLoader from "../../components/CircleLoader.vue";
import Utils from "../../store/services/utils";
import ButtonsExport from "../../components/ButtonsExport.vue";
export default {
  components: {
    Pagination,
    CircleLoader,
    ButtonsExport
},
  data() {
    return {
      //data
      payment: {
        id: "",
        customerId: "",
        employeeId: "",

        type: "",
        price: "",
      },

      house: null,
      payments: [
        //  make same data with deferent value
      ],
      customers: [],
      selectedCustomer: null,
      selectedKavling: null,
      isLoading: false,
      typePayment: [
        {
          type: "Cash Keras",
          color: "success",
        },
        {
          type: "Cash Bertahap",
          color: "danger",
        },
        {
          type: "KPR",
          color: "info",
        },
      ],
      // paginations
      pagination: {
        total: 0,
        perPage: 5,
        currentPage: 1,
        lastPage: 0,
        page: 0,
      },
    };
  },
  watch: {
    selectedCustomer(newVal){
        this.selectedCustomer = newVal

    }
  },
  mounted() {
    this.getPayments();
    this.getCustomers();
    // if(this.selectedKavling != null){
    //     this.getHouse()
    // }
  },
  computed: {
    idEmployee() {
      return Cookie.get("id");
    },
  },
  watch: {},
  methods: {

    getHouse(){
    const self = this;
      this.$store.dispatch("getData", ["house-type/"+ this.selectedKavling.houseTypeId]).then((res) => {
            this.house = res.data
      });
    },
    selectCustomer(){
        this.customers.filter((cs)=>{
            if(cs.id == this.$refs['fieldCustomer'].value){
                this.selectedCustomer = cs
            }
        })
    },
    showNameCustomer(id){
            let name =''
            this.customers.forEach((customer) => {
                if (customer.id == id) {
                    name = customer.name;
                }
            });
            return name
        },
    getBlocks(array) {
      //    getblock name between comma
      let blocks = [];
      array.forEach((element) => {

        blocks.push(element.kavling.block);
      });
      return blocks.join(", ");
    },
    formatRupiah(number) {
      return Utils.formatRupiah(number, "Rp. ");
    },
    calcReferral(percent , number){
        return Utils.calcReferral(percent , number)
    },
    showLogUpdate(date) {
      return moment(date).fromNow();
    },
    showTypePayment(type) {
        if(type)return this.typePayment.find((item) => item.type === type).color;
    },
    getPayments() {
      const self = this;
      this.isLoading = true;
      const params = [
        //   `name=${this.name}`,
        // `position=${this.name}`,
        `order_direction=${this.order_direction}`,
        `page=${this.pagination.page}`,
        `per_page=${this.pagination.perPage}`,
      ].join("&");
      self.$store.dispatch("getData", ["payment", params]).then((res) => {
        console.log(res.data)
        self.payments = res.data;
        self.pagination.total = res.meta.total;
        self.pagination.currentPage = res.meta.currentPage;
        self.pagination.lastPage = res.meta.lastPage;
        this.isLoading = false;
      });
    },
    onPageChange(page) {
      this.pagination.page = page;
      this.getPayments();
    },
    onSuccess() {
      this.getPayments();
      this.reset();
    },
    getCustomers() {
      const self = this;
      self.$store.dispatch("getData", ["customer"]).then((res) => {
        self.customers = res.data;
      });
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
          price: this.payment.price,
        },
      ];
      self.$store
        .dispatch("postData", url)
        .then((res) => {
          iziToast.success({
            title: "Success",
            message: "Data berhasil ditambahkan",
            position: "topRight",
          });
          $("#formCreate").collapse('hide');
          self.onSuccess();
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
    editPayment(){
        const self = this;
        const url = [
          "payment",
          {
          customer_id: this.payment.customerId,
          employee_id: this.idEmployee,
          price: this.payment.price,
          },
        ];
        self.$store.dispatch('postData' ,url).then(
              res=>{
                iziToast.success({
                  title: "Success",
                  message: "Data berhasil diubah",
                  position: "topRight",
                });
                $("#formEdit").collapse('hide');
                self.onSuccess();
                self.reset()
              }
        )
    },
    sendEdit(payment){
        // this.payment.customerId= payment.customer.id

        this.selectedCustomer = payment.customer
    },
    delete(id) {
      const self = this;
      this.$swal
        .fire({
          title: "Yakin ?",
          text: "Data akan dihapus",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Hapus!",
          cancelButtonText: "Batal",
        })
        .then((result) => {
          if (result.isConfirmed) {
            self.$store
              .dispatch("deleteData", ["payment", id])
              .then((response) => {
                iziToast.success({
                  title: "Success",
                  message: "Data berhasil dihapus",
                  position: "topRight",
                });
                self.getPayments();
              });
          }
        });
    },
    reset(){
        this.payment = {
            id: "",
            customerId: "",
            employeeId: "",
            type: "",
            price: "",
        },
        this.selectedCustomer = null
        this.selectedKavling = null
        this.house = null

    }
  },
};
</script>
<style >
    table th {

    padding: 0 15px !important;
    height: 60px;
    vertical-align: middle;
}
.avatar .avatar-presence {
  top: 0 !important;
}
.box {
  border: 1px solid #e5e5e5;
  border-radius: 5px;
  padding: 10px;
  background-color: #E6EFFF;
  margin: auto;
}
</style>

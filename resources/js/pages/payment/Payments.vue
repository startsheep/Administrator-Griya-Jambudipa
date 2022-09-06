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
          <div class="collapse" id="formCreate">
            <div class="card">
              <div class="card-header">
                <h4>Tambah Pembayaran</h4>
              </div>
              <div class="card-body">
                <div class="form-col">
                  <div class="form-group">
                    <label>Nama</label>
                    <select class="form-control" v-model="payment.customerId">
                      <option
                        :key="customer.id"
                        v-for="customer in customers"
                        :value="customer.id"
                      >
                        {{ customer.name }}
                      </option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Jenis Pembayaram</label>
                    <select class="form-control" v-model="payment.type">
                      <option value="Cash Keras">Cash Keras</option>
                      <option value="Cash Bertahap">Cash Bertahap</option>
                      <option value="KPR">KPR</option>
                    </select>
                  </div>
                  <!-- <div class="form-group">
                                <label for="name">Blok</label>
                                <select  class="form-control"></select>
                            </div> -->
                  <div class="form-group">
                    <label>Cicilan</label>
                    <input
                    v-model="payment.price"
                    type="text"
                    class="form-control"
                    @change="formatRupiah(payment.price)"
                    />
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
                >
                  Batal
                </button>
              </div>
            </div>
          </div>
          <!-- <div class="collapse" id="formEdit">
            <div class="card">
              <div class="card-header">
                <h4>Form Angsuran {{ showNameCustomer(payment.customerId)}}</h4>
              </div>
              <div class="card-body">
                <div class="form-col">
                  <div class="form-group">
                    <label>Cicilan</label>
                    <input
                      v-model="payment.price"
                      type="text"
                      class="form-control"
                    />
                  </div>
                </div>
              </div>
              <div class="card-body">
                <button
                  class="btn btn-primary btn-block"
                  @click="editPayment"
                >
                  Simpan
                </button>
                <button
                  data-toggle="collapse"
                  data-target="#formEdit"
                  class="btn btn-danger btn-block"
                >
                  Batal
                </button>
              </div>
            </div>
          </div> -->
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
              <div class="row">
                <div class="col-lg-8">
                  <div class="btn-group-sm mb-3">
                    <button
                      data-toggle="modal"
                      data-target="#modal-create"
                      type="button"
                      class="btn btn-icon icon-rigth btn-primary mr-2"
                    >
                      EXPORT PDF <i class="fa-solid fa-file-pdf"></i>
                    </button>
                    <button
                      type="button"
                      class="btn btn-icon icon-rigth btn-primary mr-2"
                    >
                      EXPORT EXCEL <i class="fa-solid fa-file-excel"></i>
                    </button>
                  </div>
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
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th width="20%">Nama</th>
                      <th width="5%">Blok</th>
                      <th width="10%">Nomor telepon</th>
                      <th width="10%">Angsuran</th>
                      <th width="15%">Sisa Angsuran</th>
                      <th width="10%">Tipe Pembayaran</th>
                      <th class="text-center" width="5%">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="payment in payments" :key="payment">
                      <td>
                        <div class="media">
                          <figure class="avatar mr-2 avatar-md">
                            <img
                              src="../../../../public/assets/images/avatar/avatar-1.png"
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
                      <td>{{ getBlocks(payment.customer.customerKavling) }}</td>
                      <td>{{ payment.customer.phone }}</td>
                      <td>{{ formatRupiah(payment.priceHouse) }}</td>
                      <td>{{ formatRupiah(payment.reminderPayment) }}</td>
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
                            <!-- <button
                              class="dropdown-item action sortable"
                              data-toggle="collapse"
                              data-target="#formEdit"
                              @click="sendEdit(payment)"
                            >
                              Nyicil
                            </button> -->
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
export default {
  components: {
    Pagination,
    CircleLoader,
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

      payments: [
        //  make same data with deferent value
      ],
      customers: [],
      isLoading: false,
      selectedCustomer: null,
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
  mounted() {
    this.getPayments();
    this.getCustomers();
  },
  computed: {
    idEmployee() {
      return Cookie.get("id");
    },
  },
  watch: {},
  methods: {
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
        // `order_direction=${this.order_direction}`,
        // `page=${this.pagination.page}`,
        // `per_page=${this.pagination.perPage}`,
      ].join("&");
      self.$store.dispatch("getData", ["payment", params]).then((res) => {
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
        this.payment.id = payment.id
        this.payment.customerId= payment.customer.id
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
        }
    }
  },
};
</script>
<style>
.avatar .avatar-presence {
  top: 0 !important;
}
</style>

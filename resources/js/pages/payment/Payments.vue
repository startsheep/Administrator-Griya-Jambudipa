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
          <FormPayment @onSuccess="onSuccess()" />
          <FormDepo :id="idPayment" @onSuccess="onSuccess()" />
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
              <div class="row mb-2 d-flex justify-content-between">
                <div class="col-lg-6">
                  <div class="" :class="'btn-group-sm'">
                    <a
                      :href="links.excel"
                      target="_parent"
                      class="btn btn-icon icon-rigth btn-primary mr-2"
                    >
                      Export Data
                      <i class="fa-solid fa-file-excel"></i>
                    </a>
                    <a
                      :href="links.print"
                      target="_blank"
                      class="btn btn-icon icon-rigth btn-primary mr-2"
                    >
                      Print Data
                      <i class="fa-solid fa-print"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 pl-0">
                <input
                  @keyup="onSearch"
                  class="form-control"
                  placeholder="Search"
                  v-model="search"
                />
              </div>
            </div>
            <div class="table-card">
              <div class="table-responsive">
                <table class="table table-striped" style="font-size: 12px">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Nomor Telepon</th>
                      <th>Blok / Kavling</th>
                      <th>Tipe Rumah</th>
                      <th>Total Angsuran</th>
                      <th>Sisa Angsuran</th>
                      <th>Tipe Pembayaran</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="position-relative" v-auto-animate>
                    <LoadingComponent v-if="isLoading" />
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
                      <td>
                        {{ payment.customer.phone }}
                      </td>
                      <td>
                        {{ payment.block.block }}-{{
                          payment.block.numberKavling
                        }}
                      </td>
                      <td>
                        {{ payment.houseType }}
                      </td>
                      <td>
                        {{ formatRupiah(payment.totalCost) }}
                      </td>
                      <td>
                        {{ formatRupiah(payment.reminderPayment) }}
                      </td>
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
                        <Actions
                          toggleDetail="modal"
                          targetDetail="#detailPayment"
                          @detail="detailPayment(payment.id)"
                          :showDelete="false"
                          labelEdit="Bayar"
                          targetEdit="#formDeposit"
                          toggleEdit="collapse"
                          @update="sendId(payment.id)"
                        />
                      </td>
                    </tr>
                    <td colspan="8">
                      <EmptyData
                        v-if="!isLoading && payments.length < 1"
                        message="Data Pembayaran Tidak Ada"
                      />
                    </td>
                  </tbody>
                </table>
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
          <!-- <div class="card-footer">
            <Pagination
              :currentPage="pagination.currentPage"
              :rowsTotal="pagination.total"
              :lastPage="pagination.lastPage"
              @onPageChange="onPageChange($event)"
            />
          </div> -->
        </div>
      </div>
    </div>
  </section>
  <PaymentDetail :id="payment.id" />
</template>
<script>
import moment from "moment";
import Cookie from "js-cookie";
import iziToast from "izitoast";
import Pagination from "../../components/Pagination.vue";
import LoadingComponent from "../../components/LoadingComponent.vue";
import Utils from "../../store/services/utils";
import ButtonsExport from "../../components/ButtonsExport.vue";
import EmptyData from "../../components/EmptyData.vue";
import PaymentDetail from "./PaymentDetail.vue";
import InputCurrency from "../../components/InputCurrency.vue";
import FormPayment from "./FormPayment.vue";
import Actions from "../../components/Actions.vue";
import FormDepo from "./FormDepo.vue";
export default {
  components: {
    Pagination,
    LoadingComponent,
    ButtonsExport,
    EmptyData,
    InputCurrency,
    PaymentDetail,
    FormPayment,
    Actions,
    FormDepo,
  },
  data() {
    return {
      //data
      payment: {
        id: "",
        customerId: "",
        employeeId: "",
        discount: "",
        type: "",
        price: "",
      },
      idPayment: null,

      search: "",
      //   customer: null,
      payments: [
        //  make same data with deferent value
      ],

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

      links: {
        excel: "export/payment/excel",
        pdf: "export/payment/pdf",
        print: "export/payment/print",
      },
    };
  },

  mounted() {
    this.getPayments();
  },
  computed: {
    idEmployee() {
      return Cookie.get("id");
    },
  },
  watch: {},
  methods: {
    detailPayment(data) {
      this.payment.id = data;
    },
    sendId(id) {
      this.idPayment = id;
    },

    formatRupiah(number) {
      return Utils.formatRupiah(number, "Rp. ");
    },
    formatPercent(number) {
      var percent = (number * 100) / 100 + "%";
      return percent;
    },
    calcReferral(percent, number) {
      return Utils.calcReferral(percent, number);
    },
    showLogUpdate(date) {
      return moment(date).fromNow();
    },
    showTypePayment(type) {
      if (type)
        return this.typePayment.find((item) => item.type === type).color;
    },
    getPayments() {
      const self = this;
      this.isLoading = true;
      const params = [
        //   `name=${this.name}`,
        `search=${this.search}`,
        `order_direction=${this.order_direction}`,
        `page=${this.pagination.page}`,
        `per_page=${this.pagination.perPage}`,
      ].join("&");
      self.$store.dispatch("getData", ["payment", params]).then((res) => {
        console.log(res);
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
      iziToast.success({
        title: "Berhasil",
        message: "Data berhasil ditambahkan",
        position: "topRight",
      });
      this.getPayments();
      this.reset();
    },
    onSearch() {
      this.getPayments();
    },
    getCustomers() {
      const self = this;
      self.$store.dispatch("getData", ["customer"]).then((res) => {
        self.customers = res.data;
      });
    },

    editPayment() {
      const self = this;
      const url = [
        "payment",
        {
          customer_id: this.payment.customerId,
          employee_id: this.idEmployee,
          price: this.payment.price,
        },
      ];
      self.isLoading = true;
      self.$store.dispatch("postData", url).then((res) => {
        iziToast.success({
          title: "Berhasil",
          message: "Data berhasil diubah",
          position: "topRight",
        });
        $("#formEdit").collapse("hide");
        self.isLoading = false;
        self.onSuccess();
        self.reset();
        self.getPayments();
      });
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
            self.isLoading = true;
            self.$store
              .dispatch("deleteData", ["payment", id])
              .then((response) => {
                iziToast.success({
                  title: "Berhasil",
                  message: "Data berhasil dihapus",
                  position: "topRight",
                });
                self.isLoading = false;
                self.getPayments();
              });
          }
        });
    },
    reset() {
      (this.payment = {
        id: "",
        customerId: "",
        employeeId: "",
        type: "",
        price: "",
      }),
        (this.selectedCustomer = null);
      this.selectedKavling = null;
      this.house = null;
    },
  },
};
</script>
<style>
.card .table-card {
  padding-left: 20px;
  padding-right: 20px;
  width: 100%;
}
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
  background-color: #e6efff;
  margin: auto;
}
</style>

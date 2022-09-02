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
          <div class="card">
            <div class="card-header">
              <Button
                data-toggle="modal"
                data-target="#Modalpayment"
                class="btn btn-primary"
                @click="isCreate()"
              >
                Tambah payment
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
                      <th width="10%">Nama</th>
                      <th width="10%">Blok</th>
                      <th width="10%">Nomor telepon</th>
                      <th width="15%">Sisa Pembayaran</th>
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
                            <i v-if="payment.remainingPayment > 0" class="avatar-presence busy"></i>
                            <i v-else class="avatar-presence online"></i>
                          </figure>

                          <div class="media-body">
                            <div class="media-title">{{ payment.name }}</div>
                            <div class="text-job text-muted">
                              <span>{{
                                showLogUpdate(payment.updatedAt)
                              }}</span>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td>{{ payment.block }}</td>
                      <td>{{ payment.phone }}</td>
                      <td>{{formatRupiah( payment.remainingPayment)}}</td>
                      <td>
                        <span
                          :class="
                            'badge badge-' +
                            showTypePayment(payment.typePayment)
                          "
                        >
                          {{ payment.typePayment }}
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
                              data-toggle="modal"
                              data-target="#Modalpayment"
                              @click="sendEdit(payment)"
                            >
                              Edit
                            </button>
                            <button
                              class="dropdown-item action sortable"
                              @click="deletepayment(payment.id)"
                            >
                              Hapus
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
                <CircleLoader v-show="isLoading" />
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
      payment: null,

      payments: [
        {
          id: "1",
          image: "../../../../public/assets/images/avatar/avatar-1.png",

          block: "A",
          name: "Ahmad",
          remainingPayment: "100.000",
          typePayment: "Cash Keras",
          updatedAt: "2020-01-01",
          phone: "123121",
        },
        {
          id: "1",
          image: "../../../../public/assets/images/avatar/avatar-1.png",
          block: "A",
          name: "Ahmadudin",
          remainingPayment: "100.000",
          typePayment: "KPR",
          phone: "1231211",
          updatedAt: "2020-01-01",
        },
        {
          id: "1",
          image: "../../../../public/assets/images/avatar/avatar-1.png",
          block: "A",
          name: "Ahmad",
          remainingPayment: "0",
          phone: "123121121",
          typePayment: "Cash Bertahap",
          updatedAt: "2020-01-01",
        },
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
    };
  },
  mounted() {
    this.getPayments();
  },
  computed: {},
  watch: {},
  methods: {
     formatRupiah(number) {
      return Utils.formatRupiah(number, "Rp. ");
    },
    showLogUpdate(date) {
      return moment(date).fromNow();
    },
    showTypePayment(type) {
      return this.typePayment.find((item) => item.type === type).color;
    },
    getPayments() {
      const self = this;
      this.isLoading = true;
      const params = [
        //   `name=${this.name}`,
        // `position=${this.name}`,
        `order_by=positions.id`,
        `order_direction=${this.order_direction}`,
        `page=${this.pagination.page}`,
        `per_page=${this.pagination.perPage}`,
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
      this.getpayments();
    },
    onSuccess() {
      this.getpayments();
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
                self.getpayments();
              });
          }
        });
    },
  },
};
</script>
<style>
    .avatar .avatar-presence{
        top:0 !important;
    }
</style>

<template>
  <section class="section">
    <div class="section-header">
      <h1>Data Customer</h1>
    </div>
    <div class="row">
      <div class="col-12 col-lg-12">
        <div class="card">
          <div class="card-header">
            <!-- <button class="btn btn-primary trigger--fire-modal-2" id="modal-2">Tambah Data</button> -->
            <!-- <button tag="router-link" to="/e    mployee/create" class="btn btn-primary">Tambah Data</button> -->
            <router-link to="customer/create" class="btn btn-primary"
              >Tambah Data</router-link
            >

            <div class="card-header-action"></div>
          </div>
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-lg-6">
                <ButtonsExport />
              </div>
              <div class="col-lg-6">
                <input
                  v-on:keyup="search"
                  v-model="name"
                  class="form-control"
                  placeholder="Search"
                />
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Nomor Telepon</th>
                    <th>Blok dan nomor kavling</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="customer in customers" :key="customer.id">
                    <td width="30%" class="align-middle">
                      <div class="media">
                        <img
                          style="object-fit: contain; width: 50px; height: 50px"
                          class="img-thumbnail rounded-circle mr-2"
                          :src="'storage/' + customer.image"
                          alt=""
                        />
                        <div class="media-body">
                          <div class="media-title">{{ customer.name }}</div>
                          <div class="text-job text-muted">
                            <span>{{ showLogUpdate(customer.updatedAt) }}</span>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td width="20%" class="align-middle">
                      <span>{{ customer.email }}</span>
                    </td>

                    <td width="20%" class="align-middle">
                      <span>{{ customer.phone }}</span>
                    </td>

                    <td width="20%" class="align-middle">
                      <div
                        v-if="customer.customerKavling.length > 0"
                        class="badge badge-success"
                      >
                        <span v-for="kavlings in customer.customerKavling" :key="kavlings">
                           {{ kavlings.kavling.block }}  | {{ kavlings.kavling.numberKavling }} ,
                        </span>
                      </div>
                      <div v-else-if="customer.customerKavling.length <1" class="badge badge-danger">
                        Belum Transaksi
                      </div>
                    </td>
                    <td width="10%" class="align-middle text-center">
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
                          <router-link
                            class="dropdown-item action sortable"
                            :to="'/customer/' + customer.id + '/edit'"
                            >Edit</router-link
                          >
                          <router
                            class="dropdown-item action sortable "
                            @click="deleteCustomer(customer.id)"
                            >Hapus</router
                          >
                        <span
                          data-toggle="modal"
                          data-target="#detailCustomer"
                          class="dropdown-item action sortable"
                          @click="sendId(customer.id)"
                            >Detail</span
                          >
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
    <DetailCustomer :id="csId"/>
  </section>
</template>
<script>
import iziToast from "izitoast";
import moment from "moment";
import Pagination from "../../components/Pagination.vue";
import Utils from "../../store/services/utils";
import CircleLoader from "../../components/CircleLoader.vue";
import DetailCustomer from "./DetailCustomer.vue";
import ButtonsExport from "../../components/ButtonsExport.vue";

export default {
  data() {
    return {
      customers: [],
      // edit
      isLoading: false,
      // filter
      name: "",
      order_direction: "asc",
      csId : "",
      //Pagination
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
    this.getCustomers();
  },
  watch:{
    csId(csId){
        this.csId = csId;
    }
  },
  computed: {},
  methods: {
    showLogUpdate(date) {
      return moment(date).fromNow();
    },
    formatRupiah(number) {
      return Utils.formatRupiah(number, "Rp. ");
    },
    search() {
      this.getCustomers();
    },
    sendId(id){
        this.csId = id;
    },
    getCustomers() {
      const self = this;
      this.isLoading = true;
      const params = [
        `name=${this.name}`,
        // `position=${this.name}`,
        `order_by=positions.id`,
        `order_direction=${this.order_direction}`,
        `page=${this.pagination.page}`,
        `per_page=${this.pagination.perPage}`,
      ].join("&");
      self.$store.dispatch("getData", ["customer", params]).then((response) => {
        self.customers = response.data;
        self.pagination.total = response.meta.total;
        self.pagination.currentPage = response.meta.currentPage;
        self.pagination.lastPage = response.meta.lastPage;
        self.isLoading = false;
        // console.log(self.customers)
      });
    },
    deleteCustomer(id) {
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
              .dispatch("deleteData", ["customer", id])
              .then((response) => {
                iziToast.success({
                  title: "Success",
                  message: "Data berhasil dihapus",
                  position: "topRight",
                });
                self.getCustomers();
              });
          }
        });
    },

    onPageChange(page) {
      this.pagination.page = page;
      this.getCustomers();
    },
  },
  components: { Pagination, CircleLoader, DetailCustomer, ButtonsExport },
};
</script>

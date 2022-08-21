<template >
  <section class="section">
    <div class="section-header">
      <h1>Data Pegawai</h1>
    </div>
    <Division />
    <div class="row">
      <div class="col-12 col-lg-12">
        <div class="card">
          <div class="card-header">
            <!-- <button class="btn btn-primary trigger--fire-modal-2" id="modal-2">Tambah Data</button> -->
            <!-- <button tag="router-link" to="/e    mployee/create" class="btn btn-primary">Tambah Data</button> -->
            <router-link to="employee/create" class="btn btn-primary"
              >Tambah</router-link
            >

            <div class="card-header-action"></div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="btn-group mb-3">
                  <button
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
                  <button
                    type="button"
                    class="btn btn-icon icon-rigth btn-primary mr-2"
                  >
                    PRINT DATA <i class="fa-solid fa-print"></i>
                  </button>
                </div>
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
                    <th>Divisi</th>
                    <th>Gaji</th>
                    <th>Status Keaktifan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="employee in employees" :key="employee.id">
                    <td width="30%" class="align-middle">
                      <div class="media">
                        <img
                          style="object-fit: contain; width: 50px; height: 50px"
                          class="img-thumbnail rounded-circle mr-2"
                          :src="'/storage/' + employee.image"
                          alt=""
                        />
                        <div class="media-body">
                          <div class="media-title">{{ employee.name }}</div>
                          <div class="text-job text-muted">
                            <span>{{ showLogUpdate(employee.updatedAt) }}</span>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td width="20%" class="align-middle">
                      <span>{{ employee.position.name }}</span>
                    </td>

                    <td width="20%" class="align-middle">
                      <span>{{ formatRupiah(employee.position.salary) }}</span>
                    </td>
                    <td width="20%" class="align-middle">
                      <div
                        v-if="employee.isActive == 1"
                        class="badge badge-success"
                      >
                        Aktif
                      </div>
                      <div v-else class="badge badge-danger">Aktif</div>
                    </td>

                    <td width="20%" class="align-middle">
                      <div
                        v-if="employee.status == 1"
                        class="badge badge-success"
                      >
                        Pegawai Tetap
                      </div>
                      <div v-else class="badge badge-secondary text-dark">
                        Pegawai Tidak Tetap
                      </div>
                    </td>
                    <td width="10%" class="align-middle text-center">
                      <div class="show">
                         <button data-toggle="dropdown" class="btn btn-transparent">
                            <i
                          class="fa-solid fa-ellipsis-vertical dropdown-toggle"
                          aria-expanded="true"
                        ></i>
                        </button>
                        <div class="dropdown-menu action">
                          <router-link
                            class="dropdown-item action sortable"
                            :to="'/employee/' + employee.id + '/edit'"
                            >Edit
                          </router-link>
                          <span
                            class="dropdown-item action sortable"
                            @click="deleteEmployees(employee.id)"
                            >Hapus</span
                          >
                          <span class="dropdown-item action sortable"
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
  </section>
</template>
<script>
import iziToast from "izitoast";
import moment from "moment";
import Pagination from "../../components/Pagination.vue";
import Utils from "../../store/services/utils";
import CircleLoader from "../../components/CircleLoader.vue";
import Division from "./Division.vue";
import CreateEditEmployee from "./CreateEditEmployee.vue";
export default {
  data() {
    return {
      employees: [],
      // edit
      isLoading: false,
      // filter
      name: "",
      order_direction: "asc",
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
    this.getEmployees();
  },
  computed: {},
  methods: {
    showLogUpdate(date) {
      return moment(date).fromNow();
    },
    formatRupiah(number) {
      // console.log(Utils.parseRupiah(Utils.formatRupiah(number,"Rp. ")))
      return Utils.formatRupiah(number, "Rp. ");
    },
    search() {
      this.getEmployees();
    },
    getEmployees() {
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
      self.$store.dispatch("getData", ["employee", params]).then((response) => {
        self.employees = response.data;
        self.pagination.total = response.meta.total;
        self.pagination.currentPage = response.meta.currentPage;
        self.pagination.lastPage = response.meta.lastPage;
        self.isLoading = false;
        //    console.log(self.Employeess)
      });
    },
    deleteEmployees(id) {
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
              .dispatch("deleteData", ["employee", id])
              .then((response) => {
                iziToast.success({
                  title: "Success",
                  message: "Data berhasil dihapus",
                  position: "topRight",
                });
                self.getEmployees();
              });
          }
        });
    },

    onPageChange(page) {
      //   this.isLoading = true;
      this.pagination.page = page;
      this.getEmployees();
    },
  },
  components: { Pagination, CircleLoader, Division },
};
</script>

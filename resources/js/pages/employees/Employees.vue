<template >
  <section class="section">
    <div class="section-header">
      <h1>Data Pegawai</h1>
    </div>

    <div class="row">
      <div class="col-lg-6 col-12">
        <div class="card">
          <div class="card-header">
            <h4>Divisi</h4>
            <form class="card-header-form">
              <input
                v-on:keyup="search"
                v-model="name"
                class="form-control"
                placeholder="Search"
              />
            </form>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-md">
                <tbody>
                  <tr>
                    <th width="40%">Jabatan</th>
                    <th width="40%">Gaji</th>
                    <th width="20%" class="text-center">Aksi</th>
                  </tr>

                  <tr v-for="division in divisions" :key="division.id">
                    <td>
                      <div class="media">
                        <div class="media-body">
                          <div class="media-title">
                            {{ division.name }}
                          </div>
                          <div class="text-job text-muted">
                            <span>update 1 day ago</span>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td>{{ formatRupiah(division.salary) }}</td>
                    <td class="text-center">
                      <div class="show">
                        <i
                          class="
                            fa-solid fa-ellipsis-vertical
                            dropdown-toggle
                            sortable
                          "
                          data-toggle="dropdown"
                          aria-expanded="true"
                        ></i>
                        <div class="dropdown-menu action">
                          <a
                            @click="editDivision(division.id)"
                            class="dropdown-item action"
                            href="#"
                            >Edit</a
                          >
                          <a
                            @click="deleteDivision(division.id)"
                            class="dropdown-item action"
                            href="#"
                            >Hapus</a
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
      <div class="col-lg-6 col-12">
        <div class="card">
          <div class="card-header">
            <h4>{{ isEditForm ? "Edit Jabatan" : "Tambah Jabatan" }}</h4>
          </div>
          <div class="card-body">
            <form class="form-group row">
              <label for="jabatan" class="col-sm-3 col-form-label"
                >Nama Jabatan</label
              >
              <div class="col-sm-9">
                <input
                  type="text"
                  class="form-control"
                  v-model="division.name"
                  placeholder="Nama Jabatan"
                />
              </div>
              <label for="gaji" class="col-sm-3 col-form label mt-4"
                >Gaji</label
              >
              <div class="col-sm-9 mt-4">
                <input
                  type="text"
                  class="form-control"
                  v-model="division.salary"
                  placeholder="Gaji"
                />
              </div>
            </form>
          </div>
          <div class="card-footer text-right">
            <button
              v-if="isEditForm"
              class="btn btn-danger mr-1"
              @click="cancelUpdate"
              type="button"
            >
              Batal
            </button>
            <button
              @click="isEditForm ? doUpdateDivision() : addDivision()"
              class="btn btn-primary mr-1"
              type="button"
            >
              {{ isEditForm ? "Edit" : "Tambah" }}
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-lg-12">
        <div class="card">
          <div class="card-header">
            <button class="btn btn-primary">Tambah Data</button>
            <div class="card-header-action"></div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col">
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
            </div>
            <div class="table-responsive">
              <table class="table table-striped" id="table-1">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Divisi</th>
                    <th>Tanggal Masuk</th>
                    <th>Gaji</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="align-middle">
                      <div class="media">
                        <img
                          class="avatar mr-3 rounded-circle"
                          src="{{ asset('assets/images/avatar/avatar-1.png') }}"
                          alt=""
                        />
                        <div class="media-body">
                          <div class="media-title">Ahmad</div>
                          <div class="text-job text-muted">
                            <span>update 1 day ago</span>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="align-middle">
                      <span>Web Developer</span>
                    </td>
                    <td class="align-middle">
                      <span>45 Agustus 2022</span>
                    </td>
                    <td class="align-middle">
                      <span>Rp.10.000.00</span>
                    </td>

                    <td class="align-middle">
                      <div class="badge badge-success">Pegawai Tetap</div>
                    </td>
                    <td class="align-middle text-center">
                      <div class="show">
                        <i
                          class="fa-solid fa-ellipsis-vertical dropdown-toggle"
                          data-toggle="dropdown"
                          aria-expanded="true"
                        ></i>
                        <div class="dropdown-menu action">
                          <a class="dropdown-item action" href="#">Edit</a>
                          <a class="dropdown-item action" href="#">Hapus</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import iziToast from "izitoast";
import Pagination from "../../components/Pagination.vue";
import Utils from "../../store/services/utils";
import CircleLoader from "../../components/CircleLoader.vue";
export default {
  data() {
    return {
      division: {
        // id : Math.random() + 1,
        name: "",
        salary: "",
      },
      divisions: [],
      isEditForm: false,
      // edit
      isLoading: false,
      idDivision: null,
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
    this.getDivisions();
  },
  computed: {
  },
  methods: {
    formatRupiah(number) {
      // console.log(Utils.parseRupiah(Utils.formatRupiah(number,"Rp. ")))
      return Utils.formatRupiah(number, "Rp. ");
    },
    search() {
      this.getDivisions();
    },
    addDivision() {
      const self = this;
      const url = [
        "position",
        {
          position: self.division.name,
          salary: self.division.salary,
        },
      ];
      self.$store
        .dispatch("postData", url)
        .then((res) => {
          self.getDivisions();
          self.division.name = "";
          self.division.salary = "";
          iziToast.success({
            title: "Success",
            message: "Data berhasil ditambahkan",
            position: "topRight",
          });
        })
        .catch((err) => {
          iziToast.error({
            title: "Error",
            message: "Data gagal ditambahkan",
            position: "topRight",
          });
        });
    },
    getDivisions() {

      const self = this;
      this.isLoading = true;
      const params = [
        `name=${this.name}`,
        `order_by=positions.id`,
        `order_direction=${this.order_direction}`,
        `page=${this.pagination.page}`,
        `per_page=${this.pagination.perPage}`,
      ].join("&");
      self.$store.dispatch("getData", ["position", params]).then((response) => {
        self.divisions = response.data;
        self.pagination.total = response.meta.total;
        self.pagination.currentPage = response.meta.currentPage;
        self.pagination.lastPage = response.meta.lastPage;
        self.isLoading = false;
        //    console.log(self.divisions)
      });
    },
    deleteDivision(id) {
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
              .dispatch("deleteData", ["position", id])
              .then((response) => {
                iziToast.success({
                  title: "Success",
                  message: "Data berhasil dihapus",
                  position: "topRight",
                });
                self.getDivisions();
              });
          }
        });
    },
    editDivision(id) {
      const self = this;
      self.divisions.filter((div) => {
        if (div.id == id) {
          self.division.name = div.name;
          self.division.salary = div.salary;
          self.idDivision = div.id;
          self.isEditForm = true;
        }
      });
    },
    doUpdateDivision() {
      const self = this;
      const url = [
        "position",
        self.idDivision,
        {
          position: self.division.name,
          salary: self.division.salary,
        },
      ];
      // self.isEditForm = true
      self.$store.dispatch("updateData", url).then((response) => {
        iziToast.success({
          title: "Success",
          message: "Data berhasil diubah",
          position: "topRight",
        });
        self.isEditForm = false;
        self.division = {
          name: "",
          salary: "",
        };
        self.getDivisions();
      });
    },
    cancelUpdate() {
      const self = this;
      self.isEditForm = false;
      self.division = {
        name: "",
        salary: "",
      };
    },
    onPageChange(page) {
    //   this.isLoading = true;
      this.pagination.page = page;
      this.getDivisions();
    },
  },
  components: { Pagination, CircleLoader },
};
</script>

<template>
    <section class="section">
      <div class="section-header">
        <h1>Data Pemborong</h1>
      </div>
      <div class="row">
        <div class="col-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <!-- <button class="btn btn-primary trigger--fire-modal-2" id="modal-2">Tambah Data</button> -->
              <!-- <button tag="router-link" to="/e    mployee/create" class="btn btn-primary">Tambah Data</button> -->
              <router-link to="contractor/create" class="btn btn-primary"
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
                      <th>Nama PIC</th>
                      <th>Email</th>
                      <th>Nomor Telepon</th>
                      <th>Status Borongan Pekerjaan</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="contractor in contractors" :key="contractor.id">
                      <td width="30%" class="align-middle">
                        <div class="media">
                          <img
                            style="object-fit: contain; width: 50px; height: 50px"
                            class="img-thumbnail rounded-circle mr-2"
                            :src="'storage/' + contractor.image"
                            alt=""
                          />
                          <div class="media-body">
                            <div class="media-title">{{ contractor.picName }}</div>
                            <div class="text-job text-muted">
                              <span>{{ showLogUpdate(contractor.updatedAt) }}</span>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td width="20%" class="align-middle">
                        <span>{{ contractor.email }}</span>
                      </td>

                      <td width="20%" class="align-middle">
                        <span>{{ contractor.phone }}</span>
                      </td>

                      <td width="20%" class="align-middle">
                      <div
                        v-if="contractor.status == 1"
                        class="badge badge-success"
                      >
                        Aktif
                      </div>
                      <div v-else class="badge badge-danger">
                        Tidak Aktif
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
                            <router-link :to="'/contractor/'+contractor.id+'/edit'"
                            class="dropdown-item action sortable
                            ">Edit</router-link>
                            <!-- <button
                              class="dropdown-item action sortable"
                              @click="getContractor(contractor.id)"
                              >Edit</button> -->
                            <button
                              class="dropdown-item action sortable "
                              @click="deleteContractor(contractor.id)"
                              >Hapus</button>
                          <span class="dropdown-item action sortable"
                              >Detail</span>
                          </div>
                        </div>
                      </td>
                    </tr>
                      <td colspan="5">
                        <EmptyData v-if="!isLoading && contractors.length < 1" message="Datan Pemborong Ngga Ada"/>
                        <CircleLoader v-if="isLoading" />
                    </td>
                  </tbody>
                </table>

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
  import CreateEditContractor from "./CreateEditContractor.vue";
import ButtonsExport from "../../components/ButtonsExport.vue";
import EmptyData from "../../components/EmptyData.vue";

  export default {
    data() {
      return {
        contractors: [],
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
      this.getContractors();
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
        this.getContractors();
      },
      getContractors() {
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
        self.$store.dispatch("getData", ["contractor", params]).then((response) => {
          self.contractors = response.data;
          self.pagination.total = response.meta.total;
          self.pagination.currentPage = response.meta.currentPage;
          self.pagination.lastPage = response.meta.lastPage;
          self.isLoading = false;
        // console.log(self.contractors)
        });
      },
      deleteContractor(id) {
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
                .dispatch("deleteData", ["contractor", id])
                .then((response) => {
                  iziToast.success({
                    title: "Success",
                    message: "Data berhasil dihapus",
                    position: "topRight",
                  });
                  self.getContractors();
                });
            }
          });
      },

      onPageChange(page) {
        this.pagination.page = page;
        this.getContractors();
      },
    },
    components: { Pagination, CircleLoader, ButtonsExport, EmptyData, EmptyData },
  };
  </script>

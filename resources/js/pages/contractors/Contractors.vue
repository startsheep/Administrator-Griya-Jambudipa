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
                <tbody class="position-relative" v-auto-animate>
                  <LoadingComponent v-if="isLoading" />
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
                          <div class="media-title">
                            {{ contractor.picName }}
                          </div>
                          <div class="text-job text-muted">
                            <span>{{
                              showLogUpdate(contractor.updatedAt)
                            }}</span>
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
                      <label class="">
                        <input
                          type="checkbox"
                          name="custom-switch-checkbox"
                          class="custom-switch-input"
                          :checked="contractor.status == 1"
                        />
                        <span
                          class="custom-switch-indicator"
                          @click="
                            updateStatus(contractor.id, contractor.status)
                          "
                        >
                        </span>
                      </label>
                    </td>
                    <td width="10%" class="align-middle text-center">
                      <Actions
                        @delete="deleteContractor(contractor.id)"
                        :editIsRouter="true"
                        :linkEdit="'/contractor/' + contractor.id + '/edit'"
                        toggleDetail="modal"
                        targetDetail="#detailContractor"
                        @detail="sendId(contractor.id)"
                      />
                    </td>
                  </tr>
                  <td colspan="5">
                    <EmptyData
                      v-if="!isLoading && contractors.length < 1"
                      message="Data Pemborong Tidak Ada"
                    />
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
  <DetailContractor :id="idForDetail" />
</template>
<script>
import iziToast from "izitoast";
import moment from "moment";
import Pagination from "../../components/Pagination.vue";
import Utils from "../../store/services/utils";
import LoadingComponent from "../../components/LoadingComponent.vue";
import CreateEditContractor from "./CreateEditContractor.vue";
import ButtonsExport from "../../components/ButtonsExport.vue";
import EmptyData from "../../components/EmptyData.vue";
import Actions from "../../components/Actions.vue";
import DetailContractor from "./DetailContractor.vue";

export default {
  data() {
    return {
      contractors: [],
      contractor: {},
      status: 0,
      // edit
      isLoading: false,
      idForDetail: "",
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
      //Link export
      links: {
                excel: 'export/contractor/excel',
                pdf: 'export/contractor/pdf',
                print: 'export/contractor/print'
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
    sendId(id) {
      this.idForDetail = id;
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
      self.$store
        .dispatch("getData", ["contractor", params])
        .then((response) => {
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
            self.isLoading = true;
            self.$store
              .dispatch("deleteData", ["contractor", id])
              .then((response) => {
                iziToast.success({
                  title: "Berhasil",
                  message: "Data berhasil dihapus",
                  position: "topRight",
                });
                self.getContractors();
                self.isLoading = false;
              });
          }
        });
    },
    onPageChange(page) {
      this.pagination.page = page;
      this.getContractors();
    },
    updateStatus(id, status) {
      let desc = "";
      if (status == 1) {
        status = 0;
        desc = "Non-aktif";
      } else {
        status = 1;
        desc = "Aktif";
      }
      var type = "updateData";
      var url = [
        "contractor/active",
        id,
        {
          active: status,
        },
      ];
      this.isLoading = true;
      this.$store.dispatch(type, url).then((response) => {
        if (response.type == "success") {
          iziToast.success({
            title: "Berhasil",
            message: "Status Borongan " + desc,
            position: "topRight",
          });
          this.isLoading = false;
          this.getContractors();
        }
      });
    },
  },
  components: {
    Pagination,
    LoadingComponent,
    ButtonsExport,
    EmptyData,
    EmptyData,
    Actions,
    DetailContractor,
  },
};
</script>

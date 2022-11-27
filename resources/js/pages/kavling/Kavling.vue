<template>
  <section class="section">
    <div class="section-header">
      <h4>Kavling</h4>
    </div>
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <Button
              data-toggle="modal"
              data-target="#ModalKavling"
              class="btn btn-primary"
              @click="isCreate()"
            >
              Tambah Kavling
            </Button>

            <button
              type="button"
              class="btn btn-icon icon-rigth btn-success mr-2 ml-4"
              data-toggle="modal"
              data-target="#importExcel"
              @click="importExcel"
            >
              {{ labelImportExcel }} <span class="mr-1">Import Excel</span>
              <i class="fa-solid fa-save ml-3"> </i>
            </button>
          </div>
          <div class="card-body">
            <div class="row mb-3 d-flex justify-content-between">
              <div class="col-lg-4">
                <div class="card-header-action">
                    <ButtonsExport
                    :showBtnPdf="false"
                    @exportExcel="exportExcel()"
                    labelExportExcel='Export Data'
                    @print="printData()"/>
                </div>
              </div>
              <div class="col-lg-3">
                <!-- <div class="form-inline"> -->
                <!-- <input
                    v-on:keyup="search"
                    class="form-control"
                    placeholder="Search"
                  /> -->
                <div class="input-group">
                  <select
                    @change="onSearch"
                    class="form-control mr-2"
                    v-model="pagination.perPage"
                  >
                    <option selected value="">Tampilkan Semua</option>
                    <option
                      v-for="limit in limits"
                      :key="limit"
                      :value="limit.value"
                    >
                      {{ limit.text }}
                    </option>
                  </select>
                  <select
                    @change="onSearch"
                    class="form-control"
                    v-model="filter.block"
                  >
                    <option selected disabled value="">
                      Filter Blok Kavling
                    </option>
                    <option
                      v-for="block in blocks"
                      :key="block"
                      :value="block.value"
                    >
                      {{ block.text }}
                    </option>
                  </select>
                  <button @click="reset()" class="btn btn-success">
                    <i class="fas fa-arrows-rotate"></i>
                  </button>
                </div>
                <!-- </div> -->
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th width="5%">Blok</th>
                    <th width="10%">Nomor Kavling</th>
                    <th width="20%">Lebar Muka Kavling</th>
                    <th width="10%">Panjang Kavling</th>
                    <th width="15%">Panjang Kavling 2</th>
                    <th width="10%">Luas Kavling</th>
                    <th width="10%">Tipe Rumah</th>
                    <th width="15%">Luas Bangunan</th>
                    <th width="5%">Aksi</th>
                  </tr>
                </thead>
                <tbody class="position-relative" v-auto-animate>
                  <LoadingComponent v-if="isLoading" />
                  <tr v-for="kavling in kavlings" :key="kavling">
                    <td>{{ kavling.block }}</td>
                    <td>{{ kavling.numberKavling }}</td>
                    <td>{{ kavling.widthKavling }}</td>
                    <td>{{ kavling.lengthKavling }}</td>
                    <td>{{ kavling.secondLengthKavling }}</td>
                    <td>{{ kavling.areaKavling }}</td>
                    <td>
                      {{ checkHouseType(kavling.houseType) }}
                    </td>
                    <td>{{ kavling.areaBuilding }}</td>
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
                            data-target="#ModalKavling"
                            @click="sendEdit(kavling)"
                          >
                            Edit
                          </button>
                          <button
                            class="dropdown-item action sortable"
                            @click="deleteKavling(kavling.id)"
                          >
                            Hapus
                          </button>
                          <!-- <button
                                                        class="dropdown-item action sortable"
                                                    >
                                                        Detail
                                                    </button> -->
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <!-- create total data -->
            <div class="row">
              <div class="col-lg-6">
                <p class="ml-2 text-muted">
                  Jumlah Data :{{ pagination.total }}
                </p>
              </div>
              <div class="col-lg-6">
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
    </div>
  </section>
  <ModalImport @onSuccess="onSuccessImport()" />
  <CreateEdit @onSuccess="onSuccess()" :kav="kavling" />
</template>
<script>
import CreateEdit from "./CreateEdi.vue";
import iziToast from "izitoast";
import Pagination from "../../components/Pagination.vue";
import LoadingComponent from "../../components/LoadingComponent.vue";
import ButtonsExport from "../../components/ButtonsExport.vue";
import ModalImport from "../land/ModalImport.vue";

export default {
  components: {
    CreateEdit,
    Pagination,
    LoadingComponent,
    ButtonsExport,
    ModalImport,
  },
  data() {
    return {
      //data
      kavling: null,
      kavlings: [],
      isLoading: false,

      filter: {
        search: "",
        orderDirection: "asc",
        block: null,
        limit: 10,
      },
      blocks: [
        { text: "A", value: "A" },
        { text: "B", value: "B" },
        { text: "C", value: "C" },
        { text: "D", value: "D" },
        { text: "E", value: "E" },
        { text: "F", value: "F" },
        { text: "G", value: "G" },
        { text: "H", value: "H" },
        { text: "I", value: "I" },
        { text: "J", value: "J" },
        { text: "K", value: "K" },
        { text: "L", value: "L" },
        { text: "M", value: "M" },
        { text: "N", value: "N" },
        { text: "O", value: "O" },
        { text: "P", value: "P" },
        { text: "Q", value: "Q" },
        { text: "R", value: "R" },
        { text: "S", value: "S" },
        { text: "T", value: "T" },
        { text: "U", value: "U" },
        { text: "V", value: "V" },
        { text: "W", value: "W" },
        { text: "X", value: "X" },
        { text: "Y", value: "Y" },
        { text: "Z", value: "Z" },
      ],
      limits: [
        { text: "5", value: 5 },
        { text: "10", value: 10 },
        { text: "20", value: 20 },
        { text: "30", value: 30 },
        { text: "40", value: 40 },
        { text: "50", value: 50 },
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
        excel: "/export/kavling/excel",
        pdf: "/export/kavling/pdf",
        print: "/export/kavling/print",
      },
    };
  },
  mounted() {
    this.getKavlings();
  },
  computed: {},
  watch: {
    kavling(newVal) {
      this.kavling = newVal;
    },
  },

  methods: {
    checkHouseType(houseType) {
        if (!houseType) {
            return '-'
        }

        return houseType.houseType
    },
    exportExcel() {
    //   window.open(this.links.excel + '/' + this.filter.block, "_parent")
      if (this.filter.block == null) {
        iziToast.warning({
            title: "Peringatan",
            message: "Silahkan Pilih Blok Lebih Dulu",
            position: "topRight",
          });
        } else {
            window.open(this.links.excel + '/' + this.filter.block, "_parent")
    }},
    printData() {
        if (this.filter.block == null) {
        iziToast.warning({
            title: "Peringatan",
            message: "Silahkan Pilih Blok Lebih Dulu",
            position: "topRight",
          });
        } else {
            window.open(this.links.print + '/' + this.filter.block, "_blank")
    }},
    sendEdit(kavling) {
      this.kavling = kavling;
    },
    isCreate() {
      this.kavling = null;
    },
    getKavlings() {
      const self = this;
      this.isLoading = true;
      const params = [
        //   `name=${this.name}`,
        // `position=${this.name}`,
        // `block=${this.filter.block}`,
        `block=${this.filter.block==null ? "" : this.filter.block}`,
        `order_by=positions.id`,
        `order_direction=${this.order_direction}`,
        `page=${this.pagination.page}`,
        `per_page=${this.pagination.perPage}`,
      ].join("&");
      self.$store.dispatch("getData", ["kavling", params]).then((res) => {
        self.kavlings = res.data;
        self.pagination.total = res.meta.total;
        self.pagination.currentPage = res.meta.currentPage;
        self.pagination.lastPage = res.meta.lastPage;
        this.isLoading = false;
      });
    },
    onPageChange(page) {
      this.pagination.page = page;
      this.getKavlings();
    },
    onSuccess() {
      this.getKavlings();
    },
    onSuccessImport() {
        // swall alert
        iziToast.success({
            title: "Sukses",
            message: "Data Berhasil Di Import",
            position: "topRight",
          });
      this.getKavlings();
    //   this.$refs.modalImport.hide();
    },
    deleteKavling(id) {
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
              .dispatch("deleteData", ["kavling", id])
              .then((response) => {
                iziToast.success({
                  title: "Berhasil",
                  message: "Data berhasil dihapus",
                  position: "topRight",
                });
                self.isLoading = false;
                self.getKavlings();
              });
          }
        });
    },
    onSearch() {
      this.getKavlings();
    },
    reset() {
      this.filter.search = "";
      this.filter.block = "";
      this.pagination.perPage = 5;
      this.getKavlings();
    },
  },
};
</script>
<style></style>

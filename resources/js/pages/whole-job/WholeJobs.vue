<template>
  <section class="section">
    <div class="section-header">
      <h1>Borongan {{ isJobHouse ? "Rumah" : "Fasilitas Umum" }}</h1>
    </div>
    <div class="row m-auto">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <button
              data-toggle="modal"
              :data-target="isJobHouse ? '#FormHouse' : '#FormFacility'"
              class="btn btn-primary"
              @click="idForEdit = null"
            >
              Tambah Borongan Rumah
            </button>
          </div>
          <div class="card-body">
            <div class="row mb-3 d-flex justify-content-between">
              <div class="col">
                <div class="card-header-action">
                    <ButtonsExport
                    :showBtnPdf="false"
                    labelExportExcel='Export Data'
                    @exportExcel="exportExcel()"
                    @print="printData()"/>
            </div>
              </div>
              <div class="col-lg-6">
                <!-- <div class="form-inline"> -->
                <div class="input-group mr-3">
                  <!-- <input
                        v-on:keyup="search"
                        class="form-control"
                        placeholder="Search"
                      /> -->
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
                    v-model="orderDirection"
                  >
                    <option selected disabled value="">
                      Filter Blok Kavling
                    </option>
                    <option value="asc">Data Baru</option>
                    <option value="desc">Data Lama</option>
                  </select>
                  <button @click="reset()" class="btn btn-success">
                    <i class="fas fa-arrows-rotate"></i>
                  </button>
                </div>
                <!-- </div> -->
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <!-- <th class="text-center" scope="col">No</th> -->
                    <th scope="col">Nama PIC/Perusahaan</th>
                    <th v-if="isJobHouse" scope="col">Customer</th>
                    <!-- <th scope="col">Deskripsi Borongan</th> -->
                    <th scope="col">Tanggal Pengerjaan</th>
                    <th scope="col">Total Biaya</th>
                    <th scope="col">Pembayaran</th>
                    <th scope="col">Status</th>
                    <th class="text-center" scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody class="position-relative" v-auto-animate>
                  <LoadingComponent v-if="isLoading" />
                  <tr v-for="job in jobs" :key="job">
                    <!-- <th class="text-center" scope="row">1</th> -->
                    <td>
                      <strong class="d-block">{{
                        job.contractor.picName
                      }}</strong>
                      <span class="d-block">{{
                        job.contractor.companyName
                      }}</span>
                    </td>
                    <td v-if="isJobHouse && job">
                      <strong class="d-block">{{ job.customer.name }}</strong>
                      <span>Tipe Rumah: {{ job.houseType.houseType }}</span>
                    </td>
                    <!-- <td>Borongan RUmah Tangga</td> -->
                    <td>
                      <span>{{ formatDateLocal(job.startDate) }}</span> -
                      {{ formatDateLocal(job.endDate) }}
                    </td>
                    <td>
                      <span>{{ formatRupiah(job.totalCost) }}</span>
                    </td>
                    <td>{{ job.paymentType }}</td>
                    <td>
                      <div
                        v-html="checkStatus(job.startDate, job.endDate)"
                      ></div>
                      <!-- <div class="badge badge-success">Selesai</div> -->
                    </td>
                    <td class="align-middle text-center">
                      <Actions
                        toggleEdit="modal"
                        targetEdit="#FormHouse"
                        @update="sendId(job.id)"
                        @delete="deleteJob(job.id)"
                        labelDetail="Rekapitulasi"
                        @detail="detailJob(job.id)"
                        :showCustom="true"
                        labelCustom="Bayar"
                      />
                    </td>
                  </tr>
                  <td colspan="7">
                    <EmptyData
                      v-if="!isLoading && jobs.length < 1"
                      message="Data Tidak Ada"
                    />
                    <!-- <CircleLoader v-if="isLoading" /> -->
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
  <FormHouse @onSuccess="onSuccess" :id="idForEdit" />
  <FormFacility @onSuccess="onSuccess" :id="idForEdit" />
</template>
<script>
import Utils from "../../store/services/utils";
import moment from "moment";
import ButtonsExport from "../../components/ButtonsExport.vue";
import Actions from "../../components/Actions.vue";
import FormHouse from "./FormHouse.vue";
import Pagination from "../../components/Pagination.vue";
import EmptyData from "../../components/EmptyData.vue";
import CircleLoader from "../../components/CircleLoader.vue";
import iziToast from "izitoast";
import LoadingComponent from "../../components/LoadingComponent.vue";
import FormFacility from "./FormFacility.vue";

// create action when hide when click outside modal clear all value in input

export default {
  components: {
    ButtonsExport,
    Actions,
    FormHouse,
    Pagination,
    EmptyData,
    CircleLoader,
    LoadingComponent,
    FormFacility,
  },
  computed: {
    dateNow() {
      return moment().format("DD-MM-YYYY");
    },
  },
  watch: {
    idForEdit() {},
    $route(to, from) {
      this.getJobs();
    },
  },
  computed: {
    isJobHouse() {
      return this.$route.name === "Job House";
    },
    currentRouteName() {
      return this.$route.name;
    },
  },
  mounted() {
    this.getJobs();
  },
  data: () => ({
    jobs: [],
    idForEdit: "",
    isLoading: false,
    limits: [
      { text: "5", value: 5 },
      { text: "10", value: 10 },
      { text: "20", value: 20 },
      { text: "30", value: 30 },
      { text: "40", value: 40 },
      { text: "50", value: 50 },
    ],
    orderDirection: "desc",
    pagination: {
      total: 0,
      perPage: 5,
      currentPage: 1,
      lastPage: 0,
      page: 0,
    },

    //Link export
    links: {
      jobHouse: {
        excel: "/export/job-house/excel",
        pdf: "/export/job-house/pdf",
        print: "/export/job-house/print",
      },
      jobOther: {
        excel: "/export/job-other/excel",
        pdf: "/export/job-other/pdf",
        print: "/export/job-other/print",
      },
    },
  }),
  methods: {
    exportExcel() {
      window.open(
        this.isJobHouse ? this.links.jobHouse.excel : this.links.jobOther.excel,
        "_parent"
      );
    },
    printData() {
      window.open(
        this.isJobHouse ? this.links.jobHouse.print : this.links.jobOther.print,
        "_blank"
      );
    },
    detailJob(id) {
      this.$router.push(`/job/${id}/detail`);
    },
    sendId(id) {
      this.idForEdit = id;
    },
    formatDateLocal(date) {
      return Utils.formateDateLocale(date);
    },
    formatRupiah(num) {
      return Utils.formatRupiah(num, "Rp. ");
    },
    checkStatus(s, e) {
      let start = moment(s);
      let end = moment(e);
      let now = moment();
      if (moment().isBetween(start, end)) {
        return ` <span class="badge badge-info">Sedang Dikerjakan</span>`;
      } else if (now.isAfter(end)) {
        return ` <span class="badge badge-success">Selesai Dikerjakan</span>`; //Selesai Dikerjakan
      } else {
        return ` <span class="badge badge-warning">Belum Dikerjakan</span>`; //Belum dikerjakan
      }
    },
    getJobs() {
      const self = this;
      const params = [
        `&page=${this.pagination.currentPage}`,
        `&per_page=${this.pagination.perPage}`,
        `order_direction=${this.orderDirection}`,
        `type=${this.isJobHouse ? "rumah" : "umum"}`,
      ].join("&");
      this.isLoading = true;
      self.$store.dispatch("getData", ["whole-job", params]).then((res) => {
        // console.log(res.data);
        self.jobs = res.data;
        self.pagination.total = res.meta.total;
        self.pagination.currentPage = res.meta.currentPage;
        self.pagination.lastPage = res.meta.lastPage;
        self.pagination.lastPage = res.data.last_page;
        self.isLoading = false;
      });
    },
    deleteJob(id) {
      const self = this;
      this.$swal
        .fire({
          title: "Apakah Anda Yakin?",
          text: "Data yang dihapus tidak dapat dikembalikan!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Ya, Hapus!",
          cancelButtonText: "Batal",
        })
        .then((result) => {
          if (result.isConfirmed) {
            self.$store
              .dispatch("deleteData", ["whole-job", id])
              .then((res) => {
                iziToast.success({
                  title: "Berhasil",
                  message: "Data Berhasil Dihapus",
                  position: "topRight",
                });
                self.getJobs();
              });
          }
        });
    },
    onSuccess() {
      this.getJobs();
    },
    onPageChange(page) {
      this.pagination.currentPage = page;
      this.getJobs();
    },
    onSearch() {
      this.getJobs();
    },
  },
};
</script>
<style>
</style>

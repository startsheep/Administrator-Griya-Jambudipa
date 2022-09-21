<template>
  <section class="section">
    <div class="section-header">    </div>
    <div class="row m-auto">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <button
              data-toggle="modal"
              data-target="#FormHouse"
              class="btn btn-primary"
            >
              Tambah Borongan Rumah
            </button>
          </div>
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-lg-4">
                <ButtonsExport :printData="false" />
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <!-- <th class="text-center" scope="col">No</th> -->
                    <th scope="col">Nama PIC/Perusahaan</th>
                    <th s cope="col">Customer</th>
                    <!-- <th scope="col">Deskripsi Borongan</th> -->
                    <th scope="col">Tanggal Pengerjaan</th>
                    <th scope="col">Total Biaya</th>
                    <th scope="col">Pembayaran</th>
                    <th scope="col">Status</th>
                    <th class="text-center" scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
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
                    <td>
                      <strong class="d-block">{{ job.customer.name }}</strong>
                      <span>Tipe Rumah: {{ job.houseType.houseType }}</span>
                    </td>
                    <!-- <td>Borongan RUmah Tangga</td> -->
                    <td>
                      <span>{{ formatDateLocal(job.startDate) }}</span> -
                      {{ formatDateLocal(job.endDate) }}
                    </td>
                    <td>
                      <span>{{formatRupiah(job.totalCost) }}</span>
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
                      />
                    </td>
                  </tr>
                    <td colspan="5" >
                        <EmptyData v-if="!isLoading && jobs.length < 1" message="Data Ngga Ada"/>
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
  <FormHouse @onSuccess="onSuccess" />
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
import iziToast from 'izitoast';
export default {
  components: { ButtonsExport, Actions, FormHouse, Pagination, EmptyData, CircleLoader },
  computed: {
    dateNow() {
      return moment().format("DD-MM-YYYY");
    },
  },
  watch:{
    idForEdit(){
        this.getJobById(this.idForEdit);
    }
  },

  mounted() {
    this.getJobs();
  },
  data: () => ({
    jobs: [],
    idForEdit: '',
    isLoading: false,
    pagination: {
      total: 0,
      perPage: 5,
      currentPage: 1,
      lastPage: 0,
      page: 0,
    },
  }),
  methods: {
    sendId(id){
        this.idForEdit = id;
    },
    formatDateLocal(date) {
      return Utils.formateDateLocale(date);
    },
    formatRupiah(num){
        return Utils.formatRupiah(num , 'Rp. ');
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
    deleteJob(id){
        const self = this;
       this.$swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
          }).then((result) => {
            if (result.isConfirmed) {
                self.$store.dispatch("deleteData", ["whole-job", id]).then((res) => {
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Data Berhasil Dihapus',
                        position: 'topRight'
                    });
                    self.getJobs();
                });
            }
          })
    },
    onSuccess() {
      this.getJobs();
    },
    onPageChange(page){
        this.pagination.currentPage = page;
        this.getJobs();
    }
  },
};
</script>
<style>
</style>

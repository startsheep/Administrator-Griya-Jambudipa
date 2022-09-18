<template>
  <section class="section">
    <div class="section-header"><h1>Borongan Rumah</h1></div>
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
                    <th scope="col">Deskripsi Borongan</th>
                    <th scope="col">Tanggal Pengerjaan</th>
                    <th scope="col">Pembayaran</th>
                    <th scope="col">Status</th>
                    <th class="text-center" scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="job in jobs " :key="job">
                    <!-- <th class="text-center" scope="row">1</th> -->
                    <td>
                        <span class="d-block">{{ job.picName }}</span>
                        <span class="d-block">{{ job.companyName }}</span>
                    </td>
                    <td>Nannnn | A-102</td>
                    <td>Borongan RUmah Tangga</td>
                    <td>{{ dateNow }}</td>
                    <td>Termin</td>
                    <td>
                      <div class="badge badge-success">Selesai</div>
                    </td>
                    <td class="align-middle text-center">
                      <Actions />
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer"></div>
        </div>
      </div>
    </div>
  </section>
  <FormHouse />
</template>
<script>
import moment from "moment";
import ButtonsExport from "../../components/ButtonsExport.vue";
import Actions from "../../components/Actions.vue";
import FormHouse from "./FormHouse.vue";
export default {
  components: { ButtonsExport, Actions, FormHouse },
  computed: {
    dateNow() {
      return moment().format("DD-MM-YYYY");
    },
  },
  data: () => ({
    jobs: [
      {
        id: 1,
        picName: "Ahmad",
        companyName: "PT Sanghai",
        customerName: "Nannnn",
        customerType: "A-102",
        description: "Borongan RUmah Tangga",
        firstDate: "2022-08-10",
        endDate: "2022-12-10",
        paymentType: "Termin",
        status: "Selesai",
      },
    //   make same data with different value
      {
        id: 2,
        picName: "Ahmad",
        companyName: "PT Sanghai",
        customerName: "Nannnn",
        customerType: "A-102",
        description: "Borongan RUmah Tangga",
        firstDate: "2022-08-10",
        endDate: "2022-12-10",
        paymentType: "Termin",
        status: "Selesai",
      },
    ],
  }),
};
</script>
<style>
</style>

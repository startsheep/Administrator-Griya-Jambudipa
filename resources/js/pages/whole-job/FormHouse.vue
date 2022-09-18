<template >
  <Modal idModal="FormHouse" tittle="Formulir Borongan Rumah" size="modal-lg">
    <template v-slot:body>
      <div class="row m-auto">
        <div class="col-12">
          <div class="form-row">
            <div class="form-group col-lg-6">
              <label>Nama PIC/Perusahaan</label>
              <select class="form-control">
                <option
                  v-for="contractor in contractors"
                  :key="contractor"
                  :value="contractor.id"
                >
                  {{ contractor.picName }} | {{ contractor.companyName }}
                </option>
              </select>
            </div>
            <div class="form-group col-lg-6">
              <label>Tipe Pembayaran</label>
              <select class="form-control">
                <option
                  v-for="contractor in contractors"
                  :key="contractor"
                  :value="contractor.id"
                >
                  {{ contractor.picName }} | {{ contractor.companyName }}
                </option>
              </select>
            </div>

            <div class="form-group col-lg-6">
              <label>Customer</label>
              <select class="form-control">
                <option
                  v-for="customer in customers"
                  :key="customer"
                  :value="customer.id"
                >
                  {{ customer.name }}
                </option>
              </select>
            </div>
            <div class="form-group col-lg-6">
              <label>Tipe Rumah / Blok</label>
              <select class="form-control">
                <option
                  v-for="customer in customers"
                  :key="customer"
                  :value="customer.id"
                >
                  {{ customer.name }}
                </option>
              </select>
            </div>
            <div class="form-group col-lg-12">
              <label>Deskripsi Pekerjaan</label>
              <SummerNote />
            </div>
            <div class="form-group col-lg-6">
              <label>Tanggal Mulai</label>
              <input type="date" class="form-control" />
            </div>
            <div class="form-group col-lg-6">
              <label>Tanggal Selesai</label>
              <input type="date" class="form-control" />
            </div>
            <div class="custom-file form-group col-lg-6">
              <input type="file" class="custom-file-input" multiple />
              <label class="custom-file-label" for="customFile">Dokumen</label>
            </div>
            <div class="form-group col-lg-6">
                <InputCurrency  placeholder="Total Anggaran"/>
            </div>
          </div>
        </div>
      </div>
    </template>
  </Modal>
</template>
<script>
import Modal from "../../components/Modal.vue";
import SummerNote from "../../components/SummerNote.vue";
import InputCurrency from "../../components/InputCurrency.vue";
export default {
  components: { Modal, SummerNote, InputCurrency },
  data() {
    return {
      contract:{
        contractor_id: "",
        customer_id: "",
        house_type_id: "",
        description: "",
        start_date: "",
        end_date: "",
        payment_type: "",
        document: "",
        budget: "",
      },
      contractors: [],
      customers: [],
    };
  },
  mounted() {
    this.getContractors();
    this.getCustomers();
  },
  methods: {
    getContractors() {
      const self = this;
      self.$store.dispatch("getData", ["contractor"]).then((response) => {
        self.contractors = response.data;
      });
    },
    getCustomers() {
      const self = this;
      self.$store.dispatch("getData", ["customer"]).then((response) => {
        self.customers = response.data;
      });
    },
  },
};
</script>
<style >
</style>

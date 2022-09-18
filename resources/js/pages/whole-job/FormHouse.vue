<template >
  <Modal idModal="FormHouse" title="Formulir Borongan RUmah">
    <template v-slot:body>
      <div class="row">
        <div class="col-12 col-md-6 col-lg-6">
          <div class="form-group">
            <label>Nama PIC/Perusahaan</label>
            <select  class="form-control">
                <option v-for="contractor in contractors" :key="contractor" :value="contractor.id">{{ contractor.picName }} | {{ contractor.companyName }}</option>
            </select>
          </div>
          <div class="form-group">
            <label>Customer</label>
            <select  class="form-control">
                <option v-for="customer in customers" :key="customer" :value="customer.id">{{ customer.name }} </option>
            </select>
          </div>
        </div>
      </div>
    </template>
  </Modal>
</template>
<script>
import Modal from "../../components/Modal.vue";
export default {
  components: { Modal },
  data() {
    return {
      contractors: [],
      customers:[]
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
    getCustomers(){
        const self = this;
        self.$store.dispatch("getData", ["customer"]).then((response) => {
            self.customers = response.data;
        });
    }
  },
};
</script>
<style >
</style>

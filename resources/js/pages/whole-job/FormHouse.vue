<template >
  <Modal
    idModal="FormHouse"
    :tittle="id ? 'Edit Borongan Rumah' : 'Formulir Borongan Rumah'"
    size="modal-lg"
    @onConfirm="createJobHouse()"
  >
    <template v-slot:body>
      <div class="row m-auto">
        <div class="col-12">
          <div class="form-row">
            <div class="form-group col-lg-6">
              <label>Nama PIC/Perusahaan</label>
              <select class="form-control" v-model="contract.contractor_id">
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
              <select class="form-control" v-model="contract.payment_type">
                <option value="Termin">Termin</option>
                <option value="Bayar Setelah Kerja">Bayar Setelah Lunas</option>
                <option value="Upah Kerja">Upah Kerja</option>
              </select>
            </div>
            <div class="form-group col-lg-6">
              <label>Customer</label>
              <select
                class="form-control"
                @change="pickCustomer(this)"
                v-model="contract.customer_id"
              >
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
              <select class="form-control" v-model="contract.house_type_id">
                <option
                  v-for="kavling in kavlings"
                  :key="kavling"
                  :value="kavling.kavling.houseTypeId"
                >
                  <span>Tipe: {{ kavling.kavling.houseType.houseType }} </span
                  > || Blok:  <span
                    >{{ kavling.kavling.block }} -
                    {{ kavling.kavling.numberKavling }}</span
                  >
                </option>
              </select>
            </div>
            <div class="form-group col-lg-12">
              <label>Deskripsi Pekerjaan</label>
              <SummerNote v-model="contract.description" />
            </div>
            <div class="form-group col-lg-6">
              <label>Tanggal Mulai</label>
              <input
                type="date"
                class="form-control"
                v-model="contract.start_date"
              />
            </div>
            <div class="form-group col-lg-6">
              <label>Tanggal Selesai</label>
              <input
                type="date"
                class="form-control"
                v-model="contract.end_date"
              />
            </div>
            <div class="custom-file form-group col-lg-6">
              <input
                type="file"
                class="custom-file-input"
                multiple
                @change="selectDocuments"
              />
              <label class="custom-file-label" for="customFile">Dokumen</label>
            </div>
            <div class="form-group col-lg-6">
              <InputCurrency
                v-model="contract.budget"
                :value="contract.budget"
                placeholder="Total Anggaran"
              />
            </div>
          </div>
        </div>
        <div class="col-lg-6 mt-2">
          <strong class="d-block mb-2">Dokumen:</strong>
          <div
            v-for="document in contract.documents"
            :key="document"
            class="badge badge-primary m-1 p-2"
          >
            {{ document.name }}
            <i
              class="fas fa-times sortable"
              @click="removeDocument(document)"
            ></i>
          </div>
        </div>
      </div>
    </template>
  </Modal>
</template>
<script>
import Modal from "../../components/Modal.vue";
import Utils from "../../store/services/utils";
import SummerNote from "../../components/SummerNote.vue";
import InputCurrency from "../../components/InputCurrency.vue";
import iziToast from "izitoast";
export default {
  props: [],
  components: { Modal, SummerNote, InputCurrency },
  data() {
    return {
      contract: {
        contractor_id: "",
        customer_id: "",
        house_type_id: "",
        description: "",
        start_date: "",
        end_date: "",
        payment_type: "",
        documents: [],
        budget: "",
      },
      contractors: [],
      customers: [],
      kavlings: [],
      houses: [],

      selectedCustomer: null,
    };
  },
  mounted() {
    this.getContractors();
    this.getCustomers();
    this.getHouse();
  },
  computed: {
    formData() {
      let formData = new FormData();
      formData.append("contractor_id", this.contract.contractor_id);
      formData.append("customer_id", this.contract.customer_id);
      formData.append("house_type_id", this.contract.house_type_id);
      formData.append("description", this.contract.description);
      formData.append("start_date", this.contract.start_date);
      formData.append("end_date", this.contract.end_date);
      formData.append(
        "total_cost",
        Utils.currencyToNumber(this.contract.budget)
      );
      formData.append("payment_type", this.contract.payment_type);
      this.contract.documents.forEach((file, index) => {
        formData.append("documents[" + index + "]", file);
      });
      return formData;
    },
  },
  methods: {
    removeDocument(doc) {
      this.contract.documents = this.contract.documents.filter(
        (document) => document.name !== doc.name
      );
    },
    checkIsDocument(file) {
      const allowedExtensions = [
        "image/jpg",
        "image/png",
        "image/jpeg",
        "application/pdf",
        "application/msword",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
      ];
      const extension = file.type;
      if (allowedExtensions.includes(extension)) {
        return true;
      } else {
        return false;
      }
    },
    selectDocuments(e) {
      const files = e.target.files;

      for (let i = 0; i < files.length; i++) {
        if (this.checkIsDocument(files[i])) {
          this.contract.documents.push(files[i]);
        } else {
          iziToast.warning({
            title: "Peringatan",
            message: "File harus berupa dokumen",
            position: "topRight",
          });
        }
      }
    },
    hideModal() {
      $("#FormHouse").hide("modal");
      $("div").removeClass("modal-backdrop");
    },
    pickCustomer(customer) {
      console.log("pickCustomer=>", customer.contract.customer_id);
      // find customer by id in customers
      this.selectedCustomer = this.customers.find(
        (c) => c.id === customer.contract.customer_id
      );
      // console.log('selectedCustomer=>',this.selectedCustomer)
      this.kavlings = this.selectedCustomer.customerKavling;
      console.log("kavlings=>", this.kavlings);
    },
    getContractors() {
      const self = this;
      self.$store.dispatch("getData", ["contractor"]).then((response) => {
        self.contractors = response.data;
      });
    },
    getHouse() {
      const self = this;
      self.$store.dispatch("getData", ["house-type/"]).then((response) => {
        this.houses = response.data;
      });
    },
    showHouse(id) {
      return this.houses.find((house) => house.id === id);
    },
    getCustomers() {
      const self = this;
      self.$store.dispatch("getData", ["customer"]).then((response) => {
        self.customers = response.data;
      });
    },
    createJobHouse() {
      const self = this;
      const type = "postDataUploadJob";
      const formData = self.formData;
      self.$store
        .dispatch(type, formData, "whole-job")
        .then((response) => {
          //   hide this. modal
          this.$emit("onSuccess");
          this.hideModal();
          this.reset();
          iziToast.success({
            title: "Berhasil",
            message: "Data berhasil disimpan",
            position: "topRight",
          });
        })
        .catch((error) => {
          let messages = error.response.data.meta.message;
          if (messages) {
            Object.entries(messages).forEach(([key, value]) => {
              iziToast.warning({
                title: "Peringatan",
                message: value,
                position: "topRight",
              });
            });
          }
        });
    },
    reset() {
      this.contract = {
        contractor_id: "",
        customer_id: "",
        house_type_id: "",
        description: "",
        start_date: "",
        end_date: "",
        payment_type: "",
        documents: [],
        budget: "",
      };
    },
  },
};
</script>
<style >
</style>

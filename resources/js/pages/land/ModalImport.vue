<template >
    <Modal
      idModal="importExcel"
      tittle="Import Data Tanah Dari Excel"
      size="modal-lg"
      @onConfirm="createJobHouse()"
      :loading="isLoading"
      data-backdrop="static"
      data-keyboard="false"
    >
      <template v-slot:body>
        <span class="mb-5">Pilih Data Excel Anda </span><br/>
        <div class="custom-file form-group col-lg-6 mt-3">
                                <input
                                    @change="selectDocuments"
                                    type="file"
                                    class="custom-file-input"
                                    multiple
                                />
                                <label
                                    class="custom-file-label"
                                    for="customFile"
                                    >Pilih Dokumen</label
                                >
                            </div>
        <br/>
      <button class="btn btn-info fa-add"> Unduh Format Excel</button>
      </template>
    </Modal>
  </template>
  <script>
  import Modal from "../../components/Modal.vue";
  export default {
    props: ["id"],
    components: { Modal},
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
          oldDocuments: [],
          budget: "",
        },
        contractors: [],
        customers: [],
        kavlings: [],
        //   houses: [],
        isLoading: false,
  
        selectedCustomer: null,
      };
    },
    watch: {
      id(newVal) {
        if (newVal != null) {
          this.getContract(newVal);
        }else{
          this.reset();
        }
      },
    },
    mounted() {
      this.getContractors();
      this.getCustomers();
      this.getHouse();
      // if (this.id != null) {
      //   this.getContract(this.id);
      // }
    },
  
    computed: {
      formData() {
        let formData = new FormData();
        if (this.id) {
          formData.append("id", this.id);
          formData.append("_method", "PUT");
        }
        formData.append("contractor_id", this.contract.contractor_id);
        formData.append("customer_id", this.contract.customer_id);
        formData.append("house_type_id", this.contract.house_type_id);
        formData.append("description", this.contract.description);
        formData.append("start_date", this.contract.start_date);
        formData.append("end_date", this.contract.end_date);
        formData.append("type", 'rumah');
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
        this.contract.documents.splice(this.contract.documents.indexOf(doc), 1);
      },
      removeOldDocument(doc) {
          this.contract.oldDocuments.splice(
              this.contract.oldDocuments.indexOf(doc),
              1
          );
      },
      getContract(id) {
        this.isLoading = true;
        this.contract.documents = [];
        this.$store.dispatch("showData", ["whole-job/" + id]).then((res) => {
          this.contract.contractor_id = res.data.contractor.id;
          this.contract.customer_id = res.data.customer.id;
          this.contract.payment_type = res.data.paymentType;
          this.selectedCustomer = this.customers.find(
            (c) => c.id === res.data.customer.id
          );
          this.kavlings = this.selectedCustomer.customerKavling;
          this.contract.house_type_id = res.data.houseTypeId;
          this.contract.description = res.data.description;
          this.contract.start_date = moment(res.data.startDate).format(
            "YYYY-MM-DD"
          );
          this.contract.end_date = moment(res.data.endDate).format("YYYY-MM-DD");
          this.contract.budget = res.data.totalCost;
          res.data.document.forEach((doc) => {
            this.contract.oldDocuments.push(doc);
          });
          this.isLoading = false;
        });
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
        // find customer by id in customers
  
        this.selectedCustomer = this.customers.find(
          (c) => c.id === customer.contract.customer_id
        );
        this.kavlings = this.selectedCustomer.customerKavling;
        // console.log('selectedCustomer=>',this.selectedCustomer)
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
      // showHouse(id) {
      //   return this.houses.find((house) => house.id === id);
      // },
      getCustomers() {
        const self = this;
        self.$store.dispatch("getData", ["customer"]).then((response) => {
          self.customers = response.data;
        });
      },
      createJobHouse() {
        const self = this;
        const type = this.id ? "updateDataUploadJob" : "postDataUploadJob";
        const formData = self.formData;
        this.isLoading = true;
        self.$store
          .dispatch(
            type,
            formData,
            this.id ? "whole-job/" + this.id : "whole-job"
          )
          .then((response) => {
            //   hide this. modal
            this.$emit("onSuccess");
            this.hideModal();
            if (this.id == null) {
              this.reset();
            }
            this.isLoading = false;
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
            this.isLoading = false;
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
  
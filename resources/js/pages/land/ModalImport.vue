<template >
  <Modal
    idModal="importExcel"
    tittle="Import Data Kavling"
    size="modal-md"
    :loading="isLoading"
    @onConfirm="doImport"
    data-backdrop="static"
    data-keyboard="false"
  >
    <template v-slot:body>
      <!-- alert -->
      <div class="alert alert-info" role="alert">
        <!-- <i class="fas fa-exclamation-triangle"></i> -->
        <strong>Perhatian!</strong>
        <p>Pilih Template Dokumen yang sudah di unduh</p>
      </div>
       <a
        class="btn btn-primary  btn-block mb-3"
        href="/assets/sample/SAMPLE_DATA_KAVLING.xlsx"
      >
        Unduh Format Excel</a
      >
      <div class="custom-file form-group col-lg-12">
        <input
          @change="selectDocument"
          type="file"
          class="custom-file-input"
        />
        <label class="custom-file-label" for="customFile">Pilih Dokumen</label>
      </div>
      <!-- show name file in badge from selectedDocument -->
        <div class="col-lg-12" v-show="selectDocument != null ">
            <span class="badge badge-primary ">
            {{ documentName }}
            </span>
        </div>
      <!-- bad -->
    </template>
  </Modal>
</template>
  <script>
import Modal from "../../components/Modal.vue";
import axios from "axios";
export default {
  props: ["id"],
  components: { Modal },
  data() {
    return {
      selectedDocument: null,
        isLoading: false,
        documentName: '',
        onUploadProgress: null,
        percentageProgress: 0,
    };
  },
  watch: {
    selectedDocument: function (val) {
      if (val != null) {
        this.documentName = val.name;
      }
    },

  },
  mounted() {},

  computed: {
    formData() {
      let formData = new FormData();
      if (this.id) {
        formData.append("id", this.id);
        formData.append("_method", "PUT");
      }

      return formData;
    },
  },
  methods: {
         hideModal() {
            $("#importExcel").hide("modal");
            $("div").removeClass("modal-backdrop");
        },
    removeDocument(doc) {
      this.selectDocument = null;
    },
    removeOldDocument(doc) {
        this.selectDocument = null;

    },

    checkIsDocument(file) {
    //   const allowedExtensions = ["xls", "xlsx"];
    // allowedextensoin is file application excel
        const allowedExtensions = ["application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"];

      const extension = file.type;
      if (allowedExtensions.includes(extension)) {
        return true;
      } else {
        return false;
      }
    },
    selectDocument(e) {
        console.log(e.target.files[0]);
        let file = e.target.files[0];
        if (this.checkIsDocument(file)) {
            this.selectedDocument = file;
        } else {
            this.$swal.fire({
            icon: "error",
            title: "Oops...",
            text: "File yang anda pilih bukan file excel",
            });
        }
    },
    onUploadProgress(progresEvent){

    },
    doImport(){
        let formData = new FormData();
        formData.append("file", this.selectedDocument);
        this.isLoading = true;
        axios
        .post("kavling/import", formData, {
            onUploadProgress:function (progressEvent)  {
                this.percentageProgress = Math.round(
                    (progressEvent.loaded / progressEvent.total) * 100
                )
            }.bind(this),
        })
        .then((res) => {
            this.isLoading = false;
            // this.$swal.fire({
            // icon: "success",
            // title: "Berhasil",
            // text: "Data berhasil di import",
            // });
            // clear modal
            this.selectedDocument = null;
            this.documentName = '';
            this.hideModal();
            this.$emit("close");
            this.$emit("onSuccess");
        })
        .catch((err) => {
            this.isLoading = false;
            this.$swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Terjadi kesalahan",
            });
        });
    },

  },

};
</script>
  <style >
</style>

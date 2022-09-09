<template>

      <section class="section">
        <div class="section-header">
          <h1>{{ id ? "Edit" : "Tambah" }} Data Pemborong</h1>
        </div>
        <div class="row">
          <div class="col d-flex justify-content-center">
            <div class="card" style="width: 80%;">
              <div class="card-header"></div>
              <div class="card-body">
                <form class="form-row">
                  <div class="form-group col-lg-6">
                    <label for="name">Nama Perusahaan</label>
                    <input
                      v-model="contractor.companyName"
                      type="text"
                      class="form-control"
                      placeholder="Nama Perusahaan"
                    />
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="name">Nama Pic</label>
                    <input
                      v-model="contractor.picName"
                      type="text"
                      class="form-control"
                      placeholder="Nama Pic"
                    />
                  </div>

                  <div class="form-group col-lg-6">
                    <label>Nomor Telepon</label>
                    <input
                      v-model="contractor.phone"
                      type="number"
                      class="form-control"
                      placeholder="Nomor Telepon"
                    />
                  </div>

                  <div class="form-group col-lg-6">
                    <label>Email</label>
                    <input
                      v-model="contractor.email"
                      type="text"
                      class="form-control"
                      placeholder="Email"
                    />
                  </div>

                  <div class="form-group col-lg-12">
                    <label>Alamat</label>
                    <input
                      v-model="contractor.address"
                      type="text"
                      class="form-control"
                      placeholder="Alamat"
                    />
                  </div>

                  <div class="custom-file form-group col-lg-6">
                    <input
                      @change="selectImage"
                      type="file"
                      class="custom-file-input"
                    />
                    <label class="custom-file-label" for="customFile"
                      >Pilih Foto</label
                    >
                  </div>
                  <div class="custom-file form-group col-lg-6">
                    <input
                      @change="selectDocuments"
                      type="file"
                      class="custom-file-input"
                      multiple
                    />
                    <label class="custom-file-label" for="customFile"
                      >Pilih Dokumen</label>
                  </div>
                </form>
                <div class="row">
                  <div class="col-lg-6">
                    <h6>Foto :</h6>
                    <div
                      v-show="previewImage"
                      class="card"
                      style="width: 200px; height: 200px"
                    >
                      <img
                        :src="previewImage"
                        alt="Gambar"
                        class="img-responsive"
                        style=""
                      />
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div
                      v-for="document in contractor.document"
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
              </div>
              <div class="card-footer text-right">
                  <button
                    :class="{ 'disabled btn-progress': isSubmit }"
                    @click="id ? updateContractor() : createContractor()"
                    class="btn btn-primary btn-block"
                    type="button"
                  >
                    {{ id ? "Update" : "Tambah" }}
                  </button>
                <button

                  @click="back"
                  class="btn btn-danger btn-block"
                  type="button"
                >
                  Batal
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>

  </template>
  <script>
  import iziToast from "izitoast";
  import moment from "moment";

  export default {
    props: ["id"],
    data() {
      return {
        contractor: {
          companyName: "",
          picName: "",
          phone: "",
          email: "",
          address: "",
          image: "",
          document: [],
        },
        previewImage: "",
        isSubmit: false,
      };
    },
    mounted: function () {
      if (this.id) {
        this.showContractor();
      }
    },
    computed: {
      formData() {
        const fieldData = new FormData();
        if (this.id) {
          fieldData.append("id", this.id);
          fieldData.append("_method", "PUT");
        }
        fieldData.append("company_name", this.contractor.companyName);
        fieldData.append("pic_name", this.contractor.picName);
        fieldData.append("phone", this.contractor.phone);
        fieldData.append("email", this.contractor.email);
        fieldData.append("address", this.contractor.address);
        //   fieldData.append("documents", this.contractor.document);
        this.contractor.document.forEach((document, index) =>
          fieldData.append("documents[" + index + "]", document)
        );

        if (this.contractor.image) {
          fieldData.append("image", this.contractor.image);
        }
        return fieldData;
      },
    },
    methods: {
      back() {
        this.$router.back();
      },
      removeDocument(document) {
        this.contractor.document.splice(
          this.contractor.document.indexOf(document),
          1
        );
      },
      checkExtension(file) {
        const allowedExtensions = ["image/jpg", "image/png", "image/jpeg"];
        const extension = file.type;
        if (allowedExtensions.includes(extension)) {
          return true;
        } else {
          return false;
        }
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
            this.contractor.document.push(files[i]);
          } else {
            iziToast.warning({
              title: "Peringatan",
              message: "File harus berupa dokumen",
              position: "topRight",
            });
          }
        }
      },
      selectImage(e) {
        const file = e.target.files[0];
        if (this.checkExtension(file)) {
          this.contractor.image = file;
          this.previewImage = URL.createObjectURL(file);
        } else {
          iziToast.warning({
            title: "Warning",
            message: "File harus berformat jpg, png, jpeg",
            position: "topRight",
          });
        }
      },

      createContractor() {
        const self = this;
        this.isSubmit = true;
        let type = "postDataUploadContractor";
        let fieldData = this.formData;
        self.$store
          .dispatch(type, fieldData, "contractor")
          .then((res) => {
            this.isSubmit = false;
            this.$router.back();
            iziToast.success({
              title: "Success",
              message: "Data berhasil ditambahkan",
              position: "topRight",
            });
          })
          .catch((err) => {
            this.isSubmit = false;
            let meta = err.response.data.meta;
            let messages = err.response.data.meta.message;
            Object.entries(messages).forEach(([key, value]) => {
              iziToast.warning({
                title: "Warning",
                message: value,
                position: "topRight",
              });
            });
          });
      },
      showContractor() {
        const self = this;
        self.$store
          .dispatch("getData", ["/contractor/" + self.id])
          .then((response) => {
            this.previewImage = "storage/" + response.data.image;
            self.contractor.companyName = response.data.companyName;
            self.contractor.picName = response.data.picName;
            self.contractor.phone = response.data.phone;
            self.contractor.email = response.data.email;
            self.contractor.address = response.data.address;
          });
      },
      updateContractor() {
        const self = this;
        this.isSubmit = true;
        let type = "updateDataUploadContractor";
        const fieldData = this.formData;
        self.$store
          .dispatch(type, fieldData, ["contractor/" + self.id])
          .then((res) => {
            this.isSubmit = false;
            this.$router.back();
            iziToast.success({
              title: "Success",
              message: "Data berhasil diubah",
              position: "topRight",
            });
          })
          .catch((err) => {
            this.isSubmit = false;
            let meta = err.response.data.meta;
            let messages = err.response.data.meta.message;
            Object.entries(messages).forEach(([key, value]) => {
              iziToast.warning({
                title: "Warning",
                message: value,
                position: "topRight",
              });
            });
          });
      },
    },
  };
  </script>

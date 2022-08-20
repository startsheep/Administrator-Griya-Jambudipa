<template>
  <Transition name="fade">
    <section class="section">
      <div class="section-header">
        <h1>{{ id ? "Edit" : "Tambah" }} Data Pegawai</h1>
      </div>
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
              <form class="form-row">
                <div class="form-group col-lg-6">
                  <label for="name">Nama Lengkap</label>
                  <input
                    v-model="employee.name"
                    type="text"
                    class="form-control"
                    placeholder="Nama Lengkap"
                  />
                </div>

                <div class="form-group col-lg-6">
                  <label>Jenis Pegawai</label>
                  <select
                    v-model="employee.type_emp"
                    class="form-control form-control"
                  >
                    <option value="1">Pegawai Tetap</option>
                    <option value="0">Pegawai Tidak Tetap</option>
                  </select>
                </div>
                <div class="form-group col-lg-6">
                  <label>Jabatan</label>
                  <select
                    v-model="employee.position_id"
                    class="form-control form-control"
                  >
                    <option
                      v-for="position in positions"
                      :key="position.id"
                      :value="position.id"
                    >
                      {{ position.name }}
                    </option>
                  </select>
                </div>
                <div class="form-group col-lg-6">
                  <label>Email</label>
                  <input
                    v-model="employee.email"
                    type="text"
                    class="form-control"
                    placeholder="Email"
                  />
                </div>
                <div class="form-group col-lg-6">
                  <label>Nomor Telepon</label>
                  <input
                    v-model="employee.phone"
                    type="number"
                    class="form-control"
                    placeholder="Nomor Telepon"
                  />
                </div>

                <div class="form-group col-lg-6">
                  <label>Jenis Kelamin</label>
                  <select
                    v-model="employee.gender"
                    class="form-control form-control"
                  >
                    <option value="L">Laki-Laki</option>

                    <option value="P">Perempuan</option>
                  </select>
                </div>

                <div class="form-group col-lg-6">
                  <label>Alamat</label>
                  <textarea
                    v-model="employee.address"
                    class="form-control"
                    rows="1"
                  ></textarea>
                </div>

                <div class="form-group col-lg-6">
                  <label>Tanggal Masuk</label>
                  <input
                    v-model="employee.entry_date"
                    type="date"
                    class="form-control"
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
                    >Pilih Dokumen</label
                  >
                  <div v-if="employee.document" class="form-group col-lg-6">
                    <!-- -->
                  </div>
                </div>
              </form>
              <div class="row">
                <div class="col-lg-6">
                  <div v-if="employee.image" class="badge badge-primary mt-2">
                    {{ employee.image.name }}
                  </div>
                </div>
                <div class="col-lg-6">
                  <div v-for="document in employee.document" :key="document" class="badge badge-primary m-1 p-2">
                    {{ document.name }} <i class="fas fa-times sortable" @click="removeDocument(document)"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="d-flex justify-content-center">
                <button @click="back" class="btn btn-danger mr-2" type="button">
                  Batal
                </button>
                <button
                  :class="{ 'disabled btn-progress': isSubmit }"
                  @click="id ? updateEmployee() : createEmployee()"
                  class="btn btn-primary ml-2"
                  type="button"
                >
                  {{ id ? "Update" : "Tambah" }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </Transition>
</template>
<script>
import iziToast from "izitoast";
import moment from "moment";

export default {
  props: ["id"],
  data() {
    return {
      idEmp: "",
      employee: {
        // name: "",
        email: "",
        position_id: "",
        type_emp: "",
        entry_date: "",
        phone: "",
        address: "",
        gender: "",
        image: "",
        document: [],
      },
      defaultImage: "../../../../public/assets/images/avatar/avatar-1.png",
      previewImage: "",
      positions: [],
      isSubmit: false,
    };
  },
  mounted: function () {
    this.getPositions();
    if (this.id) {
      this.showEmployee();
    }
  },
  computed: {
    formData() {
      const fieldData = new FormData();
      if (this.id) {
        fieldData.append("id", this.id);
        fieldData.append("_method", "PUT");
      }
      fieldData.append("name", this.employee.name);
      fieldData.append("email", this.employee.email);
      fieldData.append("position_id", this.employee.position_id);
      fieldData.append("type_emp", this.employee.type_emp);
      fieldData.append("entry_date", this.employee.entry_date);
      fieldData.append("phone", this.employee.phone);
      fieldData.append("address", this.employee.address);
      fieldData.append("gender", this.employee.gender);
      fieldData.append("documents", this.employee.document);
      if (this.employee.image) {
        fieldData.append("image", this.employee.image);
      }
      return fieldData;
    },
  },
  methods: {
    back() {
      this.$router.back();
    },
    removeDocument(document) {
      this.employee.document.splice(this.employee.document.indexOf(document), 1);
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
          this.employee.document.push(files[i]);
        } else {
          iziToast.warning({
            title: "Peringatan",
            message: "File harus berupa dokumen",
            position: "topRight",
          });
        }
      }
      console.log(this.employee.document);
    },
    selectImage(e) {
      console.log(e.target.files);
      const file = e.target.files[0];
      if (this.checkExtension(file)) {
        this.employee.image = file;
        const reader = new FileReader();
        reader.onload = (e) => {
          this.previewImage = e.target.result;
        };
        reader.readAsDataURL(file);
      } else {
        iziToast.warning({
          title: "Warning",
          message: "File harus berformat jpg, png, jpeg",
          position: "topRight",
        });
      }
    },

    getPositions() {
      const self = this;
      console.log(this.id);
      self.$store.dispatch("getData", ["position"]).then((response) => {
        self.positions = response.data;
      });
    },
    createEmployee() {
      const self = this;
      this.isSubmit = true;
      let type = "postDataUploadEmployee";
      let fieldData = this.formData;
      console.log(fieldData);
      self.$store
        .dispatch(type, fieldData, "employee")
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

          console.log(messages);
          Object.entries(messages).forEach(([key, value]) => {
            iziToast.warning({
              title: "Warning",
              message: value,
              position: "topRight",
            });
          });
        });
    },
    showEmployee() {
      const self = this;
      self.$store
        .dispatch("getData", ["/employee/" + self.id])
        .then((response) => {
          console.log(response.data);
          this.previewImage = response.data.image;
          self.employee.name = response.data.name;
          self.employee.email = response.data.email;
          self.employee.position_id = response.data.positionId;
          self.employee.type_emp = response.data.status;
          self.employee.entry_date = response.data.entryDate;
          self.employee.phone = response.data.phone;
          self.employee.address = response.data.address;
          self.employee.gender = response.data.gender;
        });
    },
    updateEmployee() {
      const self = this;
      this.isSubmit = true;
      let type = "updateDataUploadEmployee";
      console.log(this.employee.image);
      const fieldData = this.formData;
      self.$store
        .dispatch(type, fieldData, ["employee/" + self.id])
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
          console.log(err);
        });
    },
  },
};
</script>


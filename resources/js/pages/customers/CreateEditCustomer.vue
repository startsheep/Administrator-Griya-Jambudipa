
<template>
      <div class="col d-flex justify-content-center">
        <div class="card" style="width: 80%">
          <div class="card-header">
            <h4>Formulir {{ id ? "Edit" : "Tambah" }} Data Customer</h4>
          </div>
          <div class="card-body">
            <form class="form-row">
              <div class="form-group col-lg-6">
                <label for="name">Nama Lengkap</label>
                <input
                  v-model="customer.name"
                  type="text"
                  class="form-control"
                  placeholder="Nama Lengkap"
                />
              </div>

              <div class="form-group col-lg-6">
                <label>Pekerjaan</label>
                <input
                  v-model="customer.profession"
                  type="text"
                  class="form-control"
                  placeholder="Pekerjaan"
                />
              </div>
              <div class="form-group col-lg-6">
                <label>Email</label>
                <input
                  v-model="customer.email"
                  type="text"
                  class="form-control"
                  placeholder="Email"
                />
              </div>
              <div class="form-group col-lg-6">
                <label>Nomor Telepon</label>
                <input
                  v-model="customer.phone"
                  type="number"
                  class="form-control"
                  placeholder="Nomor Telepon"
                />
              </div>

              <div class="form-group col-lg-6">
                <label>Jenis Kelamin</label>
                <select
                  v-model="customer.gender"
                  class="form-control form-control"
                >
                  <option value="L">Laki-Laki</option>

                  <option value="P">Perempuan</option>
                </select>
              </div>

              <div class="form-group col-lg-6">
                <label class="typo__label">Blok Kavling</label>
                <multiselect
                  v-model="customer.kavlings"
                  :options="kavlings"
                  :multiple="true"
                  :close-on-select="false"
                  :clear-on-select="false"
                  :preserve-search="true"
                  placeholder="Pick some"
                  label="block"
                  track-by="block"
                >
                  <template slot="singleLabel" slot-scope="props"
                    ><span class="option__desc"
                      ><span class="option__title">{{
                        props.option.block
                      }}</span></span
                    ></template
                  >
                  <template slot="option" slot-scope="props">
                    <div class="option__desc">
                      <span class="option__title">{{ props.option.block }}</span
                      ><span class="option__small">{{
                        props.option.numberKavling
                      }}</span>
                    </div>
                  </template>
                </multiselect>
                <!-- <pre class="language-json"><code>{{ value  }}</code></pre> -->
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
                <div v-if="customer.document" class="form-group col-lg-6">
                  <!-- -->
                </div>
              </div>

              <div class="form-group col-lg-12">
                <label>Alamat</label>
                <textarea
                  v-model="customer.address"
                  class="form-control"
                  rows="1"
                ></textarea>
              </div>
            </form>
            <div class="row">
              <div class="col-lg-6">
                <PreviewImage  :previewImage="previewImage"/>
              </div>
              <div class="col-lg-6">
                <div
                  v-for="document in customer.document"
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
          <div class="card-footer">
            <button
              :class="{ 'disabled btn-progress': isSubmit }"
              @click="id ? updateCustomer() : createCustomer()"
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

</template>
<script>
import Multiselect from "vue-multiselect";
import iziToast from "izitoast";
import moment from "moment";
import PreviewImage from "../../components/PreviewImage.vue";

export default {
  props: ["id"],
  components: { Multiselect, PreviewImage },
  data() {
    return {
      //   value: [],
      customer: {
        name: "",
        email: "",
        profession: "",
        kavlings: [],
        phone: "",
        address: "",
        gender: "",
        image: "",
        document: [],
      },
      previewImage: "",
      kavlings: [],
      isSubmit: false,
    };
  },
  mounted() {
    this.getKavlings();
    this.changeKavlings();
    if (this.id) {
      this.showCustomer();
    }
  },
  computed: {
    customLabel({ block, numberKavling }) {
      return `${block} – ${block}`;
    },

    formData() {
      const fieldData = new FormData();
      let kavlings_id = [];
      //   this.customer.kavlings.forEach((kav , index)=>kavlings_id.push(kav.id))
      if (this.id) {
        fieldData.append("id", this.id);
        fieldData.append("_method", "PUT");
      }
      this.customer.kavlings.forEach((kav, index) => {
        fieldData.append("kavlings[" + index + "]", kav.id);
      });
      fieldData.append("name", this.customer.name);
      fieldData.append("email", this.customer.email);
      //   fieldData.append("kavlings", kavlings_id);
      fieldData.append("profession", this.customer.profession);
      fieldData.append("phone", this.customer.phone);
      fieldData.append("address", this.customer.address);
      fieldData.append("gender", this.customer.gender);
      this.customer.document.forEach((document, index) => {
        fieldData.append("documents[" + index + "]", document);
      });
      //   fieldData.append("documents[]", this.customer.document);
      if (this.customer.image) {
        fieldData.append("image", this.customer.image);
      }
      return fieldData;
    },
  },
  methods: {
    changeKavlings() {},
    back() {
      this.$router.back();
    },
    removeDocument(document) {
      this.customer.document.splice(
        this.customer.document.indexOf(document),
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
          this.customer.document.push(files[i]);
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
        this.customer.image = file;
        this.previewImage = URL.createObjectURL(file);
      } else {
        iziToast.warning({
          title: "Warning",
          message: "File harus berformat jpg, png, jpeg",
          position: "topRight",
        });
      }
    },

    getKavlings() {
      const self = this;
      self.$store.dispatch("getData", ["kavling"]).then((response) => {
        response.data.forEach((elm) => {
          // console.log(elm)
          this.kavlings.push({
            id: elm.id,
            block: elm.block + "-" + elm.numberKavling,
          });
        });
        console.log(this.kavlings);
      });
    },
    createCustomer() {
      const self = this;
      this.isSubmit = true;
      let type = "postDataUploadCustomer";
      let fieldData = this.formData;
      self.$store
        .dispatch(type, fieldData, "customer")
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
    showCustomer() {
      const self = this;

      self.$store
        .dispatch("getData", ["/customer/" + self.id])
        .then((response) => {
          //   console.log(response);
          this.previewImage = '/storage/'+response.data.image;
          self.customer.name = response.data.name;
          self.customer.email = response.data.email;
          self.customer.profession = response.data.profession;
          //   self.customer.kavlings =response.data.customerKavling.kavling;
          self.customer.entry_date = response.data.entryDate;
          self.customer.phone = response.data.phone;
          self.customer.address = response.data.address;
          self.customer.gender = response.data.gender;
          response.data.customerKavling.forEach((kav) => {
            kav.kavling.block =
              kav.kavling.block + "-" + kav.kavling.numberKavling;
            //   console.log(kav.kavling)
            this.customer.kavlings.push(kav.kavling);
          });
        });
    },
    updateCustomer() {
      const self = this;
      this.isSubmit = true;
      let type = "updateDataUploadCustomer";

      const fieldData = this.formData;
      self.$store
        .dispatch(type, fieldData, ["customer/" + self.id])
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


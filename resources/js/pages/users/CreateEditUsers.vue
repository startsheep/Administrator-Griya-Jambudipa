<template>
<<<<<<< Updated upstream
  <Modal idModal="formUserModal"
   :loading="isSubmit"
    :tittle=" (id ?'Edit' :'Tambah' ) +  ' Akun Pengguna' "
   @onConfirm="handleSubmit"
   @onClose="resetForm"
   size="lg"
  >
    <template #body>
      <form @submit.prevent="handleSubmit">
          <div class="row">
          <div class="form-group col-lg-6">
            <label for="name">Nama</label>
            <input
              type="text"
              class="form-control"
              v-model="form.name"
              id="name"
            />
          </div>
          <div class="form-group col-lg-6">
            <label for="email">Email</label>
            <input
              type="text"
              class="form-control"
              v-model="form.email"
              id="email"
            />
          </div>
=======
    <div
        class="modal fade"
        id="formUserModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="formUserModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formUserModalLabel">
                        {{ id ? "Edit Akun Pengguna" : "Tambah Akun Pengguna" }}
                    </h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                        @click="emptyForm()"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="handleSubmit">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.name"
                                id="name"
                            />
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.email"
                                id="email"
                            />
                        </div>
                        <div class="form-group">
                            <label for="phone">No Telp</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.phone"
                                id="phone"
                            />
                        </div>
  
                        <div class="form-group col-lg-6">
                                <label>Pilih Role Akun</label>
                                <select
                                    class="form-control form-control"
                                    v-model="form.role_id"
                                >
                                    <option value="1">Administrator</option>
                                    <option value="2">Staff</option>
                                </select>
                            </div>
>>>>>>> Stashed changes

            <div class="form-group col-lg-6">
            <label for="phone">No Telp</label>
            <input
              type="text"
              class="form-control"
              v-model="form.phone"
              id="phone"
            />
          </div>

          <div class="form-group col-lg-6">
            <label>Pilih Role Akun</label>
            <select class="form-control form-control" v-model="form.role_id">
              <option value="1">Administrator</option>
              <option value="2">Staff</option>
            </select>
          </div>
          </div>

          <div class="form-group" v-if="previewImage">
            <img :src="previewImage" style="width: 100%" />
          </div>
          <div class="custom-file form-group">
            <input
              type="file"
              class="custom-file-input"
              id="image"
              @change="uploadImage"
            />
            <label class="custom-file-label" for="customFile"
              >Pilih gambar</label
            >
          </div>

      </form>
    </template>
  </Modal>
</template>

<script>
import iziToast from "izitoast";
import Modal from "../../components/Modal.vue";

export default {
  props: ['id'],
  data() {
    return {
      form: {
        image: null,
        name: "",
        email: "",
        phone: "",
        role_id: "",
      },
      previewImage: null,
      isLoading: false,
      isSubmit: false,
    };
  },
  watch: {
    id(newVal) {
      if (newVal != null) {
        this.getUser(newVal);
      } else {
        this.resetForm();
      }
    },

  },
  mounted() {
    if (this.id != null) {
      this.getUser(this.id);
    }
  },
  computed: {
    formData() {
      const fieldData = new FormData();
      fieldData.append("name", this.form.name);
      fieldData.append("email", this.form.email);
      fieldData.append("phone", this.form.phone);
      fieldData.append("role_id", this.form.role_id);
      if (this.id) {
        fieldData.append("_method", "PUT");
        fieldData.append("id", this.id);
      }
      return fieldData;
    },
  },
  methods: {
    getUser(id) {
      console.log(id);
      this.$store.dispatch("showData", ["user/" + id]).then((res) => {
        this.form.name = res.data.name;
        this.form.email = res.data.email;
        this.form.phone = res.data.phone;
        this.form.role_id = res.data.roleId;
        this.previewImage = "storage/" + res.data.document[0].documentPath;
      });
    },
<<<<<<< Updated upstream
    uploadImage(e) {
      let files = e.target.files[0];
      this.previewImage = URL.createObjectURL(files);
      this.form.image = files;
      $(".custom-file-label").addClass("selected").html(files.name);
=======
    data() {
        return {
            form: {
                image: null,
                name: "",
                email: "",
                phone: "",
                role_id: "",
            },
            previewImage: null,
            isLoading: false,
            isSubmit: false,
        };
>>>>>>> Stashed changes
    },
    handleSubmit() {
      let fieldData = this.formData;
      this.isLoading = true;
      this.isSubmit = true;
      if (this.form.image) {
        fieldData.append("image", this.form.image);
      }
      if (this.id) {
        this.$store
          .dispatch("updateDataUploadUser", fieldData, ["user/" + this.id])
          .then((result) => {
            this.isLoading = false;
            this.isSubmit = false;
            this.deleteModal();
            // this.resetForm();
            this.$emit("onSuccess");
            iziToast.success({
              title: "Berhasil",
              message: "Data berhasil diubah",
              position: "topRight",
            });
<<<<<<< Updated upstream
          })
          .catch((err) => {
            this.isLoading = false;
            this.isSubmit = false;
            let meta = err.response.data.meta;
            let messages = err.response.data.meta.message;
            Object.entries(messages).forEach(([key, value]) => {
              iziToast.warning({
                title: "Peringatn",
                message: value,
                position: "topRight",
              });
            });
          });
      } else {
        this.$store
          .dispatch("postDataUploadUser", fieldData, "user")
          .then((result) => {
            this.isLoading = false;
            this.isSubmit = false;
            this.deleteModal();
            this.resetForm();
            iziToast.success({
              title: "Berhasil",
              message: "Data berhasil ditambah",
              position: "topRight",
            });
            this.$emit("onSuccess", this);
          })
          .catch((err) => {
            this.isLoading = false;
            this.isSubmit = false;
            let meta = err.response.data.meta;
            let messages = err.response.data.meta.message;
            Object.entries(messages).forEach(([key, value]) => {
              iziToast.warning({
                title: "Peringatan",
                message: value,
                position: "topRight",
              });
            });
          });
      }
    },
    deleteModal() {
      $("#formUserModal").modal("hide");
=======
            this.form.name = user.name;
            this.form.email = user.email;
            this.form.role_id = user.role_id;
        },
    },
    computed: {
        formData() {
            const fieldData = new FormData();
            fieldData.append("name", this.form.name);
            fieldData.append("email", this.form.email);
            fieldData.append("phone", this.form.phone);
            fieldData.append("role_id", this.form.role_id);

            if (this.user && this.id) {
                fieldData.append("_method", "PUT");
                fieldData.append("id", this.id);
            }

            return fieldData;
        },
>>>>>>> Stashed changes
    },
    resetForm() {
    //   this.id = "";
      this.form = {
        image: null,
        name: "",
        email: "",
        phone: "",
        role_id: "",
      };
      this.id = null;
      this.previewImage = null;
      $(".custom-file-label").addClass("selected").html("Pilih gambar");
    },
  },
  components: { Modal },
};
</script>

<style></style>

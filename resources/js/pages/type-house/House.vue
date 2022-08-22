<template>
  <section class="section">
    <div class="section-header">
      <h1>Tipe Rumah</h1>
    </div>
    <div class="row">
         <div class="col-12 col-lg-5" style="position:sticky;">
        <div class="card " >
          <div class="card-header">
            <h4>Tambah Tipe Rumah</h4>
          </div>
          <div class="card-body">
            <form>
              <div class="form-group">
                <label>Tipe</label>
                <input
                  v-model="house.type"
                  type="text"
                  class="form-control"
                  placeholder="Tipe"
                />
              </div>

              <div class="form-group">
                <label for="">Harga</label>
                <input type="text" class="form-control" placeholder="Harga" />
              </div>
              <div class="form-group">
                <SummerNote />
                <!-- <textarea class="form-control" cols="80" rows="1"></textarea> -->
              </div>
              <div class="form-group custom-file">
                <label class="custom-file-label">Gambar</label>
                <input
                  multiple
                  type="file"
                  @change="selectImages"
                  class="form-control custom-file-input"
                  placeholder="Image"
                />
              </div>
            </form>
            <div class="row d-flex justify-content-center">

                    <div v-for="(image ,index) in previewImages" :key="image" class="d-flex justify-content-end mr-1 mb-1 " style="width: 100px; height: 100px;">
                        <span @click="removeItem(index)" class="badge badge-primary position-absolute cursor">&times;</span>
                        <img :src="image" alt="" class="img-thumbnail" style="object-fit: cover; width: 100px; height: 100px">
                    </div>
                    <!-- <div class="bg-primary mr-1" style="width: 100px; height: 100px;"> </div>
                    <div class="bg-primary mr-1" style="width: 100px; height: 100px;"> </div> -->
            </div>
          </div>
          <div class="card-footer">
            <button
              type="button"
              :class="{ 'disabled btn-progress': isSubmit }"
              @click="createHouse()"
              class="btn btn-primary btn-block"
            >
              Tambah
            </button>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-7">
        <div class="card">
          <div class="card-header">
            <button
              class="btn btn-primary"
              data-toggle="modal"
              data-target="#ModalHouse"
            >
              Tambah Data
            </button>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-8">
                <div class="btn-group-sm mb-3">
                  <button
                    data-toggle="modal"
                    data-target="#modal-create"
                    type="button"
                    class="btn btn-icon icon-rigth btn-primary mr-2"
                  >
                    EXPORT PDF <i class="fa-solid fa-file-pdf"></i>
                  </button>
                  <button
                    type="button"
                    class="btn btn-icon icon-rigth btn-primary mr-2"
                  >
                    EXPORT EXCEL <i class="fa-solid fa-file-excel"></i>
                  </button>
                  <button
                    type="button"
                    class="btn btn-icon icon-rigth btn-primary mr-2"
                  >
                    PRINT DATA <i class="fa-solid fa-print"></i>
                  </button>
                </div>
              </div>
              <div class="col-lg-4">
                <input
                  v-on:keyup="search"
                  v-model="name"
                  class="form-control"
                  placeholder="Search"
                />
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th width="5%">#</th>
                    <th width="25%">Tipe</th>
                    <th width="35%">Deskripsi</th>
                    <th width="25%">Harga</th>
                    <th width="10% " class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(house, index) in houses" :key="house.id">
                    <td class="text-center">
                      <!-- calculate iteration then page number-->
                      {{ iteration(index) }}
                    </td>
                    <td>
                      <span> {{ house.houseType }}</span>
                    </td>
                    <td>
                      <span> {{ house.houseType }}</span>
                    </td>
                    <td>
                      <span> {{ house.houseType }}</span>
                    </td>
                    <td class="align-middle text-center">
                      <div class="show">
                        <button
                          data-toggle="dropdown"
                          class="btn btn-transparent"
                        >
                          <i
                            class="
                              fa-solid fa-ellipsis-vertical
                              dropdown-toggle
                            "
                            aria-expanded="true"
                          ></i>
                        </button>
                        <div class="dropdown-menu action">
                          <router-link
                            class="dropdown-item action sortable btn"
                            :to="'/customer/' + house.id + '/edit'"
                            >Edit</router-link
                          >
                          <router
                            class="dropdown-item action sortable btn"
                            @click="deleteHouse(house.id)"
                            >Hapus</router
                          >
                          <span class="dropdown-item action sortable"
                            >Detail</span
                          >
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              <CircleLoader v-show="isLoading" />
            </div>
          </div>
          <div class="card-footer">
            <Pagination
              :currentPage="pagination.currentPage"
              :rowsTotal="pagination.total"
              :lastPage="pagination.lastPage"
              @onPageChange="onPageChange($event)"
            />
            <ModalCreate />
          </div>
        </div>
      </div>

    </div>
  </section>
</template>
<script>
import iziToast from "izitoast";
import CircleLoader from "../../components/CircleLoader.vue";
import Pagination from "../../components/Pagination.vue";
import ModalCreate from "./ModalCreate.vue";
import SummerNote from "../../components/SummerNote.vue";
import DetailImage from "../../components/DetailImage.vue";

export default {
  data() {
    return {
      houses: [],
      house: {
        type: "",
        description: "",
        price: "",
        images: [],
      },
      isLoading: false,
      previewImages: [],
      detailImage: [],
      name: "",
      order_direction: "asc",
      isSubmit: false,
      //Pagination
      pagination: {
        total: 0,
        perPage: 5,
        currentPage: 1,
        lastPage: 0,
        page: 0,
      },
    };
  },
  mounted() {
    this.getHouses();
  },
  computed: {
    formData() {
      const fieldData = new FormData();
      fieldData.append("house_type", this.house.type);
      // fieldData.append('price' , self.house.price)
      // fieldData.append('image' , self.house.image)
      return fieldData;
    },
  },
  methods: {
    showDetail(img) {
      this.detailImage = img;
    },
    removeItem(index){
        this.previewImages.splice(index, 1);
    },
    iteration(index) {
      return (
        (this.pagination.currentPage - 1) * this.pagination.perPage + index + 1
      );
    },
    checkExtension(file) {
      const allowedExtensions = ["image/jpg", "image/png", "image/jpeg", "pdf"];
      // const fileExtension = file.split(".").pop().toLowerCase();
      if (allowedExtensions.includes(file.type)) {
        return true;
      } else {
        return false;
      }
    },

    selectImages(e) {
      console.log(e);
      const files = e.target.files;
      for (let i = 0; i < files.length; i++) {
        if (this.checkExtension(files[i])) {
          this.house.images.push(files[i]);
          this.previewImages.push(URL.createObjectURL(files[i]));
          console.log(this.previewImage);
        } else {
          iziToast.warning({
            title: "Peringatan",
            message: "File harus berupa gambar",
            position: "topRight",
          });
        }
      }
    },
    getHouses() {
      const self = this;
      this.isLoading = true;
      const params = [
        // `name=${this.name}`,
        // `position=${this.name}`,
        `order_by=positions.id`,
        `order_direction=${this.order_direction}`,
        `page=${this.pagination.page}`,
        `per_page=${this.pagination.perPage}`,
      ];
      self.$store.dispatch("getData", ["house-type", params]).then((res) => {
        self.houses = res.data;
        self.pagination.total = res.meta.total;
        self.pagination.currentPage = res.meta.currentPage;
        self.pagination.lastPage = res.meta.lastPage;
        this.isLoading = false;
      });
    },
    createHouse() {
      const self = this;
      let type = "postDataUploadHouse";
      let fieldData = self.formData;
      this.isSubmit = true;
      if (this.house.type == "") {
        this.isSubmit = false;
        iziToast.warning({
          title: "Peringatan",
          message: "Tipe Rumah tidak boleh kosong",
          position: "topRight",
        });
      } else {
        self.$store.dispatch(type, fieldData, "house-type").then((res) => {
          this.isSubmit = false;
          iziToast.success({
            title: "success",
            text: "Tipe Rumah berhasil ditambahkan",
            position: "topRight",
          });
          self.getHouses();
        });
      }
    },
    deleteHouse(id) {
      const self = this;
      this.$swal
        .fire({
          title: "Yakin ?",
          text: "Data akan dihapus",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Hapus!",
          cancelButtonText: "Batal",
        })
        .then((result) => {
          if (result.isConfirmed) {
            self.$store
              .dispatch("deleteData", ["house-type", id])
              .then((response) => {
                iziToast.success({
                  title: "Success",
                  message: "Data berhasil dihapus",
                  position: "topRight",
                });
                this.getHouses();
              });
          }
        });
    },
    onPageChange(page) {
      this.pagination.page = page;
      this.getHouses();
    },
  },
  components: {
    CircleLoader,
    Pagination,
    ModalCreate,
    SummerNote,
    DetailImage,
  },
};
</script>

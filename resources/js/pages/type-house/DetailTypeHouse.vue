<template>
  <section class="section">
    <div class="section-body my-2">
      <div class="row">
        <div class="col-12 col-sm-12 col-lg-4">
          <div class="card">
            <div class="card-header">
              <h4>Informasi Rumah</h4>
            </div>
            <div class="card-body">
              <tag-component
                label="Tipe Rumah"
                :value="house.kavling.houseType"
              />
              <tag-component label="Harga" :value="formatRupiah(house.price)" />
              <tag-component label="Blok" :value="house.kavling.block" />
              <tag-component
                label="Nomor Kavling"
                :value="house.kavling.numberKavling"
              />
              <tag-component
                label="Luas Kavling"
                :value="house.kavling.areaKavling + ' meter persegi'"
              />
              <tag-component
                label="Luas Bangunan"
                :value="house.kavling.areaBuilding + ' meter persegi'"
              />
              <tag-component
                label="Panjang Kavling"
                :value="house.kavling.lengthKavling + ' meter'"
              />
              <tag-component
                label="Lebar Kavling"
                :value="house.kavling.widthKavling + ' meter'"
              />
            </div>
            <div class="card-footer"></div>
          </div>
        </div>
        <div class="col-12 col-sm-12 col-lg-8">
          <div class="card">
            <div class="card-header">
              <h4>Deskripsi</h4>
            </div>
            <div class="card-body">
              <!-- makebutton  -->
              <div v-html="house.description"></div>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <h4>Gallery</h4>
            </div>
            <div class="card-body">
              <!-- makebutton  -->

              <div class="gallery flex items-center justify-center">
                <div
                  v-for="(image, index) in house.document"
                  :key="image.id"
                  @click="showImages(house.document, index)"
                  class="
                    gallery-item
                    m-2
                    bg-gray-100
                    rounded-lg
                    shadow-inner
                    border border-gray-200
                    overflow-hidden
                    cursor-pointer
                  "
                  :data-image="'/storage/' + image.documentPath"
                  :data-title="image.documentName"
                  :href="'/storage/' + image.documentPath"
                  :title="image.documentName"
                  :style="{
                    backgroundImage: 'url(/storage/' + image.documentPath + ')',
                  }"
                  style="
                    width: 200px;
                    height: 200px;
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                    align-items: center;
                    /* shadow bottom */
                    box-shadow: 0 0 10px rgba(0, 0, 0, 1);
                  "
                ></div>
              </div>
              <button
                v-if="house.document.length > 4"
                @click="showImages(house.document, 0)"
                class="btn btn-primary btn-block mt-2 mx-2"
              >
                Selengkapnya
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <vue-easy-lightbox
    :visible="showBox"
    :imgs="images"
    :index="indexOfImage"
    @hide="onHide"
  ></vue-easy-lightbox>
</template>
<script>
import CircleLoader from "../../components/CircleLoader.vue";
import Utils from "../../store/services/utils";
import Modal from "../../components/Modal.vue";
import TagComponent from "./TagComponent.vue";
import { ref } from "vue";
// import { Carousel, Slide } from "vue-carousel";
export default {
  mounted() {
    this.getHouse();
  },
  data() {
    return {
      isLoading: false,
      indexOfImage: 0,
      showBox: false,
      showingImage: "",
      images: [],
      house: {
        document: [],
        kavling: {},
        price: 0,
        description: "",
      },
    };
  },
  methods: {
    onHide() {
      this.showBox = false;
    },
    showImages(images, index) {
      this.house.document.forEach((image) => {
        this.images.push("/storage/" + image.documentPath);
      });
      this.indexOfImage = index;
      this.showBox = true;
    },
    showImage(image, index) {
      console.log(
        "🚀 ~ file: DetailTypeHouse.vue:139 ~ showImage ~ showImage",
        image
      );
      this.indexOfImage = index;
      this.showBox = true;

      this.showingImage = image;
    },
    formatRupiah(number) {
      if (number) {
        return Utils.formatRupiah(number, "Rp. ");
      }
    },
    getHouse() {
      this.isLoading = true;
      const id = this.$route.params.id;

      this.$store.dispatch("showData", ["house-type/" + id]).then((res) => {
        this.isLoading = false;
        this.house = {
          ...res.data,
          kavling: res.data.kavling,
          price: res.data.price,
          description: res.data.description,
        };
        this.house.document = res.data.document;
      });
    },
  },
  components: { CircleLoader, Modal, TagComponent },
};
</script>
<style>
.list-group .list-group-item {
  padding: 5px;
  margin-top: 2px;
  color: #000;
}
.user-item img {
  border-radius: 20%;
  padding-left: 3px;
  padding-right: 3px;
}
.img-fluid {
  max-width: 95%;
  height: 95%;
}
</style>

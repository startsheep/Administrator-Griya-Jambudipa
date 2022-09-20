<template>
  <Modal
    idModal="detailTypeHouse"
    tittle="Detail Rumah"
    size="modal-md"
    :dark="true"
    displayBtn="btn-block"
    :confirmBtn="false"
  >
    <template v-slot:body>
      <div class="row">
        <div class="col-12">
          <div
            id="carouselExampleIndicators3"
            class="carousel slide"
            data-ride="carousel"
          >
            <ol class="carousel-indicators">
              <li
                data-target="#carouselExampleIndicators3"
                v-for="(image, index) in detailHouse.document"
                :key="image"
                :data-slide-to="index"
                :class="{ active: index }"
              ></li>
            </ol>
            <div class="carousel-inner">
              <div
                class="carousel-item"
                :class="{ active: index }"
                v-for="(image, index) in detailHouse.document"
                :key="image"
              >
                <img
                  class="d-block w-100"
                  style="height: 250px; object-fit: cover"
                  :src="'/storage/' + image.documentPath"
                  alt="First slide"
                />
              </div>
            </div>
            <a
              class="carousel-control-prev"
              href="#carouselExampleIndicators3"
              role="button"
              data-slide="prev"
            >
              <span
                class="carousel-control-prev-icon"
                aria-hidden="true"
              ></span>
              <span class="sr-only">Previous</span>
            </a>
            <a
              class="carousel-control-next"
              href="#carouselExampleIndicators3"
              role="button"
              data-slide="next"
            >
              <span
                class="carousel-control-next-icon"
                aria-hidden="true"
              ></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-6">
          <strong class="mr-2">Tipe Rumah : </strong>
          <strong class="">{{ detailHouse.houseType }}</strong>

          <div class="d-block mt-2">
            <strong class="mr-2">Harga : </strong>
            <strong class="">{{ formatRupiah(detailHouse.price) }}</strong>
          </div>
        </div>
        <div class="col">
            <strong class="mb-3">Deskripsi</strong>
            <div v-html="detailHouse.description"></div>
          </div>
      </div>
    </template>
  </Modal>
</template>
<script>
import CircleLoader from "../../components/CircleLoader.vue";
import Utils from "../../store/services/utils";
import Modal from "../../components/Modal.vue";
export default {
  props: ["detailHouse"],

  // data() {
  //     return {
  //         typeHouse: {},
  //         isLoading: false,

  //     };
  // },

  // watch: {
  //     id(newVal) {
  //         this.getTypeHouse();
  //     }
  // },
  computed: {
    // ...mapGetters(["typeHouse"])
  },
  methods: {
    formatRupiah(number) {
      if (number) {
        return Utils.formatRupiah(number, "Rp. ");
      }
    },
  },
  components: { CircleLoader, Modal },
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

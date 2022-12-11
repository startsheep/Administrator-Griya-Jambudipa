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
        <div class="col">
          <!-- make carousel from bootStrap with data  -->
          <div
            id="carouselExampleSlidesOnly"
            class="carousel slide carousel-fade "
            data-ride="carousel"
            data-interval="3500"

          >
            <ol class="carousel-indicators ">
              <li
                v-for="(image, index) in house.document"
                :key="index"

                :data-target="`#carouselExampleSlidesOnly`"
                :data-slide-to="index"
                :class="{  active: index }"

              ></li>
            </ol>
            <div class="carousel-inner">
              <div
                v-for="(image, index) in house.document"
                :key="index"
                :class="{ 'carousel-item': true, active: index === 0 }"
              >
                <img
                  :src="'/storage/' + image.documentPath"
                  class="d-block w-100"
                  alt="..."
                  style="height: 300px; object-fit: cover"
                />
                <div class="carousel-caption d-none d-md-block">
                  <!-- <h5>{{ image.title }}</h5>
          <p>{{ image.description }}</p> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-6">
          <strong class="mr-2">Tipe Rumah : </strong>
          <strong class="">{{ house.kavling.houseType }}</strong>

          <div class="d-block mt-2">
            <strong class="mr-2">Harga : </strong>
            <strong class="">{{ formatRupiah(house.price) }}</strong>
          </div>
        </div>
        <div class="col">
          <strong class="mb-3">Deskripsi</strong>
          <div v-html="house.description"></div>
        </div>
      </div>
    </template>
  </Modal>
</template>
<script>
import CircleLoader from "../../components/CircleLoader.vue";
import Utils from "../../store/services/utils";
import Modal from "../../components/Modal.vue";
// import { Carousel, Slide } from "vue-carousel";
export default {
  props: {
    id: {
      type: String,
      default: () => null,
    },
  },

  // },
  computed: {
    // ...mapGetters(["typeHouse"])
  },
  watch: {
    id(newVal) {
      this.getHouse(newVal);

      //
    },
    // watch when modal is closed and reset the data
    $store: {
      handler() {
        if (!this.$store.state.modal.detailTypeHouse) {
          this.house = {};
        }
      },
      deep: true,
    },
  },
  mounted() {
    if (this.id) {
      this.getHouse(this.id);
    }
  },
  data() {
    return {
      isLoading: false,
      house: {
        document: [],
        kavling: {},
        price: 0,
        description: "",
      },
    };
  },
  methods: {
    formatRupiah(number) {
      if (number) {
        return Utils.formatRupiah(number, "Rp. ");
      }
    },
    getHouse(id) {
      console.log(id);
      this.isLoading = true;
      this.$store.dispatch("showData", ["house-type/" + id]).then((res) => {
        this.isLoading = false;
        this.house = {
          ...res.data,
          kavling: res.data.kavling,
          price: res.data.price,
          description: res.data.description,
        };
        this.house.document = res.data.document;
        console.log(this.house);
      });
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

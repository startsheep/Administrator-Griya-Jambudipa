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
                v-for="(image, index) in house.document"
                :key="image"
                :data-slide-to="index"
                :class="{ active: index }"
              ></li>
            </ol>
            <div class="carousel-inner">
              <div
                class="carousel-item"
                :class="{ active: index }"
                v-for="(image, index) in house.document"
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
export default {
  props: {
    id: {
      type: String,
      default: ()=> null,
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
    if(this.id) {
        this.getHouse(this.id);
    }
  },
  data() {
    return {
      isLoading: false,
      house: {
        document: [],
        kavling:{},
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
      this.$store.dispatch("showData", ['house-type/'+id]).then((res) => {
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

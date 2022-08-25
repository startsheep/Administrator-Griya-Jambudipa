<template>
  <div
    class="modal fade"
    id="ModalKavling"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
    style="backdrop-filter: brightness(60%)"
  >
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">
            {{ kav != null ? "Edit" : "Tambah" }} Kavling
          </h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-primary alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>×</span>
              </button>
              Satuan Panjang dan Lebar Yang DIgunakan adalah
              <Strong>Meter</Strong>
            </div>
          </div>

          <form class="form-row">
            <div class="form-group col-lg-6">
              <label>Blok</label>
              <input
                v-model="kavling.block"
                ref="formkavling"
                type="text"
                class="form-control"
                placeholder="Blok Kavling"
              />
            </div>
            <div class="form-group col-lg-6">
              <label>Nomor Kavling</label>
              <input
                v-model="kavling.numberKavling"
                ref="formkavling"
                type="text"
                class="form-control"
                placeholder="Nomor Kavling"
              />
            </div>
            <div class="form-group col-lg-6">
              <label>Lebar Muka Kavling (M)</label>
              <input
                v-model="kavling.widthKavling"
                ref="formkavling"
                type="text"
                class="form-control"
                placeholder="Lebar Muka Kavling"
              />
            </div>
            <div class="form-group col-lg-6">
              <label>Panjang Kavling (M)</label>
              <input
                v-model="kavling.lengthKavling"
                ref="formkavling"
                type="text"
                class="form-control"
                placeholder="Panjang Kavling"
              />
            </div>
            <div class="form-group col-lg-6">
              <label>Panjang Kavling 2 (M)</label>
              <input
                v-model="kavling.lengthKavling"
                ref="formkavling"
                type="text"
                class="form-control"
                placeholder="Panjang Kavling 2"
              />
            </div>
            <div class="form-group col-lg-6">
              <label>Luas Kavling (M<sup>2</sup>)</label>
              <input
                v-model="kavling.areaKavling"
                ref="formkavling"
                type="text"
                class="form-control"
                placeholder="Luas Kavling"
              />
            </div>
            <div class="form-group col-lg-6">
              <label>Luas Bangunan (M<sup>2</sup>)</label>
              <input
                v-model="kavling.areaBuilding"
                ref="formkavling"
                type="text"
                class="form-control"
                placeholder="Luas Bangunan"
              />
            </div>
            <div class="form-group col-lg-6">
              <label>Tipe Rumah</label>
              <select class="form-control" v-model="kavling.houseTypeId">
                <option selected disabled value="">Pilih Tipe Rumah</option>

                <option :value="house.id" :key="house" v-for="house in houses">
                  {{ house.houseType }}
                </option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Batal
          </button>
          <button
            @click="kav != null ? update() : create()"
            :class="{ 'disabled btn-progress': isSubmit }"
            type="button"
            class="btn btn-primary"
          >
            {{ kav != null ? "Edit" : "Tambah" }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import iziToast from "izitoast";

export default {
  props: {
    kav: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      houses: [],

      kavling: {
        id: "",
        block: "",
        houseType: "",
        numberKavling: "",
        widthKavling: "",
        lengthKavling: "",
        areaKavling: "",
        areaBuilding: "",
      },
      isSubmit: false,
    };
  },
  watch: {
    kav(newVal , oldVal) {
        if (newVal != null) {
            this.kavling = newVal;
        }
    },
  },
  computed: {
    successMessage() {
      return iziToast.success({
        title: "Success",
        message:
          "Kavling Berhasil Di " + (this.kav != null ? "Edit" : "Tambah"),
        position: "topRight",
      });
    },
  },
  mounted() {
    this.getHouses();
    //   this.showKav()
  },

  methods: {

    hideModal() {
      $("#ModalKavling").hide("modal");
    },
    reset() {
      this.kavling = {
            id: "",
            block: "",
            houseTypeId: "",
            numberKavling: "",
            widthKavling: "",
            lengthKavling: "",
            areaKavling: "",
            areaBuilding: "",
        };

    },
    showKav() {
      console.log(this.kav);
    },
    getHouses() {
      const self = this;
      self.$store.dispatch("getData", ["house-type"]).then((res) => {
        self.houses = res.data;
      });
    },
    update() {
      this.isSubmit = true;
      this.isLoading = true;
      const self = this;
      const url = [
        "kavling",
        this.kavling.id,
        {
          block: this.kavling.block,
          house_type_id: this.kavling.houseTypeId,
          number_kavling: this.kavling.numberKavling,
          width_kavling: this.kavling.widthKavling,
          length_kavling: this.kavling.lengthKavling,
          areaKavling: this.kavling.areaKavling,
          areaBuilding: this.kavling.areaBuilding,
        },
      ];
      self.$store
        .dispatch("updateData", url)
        .then((res) => {
          this.isSubmit = false;
          this.$emit("onSuccess", res);
          this.hideModal();
          this.successMessage;
        })
        .catch((err) => {
          this.isSubmit = false;
          this.reset();
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
    create() {
      this.isSubmit = true;
      this.isLoading = true;
      const self = this;
      const url = [
        "kavling",
        {
          block: this.kavling.block,
          house_type_id: this.kavling.houseTypeId,
          number_kavling: this.kavling.numberKavling,
          width_kavling: this.kavling.widthKavling,
          length_kavling: this.kavling.lengthKavling,
          areaKavling: this.kavling.areaKavling,
          areaBuilding: this.kavling.areaBuilding,
        },
      ];
      self.$store
        .dispatch("postData", url)
        .then((res) => {
          this.isSubmit = false;
          this.reset()
          this.$emit("onSuccess", res);
          this.hideModal();
          this.successMessage;
        })
        .catch((err) => {
          this.isSubmit = false;
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
<style lang="">
</style>

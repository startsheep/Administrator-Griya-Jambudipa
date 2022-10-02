<template>
  <section class="section">
    <LoadingComponent v-if="loading"></LoadingComponent>
    <div class="row mt-3 position-sticky" style="top: 70px; z-index: 99">
      <div class="col-lg-2">
        <div class="card-rounded">
          <select class="form-control" v-model="block" @change="filterByBlock">
            <option value="">Pilih Blok</option>
            <option v-for="item in blocks" :value="item" :key="item">
              {{ item }}
            </option>
          </select>
        </div>
      </div>
      <div class="col-lg-2">
        <div class="card-rounded">
          <select class="form-control" @change="filterByStatus" v-model="status">
            <option value="">Pilih Status</option>
            <option value="1">Terjual</option>
            <option value="0">Belum Terjual</option>
          </select>
        </div>
      </div>
      <div class="col-lg-8">
        <!-- input search -->
        <div class="card-rounded">
          <div class="input-group">
            <input
              type="text"
              class="form-control"
              placeholder="Search"
              v-model="search"
            />
            <div class="input-group-append">
              <button
                class="btn btn-outline-secondary"
                type="button"
                @click="searchData"
              >
                Search
              </button>
            </div>
          </div>
          <!-- select block -->
        </div>
      </div>
    </div>
    <div class="row mt-3" v-auto-animate>
      <div

        class="col-lg-3 col-md-4 col-sm-6 col-12"
        v-for="kavling in kavlings"
        :key="kavling.id"
      >
        <div class="card">
          <div class="card-header pb-0">
            <h4 class="card-title d-block">Kavling blok {{ kavling.block }}</h4>
            <!-- actions header -->
                <div class="actions-header">
                    l
                </div>
          </div>
          <div class="card-body pt-0">
            <div class="row">
              <div class="col-12">
                <strong>Tipe Rumah : </strong>
                <span>{{ kavling.houseType.houseType }}</span>
              </div>

              <div class="col-12">
                <strong>Nomor Kavling : </strong>
                <span>{{ kavling.numberKavling }}</span>
              </div>
              <div class="col-12">
                <strong>Panjang Kavling : </strong>
                <span>{{ kavling.lengthKavling }}</span>
              </div>
              <div class="col-12">
                <strong>Lebar Kavling : </strong>
                <span>{{ kavling.widthKavling }}</span>
              </div>
              <div class="col-12">
                <strong>Luas Kavling : </strong>
                <span>{{ kavling.areaKavling }}</span>
              </div>
              <div class="col-12">
                <strong>Luas Bangunan : </strong>
                <span>{{ kavling.widthKavling }}</span>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <span
              class="badge d-block"
              :class="kavling.status == 1 ? 'badge-success' : 'badge-info'"
              >{{ kavling.status == 1 ? "Terjual" : "Belum Terjual" }}</span
            >
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<style>
.card-rounded {
  /* make background white has shadow with radius */
  background-color: white;
  padding: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 8px rgb(0 0 0 / 3%);
  border-radius: 10px;
  /* shadow bot0om */
  box-shadow: 1 0 5px 5px rgba(190, 190, 190, 0.74);
}
</style>
<script >
import LoadingComponent from "../../components/LoadingComponent.vue";
export default {
  data() {
    return {
      kavlings: [],
      search: "",
      block: "",
      status: "",
      blocks: [
        "A",
        "B",
        "C",
        "D",
        "E",
        "F",
        "G",
        "H",
        "I",
        "J",
        "K",
        "L",
        "M",
        "N",
        "O",
        "P",
        "Q",
        "R",
        "S",
        "T",
        "U",
        "V",
        "W",
        "X",
        "Y",
        "Z",
      ],
      loading: false,
    };
  },
  components: {
    LoadingComponent,
  },
  methods: {
    getData() {
      this.loading = true;
      this.$store.dispatch("getData", ["dashboard/kavling"]).then((res) => {
        this.kavlings = res.data.kavlings;
        this.loading = false;
      });
    },
    filterByStatus(){
        // this.kavlings = this.kavlings.filter(status => status.status == this.status);
    },
    filterByBlock(){

    }
    // make infinite scrollTop and load data
  },
  mounted() {
    this.getData();
  },
};
</script>

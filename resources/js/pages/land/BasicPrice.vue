<template>
  <section class="section">
    <div class="section-header">
      <h4>Perincian Harga Dasar {{ isBuilding ? "Bangunan" : "Tanah" }}</h4>
    </div>
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <div class="card-header-action">
              <ButtonsExport
                :showBtnPdf="false"
                @exportExcel="exportExcel()"
                labelExportExcel='Export Data'
                @print="printData()"
              />
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6 mb-3">
                <div
                  v-if="isCreateCategories || isEditCategories"
                  class="form-group"
                >
                  <div class="input-group mb-3">
                    <input
                      type="text"
                      v-model="categoryLand.category"
                      class="form-control"
                      placeholder="Masukan Rincian"
                    />
                    <div class="input-group-append">
                      <button
                        @click="
                          isCreateCategories
                            ? createCategories()
                            : updateCategory()
                        "
                        class="btn btn-primary"
                        :disabled="categoryLand.category == ''"
                        type="button"
                      >
                        {{ !isCreateCategories ? "Simpan" : "Tambah" }}
                      </button>
                      <button
                        @click="
                          (isCreateCategories = false),
                            (isEditCategories = false),
                            reset()
                        "
                        class="btn btn-danger"
                        type="button"
                      >
                        Batal
                      </button>
                    </div>
                  </div>
                </div>
                <button
                  v-else
                  @click="isCreateCategories = !isCreateCategories"
                  class="btn btn-primary"
                >
                  Tambah Perincian
                </button>

                <!-- <button
                  type="button"
                  class="btn btn-icon icon-rigth btn-success mr-2 ml-4"
                  data-toggle="modal"
                  data-target="#importExcel"
                  @click="importExcel"
                >
                  {{ labelImportExcel }} <span class="mr-1">Import Excel</span>
                  <i class="fa-solid fa-save ml-3"> </i>
                </button> -->
              </div>
              <div class="col">
                <div class="mb-3 d-flex justify-content-end">
                  <div class="form-inline">
                    <select
                      @change="getBasicPriceCategories()"
                      class="form-control mr-2"
                      style="width: 80px"
                      v-model="pagination.perPage"
                    >
                      <option hidden value="">Semua</option>
                      <option value="5">5</option>
                      <option value="10">10</option>
                      <option value="15">15</option>
                      <option value="20">20</option>
                    </select>

                    <div class="input-group">
                      <input
                        class="form-control border-end-0 border"
                        type="text"
                        v-model="filter.search"
                        @keyup="onSearch()"
                      />
                      <span class="input-group-append">
                        <button
                          class="
                            btn btn-outline-secondary
                            border-start-0 border
                          "
                          type="button"
                        >
                          <i class="fa fa-search"></i>
                        </button>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered border-2">
                <thead>
                  <tr>
                    <th class="text-center" width="5%">No</th>
                    <th width="25%">Uraian</th>
                    <th width="10%">Volume</th>
                    <th width="5%">Satuan</th>
                    <th width="15%">Harga</th>
                    <th width="5%">Jumlah</th>
                    <th width="18%">Total</th>
                    <th width="5%">Aksi</th>
                  </tr>
                </thead>
                <tbody
                  style="font-size: 12px"
                  class="position-relative"
                  v-auto-animate
                >
                  <LoadingComponent v-if="isLoading" />
                  <tr
                    v-for="(categories, index) in basicPriceCategories"
                    :key="categories"
                  >
                    <td class="text-center">
                      {{ formatRoman(iteration(index)) }}
                    </td>
                    <td colspan="6" class="align-middle">
                      <Media class="col-3 my-2">
                        <template
                          v-slot:left
                          v-if="categories.basicPrice.length > 0"
                        >
                          <i
                            data-toggle="collapse"
                            :data-target="'#child' + categories.id"
                            class="fa-solid fa-angle-right sortable fa-lg mr-3"
                          ></i>
                        </template>
                        <template v-slot:right>
                          <i
                            data-toggle="collapse"
                            :data-target="'#formChild' + categories.id"
                            class="btn fas fa-square-plus fa-lg sortable"
                          ></i>
                        </template>
                        <template v-slot:mediaTittle>
                          {{ categories.category }}
                        </template>
                      </Media>
                      <div class="collapse mx-2" :id="'child' + categories.id">
                        <div
                          v-for="(child, index) in categories.basicPrice"
                          :key="child"
                        >
                          <div
                            class="
                              row
                              ml-3
                              d-flex
                              justify-content-between
                              align-items-center
                              my-2
                            "
                          >
                            <div class="col-3">
                              <Media>
                                <template v-slot:left> </template>
                                <template v-slot:mediaTittle>
                                  <span class="mr-1">{{ index + 1 }}.</span
                                  ><span>{{ child.description }}</span>
                                </template>
                                <template v-slot:right>
                                  <i
                                    data-toggle="collapse"
                                    :data-target="
                                      '#formChild' + child.id + 'children'
                                    "
                                    class="
                                      btn
                                      fas
                                      fa-square-plus fa-lg
                                      sortable
                                      mr-1
                                    "
                                  ></i>
                                  <!-- <i class="fas fa-pencil"></i>
                                    <i class="fas fa-pencil"></i> -->
                                </template>
                              </Media>
                            </div>
                            <div class="col">
                              <span class="ml-3">{{ child.volume }}</span>
                            </div>
                            <div class="col">
                              <span class="ml-3">{{ child.unit }}</span>
                            </div>
                            <div class="col-2">
                              <span>{{ formatRupiah(child.price) }}</span>
                            </div>
                            <div class="col">
                              <span class="ml-2">{{ child.amount }}</span>
                            </div>
                            <div class="col mr-3">
                              <span class="">
                                {{ formatRupiah(child.total) }}</span
                              >
                            </div>
                            <Actions
                              :showDetail="false"
                              toggleEdit="collapse"
                              @update="sendEditLand(child)"
                              :targetEdit="'#formChild' + categories.id"
                              @delete="deleteLand(child.id)"
                            />
                            <FormChild
                              @onSubmit="
                                isEditLand
                                  ? updateLand($event)
                                  : createChild($event, child.id)
                              "
                              :idForm="child.id + 'children'"
                              :basicPrice="landPrice"
                            />
                          </div>
                          <div
                            class="row ml-3 my-1"
                            v-for="children in child.child"
                            :key="children"
                          >
                            <div class="col-3">
                              <Media>
                                <template v-slot:left>
                                  <span class="mr-3">-</span>
                                </template>
                                <template v-slot:mediaTittle>
                                  <span>{{ children.description }}</span>
                                </template>
                              </Media>
                            </div>
                            <div class="col">
                              <span class="ml-3">{{ children.volume }}</span>
                            </div>
                            <div class="col">
                              <span class="ml-3">{{ children.unit }}</span>
                            </div>
                            <div class="col-2">
                              <span class="ml-3">{{
                                formatRupiah(children.price)
                              }}</span>
                            </div>
                            <div class="col">
                              <span class="ml-3">{{ children.amount }}</span>
                            </div>
                            <div class="col mr-4">
                              <span class="">
                                {{ formatRupiah(children.total) }}</span
                              >
                            </div>
                            <Actions
                              :showDetail="false"
                              toggleEdit="collapse"
                              @update="sendEditLand(children)"
                              :targetEdit="'#formChild' + categories.id"
                              @delete="deleteLand(children.id)"
                            />
                          </div>
                        </div>
                      </div>
                      <FormChild
                        :basicPrice="landPrice"
                        @onSubmit="
                          isEditLand
                            ? updateLand($event)
                            : createLandPrice($event, categories.id)
                        "
                        :idForm="categories.id"
                      />
                    </td>
                    <td class="align-top text-center">
                      <Actions
                        :showDetail="false"
                        @update="sendEdit(categories)"
                        @delete="deleteCategory(categories.id)"
                      />
                    </td>
                  </tr>
                </tbody>
              </table>
              <Pagination
                :currentPage="pagination.currentPage"
                :rowsTotal="pagination.total"
                :lastPage="pagination.lastPage"
                @onPageChange="onPageChange($event)"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <ModalImport />
</template>
<script>
import Media from "../../components/Media.vue";
import Actions from "../../components/Actions.vue";
import iziToast from "izitoast";
import Utils from "../../store/services/utils";
import FormChild from "./FormChild.vue";
import Pagination from "../../components/Pagination.vue";
import ButtonsExport from "../../components/ButtonsExport.vue";
import LoadingComponent from "../../components/LoadingComponent.vue";
import ModalImport from "./ModalImport.vue";
export default {
  data() {
    return {
      categoryLand: {
        category: "",
        id: "",
      },
      basicPriceCategories: [],
      landPrice: {
        id: "",
        categoryId: "",
        description: "",
        volume: "",
        unit: "",
        price: "",
        amount: "",
        total: "",
        // child: []
      },
      //condition
      isCreateCategories: false,
      isEditCategories: false,
      isEditLand: false,
      isLoading: false,
      isSubmit: false,

      pagination: {
        total: 0,
        perPage: 5,
        currentPage: 1,
        lastPage: 0,
        page: 0,
      },

      links: {
        building: {
          excel: "/export/building/excel",
          pdf: "/export/building/pdf",
          print: "/export/building/print",
        },
        lands: {
          excel: "/export/land/excel",
          pdf: "/export/land/pdf",
          print: "/export/land/print",
        },
      },

      filter: {
        search: "",
      },
    };
  },
  mounted() {
    this.getBasicPriceCategories();
  },
  watch: {
    $route(to, from) {
      this.getBasicPriceCategories();
    },
  },
  computed: {
    isBuilding() {
      return this.currentRouteName == "Building" ? true : false;
    },
    currentRouteName() {
      return this.$route.name;
    },
  },
  methods: {
    exportExcel() {
      window.open(
        this.isBuilding ? this.links.building.excel : this.links.lands.excel,
        "_parent"
      );
    },
    printData() {
      window.open(
        this.isBuilding ? this.links.building.print : this.links.lands.print,
        "_blank"
      );
    },
    iteration(index) {
      return (
        (this.pagination.currentPage - 1) * this.pagination.perPage + index + 1
      );
    },
    formatRupiah(number) {
      // return 'Rp.'
      return number ? Utils.formatRupiah(number, "Rp. ") : "-";
    },
    formatRoman(num) {
      return Utils.formatNumberToRoman(num);
    },
    hoverAction() {},
    createCategories() {
      this.isLoading = true;
      const self = this;
      const url = [
        "basic-price-category",
        {
          section: this.isBuilding ? "bangunan" : "tanah",
          category: this.categoryLand.category,
        },
      ];
      self.$store.dispatch("postData", url).then(() => {
        self.isLoading = false;
        self.isCreateCategories = false;
        iziToast.success({
          title: "Berhasil",
          message: "Data Berhasil Disimpan",
          position: "topRight",
        });
        self.getBasicPriceCategories();
        self.reset();
      });
    },
    updateCategory() {
      this.isLoading = true;
      const self = this;
      const url = [
        "basic-price-category",
        this.categoryLand.id,
        {
          category: this.categoryLand.category,
        },
      ];
      self.$store.dispatch("updateData", url).then(() => {
        self.isLoading = false;
        self.isEditCategories = false;
        iziToast.success({
          title: "Berhasil",
          message: "Data Berhasil Disimpan",
          position: "topRight",
        });
        self.getBasicPriceCategories();
        self.reset();
      });
    },
    updateLand(event) {
      this.isLoading = true;
      const self = this;
      const url = [
        "basic-price",
        event.id,
        {
          description: event.description,
          volume: event.volume,
          unit: event.unit,
          price: event.price,
          amount: event.amount,
          total: event.total,
        },
      ];
      self.$store.dispatch("updateData", url).then(() => {
        self.isLoading = false;
        self.isEditLand = false;
        iziToast.success({
          title: "Berhasil",
          message: "Data Berhasil Disimpan",
          position: "topRight",
        });
        self.getBasicPriceCategories();
        self.reset();
      });
    },
    deleteCategory(id) {
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
            this.isLoading = true;
            self.$store
              .dispatch("deleteData", ["basic-price-category", id])
              .then(() => {
                self.isLoading = false;
                iziToast.success({
                  title: "Berhasil",
                  message: "Data Berhasil Dihapus",
                  position: "topRight",
                });
                self.getBasicPriceCategories();
                self.reset();
              });
          }
        });
    },
    deleteLand(id) {
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
            this.isLoading = true;
            self.$store.dispatch("deleteData", ["basic-price", id]).then(() => {
              self.isLoading = false;
              iziToast.success({
                title: "Berhasil",
                message: "Data Berhasil Dihapus",
                position: "topRight",
              });
              self.getBasicPriceCategories();
              self.reset();
            });
          }
        });
    },
    sendEdit(categories) {
      this.categoryLand = categories;
      this.isEditCategories = true;
    },
    sendEditLand(land) {
      this.landPrice.id = land.id;
      this.landPrice.description = land.description;
      this.landPrice.volume = land.volume;
      this.landPrice.unit = land.unit;
      this.landPrice.price = land.price;
      this.landPrice.amount = land.amount;
      this.landPrice.total = land.total;

      this.isEditLand = true;
    },
    getBasicPriceCategories() {
      const self = this;
      this.isLoading = true;
      const params = [
        `per_page=${self.pagination.perPage}`,
        `page=${self.pagination.currentPage}`,
        `order_direction=${this.orderDirection}`,
        `search=${this.filter.search}`,
        `section=${this.isBuilding ? "bangunan" : "tanah"}`,
      ].join("&");
      self.$store
        .dispatch("getData", ["basic-price-category", params])
        .then((res) => {
          self.basicPriceCategories = res.data;
          self.pagination.total = res.meta.total;
          self.pagination.currentPage = res.meta.currentPage;
          self.pagination.lastPage = res.meta.lastPage;
          this.isLoading = false;
        });
    },
    createLandPrice(event, parent) {
      this.isLoading = true;
      const self = this;
      const url = [
        "basic-price",
        {
          basic_price_category_id: parent,
          description: event.description,
          volume: event.volume,
          unit: event.unit,
          price: event.price,
          amount: event.amount,
          total: event.total,
        },
      ];
      self.$store.dispatch("postData", url).then(() => {
        self.isLoading = false;
        self.isCreateCategories = false;
        iziToast.success({
          title: "Berhasil",
          message: "Data Berhasil Disimpan",
          position: "topRight",
        });
        self.getBasicPriceCategories();
        self.reset();
      });
    },
    createChild(event, parent) {
      this.isLoading = true;
      const self = this;
      const url = [
        "basic-price",
        {
          parent_id: parent,
          description: event.description,
          volume: event.volume,
          unit: event.unit,
          price: event.price,
          amount: event.amount,
          total: event.total,
        },
      ];
      self.$store.dispatch("postData", url).then(() => {
        self.isLoading = false;
        self.isCreateCategories = false;
        iziToast.success({
          title: "Berhasil",
          message: "Data Berhasil Disimpan",
          position: "topRight",
        });
        self.getBasicPriceCategories();
        self.reset();
      });
    },
    onPageChange(page) {
      this.pagination.currentPage = page;
      this.getBasicPriceCategories();
    },
    onSearch() {
      this.getBasicPriceCategories();
    },

    reset() {
      this.categoryLand = {
        category: "",
        id: "",
      };
    },
  },
  components: {
    Media,
    Actions,
    FormChild,
    Pagination,
    ButtonsExport,
    LoadingComponent,
    ModalImport,
  },
};
</script>
<style>
.bg-parent {
  background-color: #f4f4f4;
}
</style>

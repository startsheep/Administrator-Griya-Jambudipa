<template>
  <section class="section">
    <div class="section-header">
      <h4>Perincian Harga Dasar Tanah</h4>
    </div>
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-4 mb-3">
                <div
                  v-if="isCreateCategories || isEditCategories"
                  class="form-group"
                >
                  <div class="input-group mb-3">
                    <input
                      type="text"
                      v-model="categoryLand.category"
                      class="form-control"
                      placeholder="Masukan RIncian"
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
                        {{ !isCreateCategories ? "Edit" : "Tambah" }}
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
              </div>
              <div class="col mb-3 d-flex justify-content-end">
                <div class="form-inline">
                  <select
                    @change="getLandCategories()"
                    class="form-control mr-2"
                    style="width: 80px"
                    v-model="pagination.perPage"
                  >
                    <option value="">Semua</option>
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
                      @keyup="search()"
                    />
                    <span class="input-group-append">
                      <button
                        class="btn btn-outline-secondary border-start-0 border"
                        type="button"
                      >
                        <i class="fa fa-search"></i>
                      </button>
                    </span>
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
                    <th>Volume</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th width="5%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(categories, index) in landCategories"
                    :key="categories"
                  >
                    <td class="text-center">
                      {{ formatRoman(iteration(index)) }}
                    </td>
                    <td colspan="6" class="align-middle">
                      <Media class="col-3">
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
                          <div class="row ml-3 d-flex justify-content-between align-items-center">
                            <div class="col-3">
                              <Media>
                                <template v-slot:left>
                                  <span class="mr-3">{{ index + 1 }}</span>
                                </template>
                                <template v-slot:mediaTittle>
                                  <span>{{ child.description }}</span>
                                </template>
                                <template v-slot:right>
                                  <i
                                    data-toggle="collapse"
                                    :data-target="
                                      '#formChild' + child.description
                                    "
                                    class="
                                      btn
                                      fas
                                      fa-square-plus fa-lg
                                      sortable
                                      mr-1
                                    "
                                  ></i>
                                </template>
                              </Media>
                            </div>
                            <div class="col  mr-5"><span class="ml-3">{{ child.volume }}</span></div>
                            <div class="col  mr-2" ><span>{{ child.unit }}</span> </div>
                            <div class="col  mr-2"><span>{{ child.price }}</span></div>
                            <div class="col "><span>{{ child.amount }}</span></div>
                            <div class="col"><span class="ml-3"> {{ child.total }}</span></div>
                            <FormChild
                              @onSubmit="
                                createChild($event,child.id)
                              "
                              :idForm="child.description"
                            />
                          </div>
                          <div class="row ml-3" v-for="children in child.child" :key="children">
                            <div class="col-3 " >
                              <Media>
                                <template v-slot:left>
                                  <span class="mr-3">-</span>
                                </template>
                                <template v-slot:mediaTittle>
                                  <span>{{ children.description }}</span>
                                </template>
                              </Media>
                            </div>
                           <div class="col  mr-5"><span class="ml-3">{{ children.volume }}</span></div>
                            <div class="col  mr-2" ><span>{{ children.unit }}</span> </div>
                            <div class="col  mr-2"><span>{{ children.price }}</span></div>
                            <div class="col "><span>{{ children.amount }}</span></div>
                            <div class="col"><span class="ml-3"> {{ children.total }}</span></div>
                          </div>
                        </div>
                      </div>
                      <FormChild
                        @onSubmit="createLandPrice($event, categories.id)"
                        :idForm="categories.id"
                      />
                    </td>
                    <td>
                      <Actions
                        :showDetail="false"
                        @update="sendEdit(categories)"
                        @delete="deleteCategory(categories.id)"
                      />
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import Media from "../../components/Media.vue";
import Actions from "../../components/Actions.vue";
import iziToast from "izitoast";
import Utils from "../../store/services/utils";
import FormChild from "./FormChild.vue";
export default {
  data() {
    return {
      categoryLand: {
        category: "",
        id: "",
      },
      landCategories: [],
      LandPrice: {
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

      filter: {
        search: "",
      },
    };
  },
  mounted() {
    this.getLandCategories();
  },
  methods: {
    iteration(index) {
      return (
        (this.pagination.currentPage - 1) * this.pagination.perPage + index + 1
      );
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
          section: "tanah",
          category: this.categoryLand.category,
        },
      ];
      self.$store.dispatch("postData", url).then(() => {
        self.isLoading = false;
        self.isCreateCategories = false;
        iziToast.success({
          title: "Success",
          message: "Data Berhasil Disimpan",
          position: "topRight",
        });
        self.getLandCategories();
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
          title: "Success",
          message: "Data Berhasil Disimpan",
          position: "topRight",
        });
        self.getLandCategories();
        self.reset();
      });
    },
    deleteCategory(id) {
      this.isLoading = true;
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
              .dispatch("deleteData", ["basic-price-category", id])
              .then(() => {
                self.isLoading = false;
                iziToast.success({
                  title: "Success",
                  message: "Data Berhasil Dihapus",
                  position: "topRight",
                });
                self.getLandCategories();
                self.reset();
              });
          }
        });
    },
    sendEdit(categories) {
      this.categoryLand = categories;
      this.isEditCategories = true;
    },
    getLandCategories() {
      const self = this;
      this.isLoading = true;
      const params = [
        `per_page=${self.pagination.perPage}`,
        `page=${self.pagination.currentPage}`,
        `order_direction=${this.orderDirection}`,
        `section=tanah`,
      ].join("&");
      self.$store
        .dispatch("getData", ["basic-price-category", params])
        .then((res) => {
          console.log(res);
          self.landCategories = res.data;
          self.pagination.total = res.meta.total;
          self.pagination.currentPage = res.meta.currentPage;
          self.pagination.lastPage = res.meta.lastPage;
          this.isLoading = false;
        });
    },
    createLandPrice(event,  parent) {
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
          title: "Success",
          message: "Data Berhasil Disimpan",
          position: "topRight",
        });
        self.getLandCategories();
        self.reset();
      });
    },
    createChild(event,  parent) {
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
          title: "Success",
          message: "Data Berhasil Disimpan",
          position: "topRight",
        });
        self.getLandCategories();
        self.reset();
      });
    },
    reset() {
      this.categoryLand = {
        category: "",
        id: "",
      };
    },
  },
  components: { Media, Actions, FormChild },
};
</script>
<style>
.bg-parent {
  background-color: #f4f4f4;
}
</style>

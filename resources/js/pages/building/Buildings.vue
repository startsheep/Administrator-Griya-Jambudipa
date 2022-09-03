<template>
  <section class="section">
    <div class="section-header">
      <h4>Harga Dasar Bangunan</h4>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Perincian Harga Dasar Bangunan </h4>
            <div class="card-header-action"></div>
          </div>
          <div class="card-body">
            <div class="row">
                <div class="col-4 mb-3"  >
                    <div v-if="isCreateCategories || isEditCategories " class="form-group">
                      <div class="input-group mb-3" >
                        <input  type="text" v-model="categoryBuilding.category" class="form-control" placeholder="Masukan RIncian">
                        <div class="input-group-append">
                          <button @click="isCreateCategories ? createCategories(): updateCategories()" class="btn btn-primary" :disabled="categoryBuilding.category == ''" type="button">{{ !isCreateCategories ? 'Edit' :'Tambah' }}</button>
                          <button @click="isCreateCategories= false , isEditCategories= false , reset()"   class="btn btn-danger" type="button">Batal</button>
                        </div>
                      </div>
                    </div>
                    <button v-else @click="isCreateCategories= !isCreateCategories" class="btn btn-primary">Tambah Perincian</button>
                </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-bordered border-lg">
                <thead>
                  <tr>
                    <th width="5%" class="text-center" >No</th>
                    <th width="25%">Uraian</th>
                    <th >Volume</th>
                    <th >Satuan</th>
                    <th >Harga</th>
                    <th >Jumlah</th>
                    <th >Total</th>
                    <th width="5%" class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(category, index) in buildingCategories"
                    :key="category"
                  >
                    <td class="text-center" style="font-weight: bold ;">
                      {{ formatRoman(index) }}
                      <!-- <tr></tr> -->
                    </td>
                    <td colspan="6" class=" p-1" >
                      <div
                        class="p-2 box "
                        >
                        <button v-if="category.buildingPrice.length > 0" data-toggle="collapse"
                        :data-target="'#childRow' + category.id" class="btn btn-icon btn-sm btn-success rounded-pill " ><i class="fa-solid fa-angle-right fa-md"></i></button>
                        <span class="ml-2 " style="font-weight:700; font-size: 16px; ">{{ category.category }} </span>
                        <button  @click="reset()" data-toggle="collapse"
                        :data-target="'#formChild' + category.id" class="btn btn-icon  btn-transparent rounded-pill flex-r" ><i class=" fa-solid fa-square-plus fa-xl"></i></button>
                    </div>
                     <div :id="'formChild'+category.id" class="collapse p-2">
                        <div class="row p-2">
                           <div class="form-inline">
                                <input type="text" v-model="buildingPrice.description" placeholder="Masukin Uraian" class="form-control form-control-sm mr-1">
                                <input type="number" v-model="buildingPrice.volume" placeholder="Masukin Volume" class="form-control form-control-sm mr-1">
                                <input type="text" v-model="buildingPrice.unit" placeholder="Masukin Satuan" class="form-control form-control-sm mr-1">
                                <input type="number" v-model="buildingPrice.price" placeholder="Masukin Harga" class="form-control form-control-sm mr-1">
                                <input type="number" v-model="buildingPrice.amount" @keyup="sumTotal()" placeholder="Masukin Jumlah" class="form-control form-control-sm mr-1">
                                <input type="text" disabled v-model="buildingPrice.total" placeholder="Total" class="form-control form-control-sm mr-1">
                            </div>
                             <button @click="createBuildingPrice(category.id)" class="btn btn-primary btn-sm "><i class="fas fa-plus-square"></i></button>
                                <button data-toggle="collapse"
                                :data-target="'#formChild' + category.id" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                        </div>
                     </div>
                      <div
                        class="collapse collapse-child"
                        :id="'childRow' + category.id"
                      >
                      <div class="section bg-child" v-for="building , index in category.buildingPrice" :key="building.id">
                          <div  class="row my-2">
                            <div class="col-3"> <span  class="ml-4">{{ index + 1 }}.</span> <span class="ml-2" style="font-weight: 600;" >{{ building.description }}</span></div>
                            <div class="col"><span class="ml-5" >{{ building.volume }}</span></div>
                            <div class="col"><span class="ml-5" > {{ building.unit }}</span></div>
                            <div class="col"><span class="ml-5 ">{{ building.price }} </span></div>
                            <div class="col"><span class="ml-5">{{ building.amount }}</span></div>
                            <div class="col"><span class="ml-4">{{ building.total }}</span><span class="ml-4"><i class="fas fa-pencil  sortable "></i> <i  @click="deleteBuilding(building.id)" class="fas fa-trash  sortable text-danger"></i></span> </div>

                        </div>
                          <div v-for="child in building.child" :key="child.id" class="row mt-2">
                            <div class="col-3"> <span class="ml-5">-</span> <span class="ml-2" >{{ child.description }}</span></div>
                            <div class="col"><span class="ml-5" > {{ child.volume }}</span></div>
                            <div class="col"><span class="ml-5" >{{ child.unit }}</span></div>
                            <div class="col"><span class="ml-5 ">{{ child.price }} </span></div>
                            <div class="col"><span class="ml-5">{{ child.amount }}</span></div>
                            <div class="col"><span class="ml-4">{{ child.total }}</span><span class="ml-4"><i class="fas fa-pencil  sortable "></i> <i  @click="deleteBuilding(building.id)" class="fas fa-trash  sortable text-danger"></i></span> </div>
                        </div>
                    </div>
                      </div>
                    </td>
                     <td class="align-middle text-center" >
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
                          <button
                            class="dropdown-item action sortable "
                              @click="isEditCategories = !isEditCategories , sendEditCategory(category)"
                            >Edit</button
                          >
                          <button
                            class="dropdown-item action sortable btn"
                            @click="deleteCategoryBuilding(category.id)"
                            >Hapus</button
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
        </div>
      </div>
    </div>
  </section>
</template>
<style>
.table-child {
  border: none;
}
.collapse.collapse-child {
  width: 100%;
}
.bg-child {
  background-color: #ffffed !important;
  color: rgb(58, 58, 58);
}
.box{
    width: 29%;
    /* background-color: aqua; */
}
.flex-r{
    position: absolute;
    left: 10;
}
</style>
<script>
import Utils from "../../store/services/utils";
import iziToast  from "iziToast";
import CircleLoader from "../../components/CircleLoader.vue";

export default {
    data() {
        return {
            categoryBuilding: {
                id: "",
                category: ""
            },
            buildingPrice:{
                id: "",
                categoryId:"",
                description: "",
                volume: "",
                unit: "",
                price: "",
                amount: "",
                total: "",
                // child: []
            },
            buildingCategories: [],
            buildings: [],
            isLoading: false,
            isSubmit: false,
            isCreateCategories: false,
            isEditCategories: false,
        };
    },
    mounted() {
        // this.getBuildingPrice()
        this.getBuildingCategory();
    },
    computed: {

    },
    methods: {

        sumTotal() {
            console.log("sumTotal")
            this.buildingPrice.total = this.buildingPrice.amount * this.buildingPrice.price;

        },
        formatRoman(num) {
            return Utils.formatNumberToRoman(num + 1);
        },
        listByCategory(ud) {
            return (this.buildings = this.buildings.filter((building) => {
                return building;
            }));
        },
        getBuildingPrice() {
            const self = this;
            self.$store.dispatch("getData", ["building-price"]).then((res) => {
                self.buildings = res.data;
                console.log(self.buildings);
            });
        },
        getBuildingCategory() {
            const self = this;
            this.isLoading = true;
            self.$store.dispatch("getData", ["building-category"]).then((res) => {
                self.buildingCategories = res.data;
                this.isLoading = false;
            });
        },
        createCategories() {
            const self = this;
            this.isLoading = true;
            const url = [
                "building-category",
                {
                    category: self.categoryBuilding.category
                }
            ];

            self.$store.dispatch("postData", url).then((res) => {
                iziToast.success({
                    title: "Success",
                    message: "Data Berhasil Disimpan",
                    position: "topRight"
                });
                self.getBuildingCategory();
                this.reset()
                self.isCreateCategories = false;
                this.isLoading = false;
            });
        },

        deleteCategoryBuilding(id){
            const self = this;
            const url = [
                "building-category",
                {
                    id: id
                }
            ];
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
              .dispatch("deleteData", ["building-category", id])
              .then((response) => {
                iziToast.success({
                  title: "Success",
                  message: "Data berhasil dihapus",
                  position: "topRight",
                });
                this.getBuildingCategory();
                this.isLoading = false;
              });
          }
        });
        },
        updateCategories(){
            const self = this;
            const url = [
                "building-category",
                 self.categoryBuilding.id,
                {
                    category: self.categoryBuilding.category
                }
            ];
            self.$store.dispatch("updateData", url).then((res) => {
                iziToast.success({
                    title: "Success",
                    message: "Data Berhasil Disimpan",
                    position: "topRight"
                });
                self.getBuildingCategory();
                self.reset()
                self.isEditCategories = false;
                this.isLoading = false;
            });
        },
        sendEditCategory(category){
            this.categoryBuilding.id = category.id;
            this.categoryBuilding.category = category.category;
        },

        //  showCategory()
        createBuildingPrice(parent){
            const self = this;
            this.isLoading = true;
            const url = [
                "building-price",
                {
                    building_price_category_id: parent,
                    // parent_id: parent ,
                    description: self.buildingPrice.description,
                    volume: self.buildingPrice.volume,
                    unit: self.buildingPrice.unit,
                    price: self.buildingPrice.price,
                    amount: self.buildingPrice.amount,
                    total: self.buildingPrice.total,
                }
            ];
            self.$store.dispatch("postData", url).then((res) => {
                iziToast.success({
                    title: "Success",
                    message: "Data Berhasil Disimpan",
                    position: "topRight"
                });
                self.getBuildingCategory();
                this.isLoading = false;
                this.reset()
            }).catch((err) => {
                iziToast.error({
                    title: "Error",
                    message: "Data Gagal Disimpan",
                    position: "topRight"
                });
                this.isLoading = false;
            });
        },
        deleteBuilding(id){
            const self = this;
            const url = [
                "building-price",
                {
                    id: id
                }
            ];
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
              .dispatch("deleteData", ["building-price", id])
              .then((response) => {
                iziToast.success({
                  title: "Success",
                  message: "Data berhasil dihapus",
                  position: "topRight",
                });
                this.getBuildingCategory();
                this.isLoading = false;
              });
          }
        });
        },

        reset(){
                this.categoryBuilding={
                    id: "",
                    category: ""
                }
                this.buildingPrice={
                    id: "",
                    categoryId:"",
                    description: "",
                    volume: "",
                    unit: "",
                    price: "",
                    amount: "",
                    total: "",
                    // child: []
                }
        }
    },
    components: { CircleLoader }
};
</script>
<style lang="">
</style>

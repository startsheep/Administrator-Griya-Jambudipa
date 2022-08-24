<template>
  <section class="section">
    <div class="section-header">
      <h4>Kavling</h4>
    </div>
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <Button
              data-toggle="modal"
              data-target="#ModalKavling"
              class="btn btn-primary"
            >
              Tambah Kavling
            </Button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th width="10%">Blok</th>
                    <th width="10%">Nomor Kavling</th>
                    <th width="15%">Lebar Muka Kavling</th>
                    <th width="10%">Panjang Kavling</th>
                    <th width="10%">Panjang Kavling</th>
                    <th width="10%">Luas Kavling</th>
                    <th width="15%">Tipe Rumah</th>
                    <th width="10%">Luas Bangunan</th>
                    <th width="5%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="kavling in kavlings" :key="kavling">
                    <td>{{ kavling.block }}</td>
                    <td>{{ kavling.numberKavling }}</td>
                    <td>{{ kavling.widthKavling }}</td>
                    <td>{{ kavling.lengthKavling }}</td>
                    <td>{{ kavling.lengthKavling }}</td>
                    <td>{{ kavling.areaKavling }}</td>
                    <td>{{ kavling.houseTypeId }}</td>
                    <td>{{ kavling.areaBuilding }}</td>
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
                          <button
                            class="dropdown-item action sortable"
                              data-toggle="modal"
              data-target="#ModalKavling"
              @click="sendEdit(kavling)"
                          >
                            Edit
                          </button>
                          <button
                            class="dropdown-item action sortable"
                            @click="deleteKavling(kavling.id)"
                          >
                            Hapus
                          </button>
                          <button class="dropdown-item action sortable">
                            Detail
                          </button>
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
              <CreateEdit @onSuccess="onSuccess()" :kav="kavling"/>
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
  </section>
</template>
<script>
import CreateEdit from "./CreateEdi.vue";
import iziToast from "izitoast";
import Pagination from "../../components/Pagination.vue";
import CircleLoader from "../../components/CircleLoader.vue";

export default {
  components: {
    CreateEdit,
    Pagination,
    CircleLoader,
  },
  data() {
    return {
      //data
      kavling:{},
      kavlings: [],
      isLoading: false,

      // paginations
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
    this.getKavlings();

  },
  computed:{
    reset(){

    }
  },
  methods: {
    sendEdit(kavling){
        this.kavling = kavling;
    },
    getKavlings() {
      const self = this;
      this.isLoading = true;
      const params = [
        //   `name=${this.name}`,
        // `position=${this.name}`,
        `order_by=positions.id`,
        `order_direction=${this.order_direction}`,
        `page=${this.pagination.page}`,
        `per_page=${this.pagination.perPage}`,
      ].join("&");
      self.$store.dispatch("getData", ["kavling", params]).then((res) => {
        self.kavlings = res.data;
        self.pagination.total = res.meta.total;
        self.pagination.currentPage = res.meta.currentPage;
        self.pagination.lastPage = res.meta.lastPage;
        this.isLoading = false;
      });
    },
    onPageChange(page) {
      this.pagination.page = page;
      this.getKavlings();
    },
    onSuccess(){
        this.getKavlings();
    },
    deleteKavling(id){
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
              .dispatch("deleteData", ["kavling", id])
              .then((response) => {
                iziToast.success({
                  title: "Success",
                  message: "Data berhasil dihapus",
                  position: "topRight",
                });
                self.getKavlings();
              });
          }
        });
    }

  },
};
</script>
<style></style>

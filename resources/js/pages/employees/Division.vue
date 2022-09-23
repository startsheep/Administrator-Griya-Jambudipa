<template>
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Divisi</h4>
                    <form class="card-header-form">
                        <input
                            v-on:keyup="search"
                            v-model="name"
                            class="form-control"
                            placeholder="Search"
                        />
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="40%">Jabatan</th>
                                    <th width="40%">Gaji</th>
                                    <th width="20%" class="text-center">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="position-relative">
                                <LoadingComponent v-if="isLoading" />
                                <tr
                                    v-for="division in divisions"
                                    :key="division.id"
                                >
                                    <td>
                                        <div class="media">
                                            <div class="media-body">
                                                <div class="media-title">
                                                    {{ division.name }}
                                                </div>
                                                <div
                                                    class="text-job text-muted"
                                                >
                                                    <span>{{
                                                        showLogUpdate(
                                                            division.updatedAt
                                                        )
                                                    }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ formatRupiah(division.salary) }}</td>
                                    <td class="text-center">
                                        <Actions
                                            :showDetail="false"
                                            @delete="
                                                deleteDivision(division.id)
                                            "
                                            @update="editDivision(division.id)"
                                        />
                                    </td>
                                </tr>
                                <td colspan="3">
                                    <EmptyData
                                        v-if="
                                            !isLoading && divisions.length < 1
                                        "
                                        message="Datanya Tidak Ada"
                                    />
                                </td>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <Pagination
                        :currentPage="pagination.currentPage"
                        :rowsTotal="pagination.total"
                        :lastPage="pagination.lastPage"
                        @onPageChange="onPageChange($event)"
                    />
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        {{ isEditForm ? "Edit Jabatan" : "Tambah Jabatan" }}
                    </h4>
                </div>
                <div class="card-body">
                    <form class="form-group row">
                        <label for="jabatan" class="col-sm-3 col-form-label"
                            >Nama Jabatan</label
                        >
                        <div class="col-sm-9">
                            <input
                                type="text"
                                class="form-control"
                                v-model="division.name"
                                placeholder="Nama Jabatan"
                            />
                        </div>
                        <label for="gaji" class="col-sm-3 col-form label mt-4"
                            >Gaji</label
                        >
                        <div class="col-sm-9 mt-4">
                            <InputCurrency
                                :value="division.salary"
                                v-model="division.salary"
                            />
                        </div>
                    </form>
                </div>
                <div class="card-footer text-right">
                    <button
                        v-if="isEditForm"
                        class="btn btn-danger mr-1"
                        @click="cancelUpdate"
                        type="button"
                        :class="{ disabled: isSubmit }"
                    >
                        Batal
                    </button>
                    <button
                        @click="isEditForm ? doUpdateDivision() : addDivision()"
                        class="btn btn-primary mr-1"
                        type="button"
                        :class="{ 'disabled btn-progress': isSubmit }"
                    >
                        {{ isEditForm ? "Simpan" : "Tambah" }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import iziToast from "izitoast";
import Pagination from "../../components/Pagination.vue";
import Utils from "../../store/services/utils";
import CircleLoader from "../../components/CircleLoader.vue";
import moment from "moment";
import EmptyData from "../../components/EmptyData.vue";
import InputCurrency from "../../components/InputCurrency.vue";
import Actions from "../../components/Actions.vue";
import LoadingComponent from "../../components/LoadingComponent.vue";
export default {
    data() {
        return {
            division: {
                // id : Math.random() + 1,
                name: "",
                salary: "",
            },
            divisions: [],
            isEditForm: false,
            isLoading: false,
            idDivision: null,
            name: "",
            order_direction: "asc",
            pagination: {
                total: 0,
                perPage: 5,
                currentPage: 1,
                lastPage: 0,
                page: 0,
            },
            isSubmit: false,
        };
    },
    mounted() {
        this.getDivisions();
    },
    watch: {
        division: (val) => {
            console.log(val);
        },
    },
    computed: {},
    methods: {
        showLogUpdate(date) {
            return moment(date).fromNow();
        },
        formatRupiah(number) {
            // console.log(Utils.parseRupiah(Utils.formatRupiah(number,"Rp. ")))
            return Utils.formatRupiah(number, "Rp. ");
        },
        search() {
            this.getDivisions();
        },
        addDivision() {
            const self = this;
            const url = [
                "position",
                {
                    position: self.division.name,
                    salary: Utils.currencyToNumber(self.division.salary),
                },
            ];
            this.isSubmit = true;
            self.$store
                .dispatch("postData", url)
                .then((res) => {
                    this.isSubmit = false;
                    self.getDivisions();
                    self.division.name = "";
                    self.division.salary = "";
                    iziToast.success({
                        title: "Berhasil",
                        message: "Data berhasil ditambahkan",
                        position: "topRight",
                    });
                })
                .catch((err) => {
                    this.isSubmit = false;
                    iziToast.error({
                        title: "Galat",
                        message: "Data gagal ditambahkan",
                        position: "topRight",
                    });
                });
        },
        getDivisions() {
            const self = this;
            this.isLoading = true;
            const params = [
                `name=${this.name}`,
                `order_by=positions.id`,
                `order_direction=${this.order_direction}`,
                `page=${this.pagination.page}`,
                `per_page=${this.pagination.perPage}`,
            ].join("&");
            self.$store
                .dispatch("getData", ["position", params])
                .then((response) => {
                    self.divisions = response.data;
                    self.pagination.total = response.meta.total;
                    self.pagination.currentPage = response.meta.currentPage;
                    self.pagination.lastPage = response.meta.lastPage;
                    self.isLoading = false;
                    //    console.log(self.divisions)
                });
        },
        deleteDivision(id) {
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
                            .dispatch("deleteData", ["position", id])
                            .then((response) => {
                                iziToast.success({
                                    title: "Berhasil",
                                    message: "Data berhasil dihapus",
                                    position: "topRight",
                                });
                                this.isLoading = false;
                                self.getDivisions();
                            });
                    }
                });
        },
        editDivision(id) {
            const self = this;
            self.divisions.filter((div) => {
                if (div.id == id) {
                    self.division.name = div.name;
                    self.division.salary = div.salary;
                    self.idDivision = div.id;
                    self.isEditForm = true;
                }
            });
        },
        doUpdateDivision() {
            const self = this;
            const url = [
                "position",
                self.idDivision,
                {
                    position: self.division.name,
                    salary: Utils.currencyToNumber(self.division.salary),
                },
            ];
            this.isLoading = true;
            self.$store.dispatch("updateData", url).then((response) => {
                iziToast.success({
                    title: "Berhasil",
                    message: "Data berhasil diubah",
                    position: "topRight",
                });
                self.isEditForm = false;
                self.division = {
                    name: "",
                    salary: "",
                };
                this.isLoading = false;
                self.getDivisions();
            });
        },
        cancelUpdate() {
            const self = this;
            self.isEditForm = false;
            self.division = {
                name: "",
                salary: "",
            };
            self.getDivisions();
        },
        onPageChange(page) {
            //   this.isLoading = true;
            this.pagination.page = page;
            this.getDivisions();
        },
    },
    components: {
        Pagination,
        CircleLoader,
        EmptyData,
        InputCurrency,
        Actions,
        LoadingComponent,
    },
};
</script>

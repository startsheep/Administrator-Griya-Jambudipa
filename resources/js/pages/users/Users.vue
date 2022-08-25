<template>
    <section class="section">
        <div class="section-header">
            <h1>Data Akun Pengguna</h1>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <Button
                                    class="btn btn-success"
                                    data-toggle="modal"
                                    data-target="#formUserModal"
                                    data-backdrop="static"
                                    data-keyboard="false"
                                >
                                    Tambah Data
                                </Button>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <input
                                    v-on:keyup="search"
                                    v-model="name"
                                    class="form-control"
                                    placeholder="Search"
                                />
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Nomor Telepon</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="user in users">
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ user.phone ?? "-" }}</td>
                                        <td>
                                            <label class="">
                                                <input
                                                    type="checkbox"
                                                    name="custom-switch-checkbox"
                                                    class="custom-switch-input"
                                                    :checked="
                                                        user.isActive == 1
                                                    "
                                                />
                                                <span
                                                    class="custom-switch-indicator"
                                                    @click="
                                                        updateStatus(
                                                            user.id,
                                                            user.isActive
                                                        )
                                                    "
                                                ></span>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="show">
                                                <button
                                                    data-toggle="dropdown"
                                                    class="btn btn-transparent"
                                                >
                                                    <i
                                                        class="fa-solid fa-ellipsis-vertical dropdown-toggle"
                                                        aria-expanded="true"
                                                    ></i>
                                                </button>
                                                <div
                                                    class="dropdown-menu action"
                                                >
                                                    <button
                                                        class="dropdown-item action sortable"
                                                        data-toggle="modal"
                                                        data-target="#formUserModal"
                                                        data-backdrop="static"
                                                        data-keyboard="false"
                                                        @click="showModal(user)"
                                                    >
                                                        Edit
                                                    </button>
                                                    <button
                                                        class="dropdown-item action sortable"
                                                        @click="
                                                            deleteUser(user.id)
                                                        "
                                                        v-if="user.id != 1"
                                                    >
                                                        Hapus
                                                    </button>
                                                    <button
                                                        class="dropdown-item action sortable"
                                                    >
                                                        Detail
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <CircleLoader v-if="isLoading" />
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
        </div>
    </section>
    <ModalForm :user="user" :id="user.id" @onSuccess="onSuccess()" />
</template>
<script>
import iziToast from "izitoast";
import moment from "moment";
import Pagination from "../../components/Pagination.vue";
import Utils from "../../store/services/utils";
import CircleLoader from "../../components/CircleLoader.vue";
import ModalForm from "./CreateEditUsers.vue";

export default {
    data() {
        return {
            user: {},
            users: [],
            status: 0,
            // edit
            isLoading: false,
            // filter
            name: "",
            order_direction: "asc",
            //Pagination
            pagination: {
                total: 0,
                perPage: 10,
                currentPage: 1,
                lastPage: 0,
                page: 0,
            },
        };
    },
    mounted() {
        this.getUsers();
    },
    computed: {},
    methods: {
        showLogUpdate(date) {
            return moment(date).fromNow();
        },
        formatRupiah(number) {
            return Utils.formatRupiah(number, "Rp. ");
        },
        search() {
            this.getUsers();
        },
        getUsers() {
            this.isLoading = true;
            const params = [
                // `name=${this.name}`,
                // `order_by=positions.id`,
                // `order_direction=${this.order_direction}`,
                `page=${this.pagination.page}`,
                `per_page=${this.pagination.perPage}`,
            ].join("&");
            this.$store
                .dispatch("getData", ["user", params])
                .then((response) => {
                    this.isLoading = false;
                    this.users = response.data;
                });
        },
        updateStatus(id, status) {
            let desc = "";
            if (status == 1) {
                status = 0;
                desc = "non-aktif";
            } else {
                status = 1;
                desc = "aktif";
            }

            var type = "updateData";
            var url = [
                "user/active",
                id,
                {
                    active: status,
                },
            ];
            this.$store.dispatch(type, url).then((response) => {
                if (response.type == "success") {
                    iziToast.success({
                        title: "Success",
                        message: "Status " + desc,
                        position: "topRight",
                    });
                    this.getUsers();
                }
            });
        },
        deleteUser(id) {
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
                        this.$store
                            .dispatch("deleteData", ["user", id])
                            .then((response) => {
                                iziToast.success({
                                    title: "Success",
                                    message: "Data berhasil dihapus",
                                    position: "topRight",
                                });
                                this.getUsers();
                            });
                    }
                });
        },
        showModal(user) {
            this.user = user;
        },
        onSuccess() {
            this.getUsers();
        },
        onPageChange(page) {
            this.pagination.page = page;
            this.getUsers();
        },
    },
    components: { Pagination, CircleLoader, ModalForm },
};
</script>

<style>
.modal-backdrop {
    position: fixed;
    height: 100vh;
    width: 100vw;
    top: 0;
    left: 0;
    z-index: 999;
    background-color: black;
}

.modal-backdrop.fade {
    opacity: 0;
}

.modal-backdrop.show {
    opacity: 0.5;
}
</style>

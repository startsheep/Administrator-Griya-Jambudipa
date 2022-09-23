<template>
    <section class="section">
        <div class="section-header">
            <h1>Data Akun Pengguna</h1>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <!-- <LoadingComponent /> -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
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
                            <div class="col-lg-6 mb-3 row">
                                <div class="col-lg-4 col-sm-4">
                                    <select
                                        class="form-control"
                                        @change="onSort"
                                        v-model="order_direction"
                                    >
                                        <option value="asc">Teratas</option>
                                        <option value="desc">Terbawah</option>
                                    </select>
                                </div>
                                <div class="col-lg-8 col-sm-8">
                                    <input
                                        @keyup="onSearch"
                                        v-model="name"
                                        class="form-control"
                                        placeholder="Search"
                                    />
                                </div>
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
                                <tbody class="position-relative">
                                    <LoadingComponent v-if="isLoading" />
                                    <tr v-for="user in users">
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ user.phone ?? "-" }}</td>
                                        <td>
                                            <label class="" v-if="user.id != 1">
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
                                                            resetPassword(user)
                                                        "
                                                    >
                                                        Reset Sandi
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
                                                        data-toggle="modal"
                                                        data-target="#detailUser"
                                                        class="dropdown-item action sortable"
                                                        @click="sendId(user.id)"
                                                    >
                                                        Detail
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <td colspan="5">
                                        <EmptyData
                                            v-if="
                                                !isLoading && users.length < 1
                                            "
                                            message="Datanya Tidak Ada"
                                        />
                                        <!-- <CircleLoader v-if="isLoading" /> -->
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
        </div>
    </section>
    <detailUser :id="userId" />
    <ModalForm :user="user" :id="user.id" @onSuccess="onSuccess()" />
    <ChangePasswordModal
        :id="user.id"
        :name="user.name"
        @onSuccess="onSuccess()"
    />
</template>

<script>
import process from "../../store/modules/user/logic";
import EmptyData from "../../components/EmptyData.vue";

export default process;
</script>

<style></style>

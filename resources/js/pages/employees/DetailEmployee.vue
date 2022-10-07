<template>
    <div
        class="modal fade"
        id="detailEmployee"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h5
                        class="modal-title text-dark"
                        id="exampleModalLongTitle"
                    >
                        Detail Pegawai
                    </h5>
                    <button
                        type="button"
                        class="close text-white"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <CircleLoader v-if="isLoading" />
                    <div v-else class="card bg-light">
                        <div class="card-body">
                            <div class="user-item">
                                <div
                                    class="avatar avatar-lg"
                                    :style="{
                                        'background-image': `url(storage/${employee.image})`,
                                    }"
                                    style="
                                        background-size: cover;
                                        width: 120px;
                                        height: 120px;
                                    "
                                ></div>
                                <div class="user-details">
                                    <div class="user-name text-dark">
                                        {{ employee.name }}
                                    </div>
                                    <div class="text-job text-muted">{{}}</div>
                                    <div class="row mt-3">
                                        <div class="col text-left">
                                            <div class="text-bold text-dark">Email</div>
                                            <div class="text-dark">
                                                {{ employee.email }}
                                            </div>
                                        </div>
                                        <div class="col text-left text-dark">
                                            <div class="text-dark">Telepon</div>
                                            <div class="">
                                                {{ employee.phone }}
                                            </div>
                                        </div>
                                        <div class="col text-left text-dark">
                                            <div class="text-dark">Divisi</div>
                                            <div class="" v-if="employee.position">
                                                {{ employee.position.name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col text-left">
                                            <div class="text-dark">Masuk Tanggal</div>
                                            <div class="text-dark">
                                                {{ employee.entryDate }}
                                            </div>
                                            <div class="mt-2">
                                                <div class="text-dark">Alamat</div>
                                                <div class="text-dark">
                                                    {{ employee.address }}
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div class="text-dark">
                                                    {{
                                                        employee.status == "1"
                                                            ? "Pegawai Tetap"
                                                            : "Pegawai Tidak Tetap"
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col text-left">
                                            <div class="">Dokumen</div>
                                            <div>
                                                <ul class="list-group">
                                                    <li
                                                        class="list-group-item d-flex justify-content-between list-group-item-secondary"
                                                        v-for="doc in employee.document"
                                                        :key="doc.id"
                                                    >
                                                        {{ doc.documentName }}
                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-transparent"
                                                            click
                                                        >
                                                            <i
                                                                class="fas fa-download"
                                                            ></i>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button
                                style="width: 100%"
                                type="button"
                                class="btn btn-danger"
                                data-dismiss="modal"
                            >
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import CircleLoader from "../../components/CircleLoader.vue";
export default {
    props: ["id"],

    data() {
        return {
            employee: {},
            isLoading: false,
        };
    },

    watch: {
        id(newVal) {
            this.getEmployees();
        },
    },
    methods: {
        downloadDoc(doc) {
            const self = this;
        },
        getEmployees() {
            this.isLoading = true;
            const self = this;
            self.$store
                .dispatch("showData", ["employee/" + self.id])
                .then(function (result) {
                    self.employee = result.data;
                    self.isLoading = false;
                });
        },
    },
    components: { CircleLoader },
};
</script>
<style>
.list-group .list-group-item {
    padding: 5px;
    margin-top: 2px;
    color: #000;
}
</style>

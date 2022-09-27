<template>
    <section class="section activity">
        <div class="section-header">
            <h1>Aktifitas {{ user.name }}</h1>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-end">
                        <router-link to="/users" class="btn btn-warning"
                            >Kembali</router-link
                        >
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Aktifitas</th>
                                        <th>Akses</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="position-relative">
                                    <LoadingComponent v-if="isLoading" />
                                    <tr v-for="(log, index) in logs">
                                        <th>{{ iteration(index) }}.</th>
                                        <td>{{ log.description }}</td>
                                        <td>
                                            {{ log.createdAtId }}
                                        </td>
                                        <td>
                                            {{ formatIndonesia(log.createdAt) }}
                                        </td>
                                    </tr>
                                    <td colspan="5">
                                        <EmptyData
                                            v-if="!isLoading && logs.length < 1"
                                            message="Datanya Tidak Ada"
                                        />
                                    </td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <p>Jumlah Data {{ pagination.total }}</p>
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
import LoadingComponent from "../../components/LoadingComponent.vue";
import Pagination from "../../components/Pagination.vue";
import moment from "moment";

export default {
    props: ["id"],
    data() {
        return {
            logs: [],
            user: {},
            pagination: {
                total: 0,
                perPage: 15,
                currentPage: 1,
                lastPage: 0,
                page: 0,
            },
            isLoading: false,
        };
    },
    mounted() {
        this.getLog();
        this.getUser();
    },
    methods: {
        getLog() {
            this.isLoading = true;
            let params = [
                `user_id=${this.id}`,
                `page=${this.pagination.page}`,
                `per_page=${this.pagination.perPage}`,
            ].join("&");
            this.$store.dispatch("getData", ["log", params]).then((result) => {
                this.isLoading = false;
                this.logs = result.data;
                this.pagination.total = result.meta.total;
                this.pagination.currentPage = result.meta.currentPage;
                this.pagination.lastPage = result.meta.lastPage;
            });
        },
        getUser() {
            this.$store
                .dispatch("showData", ["user/" + this.id])
                .then((result) => {
                    this.user = result.data;
                });
        },
        iteration(index) {
            return (
                (this.pagination.currentPage - 1) * this.pagination.perPage +
                index +
                1
            );
        },
        fromNowIndonesia(date) {
            moment.locale("id");
            return moment(date).fromNow();
        },
        formatIndonesia(date) {
            return moment(date).fromNow();
        },
        onPageChange(page) {
            this.pagination.page = page;
            this.getLog();
        },
    },
    components: { LoadingComponent, Pagination },
};
</script>

<style></style>

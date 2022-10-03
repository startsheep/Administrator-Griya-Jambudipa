<template>
    <section class="section dashboard">
        <div class="section-header">
            <h4>Dashboard</h4>
            <!-- {{ user }} -->
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="row" v-auto-animate>
                    <div class="col-lg-6 counting">
                        <CardStatistic
                            :isLoading="loadingEmployee"
                            tittle="Pegawai"
                            icon="fas fa-people-group"
                            backgroundColor="dark"
                            :count="count.employeeActive"
                        />
                    </div>
                    <div class="col-lg-6 counting">
                        <CardStatistic
                            :isLoading="loadingCustomer"
                            tittle="Customer"
                            backgroundColor="success"
                            icon="fas fa-people-roof"
                            :count="count.customerActive"
                        />
                    </div>
                    <div class="col-lg-6 counting">
                        <CardStatistic
                            :isLoading="loadingContractor"
                            tittle="Pemborong"
                            icon="fas fa-users"
                            backgroundColor="secondary"
                            :count="count.contractorActive"
                        />
                    </div>
                    <div class="col-lg-6 counting">
                        <CardStatistic
                            :isLoading="loadingWholeJob"
                            tittle="Borongan Pekerjaan"
                            icon="fas fa-briefcase"
                            :count="count.job"
                            backgroundColor="warning"
                        />
                    </div>
                    <div class="col-lg-4 counting">
                        <CardStatistic
                        class="cursor"
                            :isLoading="loadingKavling"
                            tittle="Kavling"
                            icon="fas fa-maximize"
                            :count="count.kavling"
                            @click="goToKavling"
                        />
                    </div>
                    <div class="col-lg-4 counting">
                        <CardStatistic
                            :isLoading="loadingHouseType"
                            tittle=" Tipe Rumah"
                            icon="fas fa-house-circle-check"
                            backgroundColor="danger"
                            :count="count.houseType"
                        />
                    </div>
                    <div class="col-lg-4 counting">
                        <CardStatistic
                            :isLoading="loadingTransaction"
                            tittle="Transaksi"
                            icon="fas fa-wallet"
                            backgroundColor="info"
                            :count="count.transaction"
                        />
                    </div>
                    <div class="col-lg-12 mb-3" v-if="$can('chart','Dashboard')">
                        <Chart />
                    </div>
                </div>
            </div>
            <div class="col-lg-4" >
                <RecentActivity style="position: sticky; top: 0" />
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-lg-8 col-md-12 col-12 col-sm-12 bg-primary">p</div>
        </div> -->
    </section>
</template>
<script>
import CardStatistic from "./CardStatistic.vue";
import RecentActivity from "./RecentActivity.vue";
import Chart from "./Chart.vue";
import Cookie from "js-cookie";
export default {
    components: { CardStatistic, RecentActivity, Chart },
    data() {
        return {
            count: {
                customerActive: 0,
                customerInactive: 0,
                employeeActive: 0,
                employeeInactive: 0,
                contractorActive: 0,
                contractorInactive: 0,
                houseType: 0,
                kavlingActive: 0,
                kavlingInactive: 0,
                transaction: 0,
                kavling: 0,
                job: 0,
            },
            loadingCustomer: false,
            loadingEmployee: false,
            loadingContractor: false,
            loadingWholeJob: false,
            loadingKavling: false,
            loadingHouseType: false,
            loadingTransaction: false,
        };
    },
    mounted() {
        this.getCount();
    },
    computed:{
        user(){
            // to object
            return  JSON.parse(Cookie.get('user')).role
        }
    },

    methods: {
        getCountEmployee() {
            const self = this;
            this.loadingEmployee = true;
            const params = [].join("&");
            self.$store
                .dispatch("getData", ["dashboard/count-employee", params])
                .then((response) => {
                    this.loadingEmployee = false;
                    this.count.employeeActive = response.data.employeeActive;
                    this.count.employeeInactive =
                        response.data.employeeNoActive;
                });
        },
        getCountCustomer() {
            const self = this;
            this.loadingCustomer = true;
            const params = [].join("&");
            self.$store
                .dispatch("getData", ["dashboard/count-customer", params])
                .then((response) => {
                    this.loadingCustomer = false;
                    this.count.customerActive = response.data.customerActive;
                    this.count.customerInactive =
                        response.data.customerNoActive;
                });
        },
        goToKavling(){
            this.$router.push({ name: "List Kavling" });
        },
        getCountContractor() {
            const self = this;
            this.loadingContractor = true;
            const params = [].join("&");
            self.$store
                .dispatch("getData", ["dashboard/count-contractor", params])
                .then((response) => {
                    this.loadingContractor = false;
                    this.count.contractorActive =
                        response.data.contractorActive;
                    this.count.contractorInactive =
                        response.data.contractorNoActive;
                });
        },
        getCountWholeJob() {
            const self = this;
            this.loadingWholeJob = true;
            self.$store
                .dispatch("getData", ["dashboard/count-whole-job"])
                .then((response) => {
                    this.loadingWholeJob = false;
                    this.count.job = response.data.wholeJob;
                });
        },
        getCountKavling() {
            const self = this;
            this.loadingKavling = true;
            self.$store
                .dispatch("getData", ["dashboard/count-kavling"])
                .then((response) => {
                    this.loadingKavling = false;
                    this.count.kavling = response.data.kavling;
                });
        },
        getCountHouseType() {
            const self = this;
            this.loadingHouseType = true;
            self.$store
                .dispatch("getData", ["dashboard/count-house-type"])
                .then((response) => {
                    this.loadingHouseType = false;
                    this.count.houseType = response.data.houseType;
                });
        },
        getCountTransaction() {
            const self = this;
            this.loadingTransaction = true;
            const params = [].join("&");
            self.$store
                .dispatch("getData", ["dashboard/count-transaction", params])
                .then((response) => {
                    this.loadingTransaction = false;
                    this.count.transaction = response.data.transaction;
                });
        },
        getCount() {
            this.getCountEmployee();
            this.getCountCustomer();
            this.getCountContractor();
            this.getCountWholeJob();
            this.getCountTransaction();
            this.getCountHouseType();
            this.getCountKavling();
        },
    },
};
</script>

<style>
.dashboard .counting .custom-loading-circle {
    width: 40px;
    height: 40px;
}
.dashboard .counting .custom-loading-circle:after {
    width: 25px;
    height: 25px;
}
.dashboard .counting .loading-section {
    margin-left: 75px;
    width: 40px;
    height: 40px;
}
</style>

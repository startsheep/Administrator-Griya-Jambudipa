<template>
    <div class="card h-100">
        <div class="card-header">
            <h4>Aktivitas Terbaru</h4>
        </div>
        <div class="card-body position-relative">
            <LoadingComponent v-if="isLoading" />
            <div class="p-2 overflow-auto" style="height: 700px">
                <ul class="list-unstyled">
                    <li
                        class="media border-bottom mt-2 mb-3"
                        v-for="activity in logs"
                        :key="activity"
                    >
                        <img
                            class="mr-3 rounded-circle"
                            width="50"
                            src="https://robohash.org/stefan-oneapi.lorem.space/image/face?w=150&h=150"
                            alt="avatar"
                        />
                        <div class="media-body">
                            <div class="float-right text-primary">
                                {{ fromNow(activity.createdAt) }}
                            </div>
                            <div class="media-title">
                                {{ activity.user.name }}
                            </div>
                            <span class="text-small text-muted">{{
                                activity.description
                            }}</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- <div class="card-footer"></div> -->
    </div>
</template>
<script>
import moment from "moment";
import LoadingComponent from "../../components/LoadingComponent.vue";
export default {
    data() {
        return {
            logs: [],
            isLoading: false,
        };
    },
    mounted() {
        this.getLogs();
    },
    methods: {
        fromNow(date) {
            return moment(date).fromNow();
        },
        getLogs() {
            const self = this;
            this.isLoading = true;
            self.$store.dispatch("getData", ["log"]).then((res) => {
                this.logs = res.data;
                this.isLoading = false;
            });
        },
    },
    components: { LoadingComponent },
};
</script>
<style></style>

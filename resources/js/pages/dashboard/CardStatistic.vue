<template>
    <div class="card card-statistic-1">
        <div class="card-icon" :class="'bg-' + backgroundColor">
            <i :class="icon"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
                <h4>{{ tittle }}</h4>
            </div>
            <div class="card-body position-relative">
                <div class="loading-section" v-if="isLoading">
                    <div class="custom-loading-circle"></div>
                </div>
                <span class="count-value" v-else>{{ count }}</span>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        tittle: {
            type: String,
            default: "Tittle",
        },
        icon: {
            type: String,
            default: "fas fa-user",
        },
        count: {
            type: Number,
            default: 0,
        },
        backgroundColor: {
            type: String,
            default: "primary",
        },
        isLoading: {
            type: Boolean,
            default: false,
        },
    },
};
</script>
<style></style>

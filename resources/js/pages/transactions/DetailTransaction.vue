<template>
    <Modal
        tittle="Detail Transaksi"
        idModal="detailTransaction"
        :confirmBtn="false"
        displayBtn="btn-block"
    >
        <template v-slot:body>
            <div class="alert alert-primary alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    <b>Info!</b> Dibawah ini merupakan hasil rekapitulasi
                    pembayaran
                </div>
            </div>
            <div class="card position-relative">
                <LoadingComponent v-if="isLoading" />
                <div class="card-body overflow-auto" style="height: 400px">
                    <ul class="list-unstyled list-unstyled-border">
                        <li
                            v-for="(history, index) in transaction.paymentPrice"
                            :key="history"
                            class="media"
                        >
                            <div class="numeric-counter mr-3">
                                {{ index + 1 }}
                            </div>
                            <div class="media-body">
                                <div class="media-right"></div>
                                <div class="media-title">
                                    {{ formatRupiah(history.price) }}
                                </div>
                                <div class="text-small text-muted">
                                    {{ formatDateTime(history.createdAt) }}
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </template>
    </Modal>
</template>
<script>
import Modal from "../../components/Modal.vue";
import Utils from "../../store/services/utils";
import LoadingComponent from "../../components/LoadingComponent.vue";
export default {
    props: ["id"],
    data() {
        return {
            transaction: {},
            isLoading: false,
        };
    },
    watch: {
        id: function (val) {
            this.getTransaction();
        },
    },
    mounted() {
        this.getTransaction();
    },
    methods: {
        randomColor() {
            // create and calculate random color
            let r = Math.floor(Math.random() * 255);
            let g = Math.floor(Math.random() * 255);
            let b = Math.floor(Math.random() * 255);
            let a = 0.5;
            return `rgba(${r},${g},${b},${a})`;
        },
        formatDateTime(date) {
            return Utils.formateDateTimeLocale(date);
        },
        formatRupiah(number) {
            return Utils.formatRupiah(number, "Rp. ");
        },
        getTransaction() {
            this.isLoading = true;
            this.$store
                .dispatch("getData", ["transaction/" + this.id])
                .then((response) => {
                    this.transaction = response.data;
                    this.isLoading = false;
                });
        },
    },
    components: { Modal, LoadingComponent },
};
</script>
<style>
.numeric-counter {
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    color: black;
    /* border radius circle */
    border-radius: 50%;
    /* border */
    border: 1px solid #ccc;
    /* font size */
    font-size: 20px;
    /* font weight */
    font-weight: bold;
    background-color: rgb(236, 236, 236);
}
</style>

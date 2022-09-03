<template>
    <div
        class="modal fade"
        id="detailTypeHouse"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-primary">
                <div class="modal-header">
                    <h5
                        class="modal-title text-white"
                        id="exampleModalLongTitle"
                    >
                        Detail Tipe Rumah
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
                    <!-- {{detailHouse}} -->

                    <div class="card bg-primary">
                        <div class="card-body">
                            <div class="user-item">
                                <div class="row mt-3">
                                    <div class="col text-center">
                                        <div class="">Dokumen</div>
                                        <div class="row">
                                            <div
                                                class="col-4"
                                                v-for="doc in detailHouse.document"
                                                :key="doc.id"
                                            >
                                                <img
                                                    alt="image"
                                                    :src="
                                                        '/storage/' +
                                                        doc.documentPath
                                                    "
                                                    class="img-fluid"
                                                    style="width: 10px height:10px"
                                                />
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-transparent"
                                                    click
                                                    style="width:5px height: 5px;"
                                                ></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col text-left">
                                        <div class="text-bold">Tipe Unit</div>
                                        <div class="">
                                            {{ detailHouse.houseType }}
                                        </div>
                                    </div>
                                    <div class="col text-left">
                                        <div class="">Harga</div>
                                        <div class="">
                                            {{
                                                formatRupiah(detailHouse.price)
                                            }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col text-left">
                                        <div class="">Deskripsi</div>
                                        <div
                                            v-html="detailHouse.description"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-center">
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
</template>
<script>
import CircleLoader from "../../components/CircleLoader.vue";
import Utils from "../../store/services/utils";
export default {
    props: ["detailHouse"],

    // data() {
    //     return {
    //         typeHouse: {},
    //         isLoading: false,

    //     };
    // },

    // watch: {
    //     id(newVal) {
    //         this.getTypeHouse();
    //     }
    // },
    methods: {
        formatRupiah(number) {
            if (number) {
                return Utils.formatRupiah(number, "Rp. ");
            }
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

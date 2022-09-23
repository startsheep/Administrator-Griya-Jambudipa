<template>
  <div :id="'formChild' + idForm" class="collapse p-2">
    <div class="row p-2">
      <div class="form-inline">
        <input
          type="text"
          v-model="landPrice.description"
          placeholder="Masukan Uraian"
          class="form-control form-control m-2"
        />
        <input
          type="number"
          v-model="landPrice.volume"
          placeholder="Masukan Volume"
          class="form-control form-control m-2"
        />
        <input
          type="text"
          v-model="landPrice.unit"
          placeholder="Masukan Satuan"
          class="form-control form-control m-2"
        />
       <InputCurrency   placeholder="Harga" :value="landPrice.price" v-model="landPrice.price"  class="form-control form-control m-2"
          @keyup="sumTotal()"/>

          <input
          type="number"
          v-model="landPrice.amount"
          @keyup="sumTotal()"
          placeholder="Masukan Jumlah"
          class="form-control form-control m-2"
          />
          <InputCurrency   disabled placeholder="Total" :value="landPrice.total" v-model="landPrice.total"  class="form-control form-control m-2"
             @keyup="sumTotal()"/>
        <button
          @click="isEdit ? update() : submit()"
          class="btn btn-primary btn-md mr-1"
        >
          <i class="fas fa-plus-square"></i>
        </button>
        <button
          data-toggle="collapse"
          :data-target="'#formChild' + idForm"
          class="btn btn-danger btn-md"
          @click="resetForm()"
        >
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>
  </div>
</template>
<script>
import InputCurrency from '../../components/InputCurrency.vue';
import Utils from '../../store/services/utils'
export default {
    props: {
        idForm: {
            type: String,
            default: "",
        },
        isEdit: {
            type: Boolean,
            default: false,
        },
        basicPrice: {
            type: Object,
            default: {
                description: "",
                volume: "",
                unit: "",
                price: "",
                amount: "",
                total: "",
            },
        },
    },
    watch: {
        basicPrice: {
            handler: function (val) {
                this.landPrice = val;
            },
            deep: true,
        },
    },
    data() {
        return {
            landPrice: {
                categories: "",
                id: "",
                description: "",
                volume: "",
                unit: "",
                price: "",
                amount: "",
                total: "",
            },
        };
    },
    methods: {
        submit() {
            this.$emit("onSubmit", this.landPrice);
        },
        sumTotal() {
            this.landPrice.total = this.landPrice.amount * Utils.currencyToNumber(this.landPrice.price);
        },
        resetForm() {
            (this.landPrice = {
                categories: "",
                id: "",
                description: "",
                volume: "",
                unit: "",
                price: "",
                amount: "",
                total: "",
            }),
                this.$emit("onResetForm");
        },
    },
    components: { InputCurrency }
};
</script>
<style >
</style>

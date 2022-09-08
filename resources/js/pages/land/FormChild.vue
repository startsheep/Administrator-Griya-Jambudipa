<template>
  <div :id="'formChild' + idForm" class="collapse p-2">
    <div class="row p-2">
      <div class="form-inline">
        <input
          type="text"
          v-model="landPrice.description"
          placeholder="Masukin Uraian"
          class="form-control form-control-md m-2"
        />
        <input
          type="number"
          v-model="landPrice.volume"
          placeholder="Masukin Volume"
          class="form-control form-control-md m-2"
        />
        <input
          type="text"
          v-model="landPrice.unit"
          placeholder="Masukin Satuan"
          class="form-control form-control-md m-2"
        />
        <input
          type="number"
          v-model="landPrice.price"
          @keyup="sumTotal()"
          placeholder="Masukin Harga"
          class="form-control form-control-md m-2"
        />
        <input
          type="number"
          v-model="landPrice.amount"
          @keyup="sumTotal()"
          placeholder="Masukin Jumlah"
          class="form-control form-control-md m-2"
        />
        <input
          type="text"
          disabled
          v-model="landPrice.total"
          placeholder="Total"
          class="form-control form-control-md m-2"
        />
        <button
          @click="
            isEdit ? update() : submit()
          "
          class="btn btn-primary btn-md mr-1"
        >
          <i class="fas fa-plus-square"></i>
        </button>
        <button
          data-toggle="collapse"
          :data-target="'#formChild' +idForm    "
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
export default {
    props:{
        idForm : {
           type: String ,
           default: ''
        },
        isEdit:{
            type:Boolean ,
            default : false
        },
    },

    data(){
        return {
             landPrice: {
                categories: '',
                id: '',
                description: '',
                volume: '',
                unit: '',
                price: '',
                amount: '',
                total: '',
            },
        }
    },

    methods:{
        submit(){
            this.$emit('onSubmit' , this.landPrice)
        },
        sumTotal() {
      this.landPrice.total =
        this.landPrice.amount * this.landPrice.price;
    },
        resetForm(){
            this.landPrice = {
                categories: '',
                id: '',
                description: '',
                volume: '',
                unit: '',
                price: '',
                amount: '',
                total: '',
            },
            this.$emit('onResetForm')
        },
    }
};
</script>
<style >
</style>

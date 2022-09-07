<template>
  <div class="" :class="'btn-group-'+size">
    <button

      type="button"
      class="btn btn-icon icon-rigth btn-primary mr-2"
        @click="exportPdf"
    >
      EXPORT PDF <i class="fa-solid fa-file-pdf"></i>
    </button>
    <button type="button" class="btn btn-icon icon-rigth btn-primary mr-2" @click="exportExcel">
      EXPORT EXCEL <i class="fa-solid fa-file-excel"></i>
    </button>
    <button v-if="printData" @click="print" type="button" class="btn btn-icon icon-rigth btn-primary mr-2">
      PRINT DATA <i class="fa-solid fa-print"></i>
    </button>
  </div>
</template>
<script>
export default {
    props:{
        printData : {
            type : Boolean,
            default : true
        },
        size: {
            type: String,
            default: 'sm'
        }
    },
    methods:{
        print(){
            this.$emit('print')
        },
        exportPdf(){
            this.$emit('exportPdf')
        },
        exportExcel(){
            this.$emit('exportExcel')
        }
    }
};
</script>
<style lang="">
</style>

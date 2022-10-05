<template>
  <div class="" :class="'btn-group-'+size">
    <button

      type="button"
      class="btn btn-icon icon-rigth btn-primary mr-2"
        @click="exportPdf"
    >
   {{ labelExportPdf }} <i class="fa-solid fa-file-pdf"></i>
    </button>
    <button type="button" class="btn btn-icon icon-rigth btn-primary mr-2" @click="exportExcel">
      {{ labelExportExcel }} <i class="fa-solid fa-file-excel"></i>
    </button>
    <button v-if="printData" @click="print" type="button" class="btn btn-icon icon-rigth btn-primary mr-2">
      {{ labelPrint }} <i class="fa-solid fa-print"></i>
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
        },
        labelExportPdf: {
            type: String,
            default: 'Export PDF'
        },
        labelExportExcel: {
            type: String,
            default: 'Export Excel'
        },
        labelPrint: {
            type: String,
            default: 'Print'
        },
        labelImportExcel: {
            type: String,
            default: 'Import Excel'
        },
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
        },
        importExcel(){
            this.$emit('importExcel')
        }
    }
};
</script>
<style lang="">
</style>

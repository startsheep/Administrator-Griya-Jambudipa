<template>
  <div class="modal fade" :id="idModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered " :class="size" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{ tittle }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <slot name="body"></slot>
      </div>
      <div class="modal-footer">
        <button v-if="cancelBtn" type="button" class="btn btn-danger" :class="displayBtn" data-dismiss="modal">{{ labelCancel }}</button>
        <button v-if="confirmBtn" type="button" class="btn btn-primary " :class="displayBtn">{{ labelConfirm }}</button>
      </div>
    </div>
  </div>
</div>
</template>
<script>
export default {
    props: {
        tittle:{
            type: String,
            default: 'Modal'
        },
        idModal: {
            type: String,
            required: true
        },
        tittleConfirm : {
            type: String,
        },
        labelCancel : {
            type: String,
            default : 'Kembali'
        },
        labelConfirm : {
            type: String,
            default : 'Simpan'
        },
        displayBtn : {
            type: String,
            default : null
        },
        cancelBtn : {
            type: Boolean,
            default : true
        } ,
        confirmBtn : {
            type: Boolean,
            default : true
        },
        size:{
            type: String,
            default : ''
        }
    }
};
</script>
<style lang="">
</style>

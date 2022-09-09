<template>
  <div class="show">
    <button data-toggle="dropdown" class="btn btn-transparent">
      <i
        class="fa-solid fa-ellipsis-vertical dropdown-toggle"
        aria-expanded="true"
      ></i>
    </button>
    <div class="dropdown-menu action">
      <button
       :data-toggle="toggleEdit"
        :data-target="targetEdit"
      v-if="showEdit" class="dropdown-item action sortable" @click="update">
        {{ labelEdit }}
      </button>
      <button
        v-if="showDelete"
        class="dropdown-item action sortable "
        @click="doDelete"
      >
        {{ labelDelete }}
      </button>
      <button
        v-if="showDetail"
        :data-toggle="toggleDetail"
        :data-target="targetDetail"
        class="dropdown-item action sortable"
        @click="detail"
      >
        {{ labelDetail }}
      </button>
    </div>
  </div>
</template>
<script>
export default {
    props:{

        labelDelete:{
            type : String ,
            default :'Hapus'
        },
        labelDetail :{
            type: String ,
            default : 'Detail'
        },
        labelEdit:{
            type :String ,
            default : 'Edit'
        },
        showDetail :{
            type:Boolean ,
            default : true,
        },
        showEdit:{
            type:Boolean ,
            default : true
        },
        showDelete:{
            type:Boolean,
            default : true
        },
        targetDetail:{
            type:String ,
            default : ''
        },
        toggleDetail:{
            type:String ,
            default : ''
        },
        targetEdit:{
            type:String ,
            default : ''
        },
        toggleEdit:{
            type:String ,
            default : ''
        },
        isRouterLink:{
            type:Boolean ,
            default : false
        },

    },
   methods:{
        detail(){
            this.$emit('detail')
        },
        doDelete(){
            this.$emit('delete')
        },
        update(){
            this.$emit('update')
        }
   }
};
</script>
<style>
</style>

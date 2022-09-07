<template>
     <div class="col">
        <div class="box">
            <span>{{ message }}</span>
        </div>
    </div>
</template>
<script>
export default {
    props : {
        message : {
            type : String,
            default : 'Data Kosong'
        }
    }
}
</script>
<style>
    .box{
        width: 100%;
        height: 100%;
        display: flex;
        padding:  10px;
        /* border: 1px solid rgb(231, 231, 231); */
        /* background-color: rgb(224, 224, 224); */
        justify-content: center;
        align-items: center;
    }
</style>

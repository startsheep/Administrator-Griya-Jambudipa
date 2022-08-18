<template lang="">
    <nav aria-label="" class="float-right" >
        <ul class="pagination">
            <li class="page-item ">
                <a @click="onPageChange(1)" class="page-link cursor "  tabindex="-1">First</a>
            </li>
            <!-- <li class="page-item"><a class="page-link cursor" >1</a></li> -->
                <a @click="onPageChange(currentPage-1)" class="page-link cursor" ><span>&laquo;</span></a>
            <li class="page-item active">
                <a  class="page-link cursor"
                    >{{ currentPage }}<span class="sr-only">{{ currentPage }}</span></a
                >
            </li>
            <div class="page-item " :class="{disabled : lastPage ==currentPage }">

                <a @click="onPageChange(currentPage +1)"  class="page-link cursor "><span>&raquo;</span></a>
            </div>
            <!-- <li class="page-item"><a class="page-link cursor" >3</a></li> -->

            <li class="page-item" :class="{disabled : lastPage ==currentPage }">
                <a class="page-link cursor"  @click="onPageChange(lastPage)">Last</a>
            </li>
        </ul>
    </nav>
</template>
<script>
export default {
    props : ['rowsTotal' , 'currentPage' ,'lastPage'],

    methods: {
        onPageChange(page){

            this.$emit('onPageChange',page);
        }
    },
};
</script>
<style lang=""></style>

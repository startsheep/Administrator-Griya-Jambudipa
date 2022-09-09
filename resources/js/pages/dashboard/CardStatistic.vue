<template>

    <div class="card card-statistic-2">
      <div class="card-icon bg-primary">
        <i :class="icon"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>{{ tittle }}</h4>
        </div>
        <div class="card-body">{{ count }}</div>
      </div>
    </div>

</template>
<script>
export default {
    props:{
        tittle: {
            type: String,
            default: "Tittle",
        },
        icon: {
            type: String,
            default: "fas fa-user",
        },
        count: {
            type: Number,
            default: 0,
        },
        color: {
            type: String,
            default: "primary",
        },
    }
};
</script>
<style>
</style>

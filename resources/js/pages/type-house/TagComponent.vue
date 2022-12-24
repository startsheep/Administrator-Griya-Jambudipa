<template >
  <div class="d-block my-2">
    <div class="flex">
      <div class="flex justify-between mr-2" style="width: 40%">
        <strong class="">{{ label }}</strong>
        <span>:</span>
      </div>
      <span class=""> {{ value }} </span>
    </div>
    <hr />
  </div>
</template>
<script>
export default {
  props: {
    label: {
      type: String,
      default: () => null,
    },
    value: {
      type: String,
      default: () => null,
    },
  },
};
</script>
<style >
.flex {
  display: flex;
  flex-direction: row;

  align-items: center;
}
.flex-row {
  display: flex;
  flex-direction: row;
}
.flex-col {
  display: flex;
  flex-direction: column;
}
.justify-between {
  justify-content: space-between;
}
.justify-center {
  justify-content: center;
}
.justify-end {
  justify-content: flex-end;
}
.items-center {
  align-items: center;
}
</style>

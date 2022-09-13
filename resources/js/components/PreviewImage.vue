<template >
  <div
    class="preview-image"
    :style="{ 'background-image': `url(${previewImage})` }"
  ></div>
</template>
<script>
export default {
    props: {
        previewImage: {
        type: String,
        default: ''
        }
    }
};
</script>
<style>
</style>

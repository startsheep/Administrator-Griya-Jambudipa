<template>
  <li class="media p-0 ">
    <div class="media-left">
        <slot name="left"></slot>
    </div>
    <div class="media-body">
      <div class="media-right m-auto">
        <slot name="right"></slot>
      </div>
      <div class="media-title">
        <slot name="mediaTittle"></slot>
      </div>
      <div class="text-small text-muted">
        {{ subtitle }}
      </div>
    </div>
  </li>
</template>
<script>
export default {
    props: {
        mediaRight: {
            type: String,
            default: ''
        },
        mediaTittle: {
            type: String,
            default: ''
        },
        subtitle: {
            type: String,
            default: ''
        }
    },

};
</script>
<style>
</style>

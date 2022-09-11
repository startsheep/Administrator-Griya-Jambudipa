<template lang="">
    <input type="text" class="form-control" v-model="currentValue" @input="handleInput" />
</template>
<script>
export default {
    props: {
      value: {
        type: [String, Number],
        default: ""
      },
    },
    data: () => ({
      currentValue: ''
    }),
    watch: {
      value: {
        handler(after) {
          this.currentValue = this.format(after)
        },
        immediate: true
      },
        currentValue: {
            handler(after) {
            this.$emit('input', after)
            },
            immediate: true
        }
    },
    methods: {
      format: value => (value + '').replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "."),

      handleInput() {
        this.currentValue = this.format(this.currentValue)
        this.$emit('input', (this.currentValue + '').replace(/[^0-9]/g, ""))
      }
    }
}
</script>
<style lang="">

</style>

<template>
  <input
    v-model="password"
    :type="showPassword ? 'text' : 'Sandi'"
    class="form-control"
    @input="handleInput"
  />
</template>
<script>
export default {
  props: {
    value: {
      type: String,
      default: "",
    },
    showPassword: {
      type: Boolean,
      default: false,
    },
  },
  data: () => ({
    password: "",
  }),
  watch: {
    value: {
      handler(after) {
        this.password = after;
      },
      immediate: true,
    },
    password: {
      handler(after) {
        this.$emit("input", after);
      },
      immediate: true,
    },
    showPassword: {
      handler(after) {
        this.$emit("input", after);
      },
      immediate: true,
    },
  },
  methods: {
    hidePassword() {
      this.showPassword = !this.showPassword;
    },
    handleInput() {
      this.passwords = this.password;
      this.$emit("input", this.password);
    },
  },
};
</script>
<style>
</style>

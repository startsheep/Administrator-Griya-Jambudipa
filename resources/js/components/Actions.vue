<template>
  <div class="show">
    <button data-toggle="dropdown" class="btn btn-transparent">
      <i
        class="fa-solid fa-ellipsis-vertical dropdown-toggle"
        aria-expanded="true"
      ></i>
    </button>
    <div class="dropdown-menu action">
      <div v-if="!editIsRouter">
        <button
          :data-toggle="toggleEdit"
          :data-target="targetEdit"
          v-if="showEdit"
          class="dropdown-item action sortable"
          @click="update"
        >
          {{ labelEdit }}
        </button>
      </div>
      <div v-else>
        <router-link custom v-slot="{ navigate }" :to="linkEdit"
          >
          <button
          class="dropdown-item action sortable"
            @click="navigate"
            @keypress.enter="navigate"
            role="link"

          > {{ labelEdit }}</button>
        </router-link>
      </div>

      <button
        v-if="showDelete"
        class="dropdown-item action sortable"
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
      <button
        v-if="showCustom"
        :data-toggle="toggleCustomBtn"
        :data-target="targetCustomBtn"
        class="dropdown-item action sortable"
        @click="customAct"
      >
        {{ labelCustom }}
      </button>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    labelDelete: {
      type: String,
      default: "Hapus",
    },
    labelDetail: {
      type: String,
      default: "Detail",
    },
    labelEdit: {
      type: String,
      default: "Edit",
    },
    showDetail: {
      type: Boolean,
      default: true,
    },
    showEdit: {
      type: Boolean,
      default: true,
    },
    showDelete: {
      type: Boolean,
      default: true,
    },
    targetDetail: {
      type: String,
      default: "",
    },
    toggleDetail: {
      type: String,
      default: "",
    },
    targetEdit: {
      type: String,
      default: "",
    },
    toggleEdit: {
      type: String,
      default: "",
    },
    isRouterLink: {
      type: Boolean,
      default: false,
    },
    editIsRouter: {
      type: Boolean,
      default: false,
    },
    linkEdit: {
      type: String,
      default: "",
    },
    showCustom: {
      type: Boolean,
      default: false,
    },
    labelCustom: {
      type: String,
      default: "",
    },
    targetCustomBtn: {
      type: String,
      default: "",
    },
    toggleCustomBtn: {
      type: String,
      default: "",
    },
  },
  methods: {
    detail() {
      this.$emit("detail");
    },
    doDelete() {
      this.$emit("delete");
    },
    update() {
      this.$emit("update");
    },
    customAct(){
        this.$emit("customAction");
    }
  },
};
</script>
<style>
</style>

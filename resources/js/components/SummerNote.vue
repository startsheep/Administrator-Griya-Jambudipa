<template >
  <ckeditor
    :editor="editor"
    v-model="editorData"
    :config="editorConfig"
  ></ckeditor>
</template>
<script>
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
export default {
  components: {
    // Use the <ckeditor> component in this view.
    // ckeditor: CKEditor.component
  },
  data() {
    return {
      editor: ClassicEditor,
      editorData: "",
      editorConfig: {
        // The configuration of the editor.
        // height: '500px',
      },
    };
  },
  methods: {
    onChange(event) {
      const value = this.editor.getData();
      this.$emit("update:modelValue", value);
    },
  },
};
</script>
<style >
.ck-editor__editable {
  min-height: 200px;
}
</style>

<template >
  <ckeditor
    :editor="editor"
    v-model="editorData"
    :config="editorConfig"
    @input="onChange"
    @reset="onReset"
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
        // width: '100%',
      },
    };
  },
  methods: {
    onChange(event) {
      const value = event;
      this.$emit("update-editor", value);
    },
  },
  onReset() {
    this.editorData = "";
    this.$emit("reset", this.editorData);
  },
};
</script>
<style >
.ck-editor__editable {
  min-height: 200px;
}
</style>

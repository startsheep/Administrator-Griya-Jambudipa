import Cookies from "js-cookie";
import { useToast } from "vue-toastification";
import Progress from "../../components/Progress.vue";
import Paginate from "../../components/pagination/Paginate.vue";
import ModalAddUser from "../../pages/admin/ModalAddUser.vue";
import ModalEditUser from "../../pages/admin/ModalEditUser.vue";

export default {
  components: {
    Progress,
    Paginate,
    ModalAddUser,
    ModalEditUser,
  },
  setup() {
    const toast = useToast();

    return { toast };
  },
  data() {
    return {
      form: {
        email: "",
        name: "",
        password: "",
        confirm_password: "",
        image: null,
      },
      edit: {
        id: 0,
        email: "",
        name: "",
      },
      data: [],
      token: Cookies.get("token") ? true : false,
      isLoading: false,
      rowsTotal: null,
      currentPage: null,
      lastPage: null,
      page: null,
      search: "",
      errors: {},
      isOpen: false,
    };
  },
  mounted() {
    this.getList();
  },
  methods: {
    getList() {
      this.isLoading = true;
      // const params = [`page=${this.page}`, `title=${this.search}`].join("&");
      this.$store.dispatch("getData", ["user"]).then((response) => {
        this.isLoading = false;
        this.data = response.data;
        this.currentPage = response.meta.currentPage;
        this.rowsTotal = response.meta.total;
        this.lastPage = response.meta.lastPage;
      });
    },
    onEnter(event) {
      this.search = event;
      this.getList();
    },
    onPageChange(page) {
      this.page = page;
      this.getList();
    },
    handleSubmitAdd(event) {
      const fileData = new FormData();
      fileData.append("name", event.name);
      fileData.append("email", event.email);
      fileData.append("password", event.password);
      fileData.append("confirm_password", event.confirm_password);
      fileData.append("image", event.image);

      this.$store
        .dispatch("postDataUpload", fileData, "auth/register")
        .then((response) => {
          this.toast.success(response.message, {
            position: "top-center",
          });

          event.email = "";
          event.name = "";
          event.password = "";
          event.confirm_password = "";
          event.image = null;

          document.getElementById("modal-add").checked = false;
          this.getList();
        })
        .catch((error) => {
          this.toast.error("Failed to register!", {
            position: "top-center",
          });
          this.errors = error.response.data.meta.message;
        });
    },
    handleSubmitEdit(event) {
      this.$store
        .dispatch("updateData", ["user", event.id, event])
        .then((response) => {
          this.toast.success(response.message, {
            position: "top-center",
          });
          document.getElementById("modal-edit").checked = false;
          this.getList();
        })
        .catch((error) => {
          this.toast.error("Failed to update!", {
            position: "top-center",
          });
          this.errors = error.response.data.meta.message;
        });
    },
    removeUser(id) {
      this.isLoading = true;
      this.$store
        .dispatch("deleteData", ["admin/user", id])
        .then((response) => {
          this.isLoading = false;
          this.getList();
          this.toast.success(response.message, {
            position: "top-center",
          });
        })
        .catch((err) => {});
    },
    showModalAdd() {
      this.isOpen = !this.isOpen;
    },
    showModalEdit(id) {
      this.isOpen = true;
      this.$store
        .dispatch("showData", ["user/" + id])
        .then((response) => {
          this.edit.id = response.data.id;
          this.edit.email = response.data.email;
          this.edit.name = response.data.name;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};

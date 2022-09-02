import iziToast from "izitoast";
import moment from "moment";
import Pagination from "../../../components/Pagination.vue";
import CircleLoader from "../../../components/CircleLoader.vue";
import ModalForm from "../../../pages/users/CreateEditUsers.vue";
import ChangePasswordModal from "../../../pages/users/ChangePassword.vue";
import DetailUser from './../../../pages/users/DetailUser.vue'
import Cookies from "js-cookie";


export default {
    data() {
        return {
            session: Cookies.get("user"),
            user: {},
            userId : '',
            users: [],
            status: 0,
            // edit
            isLoading: false,
            // filter
            name: "",
            order_by: "users.id",
            order_direction: "asc",
            //Pagination
            pagination: {
                total: 0,
                perPage: 10,
                currentPage: 1,
                lastPage: 0,
                page: 0,
            },
        };
    },
    mounted() {
        this.getUsers();
    },
    computed: {},
    methods: {
        sendId(id){
            this.userId = id;
        },
        showLogUpdate(date) {
            return moment(date).fromNow();
        },
        formatRupiah(number) {
            return Utils.formatRupiah(number, "Rp. ");
        },
        search() {
            this.getUsers();
        },
        getUsers() {
            this.isLoading = true;
            const params = [
                `name=${this.name}`,
                `order_by=${this.order_by}`,
                `order_direction=${this.order_direction}`,
                `page=${this.pagination.page}`,
                `per_page=${this.pagination.perPage}`,
            ].join("&");
            this.$store
                .dispatch("getData", ["user", params])
                .then((response) => {
                    this.isLoading = false;
                    this.users = response.data;
                });
        },
        updateStatus(id, status) {
            let desc = "";
            if (status == 1) {
                status = 0;
                desc = "non-aktif";
            } else {
                status = 1;
                desc = "aktif";
            }

            var type = "updateData";
            var url = [
                "user/active",
                id,
                {
                    active: status,
                },
            ];
            this.$store.dispatch(type, url).then((response) => {
                if (response.type == "success") {
                    iziToast.success({
                        title: "Success",
                        message: "Status " + desc,
                        position: "topRight",
                    });
                    this.getUsers();
                }
            });
        },
        deleteUser(id) {
            this.$swal
                .fire({
                    title: "Yakin ?",
                    text: "Data akan dihapus",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Hapus!",
                    cancelButtonText: "Batal",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        this.$store
                            .dispatch("deleteData", ["user", id])
                            .then((response) => {
                                iziToast.success({
                                    title: "Success",
                                    message: "Data berhasil dihapus",
                                    position: "topRight",
                                });
                                this.getUsers();
                            });
                    }
                });
        },
        showModal(user) {
            this.user = user;
        },
        onSort() {
            console.log("OK");
            this.getUsers();
        },
        onSuccess() {
            this.getUsers();
        },
        onSearch() {
            this.getUsers();
        },
        onPageChange(page) {
            this.pagination.page = page;
            this.getUsers();
        },
    },
    components: { Pagination, CircleLoader, ModalForm, ChangePasswordModal , DetailUser},
};

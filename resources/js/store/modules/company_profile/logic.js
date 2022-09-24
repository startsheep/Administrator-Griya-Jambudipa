import iziToast from "izitoast";
import LightBox from "../../../components/DetailImage.vue";
import CircleLoader from "../../../components/CircleLoader.vue";
import LoadingComponent from "../../../components/LoadingComponent.vue";

export default {
    data() {
        return {
            form: {
                name: "",
                email: "",
                phone: "",
                url: "",
                address: "",
                logo: null,
            },
            previewLogo: null,
            profile: [],
            isLoading: false,
            isSubmit: false,
        };
    },
    mounted() {
        this.getProfile();
    },
    computed: {
        formData() {
            const fieldData = new FormData();
            fieldData.append("id", this.profile.id);
            fieldData.append("_method", "PUT");
            fieldData.append("name", this.form.name);
            fieldData.append("email", this.form.email);
            fieldData.append("phone", this.form.phone);
            fieldData.append("url", this.form.url);
            fieldData.append("address", this.form.address);

            if (this.form.logo) {
                fieldData.append("logo", this.form.logo);
            }

            return fieldData;
        },
    },
    methods: {
        getProfile() {
            const self = this;
            self.isLoading = true;

            self.$store
                .dispatch("getData", ["company-profile"])
                .then((response) => {
                    self.isLoading = false;
                    self.profile = response.data;
                    self.form.name = response.data.name;
                    self.form.email = response.data.email;
                    self.form.phone = response.data.phone;
                    self.form.url = response.data.url;
                    self.form.address = response.data.address;
                    self.previewLogo = "/storage/" + response.data.logo;
                });
        },
        uploadLogo(e) {
            let files = e.target.files[0];
            this.previewLogo = URL.createObjectURL(files);
            this.form.logo = files;
        },
        createProfile() {
            const self = this;
            let fieldData = this.formData;
            let type = "updateDataUploadCompanyProfile";
            this.isLoading = true;
            this.isSubmit = true;

            self.$store
                .dispatch(type, fieldData, [
                    "company-profile/" + self.profile.id,
                ])
                .then((result) => {
                    this.isLoading = false;
                    this.isSubmit = false;

                    this.deleteModal();

                    self.getProfile();
                    iziToast.success({
                        title: "Success",
                        message: "Data berhasil diubah",
                        position: "topRight",
                    });
                })
                .catch((err) => {
                    this.isLoading = false;
                    this.isSubmit = false;
                    let meta = err.response.data.meta;
                    let messages = err.response.data.meta.message;
                    Object.entries(messages).forEach(([key, value]) => {
                        iziToast.warning({
                            title: "Warning",
                            message: value,
                            position: "topRight",
                        });
                    });
                });
        },
        deleteModal() {
            $("#editCompanyModal").modal("hide");

            self.form.name = "";
            self.form.email = "";
            self.form.phone = "";
            self.form.url = "";
            self.form.address = "";
            self.previewLogo = "";
        },
    },
    components: {
        CircleLoader,
        LightBox,
        LoadingComponent,
    },
};

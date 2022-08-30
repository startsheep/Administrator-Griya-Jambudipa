import {
    reject
} from "lodash";
import Api from "./api";

const process = {
    actions: {
        getData(context, param) {
            return new Promise((resolve, reject) => {
                Api.init();
                Api.get(param[0] + "?" + param[1]).then(
                    (response) => {
                        resolve(response.data);
                    },
                    (error) => {
                        reject(error);
                    }
                );
            });
        },
        showData(context, param) {
            return new Promise((resolve, reject) => {
                Api.init();
                Api.get(param[0] + "?" + param[1]).then(
                    (response) => {
                        resolve(response.data);
                    },
                    (error) => {
                        reject(error);
                    }
                );
            });
        },
        postData(context, param) {
            return new Promise((resolve, reject) => {
                Api.init();
                Api.post(param[0], param[1]).then(
                    (response) => {
                        resolve(response.data);
                    },
                    (error) => {
                        reject(error);
                    }
                );
            });
        },
        postDataUpload(context, param, url) {
            return new Promise((resolve, reject) => {
                Api.init();
                Api.postFormData(url, param).then(
                    (response) => {
                        resolve(response.data);
                    },
                    (error) => {
                        reject(error);
                    }
                );
            });
        },
        updateData(state, param) {
            return new Promise((resolve, reject) => {
                Api.init();
                Api.update(param[0], param[1], param[2]).then(
                    (response) => {
                        resolve(response.data);
                    },
                    (error) => {
                        reject(error);
                    }
                );
            });
        },
        putData(state, param) {
            return new Promise((resolve, reject) => {
                Api.init();
                Api.put(param[0], param[1], param[2]).then(
                    (response) => {
                        resolve(response.data.data);
                    },
                    (error) => {
                        reject(error);
                    }
                );
            });
        },
        deleteData(context, param) {
            return new Promise((resolve, reject) => {
                Api.init();
                Api.delete(param[0] + `/${param[1]}`).then(
                    (response) => {
                        resolve(response.data);
                    },
                    (error) => {
                        reject(error.response);
                    }
                );
            });
        },
        async getFile(context, param) {
            Api.init();
            // Api.getFile(param[0]+'?'+param[1]).then(
            const response = await Api.getFile(param[0] + '?' + param[1]);
            let blob = new Blob([response.data], {
                type: "application/vnd.ms-excel"
            });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = 'example.xlsx';
            link.click();
        },
    },
};

export default process;

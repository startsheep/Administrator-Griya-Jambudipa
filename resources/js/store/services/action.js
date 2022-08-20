import { reject } from "lodash";
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
    },
};

export default process;

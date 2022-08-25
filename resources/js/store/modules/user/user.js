import { reject } from "lodash";
import ServiceApi from "../../services/api";
const process = {
    actions: {
        postDataUploadUser(context, credentials, url = "user") {
            return new Promise((resolve, reject) => {
                ServiceApi.init();
                ServiceApi.postFormData(url, credentials).then(
                    (response) => {
                        resolve(response.data);
                    },
                    (error) => {
                        reject(error);
                    }
                );
            });
        },
    },
};

export default process;

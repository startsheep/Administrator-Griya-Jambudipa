import { reject } from "lodash";
import ServiceApi from "../../services/api";
const process = {
    actions: {
        updateDataUploadCompanyProfile(context, credentials) {
            var id = credentials.get("id");
            return new Promise((resolve, reject) => {
                ServiceApi.init();
                ServiceApi.postFormData(
                    "company-profile/" + id,
                    credentials
                ).then(
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

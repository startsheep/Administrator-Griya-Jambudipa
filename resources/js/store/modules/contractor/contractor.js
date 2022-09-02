import {
    reject
} from 'lodash'
import ServiceApi from '../../services/api'
const process = {
    actions: {
        postDataUploadContractor(context, credentials, url = 'contractor') {
            return new Promise((resolve, reject) => {
                ServiceApi.init()
                ServiceApi.postFormData(url, credentials).then(
                    response => {
                        resolve(response.data)
                    }, error => {
                        reject(error)
                    }
                );
            })
        },
        // updateDataUploadCustomer(context, credentials) {
        //     var id = credentials.get('id');
        //     return new Promise((resolve, reject) => {
        //         ServiceApi.init()
        //         ServiceApi.postFormData('customer/' + id, credentials).then(
        //             response => {
        //                 resolve(response.data)
        //             }, error => {
        //                 reject(error)
        //             }
        //         );
        //     });
        // },
    }
}

export default process;
import {
    reject
} from 'lodash'
import ServiceApi from '../../services/api'

const process = {
    actions : {
        postDataUploadPayment(context, credentials, url = 'payment'){
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
        }
    }
}
export default process

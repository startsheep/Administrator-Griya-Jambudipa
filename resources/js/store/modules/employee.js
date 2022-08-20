import {reject} from 'lodash'
import ServiceApi from '../services/api'
const process = {
    actions : {
        postDataUploadEmployee(context , credentials , url='employee'){
            return new Promise((resolve , reject)=>{
                ServiceApi.init()
                ServiceApi.postFormData(url , credentials).then(
                    response => {
                        resolve(response.data)
                    },error=>{
                        reject(error)
                    }
                );
            })
        },
        updateDataUploadEmployee(context, credentials) {
            var id = credentials.get('id');
            return new Promise((resolve, reject) => {
                ServiceApi.init()
                ServiceApi.postFormData('employee/' + id, credentials).then(
                    response => {
                        resolve(response.data)
                    }, error => {
                        reject(error)
                    }
                );
            });
        },
    }
}

export default process;

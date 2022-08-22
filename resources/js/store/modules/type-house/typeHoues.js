import {reject} from 'lodash'
import ServiceApi from '../../services/api'

const process = {
    actions : {
        postDataUploadHouse(context , credentials , url='house-type'){
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
        updateDataUploadHouse(context, credentials) {
            var id = credentials.get('id');
            return new Promise((resolve, reject) => {
                ServiceApi.init()
                ServiceApi.postFormData('house-type/' + id, credentials).then(
                    response => {
                        resolve(response.data)
                    }, error => {
                        reject(error)
                    }
                );
            });
        }
    }
}

export default process

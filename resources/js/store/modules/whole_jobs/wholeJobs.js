import {reject} from 'lodash'
import ServiceApi from '../../services/api'

const process={
    actions: {
        postDataUploadJob(context,credentials , url='whole-job'){
            return new Promise((resolve,reject)=>{
                ServiceApi.init()
                ServiceApi.postFormData(url,credentials).then(
                    response=>{
                        resolve(response.data)
                    },error=>{
                        reject(error)
                    }
                );
            })
        },
        updateDataUploadJob(context,credentials){
            var id = credentials.get('id');
            return new Promise((resolve,reject)=>{
                ServiceApi.init()
                ServiceApi.postFormData('whole-job/'+id,credentials).then(
                    response=>{
                        resolve(response.data)
                    },error=>{
                        reject(error)
                    }
                );
            })
        }
    }
}
export default process

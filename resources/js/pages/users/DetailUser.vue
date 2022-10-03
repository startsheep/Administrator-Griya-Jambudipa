<template>
  <div
    class="modal fade"
    id="detailUser"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content bg-light">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="exampleModalLongTitle">
            Detail user
          </h5>
          <button
            type="button"
            class="close text-dark"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <CircleLoader v-if="isLoading" />
          <div v-else class="card bg-light">
            <div class="card-body">
              <div class="user-item">
                <img
                v-if="user.documents.length > 0"
                  alt="image"
                  :src="'storage/'+ user.documents[0].documentPath"
                  class="img-fluid"
                  style="width: 150px"
                />
                <img
                v-else
                  alt="image"
                  src="../../../../public/assets/images/avatar/avatar-1.png"
                  class="img-fluid"
                  style="width: 150px"
                />
                <div class="user-details">
                  <div class="user-name text-dark">{{ user.name }}</div>
                  <div class="text-job text-muted">{{ }}</div>
                  <div class="row mt-3">
                    <div class="col text-left">
                      <div class="text-bold text-dark">Email</div>
                      <div class="text-dark">
                        {{ user.email }}
                      </div>
                    </div>
                    <div class="col text-left">
                      <div class="text-dark">Telepon</div>
                      <div class="text-dark">
                        {{ user.phone }}
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
                 <button
                    style="width: 100%;"
                 type="button" class="btn btn-danger" data-dismiss="modal">
            Tutup
          </button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>
<script>
import CircleLoader from '../../components/CircleLoader.vue';
export default {
    props: ["id"],

    data() {
        return {
            user: {
                name: "",
                email: "",
                phone: "",
                documents : []
            },
            isLoading: false,
        };
    },

    watch : {
        id(newVal){
            this.getUser();
        }
    },
    computed : {

    },
    methods: {

        getUser() {
            this.isLoading = true;
            const self = this;
            self.$store.dispatch("showData", ["user/" +self.id]).then(function (result) {
                self.user.email = result.data.email;
                self.user.name = result.data.name;
                self.user.phone = result.data.phone;
                self.user.documents = result.data.document;
                self.isLoading = false;
            }).catch(error=>{
                this.isLoading = false;
            })
            ;
        },
    },
    components: { CircleLoader }
};
</script>
<style >
    .list-group .list-group-item{

          padding: 5px;
          margin-top: 2px;
          color: #000;

    }
</style>

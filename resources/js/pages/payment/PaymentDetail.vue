<template>
    <div
      class="modal fade"
      id="detailPayment"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalCenterTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-primary">
          <div class="modal-header">
            <h5 class="modal-title text-white" id="exampleModalLongTitle">
              Detail Pembayaran
            </h5>
            <button
              type="button"
              class="close text-white"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <CircleLoader v-if="isLoading" />
            <div v-else class="card bg-primary">
            <div class=" card-body-left">
                <div class="user-item">
                    <div class="row mt-3">
                        <div class="col text-left">
                            <img
                v-if="user.documents.length > 0"
                  alt="image"
                  :src="'storage/'+ payment.documents[0].documentPath"
                  class="img-fluid"
                  style="width: 150px"/>
                <img
                v-else
                  alt="image"
                  src="../../../../public/assets/images/avatar/avatar-1.png"
                  class="img-fluid"
                  style="width: 150px"/>
                    </div>
                    <div class="user-details">

                            <div class="col text-middle">
                                <div class="user-name text-white">{{ customers.name }}</div>
                            </div>
                            <div class="col text">
                                <div class="">No Telp</div>
                                <div class="">{{ customers.phone }}</div>
                            </div>
                            <div class="col text">
                                <div class="">Blok</div>
                                <div class="">{{ payment.block.block}}-{{ payment.block.numberKavling }}</div>
                            </div>
                            <div class="col text">
                                <div class="">Tipe Rumah</div>
                                <div class="">{{ payment.houseType.houseType}}</div>
                            </div>
                            <div class="col text">
                                <div class="">Jenis Pembayaran</div>
                                <div class="">{{  formatRupiah(payment.reminderPayment)}}</div>
                            </div>
                            <div class="col text-middle">
                                <div class="">Referal</div>
                                <div class="">{{ user.name }}</div>
                            </div>
                            <div class="col text-middle">
                                <div class="">Komisi</div>
                                <div class="">{{ user.name }}</div>
                            </div>
                            <div class="col text">
                                <div class="">Sisa Pembayaran</div>
                                <div class="">{{ formatRupiah(payment.houseType.price) }}</div>
                            </div>
                            <div class="col text-left">
                                <div class="">Pembayaran Cicilan</div>
                                <div class="">{{ user.name }}</div>
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
              this.getPayments();
          }
      },
      computed : {

      },
      methods: {

          getPayments() {
              this.isLoading = true;
              const self = this;
              self.$store.dispatch("showData", ["payment/" +self.id]).then(function (result) {
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
      .custom-avatar{
           width: 60px;
    height: 60px;
    -webkit-border-radius: 60px;
    -webkit-background-clip: padding-box;
    -moz-border-radius: 60px;
    -moz-background-clip: padding;
    border-radius: 60px;
    background-clip: padding-box;
    margin: 7px 0 0 5px;
    float: left;
    background-size: cover;
    background-position: center center;
    }
  </style>

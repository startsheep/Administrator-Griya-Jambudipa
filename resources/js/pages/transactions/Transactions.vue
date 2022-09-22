<template>
  <section class="section">
    <div class="section-header">
      <h4>Transaksi</h4>
    </div>
    <div class="section-body">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <div class="row mb-3 d-flex justify-content-between">
                <div class="col-lg-6">
                  <ButtonsExport :printData="false" />
                </div>
                <div class="col-lg-5 ">
                    <div class="input-group" >
                        <button @click="reset()" class="btn btn-success "><i class="fas fa-arrows-rotate"></i></button>
                     <!-- <span>Dari</span>  q -->
                    <input v-model="filter.from" type="month" class="form-control mr-2" >
                    <span class="m-auto "> <i class="fas fa-arrow-right"></i> </span>
                    <input v-model="filter.to" type="month" class="form-control ml-2">
                    <button @click="getTransactions" class="btn btn-primary"><i class="fas fa-search"></i></button>
                 </div>
                </div>
              </div>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Nomor telepon</th>
                    <th>Blok / Kavling</th>
                    <th>Tipe Rumah</th>
                    <th>Angsuran</th>
                    <!-- <th >Sisa Angsuran</th> -->
                    <th>Tipe Pembayaran</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="transaction in transactions" :key="transaction">
                    <td>
                      <div class="media">
                        <figure class="avatar mr-2 avatar-md">
                          <img
                            :src="'storage/' + transaction.customer.image"
                            alt="..."
                          />
                        </figure>

                        <div class="media-body">
                          <div class="media-title">
                            {{ transaction.customer.name }}
                          </div>
                          <div class="text-job text-muted">
                            <span>{{
                              showLogUpdate(transaction.updatedAt)
                            }}</span>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td>{{ transaction.customer.phone }}</td>
                    <td>
                      {{ transaction.block.block }} -
                      {{ transaction.block.numberKavling }}
                    </td>
                    <td>{{ transaction.houseType.houseType }}</td>
                    <td>{{ formatRupiah(transaction.houseType.price) }}</td>
                    <!-- <td>{{ formatRupiah(transaction.reminderPayment) }}</td> -->
                    <td>
                      <span
                        v-if="transaction.type == 'Cash Keras'"
                        class="badge badge-success"
                      >
                        {{ transaction.type }}
                      </span>
                      <span
                        v-if="transaction.type == 'Cash Bertahap'"
                        class="badge badge-warning"
                      >
                        {{ transaction.type }}
                      </span>
                      <span v-else class="badge badge-info">
                        {{ transaction.type }}
                      </span>
                    </td>
                    <td>
                      <span

                        class="badge badge-success"
                      >
                        Lunas
                      </span>
                    </td>
                    <td class="align-middle text-center">
                        <Actions
                            toggleDetail="modal"
                            targetDetail="#detailTransaction"
                            @detail="sendDetail(transaction.id)"
                            :showDelete="false"
                            :showEdit="false"
                        />

                    </td>
                  </tr>
                  <tr>
                    <td colspan="9">
                         <EmptyData message="Data Transaksi Kosong " v-if="transactions.length <1 && !isLoading"/>
                               <CircleLoader v-if="isLoading" />
                        </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="card-footer">
              <Pagination
                :currentPage="pagination.currentPage"
                :rowsTotal="pagination.total"
                :lastPage="pagination.lastPage"
                @onPageChange="onPageChange($event)"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <DetailTransaction  :id="idTransaction"/>
</template>
<script>
    import moment from 'moment'
import Utils from "../../store/services/utils";
import ButtonsExport from "../../components/ButtonsExport.vue";
import Pagination from "../../components/Pagination.vue";
import CircleLoader from "../../components/CircleLoader.vue";
import EmptyData from "../../components/EmptyData.vue";
import DetailTransaction from './DetailTransaction.vue';
import Actions from '../../components/Actions.vue';
export default {
  data() {
    return {
      transactions: [],
      isLoading: false,
      idTransaction: null,
      filter: {
        from: moment().format("YYYY-MM"),
        to: null,
      },
      pagination: {
        total: 0,
        perPage: 5,
        currentPage: 1,
        lastPage: 0,
        page: 0,
      },
    };
  },
  mounted() {
    this.getTransactions();
  },
  methods: {
    showLogUpdate(date) {
      return Utils.showLogUpdate(date);
    },
    formatRupiah(value) {
      return Utils.formatRupiah(value);
    },
    sendDetail(id){
        this.idTransaction = id
    },
    getBlocks(array) {
      //    getblock name between comma
      let blocks = [];
      array.forEach((element) => {
        blocks.push(element.kavling.block);
      });
      return blocks.join(", ");
    },
    getTransactions() {
        console.log('te')
      this.isLoading = true;
      const self = this;
      const params = [];
      if(this.filter.from && this.filter.to){
        params.push(`from=${this.filter.from}`)
        params.push(`to=${this.filter.to}`)
      }

      self.$store.dispatch("getData", ["transaction", params.join('&')]).then((res) => {
        self.transactions = res.data;
        self.pagination.total = res.meta.total;
        self.pagination.currentPage = res.meta.currentPage;
        self.pagination.lastPage = res.meta.lastPage;
        self.isLoading = false;
      });
    },
    onPageChange(page){
        this.pagination.currentPage = page;
        this.getTransactions();
    },
    filter(){
        this.getTransactions();
    },
    reset(){
        this.filter.from = moment().format("YYYY-MM");
        this.filter.to = null;
        this.getTransactions();
    }

  },
  components: { ButtonsExport, Pagination, CircleLoader, EmptyData, DetailTransaction, Actions },
};
</script>
<style lang="">
</style>

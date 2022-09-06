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
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th width="20%">Nama</th>
                      <th width="5%">Blok</th>
                      <th width="10%">Nomor telepon</th>
                      <th width="10%">Angsuran</th>
                      <th width="15%">Sisa Angsuran</th>
                      <th width="10%">Tipe Pembayaran</th>
                      <th class="text-center" width="5%">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="transaction in transactions" :key="transaction">
                      <td>
                        <div class="media">
                          <figure class="avatar mr-2 avatar-md">
                            <img
                              src="../../../../public/assets/images/avatar/avatar-1.png"
                              alt="..."
                            />
                            <i
                              v-if="transaction.reminderPayment > 0"
                              class="avatar-presence busy"
                            ></i>
                            <i v-else class="avatar-presence online"></i>
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
                      <td>{{ getBlocks(transaction.customer.customerKavling) }}</td>
                      <td>{{ transaction.customer.phone }}</td>
                      <td>{{ formatRupiah(transaction.priceHouse) }}</td>
                      <td>{{ formatRupiah(transaction.reminderPayment) }}</td>
                      <td>
                        <span

                        >
                          {{ transaction.type }}
                        </span>
                      </td>
                      <td class="align-middle text-center">
                        <div class="show">
                          <button
                            data-toggle="dropdown"
                            class="btn btn-transparent"
                          >
                            <i
                              class="
                                fa-solid fa-ellipsis-vertical
                                dropdown-toggle
                              "
                              aria-expanded="true"
                            ></i>
                          </button>
                          <div class="dropdown-menu action">
                            <!-- <button
                              class="dropdown-item action sortable"
                              data-toggle="collapse"
                              data-target="#formEdit"
                              @click="sendEdit(transaction)"
                            >
                              Nyicil
                            </button> -->
                            <button class="dropdown-item action sortable">
                              Detail
                            </button>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import Utils from "../../store/services/utils";
export default {
  data() {
    return {
      transactions: [],
      isLoading : false,

      filter:{
        from : null,
        to : null,
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
    showLogUpdate(date){
        return Utils.showLogUpdate(date)
    },
    formatRupiah(value) {
      return Utils.formatRupiah(value);},
     getBlocks(array) {
      //    getblock name between comma
      let blocks = [];
      array.forEach((element) => {

        blocks.push(element.kavling.block);
      });
      return blocks.join(", ");
    },
    getTransactions() {
        this.isLoading = true;
        const self = this;
        const params =[
            // `from=${this.filter.from}`,
            // `to=${this.filter.to}`,
        ].join('&')
        self.$store.dispatch('getData' , ['transaction', params ]).then(
            res =>{
                console.log(res)
                self.transactions = res.data;
                self.pagination.total = res.data.total;
                self.pagination.lastPage = res.data.last_page;
                self.pagination.currentPage = res.data.current_page;
                self.isLoading = false;
            }
        )
    },
  },
};
</script>
<style lang="">
</style>

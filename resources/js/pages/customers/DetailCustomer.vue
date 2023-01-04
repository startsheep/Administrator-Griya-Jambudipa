<template>
  <div
    class="modal fade"
    id="detailCustomer"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content bg-light">
        <div class="modal-header bg-light">
          <h5 class="modal-title text-dark" id="exampleModalLongTitle">
            Detail Customer
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
                <div
                  class="avatar avatar-lg"
                  :style="{
                    'background-image': `url(storage/${customer.image})`,
                  }"
                  style="background-size: cover; width: 120px; height: 120px"
                ></div>

                <div class="user-details">
                  <div class="user-name text-dark">{{ customer.name }}</div>
                  <div class="text-job text-muted">{{}}</div>
                  <div class="row mt-3">
                    <div class="col text-left">
                      <div class="text-bold text-dark">Email</div>
                      <div class="text-dark">
                        {{ customer.email }}
                      </div>
                    </div>
                    <div class="col text-left text-dark">
                      <div class="">Telepon</div>
                      <div class="text-dark">
                        {{ customer.phone }}
                      </div>
                    </div>
                    <div class="col text-left text-dark">
                      <div class="">Pekerjaan</div>
                      <div class="">
                        {{ customer.profession }}
                      </div>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col text-left text-dark">
                      <div class="">Blok / Nomor Kavling</div>
                      <div class="text-dark">
                        {{ showKavlings(customer.customerKavling) }}
                      </div>
                      <div class="mt-2">
                        <div class="text-dark">Alamat</div>
                        <div class="text-dark">
                          {{ customer.address }}
                        </div>
                      </div>
                      <div class="mt-2">
                        <div class="text-dark">Jenis Kelamin</div>
                        <div class="text-dark">
                          {{
                            customer.gender == "L" ? "Laki-Laki" : "Perempuan"
                          }}
                        </div>
                      </div>
                    </div>
                    <div class="col text-left">
                      <div class="text-dark">Dokumen</div>
                      <div>
                        <ul class="list-group">
                          <li
                            class="
                              list-group-item
                              d-flex
                              justify-content-between
                              list-group-item-secondary
                            "
                            v-for="doc in customer.document"
                            :key="doc.id"
                          >
                            {{ doc.documentName }}
                            <a
                              :href="`storage/${doc.documentPath}`"
                              class="btn btn-sm btn-transparent"
                              target="_blank"
                            >
                              <i class="fas fa-download"></i>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button
                style="width: 100%"
                type="button"
                class="btn btn-danger"
                data-dismiss="modal"
              >
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
import CircleLoader from "../../components/CircleLoader.vue";
export default {
  props: ["id"],

  data() {
    return {
      customer: {},
      isLoading: false,
    };
  },

  watch: {
    id(newVal) {
      this.getCustomer();
    },
  },
  methods: {
    showKavlings(kavlings) {
      if (kavlings) {
        return kavlings
          .map((kavling) => {
            return (
              kavling.kavling.block + " / " + kavling.kavling.numberKavling
            );
          })
          .join(", ");
      } else {
        return "-";
      }
    },
    downloadDoc(doc) {
      const self = this;
    },
    getCustomer() {
      this.isLoading = true;
      const self = this;
      self.$store
        .dispatch("showData", ["customer/" + self.id])
        .then(function (result) {
          self.customer = result.data;
          self.isLoading = false;
        });
    },
  },
  components: { CircleLoader },
};
</script>
<style >
.list-group .list-group-item {
  padding: 5px;
  margin-top: 2px;
  color: #000;
}
.custom-avatar {
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

<template>
  <modal id="detailContractor" tittle="Detail Contractor" :confirmBtn="false">
    <template #body>
      <div class="user-item">
        <div
          class="avatar avatar-lg"
          :style="{
            'background-image': `url(storage/${contractor.image})`,
          }"
          style="background-size: cover; width: 120px; height: 120px"
        ></div>

        <div class="user-details">
          <div class="user-name">{{ contractor.picName }}</div>
          <div class="text-job text-muted">{{ contractor.companyName }}</div>
          <div class="row mt-3">
            <div class="col text-left">
              <div class="text-bold">Email</div>
              <div class="">
                {{ contractor.email }}
              </div>
            </div>
            <div class="col text-left">
              <div class="">Telepon</div>
              <div class="">
                {{ contractor.phone }}
              </div>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col text-left">
              <div class="mt-2">
                <div class="">Alamat</div>
                <div class="">
                  {{ contractor.address }}
                </div>
              </div>
            </div>
            <div class="col text-left">
              <div class="">Dokumen</div>
              <div>
                <ul class="list-group">
                  <li
                    class="
                      list-group-item
                      d-flex
                      justify-content-between
                      list-group-item-secondary
                    "
                    v-for="doc in contractor.document"
                    :key="doc"
                  >
                    {{doc.documentName}}
                    <button
                      type="button"
                      class="btn btn-sm btn-transparent"
                      click
                    >

                      <a :href="'storage/'+doc.documentPath" target="_blank">
                        <i class="fas fa-download"></i>
                    </a>
                    </button>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </modal>
</template>
<script>
import Modal from "../../components/Modal.vue";
export default {
  components: { Modal },
  props: ["id"],
  data() {
    return {
      contractor: {},
    };
  },
  watch: {
    id: function (val) {
      this.getContractor();
    },
  },
  mounted() {
    if (this.id != null) {
      this.getContractor();
    }
  },
  methods: {
    getContractor() {
      this.$store
        .dispatch("showData", ["contractor/" + this.id])
        .then((res) => {
          this.contractor = res.data;
        });
    },
    downloadFile(file){



    }
  },
};
</script>
<style lang="">
</style>

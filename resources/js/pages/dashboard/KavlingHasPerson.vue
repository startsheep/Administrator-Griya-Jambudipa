<template>
    <section class="section">
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- search button -->

                                <div class="float-right">
                                    <button class="btn btn-primary" @click="showModal = true">
                                        <i class="fas fa-plus"></i> Tambah
                                    </button>
                                </div>
                    </div>
                </div>
            </div>
            <div class="col-3 " v-for="kavling in kavlings">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <h4>{{ kavling.name }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script setup>
    import { ref, onMounted } from 'vue'
    let kavlings = ref([
        {
            id: 1,
            name: 'Kavling 1',
            price: 100000000,
            status: 'sold',
            person: {
                name: 'Person 1',
                phone: '08123456789',
                email: 'Exported from KavlingHasPerson.vue'
        }},
        {
            id: 2,
            name: 'Kavling 2',
            price: 200000000,
            status: 'sold',
            person: {
                name: 'Person 2',
                phone: '08123456789',
                email: 'Exported from KavlingHasPerson.vue'
        }},
        {
            id: 1,
            name: 'Kavling 1',
            price: 100000000,
            status: 'sold',
            person: {
                name: 'Person 1',
                phone: '08123456789',
                email: 'Exported from KavlingHasPerson.vue'
        }},
        {
            id: 2,
            name: 'Kavling 2',
            price: 200000000,
            status: 'sold',
            person: {
                name: 'Person 2',
                phone: '08123456789',
                email: 'Exported from KavlingHasPerson.vue'
        }},
        {
            id: 1,
            name: 'Kavling 1',
            price: 100000000,
            status: 'sold',
            person: {
                name: 'Person 1',
                phone: '08123456789',
                email: 'Exported from KavlingHasPerson.vue'
        }},
        {
            id: 2,
            name: 'Kavling 2',
            price: 200000000,
            status: 'sold',
            person: {
                name: 'Person 2',
                phone: '08123456789',
                email: 'Exported from KavlingHasPerson.vue'
        }},
        {
            id: 1,
            name: 'Kavling 1',
            price: 100000000,
            status: 'sold',
            person: {
                name: 'Person 1',
                phone: '08123456789',
                email: 'Exported from KavlingHasPerson.vue'
        }},
        {
            id: 2,
            name: 'Kavling 2',
            price: 200000000,
            status: 'sold',
            person: {
                name: 'Person 2',
                phone: '08123456789',
                email: 'Exported from KavlingHasPerson.vue'
        }},
    ])
</script>

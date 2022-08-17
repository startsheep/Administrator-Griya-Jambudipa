<template >
      <section class="section">
        <div class="section-header">
            <h1>Data Pegawai</h1>
        </div>

        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Divisi</h4>
                        <form class="card-header-form">
                            <input type="text" name="search" class="form-control" placeholder="Search">
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive   ">
                            <table class="table table-bordered table-md tabel-jabatan">
                                <tbody>
                                    <tr>
                                        <th>Jabatan</th>
                                        <th>Gaji</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                    <tr v-for="division in divisions" :key="division.id">
                                        <td>
                                            <div class="media">
                                                <div class="media-body">
                                                    <div class="media-title">
                                                        {{ division.title }}
                                                    </div>
                                                    <div class="text-job text-muted">
                                                        <span>update 1 day ago</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ division.salary }}</td>
                                        <td class="text-center">
                                            <div class="show">

                                                <i class="fa-solid fa-ellipsis-vertical dropdown-toggle "
                                                    data-toggle="dropdown" aria-expanded="true"></i>
                                                <div class="dropdown-menu action">
                                                    <a class="dropdown-item action" href="#">Hapus</a>
                                                    <a class="dropdown-item action" href="#">Hapus</a>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah jabatan</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-group row" action="">

                            <label for="jabatan" class="col-sm-3 col-form-label">Nama Jabatan</label>
                            <div class="col-sm-9 ">
                                <input type="text" class="form-control" v-model="division.title"  placeholder="Nama Jabatan">
                            </div>
                            <label for="gaji" class="col-sm-3 col-form label mt-4">Gaji</label>
                            <div class="col-sm-9 mt-4"><input type="number" class="form-control " v-model="division.salary"
                                    placeholder="Gaji"></div>
                        </form>
                    </div>
                    <div class="card-footer text-right">
                        <button @click="addDivision" class="btn btn-primary mr-1" type="submit">Submit</button>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-primary">Tambah Data</button>
                        <div class="card-header-action">

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col">
                                <div class="btn-group mb-3">
                                    <button type="button" class="btn btn-icon icon-rigth btn-primary mr-2">EXPORT PDF <i
                                            class="fa-solid fa-file-pdf"></i></button>
                                    <button type="button" class="btn btn-icon icon-rigth btn-primary mr-2">EXPORT EXCEL <i
                                            class="fa-solid fa-file-excel"></i></button>
                                    <button type="button" class="btn btn-icon icon-rigth btn-primary mr-2">PRINT DATA <i
                                            class="fa-solid fa-print"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Divisi</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Gaji</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="align-middle">
                                            <div class="media">

                                                <img class="avatar mr-3 rounded-circle"
                                                    src="{{ asset('assets/images/avatar/avatar-1.png') }}" alt="">
                                                <div class="media-body">
                                                    <div class="media-title">
                                                        Ahmad
                                                    </div>
                                                    <div class="text-job text-muted">
                                                        <span>update 1 day ago</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <span>Web Developer</span>
                                        </td>
                                        <td class="align-middle">
                                            <span>45 Agustus 2022</span>
                                        </td>
                                        <td class="align-middle">
                                            <span>Rp.10.000.00</span>
                                        </td>

                                        <td class="align-middle">
                                            <div class="badge badge-success">Pegawai Tetap</div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="show">
                                            <i class="fa-solid fa-ellipsis-vertical dropdown-toggle "
                                                data-toggle="dropdown" aria-expanded="true"></i>
                                            <div class="dropdown-menu action">
                                                <a class="dropdown-item action" href="#">Hapus</a>
                                                <a class="dropdown-item action" href="#">Hapus</a>
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
export default {
data(){
    return {
        division : {
            id : Math.random() + 1,
            title : '',
            salary: '',
        },
        divisions : []
    }
},

methods: {
    addDivision(){
        this.divisions.push(this.division)
        this.division = {
            title : '',
            salary: '',
        }
    },
    getDivisions(){
       const self = this
       self.$store.dispatch('getDivisions').then((response)=>{
           self.divisions = response.data
       })
    }
}

}
</script>

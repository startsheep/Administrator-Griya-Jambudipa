<template>
    <div class="main-sidebar sidebar-style-1" style="z-index:999">
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <img
                    src="../../../public/assets/images/logo.png"
                    class="img-fluid"
                    alt=""
                    style="width: 30%"
                />
            </div>
            <div class="sidebar-brand sidebar-brand-sm">
                <router-link to="/">AGJ</router-link>
            </div>
            <ul class="sidebar-menu">
                <li class="menu-header">Data Master</li>

                <li class="nav-item">
                    <router-link to="/dashboard" class="nav-link"
                        ><i class="fa-solid fa-chart-line"></i
                        ><span>Dashboard</span></router-link
                    >
                </li>

                <li class="nav-item">
                    <router-link to="/company_profile" class="nav-link"
                        ><i class="fa-solid fa-building"></i
                        ><span>Profile Perusahaan</span></router-link
                    >
                </li>
                <li class="nav-item">
                    <router-link to="/building" class="nav-link"
                        ><i class="fa-solid fa-building-columns"></i
                        ><span>Harga Dasar Bangunan</span></router-link
                    >
                </li>
                <li class="nav-item">
                    <router-link to="/land" class="nav-link"
                        ><i class="fa-solid fa-signs-post"></i
                        ><span>Harga Dasar Tanah</span></router-link
                    >
                </li>
                <li class="nav-item">
                    <router-link to="/kavlings" class="nav-link"
                        ><i class="fa-solid fa-maximize"></i
                        ><span>Kavling</span></router-link
                    >
                </li>
                <li class="nav-item">
                    <router-link to="/type-house" class="nav-link"
                        ><i class="fa-solid fa-house-circle-check"></i
                        ><span>Tipe Rumah</span></router-link
                    >
                </li>
                
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link"
                        ><i class="fa-solid fa-id-card-clip"></i
                        ><span>Dokumen Customer</span></a
                    >
                </li> -->
                <li class="menu-header">Informasi Umum</li>
                
                <li class="nav-item">
                    <router-link to="/employees" class="nav-link"
                        ><i class="fa-solid fa-people-group"></i
                        ><span>Data Pegawai</span></router-link
                    >
                </li>
                <li class="nav-item">
                    <router-link to="/customers" class="nav-link"
                        ><i class="fa-solid fa-people-roof"></i
                        ><span>Data Customer</span></router-link
                    >
                </li>
                <li class="nav-item">
                    <router-link to="/contractor" class="nav-link"
                        ><i  class="fa-solid fa-people-roof"></i
                        ><span>Data Pemborong</span></router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/users" class="nav-link"
                        ><i class="fa-solid fa-users"></i
                        ><span>Data Pengguna</span></router-link
                    >
                </li>
                
                <li class="menu-header">Menu Utama</li>
                <li class="nav-item">
                    <router-link to="/transaction" class="nav-link"
                        ><i class="fa-solid fa-cash-register"></i
                        ><span>Transaksi</span></router-link
                    >
                </li>
                <li class="nav-item">
                    <router-link to="/payment" class="nav-link"
                        ><i class="fa-solid fa-wallet"></i
                        ><span>Pembayaran</span></router-link
                    >
                </li>
                <li class="nav-item">
                    <router-link to="/payment" class="nav-link"
                        ><i class="fa-solid fa-wallet"></i
                        ><span>Borongan Pekerjaan</span></router-link
                    >
                </li>
                <li class="nav-item">
                    <router-link to="/payment" class="nav-link"
                        ><i class="fa-solid fa-wallet"></i
                        ><span>Pembayaran Borongan</span></router-link
                    >
                </li>
                
               
                <!-- <li>
                    <a href="#" class="nav-link"
                        ><i class="fas fa-gear"></i><span>Settings</span></a
                    >
                </li> -->
            </ul>
            <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
 
            </div>
        </aside>
    </div>
</template>
<script>
export default {
    name: "Sidebar",
};
</script>
<style lang=""></style>

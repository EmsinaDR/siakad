@props(['data_keuangan_komite', 'data_keuangan_komite_keluar'])
<section class='content'>

    <div class='container-fluid'>
        <div class='row'>
            <div class='col'>
                <!-- Papan Informasi  -->
                <div class='row mx-2'>
                    <div class='col-lg-3 col-6'>
                        <!-- small box -->
                        <div class='small-box bg-info'>
                            <h3 class='m-2'>Komite</h3>

                            <div class='inner'>
                                <div class=" d-flex justify-content-between">
                                    <span>Total Pemasukkan</span><span>Rp. {{ number_format(($data_keuangan_komite), 2) }}</span>
                                </div>
                                <div class=" d-flex justify-content-between">
                                    <span>Total Pengeluaran</span><span>Rp. {{ number_format(($data_keuangan_komite_keluar), 2) }}</span>
                                </div>
                                <div class=" d-flex justify-content-between">
                                    {{-- <span>Kelas IX</span><span>155 Orang</span> --}}
                                    <span>Sisa Keuangan</span><span>
                                        @if($data_keuangan_komite < $data_keuangan_komite_keluar)
                                        <b class='text-danger'>Rp. {{ number_format(($data_keuangan_komite - $data_keuangan_komite_keluar), 2) }}</b>
                                        @else
                                        Rp. {{ number_format(($data_keuangan_komite - $data_keuangan_komite_keluar), 2) }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class='icon'>
                                <i class='fa fa-wallet'></i>
                            </div>
                            <a href='#' class='small-box-footer'>More info <i
                                    class='fas fa-arrow-circle-right'></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class='col-lg-3 col-6'>
                        <!-- small box -->
                        <div class='small-box bg-success'>
                            <h3 class='m-2'>Total Pengeluaran</h3>
                            <div class='inner'>
                                <div class=" d-flex justify-content-between">
                                    <span>Kelas VII</span><span>Rp. 3.000.000</span>
                                </div>
                                <div class=" d-flex justify-content-between">
                                    <span>Kelas VIII</span><span> Orang</span>
                                </div>
                                <div class=" d-flex justify-content-between">
                                    <span>Kelas IX</span><span> Orang</span>
                                </div>
                            </div>

                            <div class='icon'>
                                <i class='ion ion-stats-bars'></i>
                            </div>
                            <a href='#' class='small-box-footer'>More info <i
                                    class='fas fa-arrow-circle-right'></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class='col-lg-3 col-6'>
                        <!-- small box -->
                        <div class='small-box bg-warning'>
                            <h3 class='m-2'>Study Tour</h3>

                            <div class='inner'>
                                <div class=" d-flex justify-content-between">
                                    <span>Total</span><span>Rp. 3.000.000</span>
                                </div>
                                <div class=" d-flex justify-content-between">
                                    <span>Pemasukan</span><span>Rp.</span>
                                </div>
                                <div class=" d-flex justify-content-between">
                                    <span>Sisa</span><span>Rp.</span>
                                </div>
                            </div>

                            <div class='icon'>
                                <i class='ion ion-person-add'></i>
                            </div>
                            <a href='#' class='small-box-footer'>More info <i
                                    class='fas fa-arrow-circle-right'></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class='col-lg-3 col-6'>
                        <!-- small box -->
                        <div class='small-box bg-danger'>
                            <h3 class='m-2'>Bantuan</h3>

                            <div class='inner'>
                                <div class=" d-flex justify-content-between">
                                    <span>Kelas VII</span><span>Rp. 3.000.000</span>
                                </div>
                                <div class=" d-flex justify-content-between">
                                    <span>Kelas VIII</span><span> Orang</span>
                                </div>
                                <div class=" d-flex justify-content-between">
                                    <span>Kelas IX</span><span> Orang</span>
                                </div>
                            </div>

                            <div class='icon'>
                                <i class='ion ion-pie-graph'></i>
                            </div>
                            <a href='#' class='small-box-footer'>More info <i
                                    class='fas fa-arrow-circle-right'></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>

                <!-- Papan Informasi  -->
                {{-- <x-footer></x-footer> --}}


            </div>
        </div>
    </div>



</section>

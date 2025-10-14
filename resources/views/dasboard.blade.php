<?php
// session_start();
// $_SESSION['judulx'] = 'aaa';
$arr_ths = ['nis', 'nama', 'kelas'];
// dd($datas);
?>
{{-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> --}}

{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"> --}}
</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">

<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    {{-- {{ dd(session('CheckAdmin')) }} --}}
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    {{-- Contoh Cek Versi Gratis, Trial, Basic, Premium --}}
    {{-- <div style="background: #f0f0f0; padding: 20px; margin-bottom: 20px; border-radius: 8px;">
    <h2>Paket: <strong>{{ $identitas->paket }}</strong></h2>

    @if ($identitas->paket === 'Trial')
        @php
            $trialEnd = \Carbon\Carbon::parse($identitas->trial_ends_at);
            $now = \Carbon\Carbon::now();
            $daysLeft = $now->diffInDays($trialEnd, false);
        @endphp

        @if ($daysLeft > 0)
            <p style="color: {{ $daysLeft <= 5 ? 'orange' : 'green' }};">
                Masa Trial tersisa <strong>{{ $daysLeft }}</strong> hari lagi.
                @if ($daysLeft <= 5)
                    <br><small>Segera upgrade untuk menghindari downgrade ke Paket Gratis!</small>
                @endif
            </p>
        @else
            <p style="color:red;">
                Masa Trial sudah berakhir. Sistem Anda telah beralih ke Paket Gratis.
            </p>
        @endif
    @endif

    @if ($identitas->paket === 'Gratis')
        <p style="color: blue;">Saat ini Anda menggunakan Paket <strong>Gratis</strong>.</p>
    @endif
</div> --}}

    {{-- Contoh Cek Versi Gratis, Trial, Basic, Premium --}}

    <x-informasi-dashboard>{{ $info }}</x-informasi-dashboard>
</x-layout>
@if ($_POST['action'] = 'tambah')
    @isset($_GET['idsiswa'])
        <script>
            $(document).ready(function() {
                $('#InsertSiswa').modal('show');
            });
        </script>
        <!-- Batas Atas Insert Siswa Modal -->
        <div class='modal fade' id='InsertSiswa'>
            <div class='modal-dialog modal-lg'>
                <div class='modal-content'>
                    <div class='modal-header bg-primasi'>
                        <h4 class='modal-title'>Tambah Siswa</h4>
                        <button type='submit' class='close' data-dismiss='modal' aria-label='Close'><span
                                aria-hidden='true'>&times;</span></button>
                    </div>
                    <div class='modal-body'>
                        <input type='text' id='idsiswa' name='myText' value=''>

                    </div>
                    <div class='modal-footer justify-content-between'>
                        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                        <!--<button type='button' class='btn btn-primary'>Save changes</button>-->
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

        <!-- Batas Bawah Insert Siswa Modal -->
    @endisset
@elseif($_POST['edit'] = 'edit')
    <script>
        $(document).ready(function() {
            $('#EditSiswa').modal('show');
        });
    </script>

    <!-- Batas Atas Edit Siswa Modal -->
    <div class='modal fade' id='EditSiswa'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header bg-primasi'>
                    <h4 class='modal-title'>Edit Siswa</h4>
                    <button type='submit' class='close' data-dismiss='modal' aria-label='Close'><span
                            aria-hidden='true'>&times;</span></button>
                </div>
                <div class='modal-body'>
                    <?php $datanew = DB::table('users')->where('id', $_GET['idsiswa'])->get(); ?>
                    <input type='text' id='idsiswa' name='myText' value='{{ $datanew[0]->id }}'>
                </div>
                <div class='modal-footer justify-content-between'>
                    <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                    <!--<button type='button' class='btn btn-primary'>Save changes</button>-->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <!-- Batas Bawah Edit Siswa Modal -->
@elseif($_POST['action'] = 'delete')
@else
@endif
















<script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<script src="{{ asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>



<script>
    new DataTable('#example1', {
        responsive: {
            details: {
                display: DataTable.Responsive.display.modal({
                    header: function(row) {
                        var data = row.data();
                        return 'Details for ' + data[0] + ' ' + data[1];
                    }
                }),
                renderer: DataTable.Responsive.renderer.tableAll({
                    tableClass: 'table'
                })
            }
        }
    });
</script>

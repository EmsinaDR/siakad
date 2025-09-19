<?php
// session_start();
// $_SESSION['judulx'] = 'aaa';
$arr_ths = ['nis', 'nama', 'kelas'];
?>
{{-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> --}}

{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"> --}}
</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<!-- DataTables CSS -->
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css"> --}}


<!-- DataTables JS -->
<!-- {{-- <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"> --}} -->
</script>

{{-- <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback'> --}}
<!-- Font Awesome -->
{{-- <link rel='stylesheet' href='plugins/fontawesome-free/css/all.min.css'> --}}

<!-- DataTables -->
<link rel='stylesheet' href='plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'>

<link rel='stylesheet' href='plugins/datatables-responsive/css/responsive.bootstrap4.min.css'>

<link rel='stylesheet' href='plugins/datatables-buttons/css/buttons.bootstrap4.min.css'>

<!-- Theme style -->
<link rel='stylesheet' href='dist/css/adminlte.min.css'>

<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content'>


        <div class='container-fluid'>
            <div class='row'>
                <div class='col'>
                    <form action="" methode='GET'>

                        <input type='hidden' class='classmydata' id='id' name='idsiswa' value='3'>

                        <input type='hidden' class='classmydata' id='id' name='tambah' value='tambah'>
                        <button type='submit' class='btn btn-default bg-primary btn-sm' id="bootstrapbtn" data-toggle='modal'>Tambah Data</button>
                    </form>
                    <form action="" methode='GET'>

                        <input type='hidden' class='classmydata' id='id' name='idsiswa' value='3'>
                        <input type='hidden' class='classmydata' id='id' name='edit' value='tambah'>
                        <button type='submit' class='btn btn-default bg-primary btn-sm' id="bootstrapbtn" data-toggle='modal'>Edit Data</button>
                    </form>
                    {{-- <a href="http://127.0.0.1:8000/?data=10"><button type='button' class='btn btn-default bg-primary btn-sm' data-toggle='modal' data-target='#InsertSiswa'>Tambah DataX</button></a> --}}
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="exampleModal" data-whatever="@getbootstrap">Open modal for @getbootstrap</button>
                    <div class="modal fade" id="modalsiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                        <div class="modal-dialog" role="document">
                            <div class="modal-content">



                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">New message Example</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <?php //echo $_REQUEST['data'];
                                    ?>

                                    <form>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                                            <input type="text" class="form-control" id="recipientname" value="">

                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Message:</label>
                                            <textarea class="form-control" id="message-text"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Send message</button>
                                </div>
                            </div>
                        </div>
                    </div>




                    <p id='myText'>aaa</p>

                    <button type='button' class='btn  btn-default bg-primary btn-sm' data-toggle='modal'>bootstrap btn</button>


                    <button onclick="myFunction()">Try it</button>







                    {{-- data-target='#InsertSiswa' --}}

                    <script>
                        // $(document).ready(function() {
                        //     $('#bootstrapbtn').on('click', function() {
                        //             // $("#message").slideUp();
                        //             $('#InsertSiswa').modal('show');
                        //             $('#idsiswa').val('300');

                        //         }


                        //     ).delay(5000);

                        // })
                        // $('#InsertSiswa').modal('show');
                        // $('#idsiswa').val('300');
                    </script>


                    <div class='card pl-3 pr-3 pt-3 pb-3'>
                        <h2>Judul Konten</h2>
                        <hr>

                        {{-- {{ dd($breadcrumb) }} --}}


                        {{-- {{ dd(Auth::user()->role) }} --}}


                        {{ $no = 1 }}






                        {{ Auth::user()->role }}
                        {{-- {{ Auth::user()->Role->User->name }} => {{ Auth::user()->Role->role }} --}}

                        <div class='card d-flex justify-content-between'>

                            <div class='card-header bg-primary '>
                                <h3 class='card-title'>$tabel_title</h3>
                            </div>

                            <div class='card-body mr-2 ml-2'>
                                <table id='example1' width="100%" class='table table-responsive table-bordered table-hover'>
                                    <thead>
                                        <tr>
                                            <th width='1%'>ID</th>
                                            @foreach ($arr_ths as $arr_th)
                                            <th> {{ $arr_th }}</th>
                                            @endforeach
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $datax)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td> {{ $datax['name'] }}</th>
                                            <td> {{ $datax['email'] }}</th>
                                            <td> {{ $datax['password'] }}</th>
                                            <td width='10%'><button type='button' class='btn  btn-default bg-primary btn-sm'><i class='fa fa-edit right'></i></button> <button type='button' class='btn  btn-default bg-danger btn-sm'><i class='fa fa-trash'></i></button></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th width='1%'>ID</th>
                                            @foreach ($arr_ths as $arr_th)
                                            <th> {{ $arr_th }}</th>
                                            @endforeach
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>

                        <!--Footer-->
                        <div class='card-footer'>
                            {{-- {{ dd(Auth::user()->role) }} --}}

                            a
                        </div>
                        <!-- /.card-footer-->
                    </div>
                    <x-footer></x-footer>


                </div>
            </div>
        </div>



    </section>


</x-layout>

@if($_POST['action'] = 'tambah')
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
                <button type='submit' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
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

@elseif(($_POST['edit'] = 'edit'))
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
                <button type='submit' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
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


@elseif(($_POST['action'] = 'delete'))

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
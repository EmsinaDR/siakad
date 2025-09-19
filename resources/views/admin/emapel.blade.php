  @php
      // $activecrud = collect([2,4, 6, 8])->search(Auth::user()->id);
      // dd($dataMapel);
      $activecrud = collect([1, 2, 6, 8])->search(Auth::user()->id);
      $show_menu = 1;
      $mapels = App\Models\Admin\Emapel::all();

  @endphp


  <style>
  </style>
  <x-layout>
      <x-slot:title>{{ $title }}</x-slot:title>
      <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
      <section class='content mx-2'>
          <x-alert-header></x-alert-header>

          <x-plugins-tabel-header></x-plugins-tabel-header>
          <x-plugins-multiple-select-header></x-plugins-multiple-select-header>
          <div class='card'>

              {{-- Papan Informasi --}}
              {{-- blade-formatter-disable --}}
              <div class="card-body">
                <div class="row float-right">
                  <div class='float-right'>
                      <x-btnjs>submit/Mapel/fa fa-plus/btn btn-primary btn-xl bg-primary btn-app/TambahMapel()</x-btnjs>
                      <x-btnjs>submit/Atur Mapel Sama/fa fa-cog/btn btn-primary btn-xl bg-primary btn-app/ModalAktivMapel()</x-btnjs>
                      <button type='button' class='btn btn-primary btn-xl bg-primary btn-app border=pill' data-toggle='modal' data-target='#MapelBerbeda'><i class='fa fa-plus'></i> Mapel Berbeda</button>
                      <button type='button' class='btn btn-primary btn-xl bg-primary btn-app border=pill' data-toggle='modal' data-target='#ModalInformasiq'><i class='fa fa-info-circle'></i> Info</button>
                    </div>
                  </div>
              </div>
              {{-- blade-formatter-enable --}}





              <div class='ml-2'>

                  <!--Car Header-->
                  <div class='card-header bg-primary'>
                      <h3 class='card-title'>{{ $title }}</H3>
                  </div>
                  <!--Car Header-->


                  <div class='card-body'>
                      <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                          <thead>
                              <tr class='table-success text-center'>
                                  <th width='1%'>ID</th>
                                  @foreach ($arr_ths as $arr_th)
                                      <th> {{ $arr_th }}</th>
                                  @endforeach
                                  @if ($activecrud === 0 or $activecrud === 1)
                                      <th width='5%'>Action</th>
                                  @endif
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($dataMapel as $data)
                                  <tr>
                                      <td class="text-center">{{ $loop->iteration }}</td>
                                      <td>{{ $data->mapel }}</td>
                                      <td class="text-center">{{ $data->kategori }}</td>
                                      <td class="text-center">{{ $data->kelompok }}</td>
                                      <td class="text-center">{{ $data->jtm }}</td>
                                      <td width="5%">
                                          <div class='gap-1 d-flex justify-content-center'>
                                              <!-- Button untuk melihat -->
                                              <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                  data-toggle='modal' data-target='#editModal{{ $data->id }}'>
                                                  <i class='fa fa-edit'></i> </button>
                                          </div>
                                      </td>
                                  </tr>
                                  {{-- Modal View Data Akhir --}}
                                  <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                      aria-labelledby='EditModalLabel' aria-hidden='true'>
                                      <x-edit-modal>
                                          <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                          <section>
                                              <form id="formedit" action="{{ route('emapel.update', $data->id) }}"
                                                  method="POST">
                                                  @csrf
                                                  @method('PUT')
                                                  {{-- blade-formatter-disable --}}
                                                                <input type='hidden' class='form-control' id='eid' name='id' value=''>
                                                                <div class='form-group'>
                                                                    <label for='emapel'>Mata Pelajaran</label>
                                                                    <input type='text' class='form-control' id='emapel' name='mapel' placeholder='Mata Pelajaran' value='{{$data->mapel}}' required>
                                                                </div>
                                                                <div class='form-group'>
                                                                    <label for='kategori'>Singkatan</label>
                                                                    <input type='text' class='form-control' id='esingkatan' name='singkatan' placeholder='Singkatan Mapel' value='{{$data->singkatan}}' required>
                                                                </div>
                                                                <div class='form-group'>
                                                                    <label for='kategori'>Kategori</label>
                                                                    <select name='kategori' class='form-control' id='ekategori'>
                                                                        <option value=''>--- Pilih Kategori ---</option>
                                                                        @foreach ($kategoris as $kategori)
                                                                            <option value='{{ $data['kategori'] }}' @if($kategori['kategori'] === $data->kategori) selected @endif>{{ $kategori['kategori'] }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class='form-group'>
                                                                    <label for='kategori'>Kelompok</label>
                                                                    <select name='kelompok' class='form-control' id='ekelompok'>
                                                                        <option value=''>--- Pilih Kelompok ---</option>
                                                                        @foreach ($kelompoks as $kelompok)
                                                                            <option value='{{ $data['kelompok'] }}' @if($data['kelompok'] === $data->kelompok) selected @endif>{{ $kelompok['kelompok'] }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class='form-group'>
                                                                    <label for='ejtm'>JTM</label>
                                                                    <input type='text' class='form-control' id='ejtm' name='jtm' value='{{$data->jtm}}'  placeholder='JTM Mapel'>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                                                                </div>
                                                                {{-- blade-formatter-enable --}}
                                              </form>



                                          </section>
                                      </x-edit-modal>
                                  </div>
                                  {{-- Modal Edit Data Akhir --}}
                              @endforeach
                          </tbody>
                          <tfoot>
                              <tr class='text-center'>
                                  <th width='1%'>ID</th>
                                  @foreach ($arr_ths as $arr_th)
                                      <th> {{ $arr_th }}</th>
                                  @endforeach
                                  @if ($activecrud === 0 or $activecrud === 1)
                                      <th>Action</th>
                                  @endif
                              </tr>

                          </tfoot>
                      </table>
                  </div>
                  <!-- /.card-body -->
                  <!--Footer-->
                  <div class='card-footer'>

                  </div>
                  <!-- /.card-footer-->
              </div>

          </div>
      </section>

  </x-layout>



  <script>
      function TambahMapel(data) {
          var TambahMapel = new bootstrap.Modal(document.getElementById('TambahMapel'));
          TambahMapel.show();
          // document.getElementById('Eid').value = data.id;
      }

      function ModalAktivMapel(data) {
          var ModalAktivMapel = new bootstrap.Modal(document.getElementById('AktivMapel'));
          ModalAktivMapel.show();
          document.getElementById('Eid').value = data.id;
      }
  </script>

  {{-- Modal Edit Data Awal --}}
  <div class='modal fade' id='TambahMapel' tabindex='-1' aria-labelledby='ModalTambahMapel' aria-hidden='true'>
      <div class='modal-dialog modal-lg'>
          <div class='modal-content'>
              <div class='modal-header bg-primary'>
                  <h5 class='modal-title' id='ModalTambahMapel'>

                      Tambah Mata Pelajaran

                  </h5>
                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                      <span aria-hidden='true'>&times;</span>
                  </button>
              </div>
              <div class='modal-body'>
                  {{-- /emapel/tambahmapel --}}
                  <form id='#id' action='{{ route('emapel.TambahMapel') }}' method='POST'>
                      @csrf
                      @method('POST')
                      <div class='form-group'>
                          <label for='mapel'>Mata Pelajaran</label>
                          <input type='text' class='form-control' id='mapel' name='mapel' placeholder='Mapel'
                              required>
                      </div>
                      <div class='form-group'>
                          <label for='singkatan'>Singkatan</label>
                          <input type='text' class='form-control' id='singkatan' name='singkatan'
                              placeholder='Singkatan Mapel contoh MTK' required>
                      </div>

                      <div class='form-group'>
                          <label for='kategori'>Kategori</label>
                          <select name='kategori' class='select2 form-control' required>
                              <option value=''>--- Pilih Kategori ---</option>
                              <option value='Umum'>Umum</option>
                              <option value='IPA'>IPA</option>
                              <option value='Bahasa'>Bahasa</option>
                              <option value='Seni'>Seni</option>
                              <option value='Agama'>Agama</option>
                          </select>
                      </div>
                      <div class='form-group'>
                          <label for='kelompok'>Kelompok</label>
                          <select name='kelompok' class='select2 form-control' required>
                              <option value=''>--- Pilih Kelompok ---</option>
                              <option value='A'>A</option>
                              <option value='B'>B</option>
                              <option value='C'>C</option>
                          </select>
                      </div>
                      <div class='form-group'>
                          <label for='jtm'>JTM</label>
                          <input type='text' class='form-control' id='jtm' name='jtm' placeholder='JTM'
                              required>
                      </div>
                      <div class='modal-footer'>
                          <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                          <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Kirim</button>
                      </div>
                  </form>

              </div>
          </div>
      </div>

  </div>
  {{-- Modal Edit Data Akhir --}}
  {{-- Modal aktiv mapel --}}


  {{-- Modal Edit Data Awal --}}
  <div class='modal fade' id='AktivMapel' tabindex='-1' aria-labelledby='ModalAktivLabel' aria-hidden='true'>
      <div class='modal-dialog modal-lg'>
          <div class='modal-content'>
              <div class='modal-header bg-primary'>
                  <h5 class='modal-title' id='ModalAktivLabel'>
                      Aktivasi Mapel Sama
                  </h5>
                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                      <span aria-hidden='true'>&times;</span>
                  </button>
              </div>

              <div class="alert alert-info m-2" role="alert">
                  <strong>Informasi!</strong>
                  <p>Jika Bp / Ibu memilih mapel disini akan dimasukkan kedalam semua kelas yang aktiv di pengaturan
                      kelas. Lebih sederhana pengaturan mapel disini digunakan untuk mapel sama pada semua kelas
                      tersedia.</p>
                  <p>Mengatur mapel aktif disetiap kelas pada data mengajar</p>
              </div>
              <form action="/emapel/mapelaktivkan" method="POST">
                  @csrf
                  @method('POST')


                  <div class='modal-body'>
                      <x-dropdown-mapel>idmapelAktivMapel</x-dropdown-mapel>
                  </div>
                  <div class='modal-footer'>
                      <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                      <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                  </div>
              </form>

          </div>
      </div>
  </div>
  {{-- Modal aktiv mapel --}}


  {{-- Modal Edit Data Awal --}}
  <script>
      $(document).ready(function() {
          initDataTable('#example1', 'Data Peserta Ekstra', '#example1_wrapper .col-md-6:eq(0)');
          initDataTable('#example2', 'Data Peserta Ekstra 2', '#example2_wrapper .col-md-6:eq(0)');
      });

      // Fungsi untuk inisialisasi DataTable
      function initDataTable(tableId, exportTitle, buttonContainer) {
          // Hancurkan DataTable jika sudah ada
          $(tableId).DataTable().destroy();

          // Inisialisasi DataTable
          var table = $(tableId).DataTable({
              lengthChange: true, //False jika ingin dilengkapi dropdown
              autoWidth: false,
              responsive: true, // Membuat tabel menjadi responsif agar bisa menyesuaikan dengan ukuran layar
              lengthChange: true, // Menampilkan dropdown untuk mengatur jumlah data per halaman
              autoWidth: false, // Mencegah DataTables mengatur lebar kolom secara otomatis agar tetap sesuai dengan CSS
              buttons: [{
                      extend: 'copy',
                      title: exportTitle,
                      exportOptions: {
                          columns: ':visible:not(.noprint)'
                      }
                  },
                  {
                      extend: 'excel',
                      title: exportTitle,
                      exportOptions: {
                          columns: ':visible:not(.noprint)'
                      }
                  },
                  {
                      extend: 'pdf',
                      title: exportTitle,
                      exportOptions: {
                          columns: ':visible:not(.noprint)'
                      }
                  },
                  {
                      extend: 'colvis',
                      titleAttr: 'Pilih Kolom'
                  }
              ],
              columnDefs: [{
                  targets: -1, // Kolom terakhir (Action) bisgunkan array contoh [-1, -2, -4]
                  visible: false // Menyembunyikan kolom Action
              }],
              rowGroup: {
                  dataSrc: 0
              } // Mengelompokkan berdasarkan kolom pertama (index 0)
          });

          // Menambahkan tombol-tombol di atas tabel
          table.buttons().container().appendTo(buttonContainer);
      }
  </script>
  {{-- Modal Edit Data Awal --}}
  <div class='modal fade' id='ModalInformasiq' tabindex='-1' aria-labelledby='LabelModalInformasiq'
      aria-hidden='true'>
      <div class='modal-dialog modal-lg'>
          <div class='modal-content'>
              <div class='modal-header bg-primary'>
                  <h5 class='modal-title' id='LabelModalInformasiq'>
                      Tambah Data Baru
                  </h5>
                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                      <span aria-hidden='true'>&times;</span>
                  </button>
              </div>
              <div class='modal-body'>

                  <div class='modal-header bg-primary'>
                      <h5 class='modal-title' id='ModalInformasiLabel'>
                          Informasi Penggunaan !!!
                      </h5>
                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                      </button>
                  </div>
                  <div class='modal-body'>
                      <table class='table table-responsive'>
                          {{-- blade-formatter-disable --}}
                      <tr>
                          <td width="10%" class='d-flex align-items-center jsutify-content-center'>
                              <x-btnjs>submit//fa fa-plus/btn btn-primary btn-xl bg-primary/TambahMapel()</x-btnjs>
                          </td>
                          <td class='pl-4 bg-info'>Tombol yang digunakan untuk menambahkan daftar mapel pada menu mapel sehingga bisa dimasukkan pada kelas yang diinginkan</td>
                      </tr>
                      <tr>
                          <td width="10%" class='pt-2'>
                              <x-btnjs>submit//fa fa-cog/btn btn-primary btn-xl bg-primary/ModalAktivMapel()</x-btnjs>
                          </td>
                          <td class='pl-4 bg-info'> Tombol yang digunakan untuk mengisi mapel sama pada <b class='text-danger'>Setiap Kelas</b> yang telah dimasukkan pada menu kelas</td>
                      </tr>
                      {{-- blade-formatter-enable --}}
                      </table>
                  </div>
                  <div class='modal-footer'>
                      <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                      <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i>
                          Simpan</button>
                  </div>
              </div>

          </div>
      </div>

  </div>

  {{-- Modal Edit Data Awal --}}
  <div class='modal fade' id='MapelBerbeda' tabindex='-1' aria-labelledby='LabelMapelBerbeda' aria-hidden='true'>
      <div class='modal-dialog modal-lg'>
          <div class='modal-content'>
              <div class='modal-body'>

                  <div class='modal-header bg-primary'>
                      <h5 class='modal-title' id='ModalMapelBedaLabel'>
                          Masukkan Mapel Kelas
                      </h5>
                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                      </button>
                  </div>
                  <div class='modal-body'>
                      <div class='alert alert-info alert-dismissible'>
                          <button type='button' class='close' data-dismiss='alert'
                              aria-hidden='true'>&times;</button>
                          <h5><i class='icon fas fa-info'></i> Information !</h5>
                          <hr>
                          Bapak / Ibu bisa menambahkan mapel untuk kelas tertentu jika memiliki perbedaan mapel didalam
                          kelasnya
                      </div>
                      <form action="/emapel/mapelaktivkan" method="POST">
                          @csrf
                          @method('POST')

                          {{-- Dropdown pilih kelas --}}
                          <x-dropdown-kelas>aktiv-multiple</x-dropdown-kelas>
                          <x-dropdown-mapel>modalmapelbeda</x-dropdown-mapel>
                          {{-- --}}
                          <div class='modal-footer'>
                              <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                              <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i>
                                  Simpan</button>
                          </div>
                      </form>
                      Mengatur Mapel Untuk Kelas Tertentu

                  </div>
              </div>

          </div>
      </div>

  </div>

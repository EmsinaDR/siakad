@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
@endphp
<x-layout>
    <style>
        textarea {
            resize: none,
        }
    </style>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content mx-2 my-4'>
        {{-- Validator --}}
        @if ($errors->any())
            <div class='alert alert-danger'>
                <ul class='mb-0'>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- Validator --}}
        <div class='card'>
            {{-- Papan Informasi --}}


            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            {{-- blade-formatter-disable --}}
               <div class='row m-2'>
                   <div class='col-xl-2'>
                       <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Tambah Data</button>
                   </div>
                   <div class='col-xl-10'></div>
               </div>
               <div class="row p-2">
                <div class="col-xl-12">

                </div>
               </div>
               {{-- blade-formatter-enable --}}


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <div class="row">
                            <div class="col-xl-6">
                                <table id='example1' width='100%' class='table table-bordered'>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Nama Sekolah</td>
                                        <td class='text-left'> : {{ $Identitas->jenjang }}{{ $Identitas->nomor }}
                                            {{ $Identitas->namasek }}</td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Nama Guru</td>
                                        <td class='text-left'> : {{ $Guru->nama_guru }}</td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>NIP/NUPTK</td>
                                        <td class='text-left'> : {{ $Guru->nip }}</td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Sertifikasi</td>
                                        <td class='text-left'> : Tahun {{ request()->detailguru_id }}</td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Kehadiran di Sekolah</td>
                                        <td class='text-left'> : .......... hari/minggu ........ %</td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Kehadiran Tatap Muka di kelas</td>
                                        <td class='text-left'> : .......... %</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-xl-6">
                                <table id='example1' width='100%' class='table table-bordered'>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Tahun Pelajaran</td>
                                        <td class='text-left'> : {{ $Tapels->tapel }}/ {{ $Tapels->tapel + 1 }}</td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Mata Pelajaran</td>
                                        <td class='text-left'> : {{ $DataMapel->mapel }}</td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Kelas/Semester</td>
                                        <td class='text-left'> : {{ $DataKelas->kelas }} / {{ $Tapels->semester }}
                                        </td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Jumlah Jam TM</td>
                                        <td class='text-left'> : {{ $DataMapel->jtm }} / minggu</td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Kehadiran di Sekolah</td>
                                        <td class='text-left'> : ............. </td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Kehadiran Tatap Muka di kelas</td>
                                        <td class='text-left'> : .............</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        {{-- {{dump($datas)}} --}}
                        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='table-primary text-center align-middle'>
                                    <th>ID</th>
                                    <th>Indikator</th>
                                    <th>Ketersediaan</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr class='text-center'>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-left'>{{ $data->indikator }}</td>
                                        <td class="editable" data-name="ketersediaan" data-id="{{ $data->id }}">
                                            Klik untuk edit</td>
                                        <td class="editable" data-name="nilai" data-id="{{ $data->id }}">Klik
                                            untuk edit</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class='table-primary text-center align-middle'>
                                    <th>ID</th>
                                    <th>Indikator</th>
                                    <th>Ketersediaan</th>
                                    <th>Nilai</th>
                                </tr>
                            </tfoot>
                        </table>
                        <button type="button" id="submitForm">Kirim</button>

                        <script>
                            $(document).ready(function() {
                                var table = $('#example1').DataTable();
                            });

                            document.querySelectorAll('.editable').forEach(cell => {
                                cell.addEventListener('click', function() {
                                    if (!this.querySelector('input')) {
                                        let input = document.createElement('input');
                                        input.type = this.dataset.name === 'nilai' ? 'number' : 'text';
                                        input.name = `${this.dataset.name}[${this.dataset.id}]`;
                                        input.classList.add('form-control');
                                        input.value = this.innerText.trim() !== 'Klik untuk edit' ? this.innerText.trim() : '';
                                        this.innerHTML = '';
                                        this.appendChild(input);
                                        input.focus();
                                    }
                                });
                            });

                            document.getElementById('submitForm').addEventListener('click', function() {
                                let formData = new FormData();
                                formData.append("_token", "{{ csrf_token() }}");
                                formData.append("kategori", "pembelajaran");

                                document.querySelectorAll('input').forEach(input => {
                                    formData.append(input.name, input.value);
                                });

                                // Debug: Log data yang dikirim ke server
                                for (let pair of formData.entries()) {
                                    console.log(pair[0] + ': ' + pair[1]);
                                }

                                fetch("{{ route('supervisi-pembelajaran.store') }}", {
                                        method: "POST",
                                        headers: {
                                            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                                        },
                                        body: formData
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        alert("Data berhasil disimpan!");
                                        console.log("Response dari server:", data);
                                    })
                                    .catch(error => {
                                        alert("Terjadi kesalahan, coba lagi.");
                                        console.error("Error:", error);
                                    });
                            });
                        </script>


                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>

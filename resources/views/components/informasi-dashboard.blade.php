@php
    use App\Models\User;
    use Illuminate\Support\Str;
    use Illuminate\Support\Carbon;

    $info = explode('/', $slot);
    $users = User::get();

    $taglines = \App\Models\Program\Tagline\DataTagline::orderBy('created_at', 'desc')
        ->get()
        ->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        });

    $taglines = \App\Models\Program\Tagline\DataTagline::orderBy('created_at', 'desc')
        ->paginate(10)
        ->through(function ($item) {
            // Bisa modifikasi tiap item kalau perlu, ini opsional
            return $item;
        })
        ->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        });
    $paginator = \App\Models\Program\Tagline\DataTagline::orderBy('created_at', 'desc')->paginate(10);

    $taglines = $paginator->getCollection()->groupBy(function ($item) {
        return $item->created_at->format('Y-m-d');
    });

@endphp

<section class='content'>

    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xl-12'>
                <!-- Papan Informasi  -->
                @if ($Identitas->paket === 'Gratis')
                @else
                    <div class='row'>
                        <div class='col-12 col-lg-{{ $Identitas->paket !== 'Premium' ? 4 : 3 }}'>
                            <!-- small box -->
                            <div class='small-box bg-info'>
                                <h3 class='m-2'>{{ $info[0] + $info[1] + $info[2] }} Orang</h3>

                                <div class='inner'>
                                    <div class=" d-flex justify-content-between">
                                        <span>Siswa</span><span>{{ $info[0] }} Orang</span>
                                    </div>
                                    <div class=" d-flex justify-content-between">
                                        <span>Guru + Karyawan</span><span>{{ $info[1] + $info[2] }} Orang</span>
                                    </div>
                                </div>
                                <div class='icon'>
                                    <i class='fa fa-user'></i>
                                </div>
                                <a href='#' class='small-box-footer'>More info <i
                                        class='fas fa-arrow-circle-right'></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class='col-12 col-lg-{{ $Identitas->paket !== 'Premium' ? 4 : 3 }}'>
                            <!-- small box -->
                            <div class='small-box bg-success'>
                                <h3 class='m-2'>{{ $info[4] + $info[5] }} Ruang</h3>
                                <div class='inner'>
                                    <div class=" d-flex justify-content-between">
                                        <span>Ruang Kelas</span><span>{{ $info[4] }} Kelas</span>
                                    </div>
                                    <div class=" d-flex justify-content-between">
                                        <span>Laboratorium</span><span>{{ $info[5] }} Lab</span>

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
                        @php
                            // $Jumlah_Alumni = Cache::tags(['Cache_jumlah_alumnni'])->remember(
                            //     'Remember_jumlah_alumnni',
                            //     now()->addMinutes(10),
                            //     function () {
                            //         return \App\Models\User\Siswa\Detailsiswa::where('status_siswa', 'Alumni')
                            //             ->select('tahun_lulus', \DB::raw('COUNT(*) as total'))
                            //             ->groupBy('tahun_lulus')
                            //             ->orderByDesc('tahun_lulus')
                            //             ->get();
                            //     },
                            // );

                            // tentukan range tahun yg mau ditampilkan (2 tahun terakhir)
                            $tahunSekarang = date('Y');
                            $tahunRange = [$tahunSekarang - 1, $tahunSekarang - 2];

                            // bikin collection dengan default 0 untuk tahun yang kosong
                            $Alumni_Display = collect($tahunRange)->map(function ($tahun) use ($Jumlah_Alumni) {
                                $found = $Jumlah_Alumni->firstWhere('tahun_lulus', $tahun);
                                return (object) [
                                    'tahun_lulus' => $tahun,
                                    'total' => $found ? $found->total : 0,
                                ];
                            });
                        @endphp

                        <div class='col-12 col-lg-{{ $Identitas->paket !== 'Premium' ? 4 : 3 }}'>
                            <div class='small-box bg-warning'>
                                <h3 class='m-2'>{{ $Jumlah_Alumni->sum('total') }} Alumni</h3>
                                <div class='inner'>
                                    @foreach ($Alumni_Display as $alumni)
                                        <div class="d-flex justify-content-between">
                                            <span>Tahun {{ $alumni->tahun_lulus }}</span>
                                            <span>{{ $alumni->total }} Orang</span>
                                        </div>
                                    @endforeach
                                </div>

                                <div class='icon'>
                                    <i class='ion ion-person-add'></i>
                                </div>
                                <a href='#' class='small-box-footer'>More info <i
                                        class='fas fa-arrow-circle-right'></i></a>
                            </div>
                        </div>


                        <!-- ./col -->
                        @if ($Identitas->paket === 'Premium')
                            <div class='col-12 col-lg-3'>
                                <!-- small box -->
                                <div class='small-box bg-danger'>
                                    <h3 class='m-2'>{{ $info[3] }} Mata Pelajaran</h3>

                                    <div class='inner'>
                                        <div class=" d-flex justify-content-between">
                                            {{-- <span>Ruang Kelas</span><span>{{ $info[0] }} Orang</span> --}}
                                        </div>
                                        <div class=" d-flex justify-content-between">
                                            {{-- <span>Lab</span><span>{{ $info[1] }} Orang</span> --}}
                                        </div>
                                    </div>

                                    <div class='icon'>
                                        <i class='ion ion-pie-graph'></i>
                                    </div>
                                    <a href='#' class='small-box-footer'>More info <i
                                            class='fas fa-arrow-circle-right'></i></a>
                                </div>
                            </div>
                        @endif
                        <!-- ./col -->
                    </div>
                @endif
                <div class='card d-flex'>
                    <div class='row'>
                        <div class='col-sm-6'>

                            <div class='card-header bg-info'>
                                <h3 class='card-title'><b>Informasi</b></h3>
                            </div>
                            <div class='card-body'>
                                <!-- Main content -->
                                <section class='content'>
                                    <div class='container-fluid'>

                                        <!-- Timelime example  -->
                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <!-- The time line -->
                                                <div class='timeline'>
                                                    <!-- timeline time label -->

                                                    <!-- /.timeline-label -->
                                                    <!-- timeline item -->
                                                    {{-- blade-formatter-disable --}}
                                                    @foreach ($taglines as $tanggal => $items)
                                                        <div class='time-label'>
                                                            <span
                                                                class='bg-red'>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</span>
                                                        </div>

                                                        @foreach ($items as $tagline)
                                                            <div>
                                                                <div class="timeline-item p-2 shadow">
                                                                    <span class="time">
                                                                        <i class="fas fa-clock"></i>
                                                                        {{ $tagline->created_at->format('H:i') }}
                                                                    </span>
                                                                    <h3 class="timeline-header">
                                                                        <a
                                                                            href="#">{{ $tagline->judul ?? 'Tanpa Judul' }}</a>
                                                                        oleh
                                                                        <strong>{{ $tagline->Guru->nama_guru ?? 'Anonim' }}</strong>
                                                                        @if ($tagline->is_aktif)
                                                                            <span
                                                                                class="badge badge-success">Aktif</span>
                                                                        @else
                                                                            <span class="badge badge-secondary">Tidak
                                                                                Aktif</span>
                                                                        @endif
                                                                    </h3>

                                                                    @php
                                                                        $isi = $tagline->isi;
                                                                        $jumlahKarakter = strlen($tagline->isi);

                                                                        $maxChars = 250;
                                                                        $hasTable = Str::contains($isi, '<table');
                                                                        // Potong isi sebelum <table>
                                                                        $posTable = strpos($isi, '<table');
                                                                        $isiTanpaTabel =
                                                                            $posTable !== false
                                                                                ? substr($isi, 0, $posTable)
                                                                                : $isi;

                                                                        // Hilangkan tag HTML dan potong 250 karakter
                                                                        $textOnly = strip_tags($isiTanpaTabel);
                                                                        $textPreview = Str::limit(
                                                                            $textOnly,
                                                                            $maxChars,
                                                                            '...',
                                                                        );

                                                                        $tabelPreview = '';

                                                                        if ($hasTable) {
                                                                            preg_match(
                                                                                '/<table.*?<\/table>/is',
                                                                                $isi,
                                                                                $matches,
                                                                            );
                                                                            if (isset($matches[0])) {
                                                                                $dom = new DOMDocument();
                                                                                libxml_use_internal_errors(true);
                                                                                $dom->loadHTML($matches[0]);
                                                                                $rows = $dom->getElementsByTagName(
                                                                                    'tr',
                                                                                );

                                                                                $tabelPreview =
                                                                                    '<table class="table table-bordered">';
                                                                                for (
                                                                                    $i = 0;
                                                                                    $i < $rows->length && $i < 4;
                                                                                    $i++
                                                                                ) {
                                                                                    $tabelPreview .= $dom->saveHTML(
                                                                                        $rows[$i],
                                                                                    );
                                                                                }
                                                                                $tabelPreview .= '</table>';
                                                                            }
                                                                        }
                                                                    @endphp

                                                                    <div class="timeline-body">
                                                                        @if ($hasTable)
                                                                            <p>{{ $textPreview }}</p>
                                                                            {!! $tabelPreview !!}
                                                                        @else
                                                                            <p>{{ $textPreview }}</p>
                                                                        @endif
                                                                    </div>

                                                                    <div class="timeline-footer">
                                                                        @if ($jumlahKarakter < 250)
                                                                        @else
                                                                            <a href="{{ route('tagline.show', $tagline->id) }}"
                                                                                class="btn btn-primary btn-sm">Read more
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endforeach
                                                    <div class="float-right">{{ $paginator->links() }}</div>
                                                </div>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                    </div>
                                    <!-- /.timeline -->

                                </section>
                                <!-- /.content -->

                            </div>


                        </div>
                        <div class='col-sm-6'>
                            <div class='card-header bg-info'>
                                <h3 class='card-title'><b>Riwayat Login</b></h3>
                            </div>
                            <div class='card-body'>
                                @php
                                    // $riwayatLogins = DB::table('riwayat_logins')
                                    //     ->join('users', 'riwayat_logins.user_id', '=', 'users.id')
                                    //     ->join('detailgurus', 'users.detailguru_id', '=', 'detailgurus.id')
                                    //     ->select('riwayat_logins.*', 'users.*', 'detailgurus.nama_guru as nama_guru')
                                    //     ->get();
                                    $riwayatLogins = Cache::tags(['cache_variabel'])->remember(
                                        'remember_variabel',
                                        now()->addMinutes(10),
                                        function () {
                                            return App\Models\Admin\RiwayatLogin::whereNot('user_id', 1)->get();
                                        },
                                    );
                                @endphp
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th width='1%'>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Posisi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($riwayatLogins as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->user->name }}</td>
                                                <td>{{ $user->user->email }}</td>
                                                <td>{{ $user->user->posisi }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                <script>
                                    $(document).ready(function() {
                                        $('#myTable').dataTable();
                                    });
                                </script>

                            </div>
                        </div>

                    </div>
                </div>
                <!-- Papan Informasi  -->
                {{-- <x-footer></x-footer> --}}


            </div>
        </div>
    </div>



</section>

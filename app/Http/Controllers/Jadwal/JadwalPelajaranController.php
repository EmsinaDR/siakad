<?php

namespace App\Http\Controllers\Jadwal;

use Faker\Factory as Faker;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\Learning\Emengajar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Admin\Emapel;
use App\Models\User\Guru\Detailguru;
use App\Models\Jadwal\JadwalPelajaran;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class JadwalPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    JadwalPelajaran
    $jadwalpelajaran
    role.jadwal
    role.jadwal.jadwal-pelajaran
    role.jadwal.blade_show
    Index = Data Jadwal Pelajaran
    Breadcume Index = 'Waka Kurikulum / Data Jadwal Pelajaran';
    Single = Jadwal Pelajaran
    php artisan make:view role.jadwal.jadwal-pelajaran
    php artisan make:view role.jadwal.jadwal-pelajaran-single
    php artisan make:seed JadwalPelajaranSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data Jadwal Pelajaran';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kurikulum / Data Jadwal Pelajaran';
        $titleviewModal = 'Lihat Data Jadwal Pelajaran';
        $titleeditModal = 'Edit Data Jadwal Pelajaran';
        $titlecreateModal = 'Create Data Jadwal Pelajaran';
        $datas = JadwalPelajaran::get();
        // Urutkan berdasarkan hari secara manual
        $DataPengawas = Detailguru::get();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $jadwals = JadwalPelajaran::with(['Guru', 'Kelas'])->where('tapel_id', $etapels->id)
            ->orderByRaw("
        CASE
            WHEN hari = 'Senin' THEN 1
            WHEN hari = 'Selasa' THEN 2
            WHEN hari = 'Rabu' THEN 3
            WHEN hari = 'Kamis' THEN 4
            WHEN hari = 'Jumat' THEN 5
            WHEN hari = 'Sabtu' THEN 6
            ELSE 7
        END
    ")
            ->orderBy('jam')
            ->get()
            ->groupBy(['hari', 'jam']);

        // **Urutkan ulang berdasarkan urutan yang diinginkan**
        $hariUrutan = ["Sabtu", "Jum'at", "Kamis", "Rabu", "Selasa", "Senin"]; // Gunakan double quote atau escape
        $hariUrutan = array_reverse($hariUrutan);

        $jadwals = collect($hariUrutan)
            ->mapWithKeys(fn($hari) => [$hari => $jadwals[$hari] ?? collect([])]);;


        // Ambil daftar kelas yang ada dalam jadwal
        $kelasList = JadwalPelajaran::select('kelas_id')
            ->distinct()
            ->orderBy('kelas_id')
            ->pluck('kelas_id')
            ->toArray();

        // dd($jadwals);
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $dataKelas = Emengajar::where('tapel_id', $etapels->id)->select('kelas_id')->distinct('kelas_id')->pluck('kelas_id')->toArray();
        $CekJadwal = JadwalPelajaran::where('tapel_id', $etapels->id)->count();
        // dd($CekJadwal);
        $emengajars = Emengajar::with(['bmapel', 'bguru'])
            ->where('tapel_id', $etapels->id)
            ->get()
            ->groupBy(fn($item) => optional($item->bmapel)->mapel ?? 'Tanpa Mapel')
            ->map(function ($group) use ($dataKelas) {
                $result = [
                    'mapel' => optional($group->first()->bmapel)->mapel ?? '-'
                ];

                foreach ($dataKelas as $kelasId) {
                    $guruData = $group->firstWhere('kelas_id', $kelasId);
                    $result['kelas_' . $kelasId] = optional($guruData?->bguru)->kode_guru ?? '-';
                }

                return $result;
            })
            ->values();
        //    dd($emengajars);

        return view('role.jadwal.jadwal-pelajaran', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'jadwals',
            'kelasList',
            'DataPengawas',
            'emengajars',
            'dataKelas',
            'CekJadwal',
        ));
        //php artisan make:view role.jadwal.jadwal-pelajaran

    }

    public function show()
    {
        //
        //Title to Controller
        $title = 'Jadwal Pelajaran';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kurikulum / Data Jadwal Pelajaran';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = \App\Models\Jadwal\JadwalPelajaran::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.jadwal.jadwal-pelajaran-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.jadwal.jadwal-pelajaran-single
    }

    public function store(Request $request)
    {
        //
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            //data_field_validator
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }



        JadwalPelajaran::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, JadwalPelajaran $jadwalpelajaran)
    {
        //

        dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            //data_field_validator
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $varmodel = JadwalPelajaran::find($id); // Pastikan $id didefinisikan atau diterima dari request
        if ($varmodel) {
            $varmodel->update($validator->validated());
            return Redirect::back()->with('Title', 'Berhasil')->with('success', 'Data Berhasil di Update');
        } else {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Data tidak ditemukan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //JadwalPelajaran
        // dd(id);
        // dd(request->all());
        $data = JadwalPelajaran::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
    // public function updateJadwal(Request $request, $id)
    // {
    //     $jadwal = JadwalPelajaran::find($id);
    //     if (!$jadwal) {
    //         return response()->json(['success' => false, 'message' => 'Jadwal tidak ditemukan!']);
    //     }

    //     $jadwal->mapel = $request->mapel;
    //     $jadwal->save();

    //     return response()->json(['success' => true, 'message' => 'Jadwal diperbarui!']);
    // }
    public function updateJadwal(Request $request, $id)
    {
        $jadwal = JadwalPelajaran::find($id);

        if (!$jadwal) {
            return response()->json(['success' => false, 'message' => 'Jadwal tidak ditemukan!']);
        }

        // Konversi kode guru ke uppercase
        $kodeGuru = strtoupper($request->kode_guru);

        // Cek apakah kode_guru valid di Detailguru
        $detailGuru = Detailguru::where('kode_guru', $kodeGuru)->first();
        if (!$detailGuru) {
            return response()->json(['success' => false, 'message' => 'Kode Guru tidak ditemukan!']);
        }

        // Cek apakah kode guru sudah digunakan pada hari & jam yang sama (BENTROK)
        $cekBentrok = JadwalPelajaran::where('hari', $jadwal->hari)
            ->where('jam', $jadwal->jam)
            ->where('detailguru_id', $detailGuru->id)
            ->where('id', '!=', $jadwal->id)
            ->exists();

        if ($cekBentrok) {
            return response()->json([
                'success' => false,
                'message' => "Kode guru {$kodeGuru} bentrok pada jam {$jadwal->jam}!"
            ]);
        }

        // Jika tidak bentrok, update jadwal
        $jadwal->update([
            'detailguru_id' => $detailGuru->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui!',
            'detailguru_id' => $detailGuru->id
        ]);
    }
    public function JadwalBlank()

    {
        $etapels = Etapel::where('aktiv', 'Y')->first();
        if ($etapels) {
            JadwalPelajaran::where('tapel_id', $etapels->id)->delete();
        }
        //dd($request->all());
        $faker = Faker::create(); //Simpan didalam code run
        // foreach ($jam as $jadwal) {
        function generateRandomCodes($length = 2, $count = 100)
        {
            $codes = [];
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

            for ($i = 0; $i < $count; $i++) {
                $codes[] = substr(str_shuffle($characters), 0, $length);
            }

            return $codes;
        }
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->

        // Contoh penggunaan
        $Mapels = Emengajar::where('tapel_id', $etapels->id)->where('tingkat_id', 7)->select('mapel_id')->distinct('mapel_id')->pluck('mapel_id')->toArray();
        $jams = ['07:00 - 07:40', '07:40 - 08:20', '08:20 - 09:00', '09:00 - 09:40', '10:00 - 10:40', '10:40 - 11:20', '11:30 - 12:10', '12:10 - 12:50'];
        $kelass = Emengajar::where('tapel_id', $etapels->id)->where('tingkat_id', 7)->select('kelas_id')->distinct('kelas_id')->pluck('kelas_id')->toArray();
        // dd($Mapels);
        $randomCodes = generateRandomCodes();
        //$faker->randomElement($Mapels)
        //Kelas 7
        foreach ($kelass as $kelas):
            // foreach ($Mapels as $Mapel):
            foreach ($jams as $jam):
                $jadwals = [
                    //Senin
                    ['tapel_id' => 8, 'jam' => $jam, 'kelas_id' => $kelas, 'tingkat_id' => 7, 'hari' => 'Senin', 'mapel_id' => Null, 'detailguru_id' => Null, 'created_at' => now(), 'updated_at' => now()],
                    ['tapel_id' => 8, 'jam' => $jam, 'kelas_id' => $kelas, 'tingkat_id' => 7, 'hari' => 'Selasa', 'mapel_id' => Null, 'detailguru_id' => Null, 'created_at' => now(), 'updated_at' => now()],
                    ['tapel_id' => 8, 'jam' => $jam, 'kelas_id' => $kelas, 'tingkat_id' => 7, 'hari' => 'Rabu', 'mapel_id' => Null, 'detailguru_id' => Null, 'created_at' => now(), 'updated_at' => now()],
                    ['tapel_id' => 8, 'jam' => $jam, 'kelas_id' => $kelas, 'tingkat_id' => 7, 'hari' => 'Kamis', 'mapel_id' => Null, 'detailguru_id' => Null, 'created_at' => now(), 'updated_at' => now()],
                    ['tapel_id' => 8, 'jam' => $jam, 'kelas_id' => $kelas, 'tingkat_id' => 7, 'hari' => 'Jum\'at', 'mapel_id' => Null, 'detailguru_id' => Null, 'created_at' => now(), 'updated_at' => now()],
                    ['tapel_id' => 8, 'jam' => $jam, 'kelas_id' => $kelas, 'tingkat_id' => 7, 'hari' => 'Sabtu', 'mapel_id' => Null, 'detailguru_id' => Null, 'created_at' => now(), 'updated_at' => now()],
                ];
                DB::table('jadwal_pelajaran')->insert($jadwals);
            endforeach;
        // endforeach;
        endforeach;
        //Kelas 8
        $Mapels = Emengajar::where('tapel_id', $etapels->id)->where('tingkat_id', 8)->select('mapel_id')->distinct('mapel_id')->pluck('mapel_id')->toArray();
        $jams = ['07:00 - 07:40', '07:40 - 08:20', '08:20 - 09:00', '09:00 - 09:40', '10:00 - 10:40', '10:40 - 11:20', '11:30 - 12:10', '12:10 - 12:50'];
        $kelass = Emengajar::where('tapel_id', $etapels->id)->where('tingkat_id', 8)->select('kelas_id')->distinct('kelas_id')->pluck('kelas_id')->toArray();
        foreach ($kelass as $kelas):
            // foreach ($Mapels as $Mapel):
            foreach ($jams as $jam):
                $jadwals = [
                    //Senin
                    ['tapel_id' => 8, 'jam' => $jam, 'kelas_id' => $kelas, 'tingkat_id' => 8, 'hari' => 'Senin', 'mapel_id' => Null, 'detailguru_id' => Null, 'created_at' => now(), 'updated_at' => now()],
                    ['tapel_id' => 8, 'jam' => $jam, 'kelas_id' => $kelas, 'tingkat_id' => 8, 'hari' => 'Selasa', 'mapel_id' => Null, 'detailguru_id' => Null, 'created_at' => now(), 'updated_at' => now()],
                    ['tapel_id' => 8, 'jam' => $jam, 'kelas_id' => $kelas, 'tingkat_id' => 8, 'hari' => 'Rabu', 'mapel_id' => Null, 'detailguru_id' => Null, 'created_at' => now(), 'updated_at' => now()],
                    ['tapel_id' => 8, 'jam' => $jam, 'kelas_id' => $kelas, 'tingkat_id' => 8, 'hari' => 'Kamis', 'mapel_id' => Null, 'detailguru_id' => Null, 'created_at' => now(), 'updated_at' => now()],
                    ['tapel_id' => 8, 'jam' => $jam, 'kelas_id' => $kelas, 'tingkat_id' => 8, 'hari' => 'Jum\'at', 'mapel_id' => Null, 'detailguru_id' => Null, 'created_at' => now(), 'updated_at' => now()],
                    ['tapel_id' => 8, 'jam' => $jam, 'kelas_id' => $kelas, 'tingkat_id' => 8, 'hari' => 'Sabtu', 'mapel_id' => Null, 'detailguru_id' => Null, 'created_at' => now(), 'updated_at' => now()],
                ];
                DB::table('jadwal_pelajaran')->insert($jadwals);
            endforeach;
        // endforeach;
        endforeach;
        //Kelas 9
        $Mapels = Emengajar::where('tapel_id', $etapels->id)->where('tingkat_id', 9)->select('mapel_id')->distinct('mapel_id')->pluck('mapel_id')->toArray();
        $jams = ['07:00 - 07:40', '07:40 - 08:20', '08:20 - 09:00', '09:00 - 09:40', '10:00 - 10:40', '10:40 - 11:20', '11:30 - 12:10', '12:10 - 12:50'];
        $kelass = Emengajar::where('tapel_id', $etapels->id)->where('tingkat_id', 9)->select('kelas_id')->distinct('kelas_id')->pluck('kelas_id')->toArray();
        foreach ($kelass as $kelas):
            // foreach ($Mapels as $Mapel):
            foreach ($jams as $jam):
                $jadwals = [
                    //Senin
                    ['tapel_id' => 8, 'jam' => $jam, 'kelas_id' => $kelas, 'tingkat_id' => 9, 'hari' => 'Senin', 'mapel_id' => Null, 'detailguru_id' => Null, 'created_at' => now(), 'updated_at' => now()],
                    ['tapel_id' => 8, 'jam' => $jam, 'kelas_id' => $kelas, 'tingkat_id' => 9, 'hari' => 'Selasa', 'mapel_id' => Null, 'detailguru_id' => Null, 'created_at' => now(), 'updated_at' => now()],
                    ['tapel_id' => 8, 'jam' => $jam, 'kelas_id' => $kelas, 'tingkat_id' => 9, 'hari' => 'Rabu', 'mapel_id' => Null, 'detailguru_id' => Null, 'created_at' => now(), 'updated_at' => now()],
                    ['tapel_id' => 8, 'jam' => $jam, 'kelas_id' => $kelas, 'tingkat_id' => 9, 'hari' => 'Kamis', 'mapel_id' => Null, 'detailguru_id' => Null, 'created_at' => now(), 'updated_at' => now()],
                    ['tapel_id' => 8, 'jam' => $jam, 'kelas_id' => $kelas, 'tingkat_id' => 9, 'hari' => 'Jum\'at', 'mapel_id' => Null, 'detailguru_id' => Null, 'created_at' => now(), 'updated_at' => now()],
                    ['tapel_id' => 8, 'jam' => $jam, 'kelas_id' => $kelas, 'tingkat_id' => 9, 'hari' => 'Sabtu', 'mapel_id' => Null, 'detailguru_id' => Null, 'created_at' => now(), 'updated_at' => now()],
                ];
                DB::table('jadwal_pelajaran')->insert($jadwals);
            endforeach;
        // endforeach;
        endforeach;
        $etapels = Etapel::where('aktiv', 'Y')->first();
        if ($etapels) {
            JadwalPelajaran::where('tapel_id', $etapels->id)->update(
                [
                    'nama_jadwal' => 'Jadwal Pelajaran'
                ]
            );
        }
        Session::flash('success', 'Data Berhasil dibuat dan silahkan mulai mengisi');
        return Redirect::back();
    }
    public function JadwalDuplikat()
    {
        //dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first(); // Ambil data tapel yang aktif
        if ($etapels) {
            // Menghapus data JadwalPelajaran dengan tapel_id aktif yang ada
            JadwalPelajaran::where('tapel_id', $etapels->id)->delete();
        }

        // 1. Mendapatkan tapel_id terbesar
        $CekTapel = JadwalPelajaran::max('tapel_id');

        // 2. Menentukan tapel_id baru yang akan digunakan untuk duplikasi (misalnya +1)
        $newTapelId = $CekTapel + 1;

        // 3. Menduplikasi data dengan tapel_id terbesar
        $jadwalPelajaranData = JadwalPelajaran::where('tapel_id', $CekTapel)->get();

        // 4. Periksa jika tapel_id saat ini berbeda dari tapel_id aktif yang sedang digunakan
        if ($CekTapel !== $etapels->id) {
            // 5. Menyalin data untuk setiap entri yang ada
            foreach ($jadwalPelajaranData as $data) {
                // Cek apakah data valid, jika valid, salin ke tapel_id baru
                JadwalPelajaran::create([
                    'nama_jadwal'   => $data->nama_jadwal, // Menyalin nama jadwal
                    'jam'            => $data->jam, // Menyalin jam
                    'tapel_id'       => $newTapelId, // Menetapkan tapel_id baru
                    'kelas_id'       => $data->kelas_id, // Menyalin kelas_id
                    'tingkat_id'     => $data->tingkat_id, // Menyalin tingkat_id
                    'mapel_id'       => $data->mapel_id ?? null, // Menyalin mapel_id (atau null jika kosong)
                    'hari'           => $data->hari, // Menyalin hari
                    'detailguru_id'  => $data->detailguru_id ?? null, // Menyalin detailguru_id (atau null jika kosong)
                ]);
            }

            Session::flash('success', 'Data Berhasil Di Duplikasi');
        } else {
            // Jika tapel_id sama, berarti tidak perlu duplikasi
            Session::flash('success', 'Tidak ada data yang diduplikasi karena tapel_id sudah sama.');
        }

        return Redirect::back();
    }
}

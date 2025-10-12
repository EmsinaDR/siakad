<?php

namespace App\Http\Controllers\WakaKesiswaan\PPDB;

use Carbon\Carbon;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKesiswaan\PPDB\PPDBPeserta;

class PPDBPesertaController extends Controller
{

    /*
    PPDBPeserta
    $ppdbpeserta
    role.waka.kesiswaan.ppdb
    role.waka.kesiswaan.ppdbppdb-peserta
    role.waka.kesiswaan.ppdbblade_show
    php artisan make:view role.waka.kesiswaan.ppdb.ppdb-peserta
    php artisan make:view role.waka.kesiswaan.ppdb.blade_show
    php artisan make:seed PPDBPesertaSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Panitian PPDB';
        $arr_ths = [
            'No Pendaftaran',
            'Status',
            'Nama Peserta',
            'Umur',
            'Asal Sekolah',
        ];
        $breadcrumb = 'Panitian PPDB / Peserta';
        $titleviewModal = 'Lihat Data Panitian PPDB';
        $titleeditModal = 'Edit Data Panitian PPDB';
        $titlecreateModal = 'Create Data Panitian PPDB';
        $etapels = Etapel::where('aktiv', 'Y')->first();

        $datas = PPDBPeserta::orderBy('created_at', 'DESC')->where('tapel_id', $etapels->id)->get();
        $umurCounts = $datas->map(function ($item) {
            $umur = Carbon::parse($item->tanggal_lahir)->age;
            return $umur;
        })->countBy();
        $kelompok_sekolah = PPDBPeserta::where('tapel_id', $etapels->id)->select(
            'namasek_asal',
            DB::raw('COUNT(*) as total'),
            DB::raw("SUM(CASE WHEN jenis_kelamin = '1' THEN 1 ELSE 0 END) as laki_laki"),
            DB::raw("SUM(CASE WHEN jenis_kelamin = '2' THEN 1 ELSE 0 END) as perempuan")
        )
            ->groupBy('namasek_asal')
            ->orderBy('total', 'DESC')
            ->get();

        // dd($kelompok_sekolah);

        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kesiswaan.ppdb.ppdb-peserta', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'kelompok_sekolah',
            'umurCounts',
        ));
        //php artisan make:view role.waka.kesiswaan.ppdb.ppdb-peserta

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Panitian PPDB';
        $arr_ths = [
            'No Pendaftaran',
            'Nama Peserta',
            'Asal Sekolah',
            'title_tabelad',
        ];
        $breadcrumb = 'Panitian PPDB / Peserta';
        $titleviewModal = 'Lihat Data Panitian PPDB';
        $titleeditModal = 'Edit Data Panitian PPDB';
        $titlecreateModal = 'Create Data Panitian PPDB';
        $datas = PPDBPeserta::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kesiswaan.ppdb.blade_show', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.kesiswaan.ppdb.blade_show
    }

    public function storex(Request $request)
    {
        //
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $kelas = Ekelas::where('kelas', $request->kelas)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester,
            'kelas_id' => $kelas->id,
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
        // Menyimpan data menggunakan mass assignment
        // Create : Buat
        // Update : Memperbaharui
        // Menyimpan data menggunakan mass assignment
        PPDBPeserta::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function store(Request $request)
    {
        //
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $kelas = Ekelas::where('kelas', $request->kelas)->where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->first();
        $DataPPDB = PPDBPeserta::where('tapel_id', $etapels->id);
        // dd(count($DataPPDB));
        $jumlahPeserta = $DataPPDB->count();
        $nomor_peserta = 'PPDB - ' . date('Y') . $jumlahPeserta;
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester,
            'nomor_peserta' => $nomor_peserta,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            // 'status_penerimaan' => 'nullable|string|max:50',
            'nomor_peserta' => 'nullable|string|max:100',
            'detailguru_id' => 'nullable|integer|exists:detailgurus,id',
            'jalur' => 'required|string|max:100',
            'rekomendasi' => 'nullable|string|max:100',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',

            'nama_calon' => 'required|string|max:255',
            'nisn' => 'required|numeric|digits_between:8,20',
            'nik' => 'required|numeric|digits_between:8,20',
            'nokk' => 'required|numeric|digits_between:8,20',
            'hobi' => 'nullable|string|max:100',
            'cita_cita' => 'nullable|string|max:100',
            'agama' => 'nullable|string|max:50',
            'nohp_calon' => 'nullable|regex:/^[0-9\+]{10,15}$/',
            'jml_saudara' => 'nullable|integer|min:0',
            'jenis_kelamin' => 'required|in:L,P',
            'anak_ke' => 'nullable|integer|min:1',
            'status_anak' => 'nullable|string|max:100',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat_calon' => 'required|string|max:255',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'desa' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'jalan' => 'nullable|string|max:255',

            'namasek_asal' => 'required|string|max:255',
            'alamatsek_asal' => 'nullable|string|max:255',

            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'penghasilan_ayah' => 'nullable|numeric',
            'nohp_ayah' => 'nullable|regex:/^[0-9\+]{10,15}$/',
            'alamat_ayah' => 'nullable|string|max:255',

            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'penghasilan_ibu' => 'nullable|numeric',
            'nohp_ibu' => 'nullable|regex:/^[0-9\+]{10,15}$/',
            'alamat_ibu' => 'nullable|string|max:255',

            // Dokumen (opsional, file upload atau string path)
            'kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'akta_kelahiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ktp_ayah' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ktp_ibu' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ijazah' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'surat_keterangan_lulus' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',

            'kartu_kia' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kartu_nisn' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kartu_bantuan_1' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kartu_bantuan_2' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kartu_bantuan_3' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kartu_bantuan_4' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kartu_bantuan_5' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = $validator->validated();

        // Daftar nama field yang berupa file
        $fileFields = [
            'foto',
            'kk',
            'akta_kelahiran',
            'ktp_ayah',
            'ktp_ibu',
            'ijazah',
            'surat_keterangan_lulus',
            'kartu_kia',
            'kartu_nisn',
            'kartu_bantuan_1',
            'kartu_bantuan_2',
            'kartu_bantuan_3',
            'kartu_bantuan_4',
            'kartu_bantuan_5',
        ];

        // Loop dan simpan file ke storage, lalu simpan path-nya ke array data
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $ext = $request->file($field)->getClientOriginalExtension();
                $filename = $request->nomor_peserta . '_' . $field . '.' . $ext;
                $data[$field] = $request->file($field)->storeAs("ppdb/$field", $filename, 'public');
            }
        }
        PPDBPeserta::create($data);
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, PPDBPeserta $ppdbpeserta)
    {
        //

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
        // Menyimpan data menggunakan mass assignment
        // Create : Buat
        // Update : Memperbaharui
        // Menyimpan data menggunakan mass assignment
        $varmodel = PPDBPeserta::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //PPDBPeserta
        // dd(id);
        // dd(request->all());
        $data = PPDBPeserta::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
    public function FormulirPpdb()
    {
        $title = 'Formulir PPDB';


        return view('role.program.ppdb.formulir-ppdb', compact(
            'title',
        ));
    }
    public function FormulirPPDBnew()
    {
        $title = 'Formulir PPDB';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $DataPPDB = PPDBPeserta::where('tapel_id', $etapels->id)->orderBy('nama_calon', 'ASC')->get();
        dd($DataPPDB->toArray());
        $jumlahPeserta = $DataPPDB->count();
        return view('role.program.ppdb.formulir-ppdb-new', compact('title', 'jumlahPeserta'));
    }
}

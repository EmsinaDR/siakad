<?php

namespace App\Http\Controllers\Bendahara;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Bendahara\BendaharaBos;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Bendahara\KasUmum\BendaharaKasUmum;
use App\Models\Bendahara\BOS\BukuKasBOS;
use App\Models\Bendahara\BOS\PengeluaranBOS;

class BendaharaBosController extends Controller
{
    public function index(BendaharaBos $BendaharaBos)
    {
        $title = 'Pemasukkan Bendahara BOS';
        $arr_ths = [
            'Nama Siswa',
            'No Pembayaran',
            'Kelas',
            'Itim',
            'Nominal',
            'Waktu',
        ];
        // //$etapels = Etapel::where('aktiv', 'Y')->first();
        // $datas = BendaharaBos::get(); //Relasi di sisipi dengan where
        $breadcrumb = 'Bendahara / Pemasukkan Bendahara BOS';
        $titleviewModal = 'Lihat Data';
        $titleeditModal = 'Edit Data';
        $titlecreateModal = 'Buat Data';

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = BendaharaBos::selectRaw('tapel_id, SUM(nominal) as total_pemasukan')
            ->groupBy('tapel_id')
            ->get();
        $datas = BendaharaBos::orderBy('created_at', 'DESC')->get();

        $DataBosPengeluaran = \App\Models\Bendahara\BOS\PengeluaranBOS::orderBy('created_at', 'DESC')->get();
        // Ambil data sumber_dana dari DB
        $dbSumberDanas = BendaharaBos::select('sumber_dana')->pluck('sumber_dana')->toArray();

        // Default sumber dana (cadangan kalau kosong atau tambahan kalau belum ada)
        $defaultSumberDanas = [
            'BOS Daerah',
            'BOS Provinsi',
            'BOS Afirmasi',
            'BOS Reguler',
            'BOS Kinerja',
            'BOS APBD'
        ];

        // Gabungkan dan pastikan unik (tidak dobel)
        $sumber_danas = array_unique(array_merge($dbSumberDanas, $defaultSumberDanas));


        // dd($sumber_dana);
        return view('role.bendahara.bos.index', compact(
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'datas',
            'sumber_danas',
        ));
    }


    public function store(Request $request)
    {
        //Proses Modal Create
        // dd($request->all());

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'petugas_id' => Auth::user()->detailguru_id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'petugas_id' => 'required|numeric',
            'tapel_id' => 'required|numeric|min:1|max:100',
            'nominal' => 'required|numeric',
            'sumber_dana' => 'required|string|min:3|max:255',
            'keterangan' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        BendaharaBos::create($validator->validated());
        // Pemasukkan
        $MaxId = BendaharaBos::max('id');
        BendaharaKasUmum::create([
            'tapel_id' => $request->tapel_id,
            'tanggal' => now()->toDateString(),
            'uraian' => 'Pemasukkan Dana ' . $request->sumber_dana . ' sejumlah : ' . $request->nominal . ' dikelola oleh : ' . Auth::user()->name,
            'sumber_dana' => $request->sumber_dana,
            'penerimaan' => $request->nominal,
            'pemasukkan_bos_id' => $MaxId,
        ]);
        BukuKasBOS::create([
            'tapel_id' => $request->tapel_id,
            'tanggal' => now()->toDateString(),
            'uraian' => 'Pemasukkan Dana ' . $request->sumber_dana . ' sejumlah : ' . $request->nominal . ' dikelola oleh : ' . Auth::user()->name,
            'sumber_dana' => $request->sumber_dana,
            'pemasukkan' => $request->nominal,
            'pemasukkan_id' => $MaxId,
            'keterangan' => 'Pemasukkan Dana ' . $request->sumber_dana . ' sejumlah : ' . $request->nominal . ' dikelola oleh : ' . Auth::user()->name . ' untuk penggunaan kebutuhan sekolah',
        ]);


        return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data disimpan dalam database');
    }
    public function update($id, Request $request)
    {
        //Proses Modal Update
        //Form Modal Update ada di index dengan Modal
        //dd($request->all());
        /*
              Validasi untuk di form
              Class : ModelClass
              Lanjutkan isi validasi
              @if ($errors->any())
                  <div class='alert alert-danger my-2'>
                      <ul class='mb-0'>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                      </ul>
                  </div>
              @endif
              */

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            // 'petugas_id' => 'required|numeric',
            // 'tapel_id' => 'required|numeric|min:1|max:100',
            'pemasukan' => 'required|numeric',
            'pengeluaran' => 'required|numeric',
            'nominal' => 'required|numeric',
            'bidang' => 'required|string|max:255',
            'kategori' => 'required|string|min:3|max:255',
            'keterangan' => 'required|string|max:255',
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
        $varmodel = BendaharaBos::find($id); // Pastikan $id didefinisikan atau diterima dari request
        if ($varmodel) {
            $varmodel->update($validator->validated());
            return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil di Update');
        } else {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Data tidak ditemukan');
        }
        return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  berhasil diperbaharui');
    }


    public function destroy($id, Request $request)
    {
        try {
            // Ambil data pemasukkan (BendaharaBos)
            $pemasukkan = BendaharaBos::find($id);

            if (!$pemasukkan) {
                return redirect()->back()
                    ->with('Title', 'Gagal !!!')
                    ->with('error', 'Data pemasukkan tidak ditemukan.');
            }

            // Simpan sumber_dana dari pemasukkan sebelum menghapusnya
            $sumberDana = $pemasukkan->sumber_dana;

            // Hapus dari KomitePengeluaran
            $pemasukkan->delete();

            // Hapus dari BendaharaKasUmum menggunakan sumber_dana yang sudah disimpan
            $kasUmum = BendaharaKasUmum::where('pemasukkan_bos_id', $id)
                ->where('sumber_dana', $sumberDana)
                ->first();

            if ($kasUmum) {
                $kasUmum->delete();
            }

            return redirect()->back()
                ->with('Title', 'Berhasil !!!')
                ->with('success', 'Data berhasil dihapus dari database');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('Title', 'Gagal !!!')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}

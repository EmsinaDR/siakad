<?php

namespace App\Http\Controllers\Bendahara\BOS;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\Bendahara\BendaharaBos;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Bendahara\RencanaAnggaran;
use Illuminate\Support\Facades\Validator;
use App\Models\Bendahara\KasUmum\BendaharaKasUmum;
use App\Models\Bendahara\BOS\BukuKasBOS;
use App\Models\Bendahara\RencanaAnggaranList;
use App\Models\Bendahara\BOS\TransaksaksiPengeluaranBOS;

class TransaksaksiPengeluaranBOSController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Bendahara BOS';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara BOS';
        $titleviewModal = 'Lihat Bendahara BOS';
        $titleeditModal = 'Edit Bendahara BOS';
        $titlecreateModal = 'Buat Bendahara BOS';
        $arr_ths = [
            'Jenis Pembayaran',
            'Nominal',
            'Rencana Anggaran',
            'Persentase',
            'Penerima',
        ];

        // Mendapatkan data dari tabel Etapel yang sedang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();

        // Mengambil data dari model terkait dengan tapel_id
        $datas = \App\Models\Bendahara\BOS\TransaksaksiPengeluaranBOS::orderBy('created_at', 'DESC')->where('tapel_id', $etapels->id)->get();
        $pengerluarans = RencanaAnggaran::where('tapel_id', $etapels->id)->where('semester', $etapels->semester)->get();
        // dump($datas);
        $sumber_danas = BendaharaBos::select('sumber_dana', DB::raw('SUM(nominal) as total'))
            ->groupBy('sumber_dana')
            ->get();


        // Mengarahkan ke view sesuai dengan folder dan nama yang sudah disusun
        return view('role.bendahara.bos.transaksaksipengeluaranbos.transaksaksi-pengeluaran-bos', compact(
            'title',
            'title',
            'arr_ths',
            'datas',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'pengerluarans',
            'sumber_danas',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data Bendahara BOS';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara BOS';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.bendahara.bos.transaksaksipengeluaranbos.transaksaksi-pengeluaran-bos-create', compact(
            'title',
            'breadcrumb',
        ));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Mendapatkan data Etapel yang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'petugas_id' => Auth::user()->id,
        ]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'jenis_pengeluaran_id' => 'required|integer',
            'tapel_id' => 'required|integer',
            'petugas_id' => 'required|integer',
            'sumber_dana' => 'required|string',
            'penerima_id' => 'required|integer',
            'nominal' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        \App\Models\Bendahara\BOS\TransaksaksiPengeluaranBOS::create($validator->validated());
        $Idmax = TransaksaksiPengeluaranBOS::max('id');
        $RencanaAnggaran = RencanaAnggaran::find($request->jenis_pengeluaran_id);
        $RencanaAnggaranList = RencanaAnggaranList::find($RencanaAnggaran->rencana_anggaran_id);
        $Penerima = Detailguru::find($request->penerima_id);
        // Buku kas Umum
        BendaharaKasUmum::create([
            'tapel_id' => $request->tapel_id,
            'tanggal' => now()->toDateString(),
            'uraian' => 'Pengeluaran: ' . $RencanaAnggaranList->jenis_pengeluaran . ' yang dikelola oleh ' . $Penerima->nama_guru . ' sebagai penanggung.',
            'sumber_dana' =>  $request->sumber_dana,
            'program' => $request->jenis_pengeluaran_id === 'non_anggaran'
                ? 'Tak Terencana'
                : 'Terencana',
            'penerimaan' => 0,
            'pengeluaran_bos_id' => $Idmax,
            'pengeluaran' => $request->nominal,
            'keterangan' => 'Via Bendahara: ' . (Auth::user()->name ?? '-') . ' Diserahkan kepada: ' . ($Penerima->nama_guru ?? '-'),
        ]);
        BukuKasBOS::create([
            'tapel_id' => $request->tapel_id,
            'tanggal' => now()->toDateString(),
            'uraian' => 'Pengeluaran: ' . $RencanaAnggaranList->jenis_pengeluaran . ' yang dikelola oleh ' . $Penerima->nama_guru . ' sebagai penanggung.',
            'petugas_id' => Auth::user()->id,
            'jenis_pengeluaran_id' => $request->jenis_pengeluaran_id,
            'sumber_dana' =>  $request->sumber_dana,
            'program' => $request->jenis_pengeluaran_id === 'non_anggaran'
                ? 'Tak Terencana'
                : 'Terencana',
            'penerimaan' => 0,
            'pengeluaran_id' => $Idmax,
            'pengeluaran' => $request->nominal,
            'keterangan' => 'Via Bendahara: ' . (Auth::user()->name ?? '-') . ' Diserahkan kepada: ' . ($Penerima->nama_guru ?? '-'),
        ]);


        // dd($request->all());
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail Bendahara BOS';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara BOS';
        $data = \App\Models\Bendahara\BOS\TransaksaksiPengeluaranBOS::findOrFail($id);

        return view('role.bendahara.bos.transaksaksipengeluaranbos.transaksaksi-pengeluaran-bos-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit Bendahara BOS';
        $breadcrumb = 'xxxxxxxxxxxx / Bendahara BOS / Edit';
        $data = \App\Models\Bendahara\BOS\TransaksaksiPengeluaranBOS::findOrFail($id);

        return view('role.bendahara.bos.transaksaksipengeluaranbos.transaksaksi-pengeluaran-bos-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        // Menemukan data yang akan diupdate berdasarkan ID
        $data = \App\Models\Bendahara\BOS\TransaksaksiPengeluaranBOS::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
            'nominal' => 'required|integer',
            'penerima_id' => 'required|integer',
            'keterangan' => 'required|string',
        ]);
        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data yang ditemukan berdasarkan hasil validasi
        $data->update($validator->validated());
        $RencanaAnggaran = RencanaAnggaran::find($request->jenis_pengeluaran_id);
        $Penerima = Detailguru::find($request->penerima_id);
        // Buku kas Umum
        BendaharaKasUmum::where('pengeluaran_bos_id', $id)->update([
            'pengeluaran' => $request->nominal,
            'keterangan' => 'Via Bendahara: ' . (Auth::user()->name ?? '-') . ' Diserahkan kepada: ' . ($Penerima->nama_guru ?? '-'),
        ]);
        BukuKasBOS::where('pengeluaran_id', $id)->update([
            'pengeluaran' => $request->nominal,
            'keterangan' => 'Via Bendahara: ' . (Auth::user()->name ?? '-') . ' Diserahkan kepada: ' . ($Penerima->nama_guru ?? '-'),
        ]);

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        // return Redirect::back();
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = \App\Models\Bendahara\BOS\TransaksaksiPengeluaranBOS::findOrFail($id);

        // Menghapus data
        $data->delete();

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}

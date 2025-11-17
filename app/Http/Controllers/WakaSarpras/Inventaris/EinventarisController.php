<?php

namespace App\Http\Controllers\WakaSarpras\Inventaris;


use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaSarpras\Inventaris\Einventaris;

class EinventarisController extends Controller
{
    public function index(Einventaris $einventaris)
    {
        $title = 'Data Inventaris';
        $arr_ths = [
            'Kode Barang',
            'Nama Barang',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = Einventaris::with('EinventaristoTapel')->where('id', 'tapel_id')->get(); //Relasi di sisipi dengan where
        $breadcrumb = 'Waka Sarprass / Data Inventaris';
        $titleviewModal = 'Lihat Data Inventaris';
        $titleeditModal = 'Edit Data Inventaris';
        $titlecreateModal = 'Buat Data Inventaris';
        // $datas = Einventaris::with('Kategori')->get();
        $datas = Einventaris::orderBy('created_at', 'DESC')->get();
        return view('role.waka.sarpras.inventaris.inventaris-sarpras', compact(
            'datas',
            'title',
            'arr_ths',
            'datas',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
    }

    public function show(Einventaris $einventaris)
    {
        $title = 'Data Inventaris';
        $arr_ths = [
            'Kode Barang',
            'Jumlah'
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = Einventaris::with('EinventaristoTapel')->where('id', 'tapel_id')->get(); //Relasi di sisipi dengan where
        $breadcrumb = 'Data / Data Inventari';
        $titleviewModal = 'Lihat Data Inventari';
        $titleeditModal = 'Edit Data Inventari';
        $titlecreateModal = 'Buat Data Inventari';
        return view('role.waka.sarpras.inventaris.waka-inventaris-single', compact('title', 'arr_ths', 'datas', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
    }


    public function store(Request $request)
    {
        //Proses Modal Create
        //Form Modal Create ada di index dengan Modal
        // Ambil semua kode yang sudah ada di database
        $existingCodes = DB::table('inventaris')->pluck('kode')->toArray();

        // Ambil huruf kapital dari nama_barang
        preg_match_all('/[A-Z]/', $request->nama_barang, $matches);
        $kode = implode('', $matches[0]);

        // Jika tidak ada huruf kapital, ambil 3 huruf pertama dari nama_barang
        if (strlen($kode) < 3) {
            $kode .= strtoupper(substr($request->nama_barang, 0, 3 - strlen($kode)));
        }

        // Jika masih kurang dari 3 huruf, tambahkan huruf random
        while (strlen($kode) < 3) {
            $kode .= chr(rand(65, 90)); // ASCII A-Z
        }

        // Cek apakah kode sudah ada di database
        $kodeAsli = $kode;
        $counter = 1;

        while (in_array($kode, $existingCodes)) {
            // Tambahkan angka unik di belakang untuk menghindari duplikasi
            $kode = substr($kodeAsli, 0, 2) . chr(rand(65, 90));

            $counter++;
            if ($counter > 10) { // Hindari loop tak terbatas
                return redirect()->back()
                    ->withErrors(['kode' => 'Gagal menghasilkan kode unik, coba lagi.'])
                    ->withInput();
            }
        }

        // Tambahkan kode baru ke array untuk menghindari duplikasi dalam iterasi berikutnya
        $existingCodes[] = $kode;

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Simpan data ke dalam database
        DB::table('inventaris')->insert([
            'kode' => $kode,
            'nama_barang' => $request->nama_barang,
            'keterangan' => $request->keterangan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Session::flash('success', 'Data Berhasil Ditambahkan');
        return Redirect::back();
    }
    public function update(Request $request, $id)
    {
        // Cek apakah data dengan ID tersebut ada
        $inventaris = DB::table('inventaris')->where('id', $id)->first();

        if (!$inventaris) {
            return redirect()->back()->withErrors(['error' => 'Data tidak ditemukan.']);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Ambil kode dari database jika sudah ada
        $kode = $inventaris->kode;

        // Jika nama barang berubah, update kode berdasarkan nama_barang
        if ($request->nama_barang !== $inventaris->nama_barang) {
            $existingCodes = DB::table('inventaris')->pluck('kode')->toArray();

            // Ambil huruf kapital dari nama_barang
            preg_match_all('/[A-Z]/', $request->nama_barang, $matches);
            $kode = implode('', $matches[0]);

            // Jika tidak ada huruf kapital, ambil 3 huruf pertama dari nama_barang
            if (strlen($kode) < 3) {
                $kode .= strtoupper(substr($request->nama_barang, 0, 3 - strlen($kode)));
            }

            // Jika masih kurang dari 3 huruf, tambahkan huruf random
            while (strlen($kode) < 3) {
                $kode .= chr(rand(65, 90)); // ASCII A-Z
            }

            // Pastikan kode unik
            $kodeAsli = $kode;
            $counter = 1;

            while (in_array($kode, $existingCodes)) {
                $kode = substr($kodeAsli, 0, 2) . chr(rand(65, 90));
                $counter++;
                if ($counter > 10) { // Hindari loop tak terbatas
                    return redirect()->back()->withErrors(['kode' => 'Gagal menghasilkan kode unik, coba lagi.']);
                }
            }
        }

        // Update data di database
        DB::table('inventaris')->where('id', $id)->update([
            'kode' => $kode,
            'nama_barang' => $request->nama_barang,
            'keterangan' => $request->keterangan,
            'updated_at' => now(),
        ]);

        Session::flash('success', 'Data Berhasil Diperbarui');
        return Redirect::back();
    }


    public function destroy($id)
    {
        //Proses Modal Delete
        //Form Modal Delete ada di index
        //Detailguru
        // dd(id);
        // dd(request->all());
        $data = Einventaris::findOrFail($id);
        $data->delete();

        Session::flash('success', 'Data Berhasil Dihapus');
        return Redirect::back();
    }
}

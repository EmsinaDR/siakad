<?php

namespace App\Http\Controllers\WakaSarpras\Inventaris;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaSarpras\Inventaris\KIBD;
use App\Models\WakaSarpras\Inventaris\InventarisVendor;

class KIBDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    KIBD
    $kibd
    role.waka.sarpras.inventaris
    role.waka.sarpras.inventaris.kibd
    role.waka.sarpras.inventaris.blade_show
    Index = Data KIB D
    Breadcume Index = 'Waka Sarpras / Data KIB D';
    Single = Data KIB D
    php artisan make:view role.waka.sarpras.inventaris.kibd
    php artisan make:view role.waka.sarpras.inventaris.kibd-single
    php artisan make:seed KIBDSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Data KIB D';
        $arr_ths = [
            'Nama Barang',
            'Lokasi',
            'Volum',
            'Tanggal Awal',
            'Tanggal Akhir',
            'Status',
            'Anggaran',
        ];
        $breadcrumb = 'Waka Sarpras / Data KIB D';
        $titleviewModal = 'Lihat Data KIB D';
        $titleeditModal = 'Edit Data KIB D';
        $titlecreateModal = 'Create Data KIB D';
        $datas = KIBD::orderBy('created_at', 'DESC')->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.sarpras.inventaris.kibd', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.waka.sarpras.inventaris.kibd

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Data KIB D';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Sarpras / Data KIB D';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = KIBD::get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.sarpras.inventaris.kibd-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.sarpras.inventaris.kibd-single
    }

    public function store(Request $request)
    {
        // Jika "Lainnya" dipilih, vendor_id harus null agar tidak error
        // $request['barang_id'] = 150;
        // $request['nomor_hp'] = 150;
        $requestData = $request->all();
        if ($request->vendor_id === "lainnya") {
            $requestData['vendor_id'] = null;
        }
        // dd($request->all());
        // Validasi Data
        $validator = Validator::make($requestData, [
            // 'barang_id' => 'nullable|integer',
            'nama_proyek' => 'required|string|max:255',
            'keterangan_proyek' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'volum_pekerjaan' => 'required|integer',
            'status' => 'required|numeric',
            'estimasi_anggaran' => 'required|numeric',
            'lokasi' => 'nullable|string',
            'vendor_id' => 'nullable|integer',  // Pastikan hanya angka atau null
            'nomor_hp' => 'nullable | string ',
            'vendor_baru' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        // Jika vendor baru diisi, buat vendor baru & gunakan ID-nya
        if (!empty($request->vendor_baru)) {
            $vendor = InventarisVendor::create([
                'nama_vendor' => $request->vendor_baru,
                'nomor_hp' => $request->nomor_hp,
                'nomor_hp' => $request->nomor_hp,
                'nama_kontak' => $request->nama_kontak,
                'alamat' => $request->alamat,
                'keterangan' => $request->keterangan,
            ]);
            $data['vendor_id'] = $vendor->id; // Pakai ID vendor baru
        }

        // Pastikan vendor_id tetap integer atau null
        $data['vendor_id'] = $data['vendor_id'] ? (int) $data['vendor_id'] : null;

        // Simpan ke database
        KIBD::create($data);

        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, KIBD $kibd)
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
        $varmodel = KIBD::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //KIBD
        // dd(id);
        // dd(request->all());
        $data = KIBD::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
        return redirect()->back()->with('Title', 'Berhasil !!!')->with('success', 'Data  datahapus Berhasil dihapus dari databse');
    }
}

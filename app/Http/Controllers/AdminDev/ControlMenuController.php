<?php

namespace App\Http\Controllers\AdminDev;

use Exception;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminDev\ControlMenu;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Program\SetingPengguna;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class ControlMenuController extends Controller
{
    public function index()
    {
        // Mendapatkan judul halaman sesuai dengan nama kelas
        $title = 'Data Seting Pengguna';
        $arr_ths = [
            'Nama Program',
            'Kontrol',
            'User',
            'Nama Guru',
        ];
        $breadcrumb = 'Seting Pengguna Program / Data Seting Pengguna';
        $titleviewModal = 'Lihat Data Seting Pengguna';
        $titleeditModal = 'Edit Data Seting Pengguna';
        $titlecreateModal = 'Create Data Seting Pengguna';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        // $datas = SetingPengguna::where('tapel_id', $etapels->id)->groupBy('nama_program')->get();
        if (Auth::user()->posisi === 'Admindev') {
            $datas = SetingPengguna::orderBy('nama_program')->get();
        } else {

            $datas = SetingPengguna::where('tapel_id', $etapels->id)->where('pemegang_id', Auth::user()->detailguru_id)->orderBy('nama_program')->get();
        }
        // dump(Auth::user()->posisi);
        // dd($datas);
        // Order dan Prioritas
        // Memisahkan 'kepala sekolah' dan 'waka' di atas
        $priority = ['Kepala Sekolah', 'Waka Kurikulum', 'Waka Kesiswaan', 'Waka Sarpras', 'Waka Humas'];

        $priorityItems = $datas->filter(function ($item) use ($priority) {
            return in_array($item->nama_program, $priority);
        });

        $otherItems = $datas->filter(function ($item) use ($priority) {
            return !in_array($item->nama_program, $priority);
        });
        HapusCacheDenganTag('Programs');
        // Gabungkan kembali, dengan priority items di atas
        $datas = $priorityItems->merge($otherItems);

        $dataGuru = Detailguru::orderBy('nama_guru', 'ASC')->get();

        return view('role.admindev.controlmenu.control-menu', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'dataGuru',
        ));
    }

    public function create()
    {
        // Judul halaman
        $title = 'Tambah Data AdminDev';
        $breadcrumb = 'xxxxxxxxxxxx / AdminDev';

        // Breadcrumb (jika diperlukan)
        $breadcrumb = 'Tambah';

        return view('role.admindev.controlmenu.control-menu-create', compact(
            'title',
            'breadcrumb',
        ));
    }

    public function store(Request $request)
    {
        // Mendapatkan data Etapel yang aktif
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge(['tapel_id' => $etapels->id]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            // Tambahkan validasi sesuai kebutuhan
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Membuat entri baru berdasarkan validasi
        \App\Models\AdminDev\ControlMenu::create($validator->validated());

        // Menyimpan pesan sukses di session
        Cache::forget('seting_program');
        HapusCacheDenganTag('cache_seting_program');
        Session::flash('success', 'Data berhasil disimpan');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }

    public function show($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Lihat Detail AdminDev';
        $breadcrumb = 'xxxxxxxxxxxx / AdminDev';
        $data = \App\Models\AdminDev\ControlMenu::findOrFail($id);

        return view('role.admindev.controlmenu.control-menu-single', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }
    public function edit($id)
    {
        // Menemukan data berdasarkan ID
        $title = 'Edit AdminDev';
        $breadcrumb = 'xxxxxxxxxxxx / AdminDev / Edit';
        $data = \App\Models\AdminDev\ControlMenu::findOrFail($id);


        return view('role.admindev.controlmenu.control-menu-edit', compact(
            'title',
            'breadcrumb',
            'data',
        ));
    }

    public function update(Request $request, $id)
    {
        try {
            // Menemukan data yang akan diupdate berdasarkan ID
            // dd($request->all());
            // Validasi input
            $validator = Validator::make($request->all(), [
                // Tambahkan validasi sesuai kebutuhan
                'aktivasi' => 'required | array',
                'pilihan' => 'integer'
            ]);

            // Jika validasi gagal, kembalikan dengan pesan error
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = \App\Models\AdminDev\ControlMenu::WhereIn('id', $request->aktivasi)->update(
                [
                    'aktivasi' => $request->pilihan
                ]
            );
            // Update data yang ditemukan berdasarkan hasil validasi
            // $data->update($validator->validated());
            Cache::forget('seting_program');
            HapusCacheDenganTag('cache_seting_program');

            HapusCacheDenganTag('Programs');
            // Menyimpan pesan sukses di session
            Session::flash('success', 'Data berhasil diperbarui');

            // Mengarahkan kembali ke halaman sebelumnya
            // dd($request->all());
            return Redirect::back();
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }

    public function updateUser(Request $request, $id)
    {
        // dd($request->all(), $id);
        // try {
        // Menemukan data yang akan diupdate berdasarkan ID
        // dd($request->all());
        // Validasi input
        $detailguru_id = $request->input('detailguru_id', []);


        if (!is_array($detailguru_id)) {
            // pastikan dalam bentuk array sebelum encode
            $detailguru_id = (array) ($request->detailguru_id ?? []);
        }

        // dd($detailguru_id);

        $data = \App\Models\AdminDev\ControlMenu::find($id);
        $data->update(
            [
                'detailguru_id' => json_encode($detailguru_id)
            ]
        );
        // Update data yang ditemukan berdasarkan hasil validasi
        // $data->update($validator->validated());
        Cache::forget('seting_program');
        HapusCacheDenganTag('cache_seting_program');
        HapusCacheDenganTag('Programs');
        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil diperbarui');

        // Mengarahkan kembali ke halaman sebelumnya
        // dd($request->all());
        // dd($request->all());
        return Redirect::back();
        // } catch (Exception $e) {
        //     return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        // }
    }

    public function destroy($id)
    {
        // Menemukan data yang akan dihapus berdasarkan ID
        $data = \App\Models\AdminDev\ControlMenu::findOrFail($id);


        // Menghapus data
        $data->delete();
        Cache::forget('seting_program');
        HapusCacheDenganTag('cache_seting_program');
        HapusCacheDenganTag('Programs');

        // Menyimpan pesan sukses di session
        Session::flash('success', 'Data berhasil dihapus');

        // Mengarahkan kembali ke halaman sebelumnya
        return Redirect::back();
    }
}

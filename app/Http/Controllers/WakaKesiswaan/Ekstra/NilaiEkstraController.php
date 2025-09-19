<?php

namespace App\Http\Controllers\WakaKesiswaan\Ekstra;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKesiswaan\Ekstra\Ekstra;
use App\Models\WakaKesiswaan\Ekstra\NilaiEkstra;
use App\Models\WakaKesiswaan\Ekstra\RiwayatEkstra;

class NilaiEkstraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*

    php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

php artisan make:view role.pembina.ekstra.nilai-ekstra
php artisan make:view role.pembina.ekstra.nilai-ekstra-single
php artisan make:seeder WakaKesiswaan/Ekstra/NilaiEkstraSeeder
php artisan make:model WakaKesiswaan/Ekstra/NilaiEkstra
php artisan make:controller WakaKesiswaan/Ekstra/NilaiEkstraController --resource

*/

    /*
    NilaiEkstra
    $dnekstra
    role.pembina.ekstra
    role.pembina.ekstra.nilai-ekstra
    role.pembina.ekstra.blade_show
    Index = Nilai Ekstra
    Breadcume Index = 'Pembina Ekstra / Nilai Ekstra';
    Single = Nilai Ekstra
    php artisan make:view role.pembina.ekstra.nilai-ekstra
    php artisan make:view role.pembina.ekstra.nilai-ekstra-single
    php artisan make:seed NilaiEkstraSeeder



    */

    //
    //Title to Controller
    public function index(Ekstra $Ekstra)
    {
        $title = 'Data Nilai Ekstra';
        $arr_ths = [
            'Ekstra',
            'Pembina',
            'Pelatih',
            'Jadwal Latihan',
            'Anggota',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = RiwayatEkstra::where('tapel_id', $etapels->id)->get();
        $breadcrumb = 'Data Admin / Data Nilai Ekstra';
        $titleviewModal = 'Lihat Data Nilai Ekstra';
        $titleeditModal = 'Edit Data Nilai Ekstra';
        $titlecreateModal = 'Buat Data Nilai Ekstra';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        $dataEkstra = RiwayatEkstra::where('tapel_id', $etapels->id)->get();
        return view('role.pembina.ekstra.nilai-ekstra', compact(
            'title',
            'arr_ths',
            'datas',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
    }
    //php artisan make:view role.pembina.ekstra.nilai-ekstra



    public function show()
    {
        //
        //Title to Controller
        $title = 'Nilai Ekstra';
        $arr_ths = [
            'Nama',
            'Nilai',
            'Predikat',
        ];
        $breadcrumb = 'Pembina Ekstra / Nilai Ekstra';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = NilaiEkstra::where('ekstra_id', request()->segment(3))->get();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $dataEkstra = Ekstra::where('id', request()->segment(3))->first();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.pembina.ekstra.nilai-ekstra-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'dataEkstra',
        ));
        //php artisan make:view role.pembina.ekstra.nilai-ekstra-single
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



        NilaiEkstra::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, NilaiEkstra $dnekstra)
    {
        //

        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'nilai' => 'integer',
            'predikat' => 'string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $varmodel = NilaiEkstra::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //NilaiEkstra
        // dd(id);
        // dd(request->all());
        $data = NilaiEkstra::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
    public function UpdateBulkNilai(Request $request)
    {
        // Debugging: Menampilkan semua data yang dikirimkan
        // dd($request->all());

        // Validasi input
        $validated = $request->validate([
            'nilai' => 'required|array',
            'predikat' => 'required|array',
            'id' => 'required|array',
        ]);

        // Mengupdate nilai dan predikat berdasarkan id
        try {
            foreach ($validated['id'] as $index => $id) {
                // Cari data NilaiEkstra berdasarkan id
                $nilaiEkstra = NilaiEkstra::find($id);

                if ($nilaiEkstra) {
                    // Update nilai dan predikat
                    $nilaiEkstra->nilai = $validated['nilai'][$index];
                    $nilaiEkstra->predikat = strtoupper($validated['predikat'][$index]);

                    // Simpan perubahan
                    $nilaiEkstra->save();
                }
            }

            // Respons jika berhasil
            // dd($request->all());
            Session::flash('success','Data Berhasil Disimpan');
            return Redirect::back();

            return response()->json(['message' => 'Data berhasil diperbarui.'], 200);
        } catch (\Exception $e) {
            // Tangani error jika ada
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}

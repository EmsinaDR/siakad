<?php

namespace App\Http\Controllers\WakaKurikulum\Kelulusan;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WakaKurikulum\Elearning\Nilai\KurulumDataPesertaUjian;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\WakaKurikulum\Kelulusan\PesertaKelulusan;

class PesertaKelulusanController extends Controller
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

php artisan make:view role.waka.kurikulum.kelulusan.peserta-kelulusan
php artisan make:view role.waka.kurikulum.kelulusan.peserta-kelulusan-single
php artisan make:model WakaKurikulum/Kelulusan/PesertaKelulusan
php artisan make:controller WakaKurikulum/Kelulusan/PesertaKelulusanController --resource



php artisan make:seeder WakaKurikulum/Kelulusan/PesertaKelulusanSeeder
php artisan make:migration Migration_PesertaKelulusan




*/
    /*
    PesertaKelulusan
    $pesertakelulusan
    role.waka.kurikulum.kelulusan
    role.waka.kurikulum.kelulusan.peserta-kelulusan
    role.waka.kurikulum.kelulusan.blade_show
    Index = Peserta Kelulusan
    Breadcume Index = 'Waka Kurikulum / Kelulusan / Peserta Kelulusan';
    Single = Peserta Kelulusan
    php artisan make:view role.waka.kurikulum.kelulusan.peserta-kelulusan
    php artisan make:view role.waka.kurikulum.kelulusan.peserta-kelulusan-single
    php artisan make:seed PesertaKelulusanSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Peserta Kelulusan';
        $arr_ths = [
            'Nama Siswa',
            'Kelas',
            'Status',
            'Tahun Lulus',
        ];
        $breadcrumb = 'Waka Kurikulum / Kelulusan / Peserta Kelulusan';
        $titleviewModal = 'Lihat Data Peserta Kelulusan';
        $titleeditModal = 'Edit Data Peserta Kelulusan';
        $titlecreateModal = 'Create Data Peserta Kelulusan';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = KurulumDataPesertaUjian::where('tapel_id', $etapels->id)->orderBy('kelas_id', 'ASC')->get();
        // dd($datas);

        return view('role.waka.kurikulum.kelulusan.peserta-kelulusan', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.waka.kurikulum.kelulusan.peserta-kelulusan

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Peserta Kelulusan';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Waka Kurikulum / Kelulusan / Peserta Kelulusan';
        $titleviewModal = 'Lihat Data Peserta Kelulusan';
        $titleeditModal = 'Edit Data Peserta Kelulusan';
        $titlecreateModal = 'Create Data Peserta Kelulusan';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = KurulumDataPesertaUjian::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.waka.kurikulum.kelulusan.peserta-kelulusan-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.waka.kurikulum.kelulusan.peserta-kelulusan-single
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



        KurulumDataPesertaUjian::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function updatePesertaKelulusan(Request $request)
    {
        // Validasi input (pastikan array 'id' wajib diisi)
        // dd($request->all(), $request->id);
        $request->validate([
            'id' => 'required|integer',
            'id.*' => 'exists:enilai_ujian_peserta,id', // Pastikan semua ID valid
            'status_kelulusan' => 'String', // Pastikan semua ID valid
        ]);

        // Update semua data sekaligus
        PesertaKelulusan::where('id', $request->id)->update([
            'status_kelulusan' => $request->status_kelulusan, // Contoh update status kelulusan
            'tahun_lulus' => date('Y')
        ]);

        return redirect()->back()->with('success', 'Data kelulusan berhasil diperbarui dan dinyatakan ' . $request->status_kelulusan . ' tahun ' . date('Y'));
    }
    public function resetPesertaKelulusan(Request $request)
    {

        // Update semua data sekaligus
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //
        PesertaKelulusan::where('tapel_id', $etapels->id)->update([
            'status_kelulusan' => Null, // Contoh update status kelulusan
            'tahun_lulus' => Null,
            'tanggal_pengumuman' => Null
        ]);

        return redirect()->back()->with('success', 'Data kelulusan berhasil direset.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //PesertaKelulusan
        // dd($id);
        // dd($request->all());
        $data = PesertaKelulusan::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
    public function StatusPesertaKelulusan(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'detailsiswa_id' => 'required|array',
            'status_kelulusan' => 'String', // Pastikan semua ID valid
        ]);

        // Update semua data sekaligus
        // Update semua data sekaligus
        PesertaKelulusan::whereIn('detailsiswa_id', $request->detailsiswa_id)->update([
            'status_kelulusan' => strtolower($request->status_kelulusan),
            'tahun_lulus' => date('Y'),
        ]);
        return back()->with('success', 'Status kelulusan berhasil diupdate.');
    }
    public function tanggalKelulusan(Request $request)
    {
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', $etapels->id)->
        PesertaKelulusan::where('tapel_id', $etapels->id)->update([
            'tanggal_pengumuman' => $request->tanggal_pengumuman,
        ]);
        return back()->with('success', 'Status Tanggal kelulusan telah di tetapkan.');
    }
}

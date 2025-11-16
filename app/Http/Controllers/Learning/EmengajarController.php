<?php

namespace App\Http\Controllers\Learning;

use Exception;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use App\Models\Admin\Etapel;
use App\Models\EnilaiTugas;
use Illuminate\Http\Request;
use App\Models\Learning\Emengajar;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Redirect;

class EmengajarController extends Controller
{
    //
    /*
           * Display a listing of the resource.
           Folder Name = admin
           Model = Emengajar
           Variabel Model = emengajar
           */
    public function index()
    {
        //Title to Controller
        $emapels = Emapel::where('aktiv', 'Y')->get();
        $title = 'E Mengajar Guru';
        $arr_ths = [
            'Mata Pelaajran',
            'Kategori',
            'Kelompok',
            'Jumlah Siswa',
            'JTM',
            'Guru',
        ];
        $gurus = Detailguru::orderBy('nama_guru', 'ASC')->get();
        $Ekelass = Ekelas::where('aktiv', 'Y')->get();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $breadcrumb = 'Data / Data Mengajar';
        $titleviewModal = 'Detail Data E Mengajar Guru';
        $titleeditModal = 'Edit Data E Mengajar Guru';
        $titlecreateModal = 'Create Data E Mengajar Guru';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $tingkata = Ekelas::select(['kelas'])->where('aktiv', 'Y')->where('tingkat_id', 7)->where('tapel_id', $etapels->id)->get()->toArray();
        $tingkata = collect($tingkata)->flatten(1);
        $tingkata = $tingkata->values()->all();
        $tingkatb = Ekelas::select(['kelas'])->where('aktiv', 'Y')->where('tingkat_id', 8)->where('tapel_id', $etapels->id)->get()->toArray();
        $tingkatb = collect($tingkatb)->flatten(1);
        $tingkatb = $tingkatb->values()->all();
        $tingkatc = Ekelas::select(['kelas'])->where('aktiv', 'Y')->where('tingkat_id', 9)->where('tapel_id', $etapels->id)->get()->toArray();
        $tingkatc = collect($tingkatc)->flatten(1);
        $tingkatc = $tingkatc->values()->all();
        return view('admin.emengajar', compact(
            'emapels',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'Ekelass',
            'etapels',
            'gurus',
            'tingkata',
            'tingkatb',
            'tingkatc'
        ));
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request, Emengajar $emengajar)
    {
        try {
            //
            $datas = Emengajar::findOrFail($request->id);;
            $title = 'Edit Data Mengajar';
            return view('emengajar.show', compact('datas'));
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }

    public function destroy($id)
    {
        try {
            $emengajar = Emengajar::findOrFail($id);
            $emengajar->delete();

            return redirect()->route('emengajar.index')->with('Titile', 'Sukses.')->with('Success', 'Data berhasil dihapus.');
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }
    public function update($id)
    {
        try {
            $emengajar = Emengajar::findOrFail($id);
            $emengajar = Emengajar::where('id', $id)->update([
                'detailguru_id' => NULL,
                'updated_at' => now(),
            ]);
            // $emengajar->delete();

            return redirect()->route('emengajar.index')->with('Success', 'Data berhasil dihapus.');
        } catch (Exception $e) {
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }
    public function UpdateMengajar(Request $request, Emengajar $emengajar)
    {
        //via ajax
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $emengajar = Emengajar::where('id', $request->detailguru_id)->first();

        $emengajar->id = $request->detailguru_id;
        $emengajar->detailguru_id = $request->id;
        $emengajar->update();
        // //Lanjutkan proses untuk e nilai tugas
        // $e_nilai_tugas = new EnilaiTugas();
        // $e_nilai_tugas->taple_id = $etapels->id;
        // $e_nilai_tugas->semester = $etapels->semester;
        // $e_nilai_tugas->detailguru_id = $request->id;
        // $e_nilai_tugas->kelas_id = $request->kelas_id;
        // $e_nilai_tugas->mapel_id = $request->mapel_id;
        // $e_nilai_tugas->tingkat_id = $request->tingkat_id;
        // $e_nilai_tugas->detailsiswa_id = $request->detailsiswa_id;
        // //Lanjutkan proses untuk e nilai ulangan
        // //Lanjutkan proses untuk e nilai pts dan pas
        return redirect()->route('emengajar.index')->with('Success', 'Data berhasil diperbarui.');



        // $emengajar = Emengajar::findOrFail($request->id);
        // $emengajar->delete();
        // return response()->json(['status' => 'success', 'message' => 'Data updated successfully ' . $emengajar->detailguru_id . ' id update' . $emengajar->id]);
        // return redirect()->route('emengajar.index')->with('Success', 'Data berhasil dihapus.');
    }
}

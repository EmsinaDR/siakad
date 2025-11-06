<?php

namespace App\Http\Controllers\Program\Supervisi;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\Supervisi\SupervisiInstrument;

class SupervisiInstrumentController extends Controller
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

php artisan make:view role.program.supervisi.instrumen-supervisi
php artisan make:view role.program.supervisi.instrumen-supervisi-single
php artisan make:model Program/Supervisi/SupervisiInstrument
php artisan make:controller Program/Supervisi/SupervisiInstrumentController --resource



php artisan make:seeder Program/Supervisi/SupervisiInstrumentSeeder
php artisan make:migration Migration_SupervisiInstrument

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

php artisan make:view role.program.supervisi.supervisi-instrumen
php artisan make:view role.program.supervisi.supervisi-instrumen-single
php artisan make:model Program/Supervisi/SupervisiInstrument
php artisan make:controller Program/Supervisi/SupervisiInstrumentController --resource



php artisan make:seeder Program/Supervisi/SupervisiInstrumentSeeder
php artisan make:migration Migration_SupervisiInstrument




*/
    /*
    SupervisiInstrument
    $supervisiinstrument
    role.program.supervisi
    role.program.supervisi.supervisi-instrument
    role.program.supervisi.blade_show
    Index = Instrument Supervisi
    Breadcume Index = 'Data Supervisi / Instrument Supervisi';
    Single = Instrument Supervisi
    php artisan make:view role.program.supervisi.supervisi-instrument
    php artisan make:view role.program.supervisi.supervisi-instrument-single
    php artisan make:seed SupervisiInstrumentSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Instrument Supervisi';
        $arr_ths = [
            'Bidang',
            'Kategori',
            'Indikator',
        ];
        $breadcrumb = 'Data Supervisi / Instrument Supervisi';
        $titleviewModal = 'Lihat Data Instrument Supervisi';
        $titleeditModal = 'Edit Data Instrument Supervisi';
        $titlecreateModal = 'Create Data Instrument Supervisi';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = SupervisiInstrument::where('tapel_id', $etapels->id)->get();
        $datas = SupervisiInstrument::get();
        // dump($datas->toArray());


        return view('role.program.supervisi.supervisi-instrument', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal'
        ));
        //php artisan make:view role.program.supervisi.supervisi-instrument

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Instrument Supervisi';
        $arr_ths = [
            'Bidang',
            'Kategori',
            'Indikator',
            'title_tabelad',
        ];
        $breadcrumb = 'Data Supervisi / Instrument Supervisi';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $datas = SupervisiInstrument::where('tapel_id', $etapels->id)->get();


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.supervisi.supervisi-instrument-single', compact('datas', 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'));
        //php artisan make:view role.program.supervisi.supervisi-instrument-single
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



        SupervisiInstrument::create($validator->validated());
        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, SupervisiInstrument $supervisiinstrument)
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
        $varmodel = SupervisiInstrument::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //SupervisiInstrument
        // dd($id);
        // dd($request->all());
        $data = SupervisiInstrument::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
}

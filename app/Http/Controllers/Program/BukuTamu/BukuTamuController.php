<?php

namespace App\Http\Controllers\Program\BukuTamu;

use App\Models\Whatsapp\WhatsApp;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Program\BukuTamu\BukuTamu;
use Illuminate\Support\Facades\Validator;

class BukuTamuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*
    BukuTamu
    $bukutamu
    role.program.bukutamu
    role.program.bukutamu.data-tamu
    role.program.bukutamu.blade_show
    Index = Program Buku Tamu
    Breadcume Index = 'Program Tamu / Buku Tamu';
    Single = Program Buku Tamu
    php artisan make:view role.program.bukutamu.data-tamu
    php artisan make:view role.program.bukutamu.data-tamu-single
    php artisan make:seed BukuTamuSeeder



    */
    public function index()
    {
        //
        //Title to Controller
        $title = 'Program Buku Tamu';
        $arr_ths = [
            'Hari dan Tanggal',
            'Nama',
            'No Surat',
            'Keperluan',
            'Tujuan Ketemu',
        ];
        $breadcrumb = 'Program Tamu / Buku Tamu';
        $titleviewModal = 'Lihat Data Program Buku Tamu';
        $titleeditModal = 'Edit Data Program Buku Tamu';
        $titlecreateModal = 'Create Data Program Buku Tamu';
        $datas = BukuTamu::orderBy('created_at', 'DESC')->get();
        $datagurus = \App\Models\User\Guru\Detailguru::orderBy('nama_guru', 'ASC')->get();


        return view('role.program.bukutamu.data-tamu', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'datagurus',
        ));
        //php artisan make:view role.program.bukutamu.data-tamu

    }


    public function show()
    {
        //
        //Title to Controller
        $title = 'Program Buku Tamu';
        $arr_ths = [
            'title_tabela',
            'title_tabelab',
            'title_tabelac',
            'title_tabelad',
        ];
        $breadcrumb = 'Program Tamu / Buku Tamu';
        $titleviewModal = 'Lihat Data title_Halaman';
        $titleeditModal = 'Edit Data title_Halaman';
        $titlecreateModal = 'Create Data title_Halaman';
        $datas = BukuTamu::get();
        $datagurus = \App\Models\User\Guru\Detailguru::orderBy('nama_guru', 'ASC')->get();

        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('role.program.bukutamu.data-tamu-single', compact(
            'datas',
            'title',
            'arr_ths',
            'breadcrumb',
            'titleviewModal',
            'titleeditModal',
            'titlecreateModal',
            'datagurus',
        ));
        //php artisan make:view role.program.bukutamu.data-tamu-single
    }

    public function store(Request $request)
    {
        //
        // dd($request->all());
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'nama'             => 'required|string|max:255',
            'nomor_surat'      => 'required|string|max:50|unique:surats,nomor_surat',
            // 'file'             => 'required|file|mimes:pdf,doc,docx|max:2048',
            'instansi'         => 'required|string|max:255',
            'keperluan'        => 'required|string|max:500',
            'kontak'           => 'required|string',
            'waktu_kedatangan' => 'nullable|date',
            'waktu_kepergian'  => 'nullable|date',
            'catatan'          => 'nullable|string|max:500',
            'detailguru_id'    => 'required|exists:detailgurus,id',
            'tapel_id'    => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }



        BukuTamu::create($validator->validated());

        // dd($request->all());
        //Kirim Wa
        // dd($request->detailguru_id);
        // dd($request->waSender);
        if ($request->waSender === 'on') {
            $DataGuru = Detailguru::where('id', $request->detailguru_id)->first();
            if ($DataGuru->jensi_kelamin === "P") {
                $sebutan = 'Ibu';
            } else {
                $sebutan = 'Bapak ';
            }
            // dd($DataGuru->nama_guru);
            $sessions = config('whatsappSession.IdWaUtama');
            $message =
                "================================\n" .
                "*📢 Pesan :* *Bagian Tamu*\n" .
                "================================\n\n" .
                "*Assalamualaikum Wr. Wb* \nMaaf mengganggu : " . $sebutan . " " . $DataGuru->nama_guru . " untuk saat ini ada tamu yang perlu ditemui dari : " . "\n" .
                "=================================\n\n" .
                "🏢 *Instansi* : " . $request->instansi . "\n" .
                "🧑 *Nama* : " . $request->nama  . "\n" .
                "📞 *Nomor HP* : " . $request->kontak  . "\n" .
                "📄 *No Surat* : " . $request->nomor_surat  . "\n" .
                "📝 *Keperluan* : " . $request->keperluan . "\n\n" .
                "*Terima Kasih* \n" .
                "*Wassalamualaikum Wr. Wb* \n";
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, '6282324399566', $message);

            // return response()->json($result);
        } else {
        }
        //Fedback
        if ($request->waSender === 'on') {
            $DataGuru = Detailguru::where('id', $request->detailguru_id)->first();
            // dd($DataGuru->nama_guru);
            $noFeedBack = $request->kontak;
            $sessions = config('whatsappSession.IdWaUtama');
            $message =

                "================================\n" .
                "*📢 Pesan :* *Bagian Feddback*\n" .
                "================================\n\n" .
                "*Assalamualaikum Wr. Wb* \n Maaf Bapak/Ibu pesan sedang diteruskan kepada " . $sebutan . " *" . $DataGuru->nama_guru . "* Mohon Bapak/Ibu " . $request->nama  . " diharapkan menunggu sejenak " . "\n" .
                "" . $sebutan . " " . $DataGuru->nama_guru . " telah kami informasikan data berikut" . "\n" .
                "=================================\n\n" .
                "🏢 *Instansi* : " . $request->instansi . "\n" .
                "🧑 *Nama* : " . $request->nama  . "\n" .
                "📞 *Nomor HP* : " . $request->kontak  . "\n" .
                "📄 *No Surat* : " . $request->nomor_surat  . "\n" .
                "📝 *Keperluan* : " . $request->keperluan . "\n\n" .
                "*Terima Kasih* \n" .
                "*Wassalamualaikum Wr. Wb* \n";
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $request->kontak, $message);

            // return response()->json($result);
        } else {
        }


        Session::flash('success', 'Data Berhasil Disimpan');
        return Redirect::back();
    }
    public function update($id, Request $request, BukuTamu $bukutamu)
    {
        //

        $etapels = Etapel::where('aktiv', 'Y')->first();
        $request->merge([
            'tapel_id' => $etapels->id,
            'semester' => $etapels->semester
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'nama'             => 'required|string|max:255',
            'nomor_surat'      => 'required|string|max:50|unique:surats,nomor_surat',
            // 'file'             => 'required|file|mimes:pdf,doc,docx|max:2048',
            'instansi'         => 'required|string|max:255',
            'keperluan'        => 'required|string|max:500',
            'kontak'           => 'required|string',
            'waktu_kedatangan' => 'nullable|date',
            'waktu_kepergian'  => 'nullable|date',
            'catatan'          => 'nullable|string|max:500',
            'detailguru_id'    => 'required|exists:detailgurus,id',
            'tapel_id'    => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $varmodel = BukuTamu::find($id); // Pastikan $id didefinisikan atau diterima dari request
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
        //BukuTamu
        // dd(id);
        // dd(request->all());
        $data = BukuTamu::findOrFail($id);
        $data->delete();
        return Redirect::back()->with('Title', 'Berhasil')->with('Success', 'Data Berhasil Dihapus');
    }
    public function indexFormulirTamu()
    {
        //dd($request->all());
        return view('role.program.bukutamu.formulir-buku-tamu', compact(
            'title',
            'breadcrumb',
        ));
    }
}

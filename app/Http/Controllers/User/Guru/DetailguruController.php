<?php

namespace App\Http\Controllers\User\Guru;

use App\Models\User;
use Illuminate\Http\Request;
// use App\Models\Detailgurus;
use App\Http\Controllers\Controller;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;

class DetailguruController extends Controller
{
   public function index(User $user)
   {

      //Title to Controller
      $title = 'Data Guru';
      $arr_ths = [
         'Foto',
         'Nama',
         'nip',
         'nik',
         'Lulusan',
         'Th Lulus',
         'No HP',
         'Alamat',
         'Status',
         'Pendidikan',
         'Jenis Kelamin'
      ];
      $userDataGuru = Cache::tags(['userDataGurunamachace'])->remember('userDataGuruList', now()->addMinutes(2), function () {
         return User::with('UsersDetailgurus')->where('posisi', 'Guru')->get();
      });

      $breadcrumb = "Admin Data / Data Guru";
      $titleviewModal = 'Lihat Data Guru';
      $titleeditModal = 'Edit Data Guru';
      $titlecreateModal = 'Create Data Guru';
      return view('admin.user.guru', compact(
         'title',
         'userDataGuru',
         'breadcrumb',
         'arr_ths',
         'titleviewModal',
         'titleeditModal',
         'titlecreateModal'
      ));
   }
   public function update($id, Request $request)
   {
      // Validasi bisa ditambah di sini sesuai kebutuhan
      $guru = Detailguru::findOrFail($id);

      $guru->update([
         'nama_guru'     => $request->nama_guru,
         'nip'           => $request->nip,
         'nik'           => $request->nik,
         'status'        => $request->status,
         'jenis_kelamin' => $request->jenis_kelamin,
         'pendidikan'    => $request->pendidikan,
         'lulusan'       => $request->lulusan,
         'tahun_lulus'   => $request->tahun_lulus,
         'jurusan'       => $request->jurusan,
         'alamat'        => $request->alamat,
         'agama'         => $request->agama,
         'no_hp'         => $request->no_hp,
         'tempat_lahir'  => $request->tempat_lahir,
         'tanggal_lahir' => $request->tanggal_lahir,
         'tmt_mengajar'  => $request->tmt_mengajar,
      ]);

      // Hapus cache guru setelah update
      HapusCacheDenganTag('userDataGurunamachace');

      return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data berhasil diperbaharui');
   }

   public function destroy($id)
   {
      $VarDetailguru = User::findOrFail($id);
      $VarDetailguru->delete();
      HapusCacheDenganTag('userDataGurunamachace');

      return redirect()->back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahaps Berhasil dihapus dari databse');
   }
   public function store(Request $request)
   {
      // dd($request->all());
      $data = $request->except(['_method']);
      //Proses User
      $data = new User();
      $data->posisi = $request->posisi;
      $data->aktiv = 'N';
      $data->name = $request->nama_guru;
      $data->email = $request->email;
      $data->remember_token = $request->_token;
      $data->password = Hash::make($request->password);
      $data->created_at = now();
      $data->updated_at =  now();
      $data->save();
      sleep(10);
      //Proses Detail Guru
      $users_max = User::select('id')->pluck('id')->max();
      $data = new Detailguru();
      $data->nama_guru = $request->nama_guru;
      $data->user_id = $users_max;
      $data->nip = $request->nip;
      $data->nik = $request->nik;
      $data->status = $request->status;
      $data->jenis_kelamin = $request->jenis_kelamin;
      $data->pendidikan = $request->pendidikan;
      $data->lulusan = $request->lulusan;
      $data->tahun_lulus = $request->tahun_lulus;
      $data->jurusan = $request->jurusan;
      $data->alamat = $request->alamat;
      $data->agama = $request->agama;
      $data->no_hp = $request->no_hp;
      $data->tempat_lahir = $request->tanggal_lahir;
      $data->tanggal_lahir = $request->tempat_lahir;
      $data->tmt_mengajar = $request->tmt_mengajar;
      $data->save();
      //Proses Update detailguru_id di User
      $guru_max = Detailguru::select('id')->pluck('id')->max();
      $users_max = User::select('id')->pluck('id')->max();
      $data = User::findOrFail($users_max);
      $data->detailguru_id = $guru_max;
      $data->update();
      HapusCacheDenganTag('userDataGurunamachace');

      // dd($users_max);
      return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data disimpan dalam database');
   }
}

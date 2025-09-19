<?php


namespace App\Models\User\Siswa;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Elist;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use App\Models\Absensi\Eabsen;
use App\Models\bk\Ebkpelanggaran;
use App\Models\Learning\EnilaiTugas;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUH;
use App\Models\WakaKurikulum\Elearning\Nilai\KurikulumNilaiTugas;

class Detailsiswa extends Model
{
    use HasFactory;
    protected $table = "detailsiswas";
    protected $fillable = [
        'user_id',
        'ppdb_id',
        'status_siswa',
        'nis',
        'nisn',
        'nama_siswa',
        'nama_panggilan',
        'nik',
        'nokk',
        'hobi',
        'cita_cita',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'nohp_siswa',
        'agama',
        'kewarganegaraan',
        'anak_ke',
        'jml_saudara',
        'jumlah_saudara_tiri',
        'jumlah_saudara_angkat',
        'status_anak',
        'status_yatim_piatu',
        'bahasa',
        'alamat_siswa',
        'jalan',
        'rt',
        'rw',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'tinggal_bersama',
        'jarak_sekolah',
        'golongan_darah',
        'riwayat_penyakit',
        'kelainan_jasmani',
        'tinggi_badan',
        'berat_badan',
        'namasek_asal',
        'alamatsek_asal',
        'tanggal_ijazah_sd',
        'nomor_ijazah_sd',
        'lama_belajar',
        'asal_pindahan',
        'alasan_pindahan',
        'kelas_penerimaan',
        'kelompok_penerimaan',
        'jurusan_penerimaan',
        'tanggal_penerimaan',
        'tahun_masuk',
        'tahun_lulus',
        'tingkat_id',
        'kelas_id',
        'jabatan_kelas',
        'piket_kelas',
        'petugas_upacara',

        // Ayah
        'ayah_nama',
        'ayah_keadaan',
        'ayah_agama',
        'ayah_kewarganegaraan',
        'ayah_pendidikan',
        'ayah_pekerjaan',
        'ayah_penghasilan',
        'ayah_alamat',
        'ayah_rt',
        'ayah_rw',
        'ayah_desa',
        'ayah_kecamatan',
        'ayah_kabupaten',
        'ayah_provinsi',
        'ayah_kodepos',
        'ayah_nohp',

        // Ibu
        'ibu_nama',
        'ibu_keadaan',
        'ibu_agama',
        'ibu_kewarganegaraan',
        'ibu_pendidikan',
        'ibu_pekerjaan',
        'ibu_penghasilan',
        'ibu_alamat',
        'ibu_rt',
        'ibu_rw',
        'ibu_desa',
        'ibu_kecamatan',
        'ibu_kabupaten',
        'ibu_provinsi',
        'ibu_kodepos',
        'ibu_nohp',

        // Wali
        'wali_nama',
        'wali_keadaan',
        'wali_agama',
        'wali_kewarganegaraan',
        'wali_pendidikan',
        'wali_pekerjaan',
        'wali_penghasilan',
        'wali_alamat',
        'wali_rt',
        'wali_rw',
        'wali_desa',
        'wali_kecamatan',
        'wali_kabupaten',
        'wali_provinsi',
        'wali_kodepos',
        'wali_nohp',
    ];



    public static function getId()
    {
        $users = User::where('posisi', 'Siswa')->get();
        $users = collect($users)->flatten(1);
        $users = $users->values()->all();
        foreach ($users as $user):
            $userId[] = $user['id'];
        endforeach;
        $data = implode(",", $userId);
        return $data;
    }

    public function Detailsiswatokelas(): HasOne
    {
        return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
    public function KelasOne(): HasOne
    {
        return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
    //Absensi
    public function kelas()
    {
        return $this->belongsTo(Ekelas::class, 'kelas_id');
    }

    public function absensi()
    {
        return $this->hasMany(Eabsen::class, 'detailsiswa_id');
    }
    //Absensi



    public function DetailsiswatoTapel(): HasOne
    {
        return $this->hasOne(Etapel::class, 'id', 'tahun_lulus');
    }
    public function Detailsiswatouser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function DetailsiswaInsertDataNilai() {}
    public function DetailsiswatoEnilaiTugas()
    {
        //dd($request->all());
        $this->hasMany(EnilaiTugas::class, 'detailsiswa_id');
    }

    public function DetailsiswaToElistsJabatanKelas()
    {
        return $this->hasOne(Elist::class, 'id', 'jabatan_kelas');
    }
    public function Elsitjengkel()
    {
        return $this->hasOne(Elist::class, 'id', 'jenis_kelamin');
    }
    public function DetailsiswaToElistsPiketKelas()
    {
        return $this->hasOne(Elist::class, 'id', 'piket_kelas');
    }
    public function DetailsiswaToElistsPetugasUpacaraKelas()
    {
        return $this->hasOne(Elist::class, 'id', 'petugas_upacara');
    }
    //
    public function FindingKelas($id)
    {
        $kelas = Ekelas::find($id);
        //dd($request->all());

        return $kelas;
    }
    public function nilaiUH()
    {
        return $this->hasMany(KurikulumNilaiUH::class, 'detailsiswa_id', 'id');
    }
    public function nilaiTGS()
    {
        return $this->hasMany(KurikulumNilaiTugas::class, 'detailsiswa_id', 'id');
    }
    public function eabsens()
    {
        return $this->hasMany(Eabsen::class);
    }
    public function generateDataSiswa(): array
    {
        return [
            '{{nama_siswa}}' => $this->nama_siswa,
            '{{nis_siswa}}' => $this->nis,
            '{{nisn_siswa}}' => $this->nisn,
            '{{tahun_masuk}}' => $this->tahun_masuk,
            '{{nohp_siswa}}' => $this->nohp_siswa,
            '{{tempat_lahir}}' => $this->tempat_lahir,
            '{{tanggal_lahir}}' => $this->tanggal_lahir,
            '{{jenis_kelamin}}' => $this->jenis_kelamin,
            '{{kecamatan}}' => $this->kecamatan,
            '{{desa}}' => $this->desa,
            '{{kelas}}' => $this->KelasOne->kelas,
            '{{alamat_siswa}}' => $this->alamat_siswa,
            '{{nama_ayah}}' => $this->nama_ayah,
            '{{penghasilan_ayah}}' => $this->penghasilan_ayah,
            '{{pekerjaan_ayah}}' => $this->pekerjaan_ayah,
            '{{nohp_ayah}}' => $this->nohp_ayah,
            '{{nama_ibu}}' => $this->nama_ibu,
            '{{pekerjaan_ibu}}' => $this->pekerjaan_ibu,
            '{{penghasilan_ibu}}' => $this->penghasilan_ibu,
            '{{nohp_ibu}}' => $this->nohp_ibu,
            '{{nama_wali}}' => $this->nama_wali,
            '{{ttl}}' => $this->tempat_lahir . ', ' .
                Carbon::parse($this->tanggal_lahir)->translatedFormat('d F Y'),
        ];
    }

    public function ebkpelanggaran()
    {
        return $this->hasMany(Ebkpelanggaran::class, 'pelaku_id');
    }
    // Di model
    public function scopeSiswaAktif($query)
    {
        return $query->where('status_siswa', 'aktif');
    }
    public function scopeSiswaPindah($query)
    {
        return $query->where('status_siswa', 'pindah');
    }
    public function scopeSiswaKeluar($query)
    {
        return $query->where('status_siswa', 'keluar');
    }
    public function scopeAlumni($query)
    {
        return $query->where('status_siswa', 'alumni');
    }
    public function scopeSiswaKelas($query, $kelas)
    {
        return $query->where('kelas_id', $kelas);
    }
    public function scopeSiswaTIngkat($query, $tingkat)
    {
        return $query->where('tingkat_id', $tingkat);
    }
    public function scopeSiswaJengkel($query, $jenis_kelamin)
    {
        return $query->where('jenis_kelamin', $jenis_kelamin);
    }
    public function scopeUsia($query, $usia)
    {
        return $query->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) = ?', [$usia]);
    }
    public function scopeGroupKelas($query)
    {
        return $query->groupBy('kelas_id', 'ASC');
    }
}

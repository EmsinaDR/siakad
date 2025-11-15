<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PpdbPesertaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'status_penerimaan' => 'required|string',
            'nomor_peserta' => 'required|string|unique:ppdb_peserta,nomor_peserta',
            'detailguru_id' => 'nullable|exists:detailgurus,id',
            'jalur' => 'required|string|in:Prestasi,Reguler',
            'rekomendasi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nama_calon' => 'required|string|max:255',
            'nisn' => 'nullable|string|max:20|unique:ppdb_peserta,nisn',
            'nik' => 'nullable|string|max:20|unique:ppdb_peserta,nik',
            'nokk' => 'nullable|string|max:50',
            'hobi' => 'nullable|exists:elists,id',
            'cita_cita' => 'nullable|exists:elists,id',
            'agama' => 'nullable|exists:elists,id',
            'nohp_calon' => 'nullable|string|max:15',
            'jml_saudara' => 'nullable|integer|min:0',
            'jenis_kelamin' => 'nullable|exists:elists,id',
            'anak_ke' => 'nullable|integer|min:1',
            'status_anak' => 'nullable|exists:elists,id',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat_calon' => 'nullable|string',
            'rt' => 'nullable|string|max:3',
            'rw' => 'nullable|string|max:3',
            'desa' => 'nullable|string|max:150',
            'kecamatan' => 'nullable|string|max:150',
            'kabupaten' => 'nullable|string|max:255',
            'provinsi' => 'nullable|exists:elists,id',
            'jalan' => 'nullable|string|max:150',
            'namasek_asal' => 'nullable|string|max:255',
            'alamatsek_asal' => 'nullable|string',
            'nama_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|exists:elists,id',
            'penghasilan_ayah' => 'nullable|exists:elists,id',
            'nohp_ayah' => 'nullable|string|max:15',
            'alamat_ayah' => 'nullable|string',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|exists:elists,id',
            'penghasilan_ibu' => 'nullable|exists:elists,id',
            'nohp_ibu' => 'nullable|string|max:15',
            'alamat_ibu' => 'nullable|string',
            'kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'akta_kelahiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ktp_ayah' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ktp_ibu' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ijazah' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'surat_keterangan_lulus' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kartu_kia' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kartu_nisn' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kartu_bantuan_1' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kartu_bantuan_2' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kartu_bantuan_3' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kartu_bantuan_4' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kartu_bantuan_5' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'nomor_peserta.unique' => 'Nomor peserta sudah terdaftar.',
            'nisn.unique' => 'NISN sudah digunakan.',
            'nik.unique' => 'NIK sudah digunakan.',
            'jalur.in' => 'Jalur harus Prestasi atau Reguler.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus jpg, jpeg, atau png.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ];
    }
}

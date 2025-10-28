<?php

namespace App\Http\Controllers\Program\StrukturSekolah;

use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Program\StrukturSekolah\DataStrukturSekolah;

class DataStrukturSekolahController extends Controller
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




     */
    // public function getStrukturData($id)
    // {
    //     try {
    //         $data = DataStrukturSekolah::with('guru') // Pastikan relasi 'guru' sudah ada
    //             ->where('parent_id', $id) // Memastikan data berdasarkan 'parent_id'
    //             ->get();

    //         if ($data->isEmpty()) {
    //             return response()->json(['message' => 'Data not found'], 404);
    //         }

    //         return response()->json($data);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
    //     }
    // }
    public function update(Request $request, $id)
    {
        $data = DataStrukturSekolah::findOrFail($id); // Ambil data berdasarkan ID
        $data->update([
            'parent_id' => $request->input('parent_id') // Update parent_id
        ]);

        return response()->json([
            'message' => 'Data updated successfully',
            'data' => $data
        ]);
    }

}

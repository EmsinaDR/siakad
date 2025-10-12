<?php

namespace App\Http\Controllers;

use App\Models\Ekstra;
use App\Models\Testpage;
use Illuminate\Http\Request;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
class TestpageController extends Controller
{
    //
    public function index()
    {
        $title = 'Tespage';
        $breadcrumb = 'Data / Data Testpage';
        $ekstras = Ekstra::select('id', 'ekstra')->get();
        $ekstras = Ekstra::get();



        // ChartJS
        // Membuat chart baru
        $labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei'];
        $data = [12, 19, 3, 5, 2];
        // ChartJS Akhir


        return view('admin.testpage', compact('title', 'breadcrumb', 'ekstras','labels', 'data'));
    }
    // public function UploadExcelDB(Request $request)
    public function create(Request $request)
    {
        dd($request->all());

        return 'ok';
    }
}

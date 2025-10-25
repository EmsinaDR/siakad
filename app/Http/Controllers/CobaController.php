<?php

namespace App\Http\Controllers;

use App\Models\Detailsiswa;
use Illuminate\Http\Request;

class CobaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $datas = Detailsiswa::get(); // Mengambil semua data dari model
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Detailsiswa $detailsiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Detailsiswa $detailsiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Detailsiswa $detailsiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Detailsiswa $detailsiswa)
    {
        //
    }
}

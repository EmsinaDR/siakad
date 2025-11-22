<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\RoleUser;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    //
    /*
           * Display a listing of the resource.
           Folder Name = admin
           Model = RoleUser
           Variabel Model = RoleUser
           Title Edit = Rool User
           */
    public function index()
    {
        //Title to Controller
        $title = 'Rool User';
        $arr_ths = [
            'Nama',
            'Rool',
            'User',
            'Password'
        ];
        $breadcrumb = 'Admin / Rool User';
        $titleviewModal = 'Detail Data Rool User';
        $titleeditModal = 'Edit Data Rool User';
        $titlecreateModal = 'Create Data Rool User';


        //compact => 'title', 'arr_ths', 'breadcrumb', 'titleviewModal', 'titleeditModal', 'titlecreateModal'
        return view('rool.index', compact('datas', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Form Create
        return view('url.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Untuk Proses Create
        $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|numeric|unique:siswas,nis',
            'kelas' => 'required|string|max:10',
            // Tambahkan aturan validasi lain sesuai kebutuhan
        ]);
        //$request['input_array'] = implode(',', $request->input_array);
        $data = $request->all();
        $data['created_at'] = now();
        $data['updated_at'] = now();
        $data = $request->except(['_token']);
        // DB::table('table_name')->insert($data);
        // RoleUser::create(request->all());
        RoleUser::insert($data);
        return redirect()->route('url.index')->with('Success', 'Data Sukses Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, RoleUser $RoleUser)
    {
        //
        $datas = RoleUser::findOrFail($request->id);
        $title = 'Edit Rool User';
        return view('url.show', compact('datas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, RoleUser $RoleUser)
    {
        //Form Edit
        $datas = RoleUser::findOrFail($request->id);
        $title = 'Edit Rool User';
        return view('url.edit', compact('datas', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoleUser $RoleUser)
    {
        // Proses Update dari Edit
        $request->validate([
            'nama' => 'required|string|max:255',
            //'nis' => 'required|numeric|unique:students,nis,' . $id,
            '//kelas' => 'required|string|max:10',
        ]);

        $RoleUser = RoleUser::findOrFail($request->id);
        $RoleUser->update($request->all());
        return redirect()->route('url.index')->with('Success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, RoleUser $RoleUser)
    {
        //
        $RoleUser = RoleUser::findOrFail($request->id);
        $RoleUser->delete();

        return redirect()->route('url.index')->with('Success', 'Data berhasil dihapus.');
    }
}

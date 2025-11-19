<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisiMisi;

class VisiMisiController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vm = VisiMisi::firstOrCreate(['id'=>1], ['visi'=>null, 'misi'=>[]]);

        // redirect ke edit yang minta parameter
        return redirect()->route('admin.profil.visimisi.edit', $vm);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VisiMisi $visimisi)
    {
        return view('admin.profil.edit', compact('visimisi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VisiMisi $visimisi)
    {
        $data = $request->validate([
            'visi' => ['nullable','string'],
            'misi' => ['nullable','string'], // misi dikirim textarea (dipisah baris)
        ]);

        // pecah misi per baris (hapus baris kosong)
        $misiArray = collect(preg_split("/\r\n|\n|\r/", $data['misi'] ?? ''))
            ->map(fn($s) => trim($s))
            ->filter(fn($s) => $s !== '')
            ->values()
            ->all();

        $visimisi->update([
            'visi' => $data['visi'] ?? null,
            'misi' => $misiArray,
        ]);

        return back()->with('success','Visi & Misi diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

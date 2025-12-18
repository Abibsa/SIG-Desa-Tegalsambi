<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index()
    {
        $wilayahs = Wilayah::latest()->paginate(10);
        return view('admin.wilayah.index', compact('wilayahs'));
    }

    public function create()
    {
        return view('admin.wilayah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|in:desa,dusun,rw,rt',
            'kk' => 'required|integer|min:0',
            'l' => 'required|integer|min:0',
            'p' => 'required|integer|min:0',
        ]);

        Wilayah::create($validated);

        return redirect()->route('admin.wilayah.index')
            ->with('success', 'Data wilayah berhasil ditambahkan!');
    }

    public function show(Wilayah $wilayah)
    {
        return view('admin.wilayah.show', compact('wilayah'));
    }

    public function edit(Wilayah $wilayah)
    {
        return view('admin.wilayah.edit', compact('wilayah'));
    }

    public function update(Request $request, Wilayah $wilayah)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|in:desa,dusun,rw,rt',
            'kk' => 'required|integer|min:0',
            'l' => 'required|integer|min:0',
            'p' => 'required|integer|min:0',
        ]);

        $wilayah->update($validated);

        return redirect()->route('admin.wilayah.index')
            ->with('success', 'Data wilayah berhasil diupdate!');
    }

    public function destroy(Wilayah $wilayah)
    {
        $wilayah->delete();

        return redirect()->route('admin.wilayah.index')
            ->with('success', 'Data wilayah berhasil dihapus!');
    }
}

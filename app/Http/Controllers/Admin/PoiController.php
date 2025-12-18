<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poi;
use Illuminate\Http\Request;

class PoiController extends Controller
{
    public function index(Request $request)
    {
        $query = Poi::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        $pois = $query->orderBy('nama', 'asc')->paginate(10);

        // Append search query to pagination links
        $pois->appends(['search' => $request->search]);

        return view('admin.poi.index', compact('pois'));
    }

    public function create()
    {
        return view('admin.poi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'kategori' => 'required|string',
        ]);

        Poi::create($request->all());

        return redirect()->route('admin.poi.index')
            ->with('success', 'POI berhasil ditambahkan.');
    }

    public function edit(Poi $poi)
    {
        return view('admin.poi.edit', compact('poi'));
    }

    public function update(Request $request, Poi $poi)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'kategori' => 'required|string',
        ]);

        $poi->update($request->all());

        return redirect()->route('admin.poi.index')
            ->with('success', 'POI berhasil diperbarui.');
    }

    public function destroy(Poi $poi)
    {
        $poi->delete();

        return redirect()->route('admin.poi.index')
            ->with('success', 'POI berhasil dihapus.');
    }
}

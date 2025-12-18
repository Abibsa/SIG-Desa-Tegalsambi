<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wilayah;
use App\Models\Pendidikan;
use App\Models\Pekerjaan;
use App\Models\Agama;
use App\Models\Umur;

class DemografiController extends Controller
{
    private function getDesaId()
    {
        // Asumsi kita mengelola data tingkat Desa (ID Desa Tegalsambi)
        $desa = Wilayah::where('tingkat', 'desa')->first();
        return $desa ? $desa->id : null;
    }

    public function index($type)
    {
        $desaId = $this->getDesaId();
        if (!$desaId)
            return redirect()->back()->with('error', 'Data Desa tidak ditemukan.');

        $data = [];
        $title = '';
        $routeUpdate = route('admin.demografi.update', $type);

        switch ($type) {
            case 'pendidikan':
                $data = Pendidikan::where('wilayah_id', $desaId)->get();
                $title = 'Data Pendidikan';
                break;
            case 'pekerjaan':
                $data = Pekerjaan::where('wilayah_id', $desaId)->get();
                $title = 'Data Pekerjaan';
                break;
            case 'agama':
                $data = Agama::where('wilayah_id', $desaId)->get();
                $title = 'Data Agama';
                break;
            case 'umur':
                $data = Umur::where('wilayah_id', $desaId)->get();
                $title = 'Statistik Umur';
                break;
            default:
                abort(404);
        }

        return view('admin.demografi.index', compact('data', 'title', 'type', 'routeUpdate'));
    }

    public function update(Request $request, $type)
    {
        $input = $request->except(['_token', '_method']);

        // Input berupa array: [id => jumlah, id => jumlah]
        // Kita loop dan update

        $modelClass = null;
        switch ($type) {
            case 'pendidikan':
                $modelClass = Pendidikan::class;
                break;
            case 'pekerjaan':
                $modelClass = Pekerjaan::class;
                break;
            case 'agama':
                $modelClass = Agama::class;
                break;
            case 'umur':
                $modelClass = Umur::class;
                break;
        }

        if ($modelClass) {
            foreach ($input['jumlah'] as $id => $val) {
                $item = $modelClass::find($id);
                if ($item) {
                    $item->jumlah = (int) $val;
                    $item->save();
                }
            }

            // Handle Penambahan Data Baru (Jika ada fitur tambah baris nanti)
            if (!empty($input['new_label']) && !empty($input['new_jumlah'])) {
                $desaId = $this->getDesaId();
                $labelCol = match ($type) {
                    'pendidikan' => 'tingkat_pendidikan',
                    'pekerjaan' => 'jenis_pekerjaan',
                    'agama' => 'agama',
                    'umur' => 'rentang_umur',
                };

                $modelClass::create([
                    'wilayah_id' => $desaId,
                    $labelCol => $input['new_label'],
                    'jumlah' => (int) $input['new_jumlah']
                ]);
            }
        }

        return redirect()->route('admin.demografi.index', $type)
            ->with('success', 'Data berhasil diperbarui.');
    }

    // Fitur Delete Row
    public function destroy($type, $id)
    {
        $modelClass = null;
        switch ($type) {
            case 'pendidikan':
                $modelClass = Pendidikan::class;
                break;
            case 'pekerjaan':
                $modelClass = Pekerjaan::class;
                break;
            case 'agama':
                $modelClass = Agama::class;
                break;
            case 'umur':
                $modelClass = Umur::class;
                break;
        }

        if ($modelClass) {
            $item = $modelClass::find($id);
            if ($item)
                $item->delete();
        }

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}

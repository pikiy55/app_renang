<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KelompokUmur;
use App\Models\NomorLomba;
use Illuminate\Http\Request;

class NomorLombaController extends Controller
{
    private array $gayaOptions = [
        'bebas', 'dada', 'punggung', 'kupu', 'ganti_perorangan', 'ganti_estafet',
    ];

    public function index(KelompokUmur $ku)
    {
        $nomorLomba = $ku->nomorLomba()->get();
        return view('admin.nomor-lomba.index', compact('ku', 'nomorLomba'));
    }

    public function create(KelompokUmur $ku)
    {
        $gayaOptions = $this->gayaOptions;
        return view('admin.nomor-lomba.create', compact('ku', 'gayaOptions'));
    }

    public function store(Request $request, KelompokUmur $ku)
    {
        $data = $request->validate([
            'nama_nomor'    => ['required', 'string', 'max:150'],
            'jarak'         => ['required', 'integer', 'min:25'],
            'gaya'          => ['required', 'in:' . implode(',', $this->gayaOptions)],
            'jenis_kelamin' => ['required', 'in:putra,putri,campuran'],
        ]);

        $ku->nomorLomba()->create($data);
        return redirect()->route('admin.ku.nomor.index', $ku)
            ->with('success', "Nomor lomba '{$data['nama_nomor']}' berhasil ditambahkan.");
    }

    public function edit(KelompokUmur $ku, NomorLomba $nomor)
    {
        $gayaOptions = $this->gayaOptions;
        return view('admin.nomor-lomba.edit', compact('ku', 'nomor', 'gayaOptions'));
    }

    public function update(Request $request, KelompokUmur $ku, NomorLomba $nomor)
    {
        $data = $request->validate([
            'nama_nomor'    => ['required', 'string', 'max:150'],
            'jarak'         => ['required', 'integer', 'min:25'],
            'gaya'          => ['required', 'in:' . implode(',', $this->gayaOptions)],
            'jenis_kelamin' => ['required', 'in:putra,putri,campuran'],
        ]);

        $nomor->update($data);
        return redirect()->route('admin.ku.nomor.index', $ku)
            ->with('success', 'Nomor lomba berhasil diperbarui.');
    }

    public function destroy(KelompokUmur $ku, NomorLomba $nomor)
    {
        $nomor->delete();
        return redirect()->route('admin.ku.nomor.index', $ku)
            ->with('success', 'Nomor lomba berhasil dihapus.');
    }
}

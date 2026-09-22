<?php

namespace App\Http\Controllers;

use App\Models\NomorLomba;
use App\Services\AutoMatchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutoCompleteController extends Controller
{
    public function __construct(private AutoMatchService $autoMatch) {}

    /**
     * Auto-complete nama atlet dari master riwayat milik klub (FR-5).
     * GET /autocomplete/atlet?q=keyword
     */
    public function atlet(Request $request)
    {
        $keyword = $request->string('q')->trim()->value();

        if (strlen($keyword) < 2) {
            return response()->json([]);
        }

        $suggestions = $this->autoMatch->suggestNama($keyword, Auth::id());

        return response()->json($suggestions);
    }

    /**
     * Auto-match limit waktu berdasarkan nama atlet + nomor lomba (FR-7, FR-8).
     * GET /autocomplete/waktu?nama_atlet=...&nomor_lomba_id=...
     */
    public function waktu(Request $request)
    {
        $request->validate([
            'nama_atlet'    => ['required', 'string'],
            'nomor_lomba_id' => ['required', 'integer', 'exists:nomor_lomba,id'],
        ]);

        $nomorLomba = NomorLomba::findOrFail($request->integer('nomor_lomba_id'));
        $limitWaktu = $this->autoMatch->matchWaktu(
            $request->string('nama_atlet')->value(),
            $nomorLomba->jarak,
            $nomorLomba->gaya,
            Auth::id()
        );

        return response()->json([
            'limit_waktu'  => $limitWaktu,
            'status_waktu' => $limitWaktu ? 'normal' : 'NT',
            'message'      => $limitWaktu
                ? "Limit waktu ditemukan dari riwayat: {$limitWaktu}"
                : 'Tidak ada riwayat waktu. Status diset NT (No Time).',
        ]);
    }
}

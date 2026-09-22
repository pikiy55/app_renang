<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePendaftaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isPerkumpulan();
    }

    public function rules(): array
    {
        return [
            'kelompok_umur_id' => ['required', 'integer', 'exists:kelompok_umur,id'],
            'nomor_lomba_id'   => ['required', 'integer', 'exists:nomor_lomba,id'],
            'nama_atlet'       => ['required', 'string', 'max:255'],
            'tanggal_lahir'    => ['required', 'date', 'before:today'],
            'jenis_kelamin'    => ['required', 'in:putra,putri'],
            'limit_waktu'      => ['nullable', 'string', 'regex:/^\d{1,2}:\d{2}\.\d{2}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'limit_waktu.regex' => 'Format limit waktu harus MM:SS.ss (contoh: 01:23.45)',
        ];
    }
}

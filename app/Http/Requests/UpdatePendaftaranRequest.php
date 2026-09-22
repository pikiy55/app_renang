<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePendaftaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        $pendaftaran = $this->route('pendaftaran');
        return auth()->check()
            && auth()->user()->isPerkumpulan()
            && $pendaftaran->user_id === auth()->id()
            && ! $pendaftaran->isLocked();
    }

    public function rules(): array
    {
        return [
            'nama_atlet'    => ['sometimes', 'string', 'max:255'],
            'tanggal_lahir' => ['sometimes', 'date', 'before:today'],
            'jenis_kelamin' => ['sometimes', 'in:putra,putri'],
            'limit_waktu'   => ['nullable', 'string', 'regex:/^\d{1,2}:\d{2}\.\d{2}$/'],
            'status_waktu'  => ['sometimes', 'in:normal,NT'],
        ];
    }

    public function messages(): array
    {
        return [
            'limit_waktu.regex' => 'Format limit waktu harus MM:SS.ss (contoh: 01:23.45)',
        ];
    }
}

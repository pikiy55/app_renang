<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'nama_event'           => ['required', 'string', 'max:255'],
            'lokasi'               => ['nullable', 'string', 'max:255'],
            'tanggal_mulai'        => ['required', 'date'],
            'tanggal_selesai'      => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'deadline_pendaftaran' => ['required', 'date', 'before_or_equal:tanggal_mulai'],
            'is_active'            => ['boolean'],

            // Kelompok Umur (opsional, array)
            'ku'                          => ['nullable', 'array'],
            'ku.*.id'                     => ['nullable', 'integer', 'exists:kelompok_umur,id'],
            'ku.*.nama_ku'                => ['required_with:ku', 'string', 'max:100'],
            'ku.*.usia_min'               => ['nullable', 'integer', 'min:0'],
            'ku.*.usia_max'               => ['nullable', 'integer', 'min:0'],

            // Nomor Lomba per KU (opsional, array)
            'ku.*.nomor'                  => ['nullable', 'array'],
            'ku.*.nomor.*.id'             => ['nullable', 'integer', 'exists:nomor_lomba,id'],
            'ku.*.nomor.*.nama_nomor'     => ['required_with:ku.*.nomor', 'string', 'max:150'],
            'ku.*.nomor.*.jarak'          => ['required_with:ku.*.nomor', 'integer', 'min:25'],
            'ku.*.nomor.*.gaya'           => ['required_with:ku.*.nomor', 'in:bebas,dada,punggung,kupu,ganti_perorangan,ganti_estafet'],
            'ku.*.nomor.*.jenis_kelamin'  => ['required_with:ku.*.nomor', 'in:putra,putri,campuran'],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal_selesai.after_or_equal'      => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
            'deadline_pendaftaran.before_or_equal' => 'Deadline pendaftaran harus sebelum atau sama dengan tanggal mulai event.',
            'ku.*.nama_ku.required_with'           => 'Nama KU wajib diisi.',
            'ku.*.nomor.*.nama_nomor.required_with'=> 'Nama nomor lomba wajib diisi.',
            'ku.*.nomor.*.jarak.required_with'     => 'Jarak lomba wajib diisi.',
            'ku.*.nomor.*.jarak.min'               => 'Jarak lomba minimal 25 meter.',
            'ku.*.nomor.*.gaya.required_with'      => 'Gaya renang wajib dipilih.',
            'ku.*.nomor.*.gaya.in'                 => 'Gaya renang tidak valid.',
            'ku.*.nomor.*.jenis_kelamin.required_with' => 'Jenis kelamin wajib dipilih.',
        ];
    }
}

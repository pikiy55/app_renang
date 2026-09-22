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
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal_selesai.after_or_equal'      => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
            'deadline_pendaftaran.before_or_equal' => 'Deadline pendaftaran harus sebelum atau sama dengan tanggal mulai event.',
        ];
    }
}

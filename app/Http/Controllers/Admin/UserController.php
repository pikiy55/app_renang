<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Daftar semua akun perkumpulan.
     */
    public function index()
    {
        $users = User::where('role', 'perkumpulan')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Form buat akun perkumpulan baru (manual oleh admin — FR-15).
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Simpan akun perkumpulan baru.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'perkumpulan',
            'nama_klub' => $request->nama_klub,
            'whatsapp'  => $request->whatsapp,
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "Akun untuk klub '{$user->nama_klub}' berhasil dibuat.");
    }

    /**
     * Detail akun perkumpulan.
     */
    public function show(User $user)
    {
        $user->load('pendaftaran.event');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Form edit akun perkumpulan.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update akun perkumpulan.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'nama_klub' => ['required', 'string', 'max:255'],
            'whatsapp'  => ['nullable', 'string', 'max:20'],
            'is_active' => ['required', 'boolean'],
            'password'  => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'name'      => $data['name'],
            'nama_klub' => $data['nama_klub'],
            'whatsapp'  => $data['whatsapp'],
            'is_active' => $data['is_active'],
        ]);

        if (! empty($data['password'])) {
            $user->update(['password' => Hash::make($data['password'])]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', "Akun '{$user->nama_klub}' berhasil diperbarui.");
    }

    /**
     * Hapus akun perkumpulan.
     */
    public function destroy(User $user)
    {
        $namaKlub = $user->nama_klub;
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', "Akun '{$namaKlub}' berhasil dihapus.");
    }
}

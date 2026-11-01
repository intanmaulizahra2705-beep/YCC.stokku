<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('role')->orderBy('nama')->get();

        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.form', ['user' => new User()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', Rule::in(['admin', 'staf'])],
        ]);

        User::create($data);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('user.form', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'username' => [
                'required', 'string', 'max:50',
                Rule::unique('users', 'username')->ignore($user->id_user, 'id_user'),
            ],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', Rule::in(['admin', 'staf'])],
        ]);

        if ($user->getKey() == auth()->id() && $data['role'] !== 'admin') {
            return back()->withInput()->with('error', 'Anda tidak bisa mengubah peran akun sendiri.');
        }

        // password dikosongkan = tidak diganti
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'User berhasil diubah.');
    }

    public function destroy(User $user)
    {
        if ($user->getKey() == auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        try {
            $user->delete();
        } catch (QueryException $e) {
            return back()->with('error', 'User tidak bisa dihapus karena sudah mencatat transaksi stok.');
        }

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
}
@extends('layouts.app')

@section('title', $user->exists ? 'Ubah user' : 'Tambah user')

@section('content')
    <h4 class="mb-3">{{ $user->exists ? 'Ubah user' : 'Tambah user' }}</h4>

    <div class="card shadow-sm border-0" style="max-width: 560px;">
        <div class="card-body">
            <form method="POST"
                  action="{{ $user->exists ? route('user.update', $user) : route('user.store') }}">
                @csrf
                @if ($user->exists)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}"
                           class="form-control @error('nama') is-invalid @enderror" required>
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}"
                           class="form-control @error('username') is-invalid @enderror" required>
                    @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           {{ $user->exists ? '' : 'required' }}>
                    @if ($user->exists)
                        <div class="form-text">Kosongkan jika tidak ingin mengganti password.</div>
                    @endif
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                        <option value="staf" @selected(old('role', $user->role) === 'staf')>Staf</option>
                    </select>
                    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
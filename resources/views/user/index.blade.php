@extends('layouts.app')

@section('title', 'Kelola user')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Kelola user</h4>
        <a href="{{ route('user.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah user
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $u)
                        <tr>
                            <td>{{ $u->nama }}</td>
                            <td>{{ $u->username }}</td>
                            <td>
                                <span class="badge {{ $u->role === 'admin' ? 'text-bg-primary' : 'text-bg-info' }} text-uppercase">
                                    {{ $u->role }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('user.edit', $u) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if ($u->id_user != auth()->id())
                                    <form action="{{ route('user.destroy', $u) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
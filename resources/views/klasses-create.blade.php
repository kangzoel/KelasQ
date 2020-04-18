@extends('layouts.app')

@section('title', 'Buat Kelas')

@section('content')
    <form action="{{ route('klass.store') }}" method="POST" class="py-4 px-4">
        @csrf
        <div class="form-group">
            <label for="name">Nama Kelas</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" autofocus>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="default_member_role_id">Peran Calon Anggota</label>
            <select class="form-control @error('default_member_role_id') is-invalid @enderror" name="default_member_role_id" id="default_member_role_id">
                @foreach (App\Role::orderBy('id', 'desc')->get() as $role)
                    <option value="{{ $role->id }}" {{ $role->id == old('default_member_role_id') ? 'selected' : '' }}>
                        @switch($role->name)
                            @case('admin')
                                Ketua
                                @break
                            @case('secretary')
                                Sekretaris
                                @break
                            @case('treasurer')
                                Bendahara
                                @break
                            @default
                                Anggota Biasa
                        @endswitch
                    </option>
                @endforeach
            </select>
            @error('default_member_role_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Deskripsi Kelas</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3">{{ old('description') }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="text-right mt-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
@endsection

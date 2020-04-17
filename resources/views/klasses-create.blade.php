@extends('layouts.app')

@section('title', 'Buat Kelas')

@section('content')
    <form action="{{ route('klass.store') }}" method="POST" class="py-4 px-4">
        @csrf
        <x-alert></x-alert>
        <div class="form-group">
            <label for="name">Nama Kelas</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}">
        </div>
        <div class="form-group">
          <label for="default_member_role_id">Peran Calon Anggota</label>
          <select class="form-control @error('default_member_role_id') is-invalid @enderror" name="default_member_role_id" id="default_member_role_id">
                @foreach (App\Role::all() as $role)
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
        </div>
        <div class="form-group">
            <label for="description">Deskripsi Kelas</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3"></textarea>
        </div>
        <div class="text-right mt-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="klassModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="h5 font-weight-bold modal-title" id="exampleModalScrollableTitle">Tambah Kelas</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('klass.join') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" placeholder="Kode Kelas" value="{{ old('code') }}">
                            @error('code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-block font-weight-bold">
                            <i class="fas fa-sign-in-alt mr-1"></i>
                            Gabung Kelas
                        </button>
                    </form>
                    <div class="text-center my-3">atau</div>
                    <a href="/classes/create" class="btn btn-outline-primary btn-block font-weight-bold">
                        <i class="fas fa-plus mr-1"></i>
                        Buat Kelas
                    </a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#klassModal').on('shown.bs.modal', function() {
            $('[name=code]').select()
        })
    </script>
@endpush

@extends('layouts.app')

@section('title', 'Daftar Kelas')

@section('content')
    <div class="py-4 px-4">
        <x-alert></x-alert>

        @forelse ($klasses as $klass)
            <div class="class-item rounded p-3 position-relative d-flex mb-4 bg-dark text-white">
                <div class="mr-auto">
                    <a href="{{ route('klass.show', ['code' => $klass->code]) }}" class="cover"></a>
                    <h2 class="h5 m-0">{{ $klass->name }}</h2>
                    <div class="small mt-1">
                        @foreach ($klass->admin as $admin)
                            {{ $admin->name }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-2x fa-sign-in-alt"></i>
                </div>
            </div>
        @empty
            @unless (session('message') || $errors->any())
                <div class="alert alert-info" role="alert">
                    Anda belum bergabung dengan kelas manapun.
                </div>
            @endunless
            Silakan <a href="#" data-toggle="modal" data-target="#klassModal">Tambahkan kelas</a> dengan mengklik tombol tambah "+" di pojok kanan bawah.
        @endforelse

        <button class="fab btn btn-primary" data-toggle="modal" data-target="#klassModal">
            <i class="fas fa-plus"></i>
        </button>
    </div>

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

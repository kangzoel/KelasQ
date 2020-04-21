@extends('layouts.app')

@push('styles')
    <style>
        body {
            padding-top: 99px;
        }
    </style>
@endpush

@push('header')
    <nav class="tabbed-nav d-flex justify-content-between position-relative">
        <a href="{{ route('klass.show', ['code' => $klass->code]) }}" class="nav-link{{ url()->current() == route('klass.show', ['code' => $klass->code]) ? ' active' : '' }}">
            <i class="fas fa-home"></i>
        </a>
        <a href="{{ route('klass.schedules', ['code' => $klass->code]) }}" class="nav-link{{ url()->current() == route('klass.schedules', ['code' => $klass->code]) ? ' active' : '' }}">
            Jadwal
        </a>
        <a href="{{ route('klass.tasks', ['code' => $klass->code]) }}" class="nav-link{{ url()->current() == route('klass.tasks', ['code' => $klass->code]) ? ' active' : '' }}">
            Tugas
        </a>
        <a href="{{ route('klass.bills', ['code' => $klass->code]) }}" class="nav-link{{ url()->current() == route('klass.bills', ['code' => $klass->code]) ? ' active' : '' }}">
            Tagihan
        </a>
    </nav>
@endpush

@push('menu')
    @can('update', $klass)
        <a href="{{ route('klass.edit', ['code' => $klass->code]) }}" class="dropdown-item">Edit Informasi</a>
        <form action="{{ route('klass.out', ['id' => $klass->id]) }}" method="POST">
            @csrf
            <input type="hidden" name="klass_id" value="{{ $klass->id }}">
            <button type="button" class="dropdown-item" id="out">Keluar Kelas</button>
        </form>
        <form action="{{ route('klass.destroy', ['id' => $klass->id]) }}" method="POST">
            @csrf
            @method('delete')
            <input type="hidden" name="klass_id" value="{{ $klass->id }}">
            <button type="button" class="dropdown-item" id="delete">Hapus Kelas</button>
        </form>
    @endcan
@endpush

@push('scripts')
    <script>
        $('#out').click(function() {
            if (confirm('Apakah Anda yakin ingin keluar dari kelas ini?')) {
                $(this).parents('form').submit()
            }
        })

        $('#delete').click(function() {
            let hapus = prompt('Silakan ketik "HAPUS" lalu tekan OK untuk menghapus kelas ini.')
            if (hapus == 'HAPUS') {
                $(this).parents('form').submit()
            } else if (hapus !== null) {
                alert('Hapus ditabalkan. Pastikan anda mengetik "HAPUS" (huruf kapital semua) untuk menghapus kelas.');
            }
        })
    </script>
@endpush

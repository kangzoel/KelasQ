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
        <a href="{{ route('task.show', ['klass_code' => $klass->code]) }}" class="nav-link{{ url()->current() == route('task.show', ['klass_code' => $klass->code]) ? ' active' : '' }}">
            Tugas
        </a>
        <a href="{{ route('bill.show', ['klass_code' => $klass->code]) }}" class="nav-link{{ url()->current() == route('bill.show', ['klass_code' => $klass->code]) ? ' active' : '' }}">
            Tagihan
        </a>
    </nav>
@endpush

@push('menu')
    @can('update', $klass)
        <a href="{{ route('klass.edit', ['code' => $klass->code]) }}" class="dropdown-item">Edit Informasi</a>
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
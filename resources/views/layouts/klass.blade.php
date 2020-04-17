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

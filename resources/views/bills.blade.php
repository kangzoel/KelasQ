@extends('layouts.app')

@section('title', 'Daftar Tagihan')

@section('content')
<div class="py-4 px-4">
    <x-alert></x-alert>

    @forelse ($bills as $bill)
    <div class="class-item rounded p-3 position-relative d-flex mb-4 bg-dark text-white">
        <div class="mr-auto">
            <a href="{{ route('klass.show', ['code' => $bill->klass->code]) }}/bills" class="cover"></a>
            <h2 class="h5 m-0">{{ $bill->name }}</h2>
            <div class="small mt-1">

                {{$bill->klass->name}}

            </div>
        </div>
        <div class="d-flex align-items-center">
            <i class="fas fa-2x fa-money-bill"></i>
            <i class="fas fa-2x">&nbsp&nbsp{{$bill->amount}}</i>
        </div>
    </div>
    @empty
    @unless (session('message') || $errors->any())
    <div class="alert alert-info" role="alert">
        Anda Tidak Memiliki Tagihan.
    </div>
    @endunless
    @endforelse
</div>
@endsection

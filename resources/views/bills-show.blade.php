@extends('layouts.klass')

@section('title', "Daftar Tagihan - $klass->name")

@section('content')
<div class="py-4 px-4">
        <x-alert></x-alert>

        @forelse ($bills as $bill)
            @forelse ($paid_bills as $paid_bill)
            
            @if($paid_bill->bill_id != $bill->id)
            <div class="class-item rounded p-3 position-relative d-flex mb-4 bg-dark text-white">
                <div class="mr-auto">
                    <a href="#/" class="cover"></a>
                    <h2 class="h5 m-0">{{ $bill->name }}</h2>
                    <div class="small mt-1">
                            {{$bill->klass->name}}
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-2x fa-money-bill"></i>
                    <i class="fas fa-2x">&nbsp&nbsp{{$bill->amount}}</i>
                    <i class="fas fa-2x">&nbsp&nbspBelum Bayar</i>
                </div>
            </div>
            
            @else
            <div class="class-item rounded p-3 position-relative d-flex mb-4 bg-dark text-white">
                <div class="mr-auto">
                    <a href="#/" class="cover"></a>
                    <h2 class="h5 m-0">{{ $bill->name }}</h2>
                    <div class="small mt-1">
                            {{$bill->klass->name}}
                    </div>
                </div>
                <div class="d-flex align-items-center">
                <i class="fas fa-2x fa-money-bill"></i>
                <i class="fas fa-2x">&nbsp&nbsp{{$bill->amount}}</i>
                <i class="fas fa-2x">&nbsp&nbspTelah Bayar</i>
                </div>
            </div>
            @endif
            @empty
            <div class="class-item rounded p-3 position-relative d-flex mb-4 bg-dark text-white">
                <div class="mr-auto">
                    <a href="#/" class="cover"></a>
                    <h2 class="h5 m-0">{{ $bill->name }}</h2>
                    <div class="small mt-1">
                            {{$bill->klass->name}}
                    </div>
                </div>
                <div class="d-flex align-items-center">
                <i class="fas fa-2x fa-money-bill"></i>
                <i class="fas fa-2x">&nbsp&nbsp{{$bill->amount}}</i>
                <i class="fas fa-2x">&nbsp&nbspBelum Bayar</i>
                </div>
            </div>
            @endforelse
        @empty
            @unless (session('message') || $errors->any())
                <div class="alert alert-info" role="alert">
                    Anda Tidak Memiliki Tagihan.
                </div>
            @endunless
            
        @endforelse
        <button class="fab btn btn-primary" data-toggle="modal" data-target="#billCreateModal">
            <i class="fas fa-money-bill"></i>
        </button>
    </div>
@endsection
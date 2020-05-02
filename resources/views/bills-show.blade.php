@php
    use App\PaidBill;
@endphp
@extends('layouts.klass')

@section('title', "Daftar Tagihan - $klass->name")

@section('content')
<div class="py-4 px-4">
        <x-alert></x-alert>

        @forelse ($bills as $bill)
            @php
            $paid_bill = PaidBill::select('paid_bills.*')
                ->where('bill_id',$bill->id)
                ->where('user_npm',$users->npm)
                ->first();
            @endphp

            @if ($paid_bill != NULL)
            <div class="class-item rounded p-3 position-relative d-flex mb-4 bg-dark text-white">
                <div class="mr-auto">
                    <a href="{{ route('bill.info', ['id' => $bill->id]) }}" class="cover"></a>
                    <h2 class="h5 m-0">{{ $bill->name }}</h2>
                    <div class="small mt-1">
                            {{$bill->klass->name}}
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-2x fa-money-bill"></i>
                    <i class="fas fa-2x">&nbsp&nbsp{{$bill->amount}}</i>
                    @if($paid_bill->user_npm == $users->npm)
                    <i class="fas fa-2x">&nbsp&nbspTelah Bayar</i>
                    @else
                    <i class="fas fa-2x">&nbsp&nbspBelum Bayar</i>

                    @endif
                </div>
            </div>

            @else
            <div class="class-item rounded p-3 position-relative d-flex mb-4 bg-dark text-white">
                <div class="mr-auto">
                    <a href="{{ route('bill.info', ['id' => $bill->id]) }}" class="cover"></a>
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
            @endif
        @empty
            @unless (session('message') || $errors->any())
                <div class="alert alert-info" role="alert">
                    Anda Tidak Memiliki Tagihan.
                </div>
            @endunless

        @endforelse
        <a href="{{ route('bill.create', $klass->code)}}"class="fab btn btn-primary">
            <i class="fas fa-plus"></i>
        </a>
    </div>
@endsection

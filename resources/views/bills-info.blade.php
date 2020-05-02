@php
use App\Bill;
use App\PaidBill;
use App\Klass;
use App\User;
use App\UserKlass;
use App\Role;

@endphp
@extends('layouts.klass')

@section('title', "Info Tagihan - $bills->name")

@section('content')
<div class="pt-4">
    @php
    $klass = Klass::where('id',$bills->klass_id)->first();
    @endphp
    @can('update_bill',$klass)
    <div class="px-4 mb-5">
        <a href="{{ route('bill.edit', $bills->id)}}" class="btn btn-outline-primary btn-block">
            <i class="fas">Edit</i>
        </a>
        <a href="{{ route('bill.destroy', $bills->id) }}" class="btn btn-outline-danger btn-block" id="delete"
            name="delete" data-toggle="delete">
            <i class="fas">Hapus</i>
        </a>
    </div>
    @endcan

    <h3 class="small text-uppercase mb-3 pl-4 font-weight-bold text-muted">Daftar Anggota</h3>
    <ol class="member-list list-unstyled">

        @php
        $users = Auth::user();
        @endphp

        @foreach ($klass->users as $user)
        <li class="member-item d-flex py-3">
            <div class="number px-4">{{ $loop->iteration }}</div>
            <div class="user flex-grow-1 d-flex flex-column">
                <div class="name d-flex">
                    {{ $user->name }}
                    @forelse($paid_bills as $paid_bill)
                    @empty
                    @endforelse
                    @php
                    $selected = PaidBill::where(['user_npm' => $user->npm, 'bill_id'=> $bills->id])
                    ->exists();
                    $selecteda = PaidBill::where(['user_npm' => $user->npm, 'bill_id'=> $bills->id])
                    ->first();
                    @endphp
                    @if (!$selected)

                    @if ($users->cant('update_bill',$klass))
                    <span class="badge rounded-0 badge-danger ml-auto d-flex align-items-center mr-4">Belum Lunas</span>
                    @else
                    <a href="{{ route('bill.paid', ['id' => $bills->id, 'npm' => $user->npm]) }}"
                        class="badge rounded-0 badge-danger ml-auto d-flex align-items-center mr-4">Belum Lunas</a>
                    @endif
                    @elseif($selected)
                    @if ($users->cant('update_bill',$klass))
                    <span class="badge rounded-0 badge-success ml-auto d-flex align-items-center mr-4">Lunas</span>
                    @else
                    <a href="{{ route('bill.unpaid', ['paid_id'=>$selecteda->id,'bill_id' => $bills->id, 'npm' => $user->npm]) }}"
                        class="badge rounded-0 badge-success ml-auto d-flex align-items-center mr-4">Lunas</a>
                    @endif
                    @endif

                </div>
                <small class="npm">
                    ({{ $user->npm }})
                </small>
                <div class="role">
                    @if ($user->npm == Auth::user()->npm)
                    <span class="badge badge-pill badge-warning">
                        Anda
                    </span>
                    @endif
                </div>
            </div>
        </li>
        @endforeach
    </ol>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Daftar Tugas')

@section('content')
    <div class="px-4 mt-5">
        @if ($tasks->count() > 0)
            <div class="history-tl-container mt-3">
                <ul class="tl">
                    @foreach ($tasks as $task)
                        @php
                            $dt = \Carbon\Carbon::parse($task->deadline)->locale('id');
                        @endphp
                        <li class="tl-item {{ $dt->isToday() ? 'active' : '' }} pr-3">
                            <div class="timestamp">
                                {{ $dt->diffForHumans() }}
                                <br>
                                <br>
                                {{ $dt->isoFormat('Do MMMM') }} <i class="fas fa-fw fa-calendar-alt ml-1"></i>
                                <br>
                                {{ $dt->isoFormat('hh:mm:ss') }} <i class="fas fa-fw fa-clock ml-1"></i>
                            </div>
                            <h2 class="item-title h5">
                                <b>{{ $task->name }}</b>
                            </h2>
                            <span class="badge badge-pill badge-dark text-white mb-3">
                                <i class="fas fa-book mr-1"></i> {{ $task->subject->name }}
                            </span>
                            <div class="item-detail small">{!! \App\XSS::clean(nl2br($task->description)) !!}</div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
        @endif
    </div>
@endsection

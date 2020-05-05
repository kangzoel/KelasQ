@extends('layouts.app')

@section('title', 'Jadwal Kelas')

@section('content')
    <div class="px-4 pt-4">
        <x-alert></x-alert>
    </div>
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-5">
            @foreach ($schedules as $schedule)
                <div class="col mb-4">
                    <div class="card text-center" style="max-width: 18rem;">
                        <div class="card-header font-weight-bold text-white bg-success">
                            @switch($schedule->day_of_week)
                                @case('1')
                                    {{ 'Senin' }}
                                    @break
                                @case('2')
                                    {{ 'Selasa' }}
                                    @break
                                @case('3')
                                    {{ 'Rabu' }}
                                    @break
                                @case('4')
                                    {{ 'Kamis' }}
                                    @break
                                @case('5')
                                    {{ 'Jumat' }}
                                    @break
                                @case('6')
                                    {{ 'Sabtu' }}
                                    @break
                                @case('7')
                                    {{ 'Minggu' }}
                                    @break
                                @default
                                    {{ 'Tidak Terdeteksi' }}
                                    @break
                            @endswitch
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">{{ $schedule->name }}</h5>
                            <p class="card-text">{{ $schedule->lecturer }}</p>
                            <p class="card-text font-weight-bold">{{ $schedule->start }} - {{ $schedule->end }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
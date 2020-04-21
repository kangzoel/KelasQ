@php
    use \Carbon\Carbon;
@endphp

@extends('layouts.klass')

@section('title', 'Tugas kelas')

@section('content')
    <div class="px-4 pt-4">
        <x-alert></x-alert>
    </div>
    <div class="history-tl-container mt-3">
        <ul class="tl">
            @foreach ($tasks as $task)
                @php
                    $dt = Carbon::parse($task->deadline)->locale('id');
                @endphp
                <li class="tl-item {{ $dt->isToday() ? 'active' : '' }} pr-3">
                    <div class="timestamp">
                        {{ $dt->diffForHumans() }}
                        <br>
                        <br>
                        {{ $dt->isoFormat('Do MMMM') }} <i class="fas fa-fw fa-calendar-alt ml-1"></i>
                        <br>
                        {{ $dt->isoFormat('hh:mm:ss') }} <i class="fas fa-fw fa-clock ml-1"></i>

                        @can('update', $task)
                            <div class="action-buttons mt-4">
                                <a href="{{ route('task.edit', ['id' => $task->id]) }}" class="btn btn-sm btn-secondary mb-3">Edit</a>
                                <form action="{{ route('task.destroy', ['id' => $task->id]) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn btn-sm btn-danger btn-delete">Hapus</button>
                                </form>
                            </div>
                        @endcan
                        <div class="clearfix"></div>
                    </div>
                    <h2 class="item-title h5">
                        <b>{{ $task->name }}</b>
                    </h2>
                    <div class="item-detail small">{!! \App\XSS::clean(nl2br($task->description)) !!}</div>
                </li>
            @endforeach
        </ul>
    </div>

    @can('create_task', $klass)
        <a href="{{ route('task.create', $klass->code) }}" class="fab btn btn-primary">
            <i class="fas fa-plus"></i>
        </a>
    @endcan
@endsection

@push('styles')
    <style>
        .history-tl-container {
            display:block;
            position:relative;
            line-height: 1.5em
        }
        .history-tl-container ul.tl {
            margin:20px 0;
            padding:0;
            display:inline-block;
        }
        .history-tl-container ul.tl li {
            list-style: none;
            margin:auto;
            margin-left:190px;
            min-height: 260px;
            /*background: rgba(255,255,0,0.1);*/
            border-left:1px dashed #86D6FF;
            padding:0 0 50px 30px;
            position:relative;
        }
        .history-tl-container ul.tl li:last-child{ border-left:0;}
        .history-tl-container ul.tl li::before {
            position: absolute;
            left: -10px;
            content: " ";
            border: 8px solid rgba(255, 255, 255, 0.74);
            border-radius: 500%;
            background: #258CC7;
            height: 20px;
            width: 20px;
            transition: all 500ms ease-in-out;

        }
        .history-tl-container ul.tl li.active::before {
            border-color:  #258CC7;
            transition: all 1000ms ease-in-out;
        }
        ul.tl li .item-title {
        }
        ul.tl li .item-detail {
            color: #444;
            font-size: .9em
        }
        ul.tl li .timestamp {
            color: #4a4a4a;
            position: absolute;
            width:150px;
            left: -182px;
            text-align: right;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $('.btn-delete').click(function() {
            if (confirm("Apakah Anda yakin ingin menghapus tugas ini?")) {
                $(this).parents('form').submit();
            }
        })
    </script>
@endpush

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

    @can('create_task', $klass)
        <a href="{{ route('task.create', $klass->code) }}" class="fab btn btn-primary">
            <i class="fas fa-plus"></i>
        </a>
    @endcan
@endsection

@push('scripts')
    <script>
        $('.btn-delete').click(function() {
            if (confirm("Apakah Anda yakin ingin menghapus tugas ini?")) {
                $(this).parents('form').submit();
            }
        })
    </script>
@endpush

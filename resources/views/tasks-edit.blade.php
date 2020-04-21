@extends('layouts.klass')

@section('title', 'Edit tugas')

@section('content')
    <form action="{{ route('task.update', ['id' => $task->id]) }}" method="POST" class="py-4 px-4">
        @csrf
        @method('put')
        <div class="form-group">
            <label for="name">Nama Tugas</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') ?: $task->name }}" autofocus autocomplete="off">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="subject_id">Mata Kuliah</label>
            <select class="form-control" name="subject_id" id="subject_id">
                @foreach ($task->subject->klass->subjects as $subject)
                    @php
                        $selected = false;

                        if (old('subject_id') == $subject->id) {
                            $selected = true;
                        } else {
                            $selected = $task->subject->id == $subject->id;
                        }
                    @endphp
                    <option value="{{ $subject->id }}" {{ $selected ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
            @error('subject_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="deadline_date">Deadline</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <button type="button" class="btn btn-outline-secondary docs-datepicker-trigger" disabled>
                        <i class="fas fa-calendar"></i>
                    </button>
                </div>
                <input data-toggle="datepicker" class="form-control @error('deadline_date') is-invalid @enderror" name="deadline_date" id="deadline" value="{{ old('deadline_date') ?: explode(' ', $task->deadline)[0] }}" autofocus placeholder="Tanggal" autocomplete="off">
            </div>

            @error('deadline_date')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-prepend">
                    <button type="button" class="btn btn-outline-secondary docs-datepicker-trigger" disabled>
                        <i class="fas fa-clock"></i>
                    </button>
                </div>
                <input type="text" class="form-control @error('deadline_time') is-invalid @enderror" name="deadline_time" id="deadline" value="{{ old('deadline_time') ?: explode(' ', $task->deadline)[1] }}" autofocus placeholder="JJ:MM:DD" autocomplete="off">
            </div>
            @error('deadline_time')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3">{{ old('description') ?: $task->description }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="text-right mt-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        $('[data-toggle="datepicker"]').datepicker({
            format: 'yyyy-mm-dd',
            autoHide: true,
            highlightedClass: null,
            filter: function(date, view) {
                let dt = date;
                dt.setDate(dt.getDate() + 1);

                if (dt < new Date()) {
                    return false;
                }
            }
        }).on('pick.datepicker', function (e) {
            let dt = new Date()

            dt.setHours('00','00','00')

            e.date.setDate(e.date.getDate() + 1);

            if (e.date < dt) {
                $(e.target).val('');
                e.preventDefault()
            }

            e.date.setDate(e.date.getDate() - 1)
        });

    </script>
@endpush

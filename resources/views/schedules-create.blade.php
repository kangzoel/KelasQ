@extends('layouts.klass')

@section('title', 'Buat Jadwal')

@section('content')
    <form action="{{ route('klass.schedules_store', ['klass_id' => $klass->id]) }}" method="POST" class="py-4 px-4">
        @csrf
        <div class="form-group">
            <label for="name">Nama Mata Kuliah</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" autofocus autocomplete="off">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="lecturer">Nama Dosen</label>
            <input type="text" class="form-control @error('lecturer') is-invalid @enderror" name="lecturer" id="lecturer" value="{{ old('lecturer') }}" autofocus autocomplete="off">
            @error('lecturer')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="day">Hari</label>
            <select class="form-control" name="day" id="day">
                @if (old('day') == NULL)
                    <option value="" selected disabled>Pilih hari</option>
                @endif
                @for ($i = 1; $i <= 7; $i++)
                    <option value="{{ $i }}" {{ old('day') == $i ? 'selected' : '' }}>
                        @switch($i)
                                @case(1)
                                    {{ 'Senin' }}
                                    @break
                                @case(2)
                                    {{ 'Selasa' }}
                                    @break
                                @case(3)
                                    {{ 'Rabu' }}
                                    @break
                                @case(4)
                                    {{ 'Kamis' }}
                                    @break
                                @case(5)
                                    {{ 'Jumat' }}
                                    @break
                                @case(6)
                                    {{ 'Sabtu' }}
                                    @break
                                @case(7)
                                    {{ 'Minggu' }}
                                    @break
                                @default
                                    {{ 'Tidak Terdeteksi' }}
                                    @break
                            @endswitch
                    </option>
                @endfor
            </select>
            @error('day')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="start">Jam Mulai</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-outline-secondary docs-datepicker-trigger" disabled>
                            <i class="fas fa-clock"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control @error('start') is-invalid @enderror" name="start" id="start" value="{{ old('start') }}" autofocus placeholder="JJ:MM:DD" autocomplete="off">
                </div>
            @error('start')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="end">Jam Selesai</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-outline-secondary docs-datepicker-trigger" disabled>
                            <i class="fas fa-clock"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control @error('end') is-invalid @enderror" name="end" id="end" value="{{ old('end') }}" autofocus placeholder="JJ:MM:DD" autocomplete="off">
                </div>
            @error('end')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="text-right mt-4">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
@endsection
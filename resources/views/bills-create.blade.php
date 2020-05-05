@extends('layouts.klass')

@section('title','Buat Tagihan')

@section('content')
<form action="{{ route('bill.store', ['klass_code' => $klass->code]) }}" method="POST" class="py-4 px-4">
    @csrf
    <div class="form-group">
        <label for="name">Nama Tagihan</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
            value="{{ old('name') }}" autofocus autocomplete="off">
        @error('name')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group">
        <label for="subject_id">Mata Kuliah</label>
        <select class="form-control" name="subject_id" id="subject_id">
            @if (old('subject_id') == NULL)
            <option value="">Pilih mata kuliah</option>
            @endif
            @foreach (\App\Subject::where('klass_id', $klass->id)->get() as $subject)
            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                {{ $subject->name }}
            </option>
            @endforeach
        </select>
        @error('subject_id')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group">
        <label for="amount">Besar Tagihan</label>
        <input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount"
            value="{{ old('amount') }}" autofocus autocomplete="off">
        @error('amount')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="text-right mt-4">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>

</form>

@endsection

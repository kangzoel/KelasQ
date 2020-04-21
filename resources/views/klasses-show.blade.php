@php
    use App\Role;
    use App\UserKlass;
    use App\Subject;
    use App\UserSubject;
@endphp

@extends('layouts.klass')

@section('title', "Kelas $klass->name")

@section('content')
    <div class="pt-4">
        <div class="px-4 mb-3">
            <x-alert :class="'mb-5'"></x-alert>
            <h3 class="small text-uppercase mb-3 font-weight-bold text-muted ">Kode Kelas</h3>
            <div class="input-group mb-3">
                <input type="text" class="form-control" value="{{ strtoupper($klass->code) }}" id="code" readonly title="Dicopy" data-placement="bottom">
                <div class="input-group-append">
                    <button class="btn btn-dark" type="button" data-clipboard-target="#code">Copy</button>
                </div>
            </div>
        </div>

        @can('update', $klass)
            <div class="px-4 mb-5">
                <h3 class="small text-uppercase mb-3 font-weight-bold text-muted ">Peran calon anggota</h3>
                <form action="{{ route('klass.set_default_role', ['code' => $klass->code]) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <select class="form-control" name="default_member_role_id" id="default_member_role_id">
                            @foreach (Role::all() as $role)
                                <option value="{{ $role->id }}" {{ $klass->default_member_role_id == $role->id ? 'selected' : '' }}>
                                    @switch($role->name)
                                        @case('admin')
                                            Ketua
                                            @break
                                        @case('secretary')
                                            Sekretaris
                                            @break
                                        @case('treasurer')
                                            Bendahara
                                            @break
                                        @default
                                            Anggota Biasa
                                    @endswitch
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        @endcan

        @if ($klass->description)
            <div class="px-4 mb-5">
                <h3 class="small text-uppercase mb-3 font-weight-bold text-muted">Deskripsi</h3>
                <p class="description">
                    {!! \App\XSS::clean($klass->description) !!}
                </p>
            </div>
        @endif

        <div class="px-4 mb-5">
            <h3 class="small text-uppercase mb-3 font-weight-bold text-muted">Ikuti Mata Kuliah</h3>
            <form action="{{ route('klass.follow_subject', ['id' => $klass->id]) }}" method="post">
                @csrf
                <div class="form-group">
                    <div class="input-group mb-3">
                        <select class="form-control select2 @error('subject_id') is-invalid @enderror" name="subject_id[]" id="subject_id" multiple="multiple" data-placeholder="Pilih mata kuliah">
                            @foreach (Subject::where('klass_id', $klass->id)->get() as $subject)
                                @php
                                    $selected = UserSubject::where([
                                        'user_npm' => Auth::user()->npm,
                                        'subject_id' => $subject->id
                                    ])->exists();

                                    if (old('subject_id')) {
                                        $selected = in_array($subject->id, old('subject_id'));
                                    }
                                @endphp
                                <option value="{{ $subject->id }}" {{ $selected ? 'selected' : '' }} >{{ $subject->name }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="px-4 mb-5">
            <form action="{{ route('klass.out', ['id' => $klass->id]) }}" method="POST" class="mb-2">
                @csrf
                <input type="hidden" name="klass_id" value="{{ $klass->id }}">
                <button type="button" class="btn btn-outline-danger btn-block" id="out">Keluar Kelas</button>
            </form>
            @can('update', $klass)
                <form action="{{ route('klass.destroy', ['id' => $klass->id]) }}" method="POST">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="klass_id" value="{{ $klass->id }}">
                    <button type="button" class="btn btn-danger btn-block" id="delete">Hapus Kelas</button>
                </form>
            @endcan
        </div>

        <h3 class="small text-uppercase mb-3 pl-4 font-weight-bold text-muted">Daftar Anggota</h3>
        <ol class="member-list list-unstyled">
            @foreach ($klass->users as $user)
                <li class="member-item d-flex py-3">
                    <div class="number px-4">{{ $loop->iteration }}</div>
                    <div class="user flex-grow-1 d-flex flex-column">
                        <div class="name d-flex">
                            {{ $user->name }}
                            @if ($user->npm == Auth::user()->npm)
                                <span class="badge rounded-0 badge-primary ml-auto d-flex align-items-center mr-4">Anda</span>
                            @else
                                @can('update', $klass)
                                    <div class="btn-group ml-auto">
                                        <button class="btn btn-sm btn-outline-dark dropdown-toggle mr-4" type="button" id="manage-user-{{ $user->npm }}"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="manage-user-{{ $user->npm }}" style="z-index: 1031">
                                            <button class="dropdown-item change-role"
                                                data-toggle="modal"
                                                data-target="#changeRole"
                                                data-role_id="{{ UserKlass::where(['user_npm' => $user->npm, 'klass_id' => $klass->id])->first()->role_id }}"
                                                data-name="{{ $user->name }}"
                                                data-user_npm="{{ $user->npm }}">
                                                <i class="fas fa-fw mr-1 fa-hat-wizard"></i>
                                                Ubah Peran
                                            </button>
                                            <form action="{{ route('klass.kick', ['code' => $klass->code]) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="user_npm" value="{{ $user->npm }}">
                                                <input type="hidden" name="klass_id" value="{{ $klass->id }}">
                                                <button type="button" class="dropdown-item kick" data-name="{{ $user->name }}">
                                                    <i class="fas fa-fw mr-1 fa-times"></i>
                                                    Keluarkan
                                                </button>
                                            </form>
                                            <form action="{{ route('klass.ban', ['code' => $klass->code]) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="user_npm" value="{{ $user->npm }}">
                                                <input type="hidden" name="klass_id" value="{{ $klass->id }}">
                                                <button type="button" class="dropdown-item ban" data-name="{{ $user->name }}">
                                                    <i class="fas fa-fw mr-1 fa-ban"></i>
                                                    Keluarkan dan Blokir
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endcan
                            @endif
                        </div>
                        <small class="npm">
                            ({{ $user->npm }})
                        </small>
                        <div class="role">
                            @php
                                $user_role = Role::find(UserKlass::where(['user_npm' =>  $user->npm, 'klass_id' => $klass->id])->first()->role_id)->name;
                            @endphp
                            <span class="badge badge-pill badge-warning">
                                @switch($user_role)
                                    @case('admin')
                                        Ketua
                                        @break
                                    @case('secretary')
                                        Sekretaris
                                        @break
                                    @case('treasurer')
                                        Bendahara
                                        @break
                                    @default
                                        Anggota Biasa
                                @endswitch
                            </span>
                        </div>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>

    <!-- Modal -->
    <form action="{{ route('klass.change_role', ['code' => $klass->code]) }}" method="POST" class="modal fade" id="changeRole" tabindex="-1" role="dialog" aria-labelledby="changeRole" aria-hidden="true">
        @csrf
        @method('put')
        <input type="hidden" name="user_npm" id="user_npm">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Peran <span id="name"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="role_id">Peran Baru</label>
                        <select class="form-control" name="role_id" id="role_id">
                            @foreach (Role::all() as $role)
                                <option value="{{ $role->id }}">
                                    @switch($role->name)
                                        @case('admin')
                                            Ketua
                                            @break
                                        @case('secretary')
                                            Sekretaris
                                            @break
                                        @case('treasurer')
                                            Bendahara
                                            @break
                                        @default
                                            Anggota Biasa
                                    @endswitch
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('js/clipboard.min.js') }}"></script>
    <script>
        $('.kick').click(function() {
            if (confirm('Apakah Anda yakin ingin mengeluarkan ' + $(this).data('name') + ' dari kelas ini?')) {
                $(this).parent().submit()
            }
        })

        $('.ban').click(function() {
            if (confirm('Apakah Anda yakin ingin memblokir ' + $(this).data('name') + ' dari kelas ini?')) {
                $(this).parent().submit()
            }
        })

        $('#changeRole').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget)
            let user_npm = button.data('user_npm')
            let role_id = button.data('role_id')
            let name = button.data('name')

            $(this).find('#user_npm').val(user_npm)
            $(this).find('#role_id').val(role_id)
            $(this).find('#name').text(name)
        })

        $('#default_member_role_id').change(function() {
            $(this).parents('form').submit()
        })

        let clipboard = new ClipboardJS('.btn')

        clipboard.on('success', function(e) {
            const target = $('#code');

            target.tooltip('show', { placement: 'bottom' })

            setTimeout(() => { target.tooltip('hide') }, 1000);
        });

    </script>
@endpush

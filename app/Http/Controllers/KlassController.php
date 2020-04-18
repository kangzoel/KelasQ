<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserKlass;
use App\Klass;
use App\KlassBlock;
use Illuminate\Http\Response;

class KlassController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $data = [
            'klasses' => $user->klasses
        ];

        return view('klasses', $data);
    }

    public function create()
    {
        return view('klasses-create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:1|max:65530',
            'description' => 'max:65530',
            'default_member_role_id' => 'required|integer|min:1|max:4',
        ]);

        $klass = new Klass;
        $code = $this->generateRandomCode(); // random 10000 to zzzzzzzzz
        while(Klass::where('code', $code)->exists()) {
            $code = $this->generateRandomCode();
        }
        $klass->code = $code;
        $klass->name = $validatedData['name'];
        $klass->description = $validatedData['description'];
        $klass->default_member_role_id = $validatedData['default_member_role_id'];
        $klass->save();

        UserKlass::create([
            'user_npm' => Auth::user()->npm,
            'klass_id' => $klass->id,
            'role_id' => 1
        ]);

        return redirect('classes/' . $klass->code)->with('message', [
            'type' => 'success',
            'content' => 'Kelas berhasil dibuat.'
        ]);
    }

    private function generateRandomCode() {
        return base_convert(rand(1679616, 101559956668415), 10, 36);
    }

    public function join(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:klasses,code'
        ]);

        $user = Auth::user();
        $klass = Klass::where('code', $request->input('code'))->first();

        if ($user->cant('join', $klass))
            return redirect(route('klass'))->with('message', [
                'type' => 'danger',
                'content' => 'Anda telah diblokir dari kelas ini.'
            ]);

        if (!UserKlass::where(['user_npm' => $user->npm,'klass_id' => $klass->id,])->exists())
            UserKlass::create(['user_npm' => $user->npm,
                'klass_id' => $klass->id,
                'role_id' => $klass->default_member_role_id
            ]);

        return redirect('classes/' . $klass->code)->with('message', [
            'type' => 'success',
            'content' => 'Anda berhasil bergabung dengan kelas ini.'
        ]);
    }

    public function out($id)
    {
        $user = Auth::user();
        $klass = Klass::find($id);

        UserKlass::where(['user_npm' => $user->npm, 'klass_id' => $id])->delete();
        if (UserKlass::where(['klass_id' => $id])->count() == 0) {
            Klass::find($id)->delete();
        }

        return redirect(route('klass'))->with('message', [
            'type' => 'success',
            'content' => "Anda berhasil keluar dari kelas $klass->name."
        ]);
    }

    public function show($code)
    {
        $user = Auth::user();
        $klass = Klass::where('code', $code)->first();

        if ($user->cant('view', $klass)) abort(404);

        return view('klasses-show', ['klass' => $klass]);
    }

    public function set_default_role($code, Request $request)
    {
        $validatedData = $request->validate([
            'default_member_role_id' => 'required|exists:roles,id',
        ]);

        $user = Auth::user();
        $klass = Klass::where('code', $code)->first();

        if ($user->cant('update', $klass))
            return abort(403);

        Klass::where('code', $code)->update([
            'default_member_role_id' => $validatedData['default_member_role_id']
        ]);

        return redirect(route('klass.show', ['code' => $code]))->with('message', [
            'type' => 'success',
            'content' => 'Peran calon anggota berhasil diubah'
        ]);
    }

    public function change_role($code, Request $request)
    {
        $validatedData = $request->validate([
            'user_npm' => 'required|exists:users,npm',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = Auth::user();
        $klass = Klass::where('code', $code)->first();

        if ($user->cant('update', $klass))
            return abort(403);

        UserKlass::where(['user_npm' => $validatedData['user_npm'],'klass_id' => $klass->id])
            ->update(['role_id' => $validatedData['role_id']]);

        return redirect(route('klass.show', ['code' => $code]))->with('message', [
            'type' => 'success',
            'content' => 'Peran anggota berhasil diubah'
        ]);
    }

    public function kick($code, Request $request)
    {
        $validatedData = $request->validate([
            'user_npm' => 'required|exists:users,npm',
        ]);

        $user = Auth::user();
        $klass = Klass::where('code', $code)->first();

        if ($user->cant('update', $klass))
            return abort(403);

        UserKlass::where(['klass_id' => $klass->id, 'user_npm' => $validatedData['user_npm']])
            ->delete();

        return redirect(route('klass.show', ['code' => $code]))->with('message', [
            'type' => 'success',
            'content' => 'Anggota berhasil dikeluarkan dari kelas ini.'
        ]);
    }

    public function ban($code, Request $request)
    {
        $validatedData = $request->validate([
            'user_npm' => 'required|exists:users,npm',
        ]);

        $user = Auth::user();
        $klass = Klass::where('code', $code)->first();

        if ($user->cant('update', $klass))
            return abort(403);

        UserKlass::where(['klass_id' => $klass->id, 'user_npm' => $validatedData['user_npm']])
            ->delete();

        KlassBlock::create(['klass_id' => $klass->id, 'user_npm' => $validatedData['user_npm']]);

        return redirect(route('klass.show', ['code' => $code]))->with('message', [
            'type' => 'success',
            'content' => 'Anggota berhasil diblokir dari kelas ini.'
        ]);
    }

    public function edit($code)
    {
        $klass = Klass::where('code', $code)->first();

        return view('klasses-edit', ['klass' => $klass]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:1|max:65530',
            'description' => 'max:65530',
            'default_member_role_id' => 'required|integer|min:1|max:4',
        ]);

        $user = Auth::user();
        $klass = Klass::find($id);

        if ($user->cant('update', $klass)) return abort(403);

        $klass->name = $validatedData['name'];
        $klass->description = $validatedData['description'];
        $klass->default_member_role_id = $validatedData['default_member_role_id'];
        $klass->save();

        return redirect('classes/' . $klass->code)->with('message', [
            'type' => 'success',
            'content' => 'Informasi kelas berhasil diubah.'
        ]);
    }

    public function destroy($id)
    {
        //
    }
}

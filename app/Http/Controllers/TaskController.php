<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Klass;
use App\Subject;
use App\Task;

class TaskController extends Controller
{
    public function index()
    {
        return view('tasks');
    }

    public function create($klass_code)
    {
        $user = Auth::user();
        $klass = Klass::where('code', $klass_code)->first();

        if ($user->cant('create_task', $klass)) abort(403);

        return view('tasks-create', ['klass' => $klass]);
    }

    public function store($klass_id, Request $request)
    {
        $v = $request->validate([
            'name' => 'required',
            'subject_id' => 'required|exists:subjects,id',
            'description' => 'required',
            'deadline_date' => 'required|date',
            'deadline_time' => ['required', 'regex:/^([01]?[1-9]|[12][0-3]|00):([01]?[1-9]|[1-5][0-9]|[1-9]|00):([01]?[1-9]|[1-5][0-9]|[1-9]|00)$/'],
        ]);

        $user = Auth::user();
        $klass = Klass::find($klass_id)->first();

        if ($user->cant('create_task', $klass)) abort(403);

        $task = new Task();
        $task->name = $v['name'];
        $task->subject_id = $v['subject_id'];
        $task->description = $v['description'];
        $task->deadline = $v['deadline_date'] . ' ' . $v['deadline_time'];
        $task->save();

        return redirect(route('task.show', ['klass_code' => $klass->code]))->with('message', [
            'type' => 'success',
            'content' => 'Tugas berhasil dibuat'
        ]);
    }

    public function show($klass_code)
    {
        $klass = Klass::where('code', $klass_code)->first();

        if ($klass == NULL) abort(404);

        $tasks = Task::join('subjects', 'tasks.subject_id','subjects.id')
            ->select('tasks.*')
            ->orderBy('deadline', 'asc')
            ->get();

        return view('tasks-show', ['tasks' => $tasks, 'klass' => $klass]);
    }


    public function edit($id)
    {
        $user = Auth::user();
        $task = Task::find($id);
        $klass = $task->subject->klass;

        if ($user->cant('create_task', $klass)) abort(403);

        return view('tasks-edit', [
            'klass' => $klass,
            'task' => $task
        ]);
    }

    public function update(Request $request, $id)
    {
        $v = $request->validate([
            'name' => 'required',
            'subject_id' => 'required|exists:subjects,id',
            'description' => 'required',
            'deadline_date' => 'required|date',
            'deadline_time' => ['required', 'regex:/^([01]?[1-9]|[12][0-3]|00):([01]?[1-9]|[1-5][0-9]|[1-9]|00):([01]?[1-9]|[1-5][0-9]|[1-9]|00)$/'],
        ]);

        $user = Auth::user();
        $task = Task::find($id);
        $klass = Klass::find($task->subject->klass)->first();

        if ($user->cant('create_task', $klass)) abort(403);

        $task->name = $v['name'];
        $task->subject_id = $v['subject_id'];
        $task->description = $v['description'];
        $task->deadline = $v['deadline_date'] . ' ' . $v['deadline_time'];
        $task->save();


        return redirect(route('task.show', ['klass_code' => $klass->code]))->with('message', [
            'type' => 'success',
            'content' => 'Tugas berhasil diubah'
        ]);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $task = Task::find($id);

        if ($user->cant('update', $task)) abort(403);

        try {
            $task->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }

        return redirect(route('task.show', ['klass_code' => $task->subject->klass->code]))
            ->with('message', [
                'type' => 'success',
                'content' => 'Tugas berhasil dihapus'
            ]);
    }
}

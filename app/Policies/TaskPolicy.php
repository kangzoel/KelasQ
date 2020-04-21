<?php

namespace App\Policies;

use App\Task;
use App\User;
use App\UserKlass;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Task $task)
    {
        return $task->join('subjects', 'tasks.subject_id', 'subjects.id')
            ->join('user_klass', 'subjects.klass_id', 'user_klass.klass_id')
            ->where([
                'user_klass.user_npm' => $user->npm
            ])
            ->whereIn('user_klass.role_id', [1, 2])
            ->exists()
            ? true
            : false;
    }
}

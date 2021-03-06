<?php

namespace App\Policies;

use App\Klass;
use App\User;
use App\UserKlass;
use App\KlassBlock;
use Illuminate\Auth\Access\HandlesAuthorization;

class KlassPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Klass  $klass
     * @return mixed
     */
    public function view(User $user, Klass $klass)
    {
        return (
            !$klass->exists()
            OR !UserKlass::where(['user_npm' => $user->npm, 'klass_id' => $klass->id])->exists()
            OR KlassBlock::where(['user_npm' => $user->npm, 'klass_id' => $klass->id])->exists()
        )
            ? false
            : true;
    }

    /**
     * Determine whether the user can join the model.
     *
     * @param  \App\User  $user
     * @param  \App\Klass  $klass
     * @return mixed
     */
    public function join(User $user, Klass $klass)
    {
        return KlassBlock::where(['user_npm' => $user->npm, 'klass_id' => $klass->id])->exists()
            ? false
            : true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Klass  $klass
     * @return mixed
     */
    public function update(User $user, Klass $klass)
    {
        return UserKlass::where(['user_npm' => $user->npm,'klass_id' => $klass->id, 'role_id' => 1])->exists()
            ? true
            : false;
    }

    public function create_task(User $user, Klass $klass)
    {
        return UserKlass::where([
            'user_npm' => $user->npm,
            'klass_id' => $klass->id,
        ])
            ->whereIn('role_id', [1, 2])
            ->exists()
                ? true
                : false;
    }

    public function schedule_update(User $user, Klass $schedule)
    {
        return $schedule->join('subjects', 'subjects.klass_id', 'klasses.id')
            ->join('user_klass', 'subjects.klass_id', 'user_klass.klass_id')
            ->where([
                'user_klass.user_npm' => $user->npm
            ])
            ->whereIn('user_klass.role_id', [1, 2])
            ->exists()
                ? true
                : false;
    }
    
            
    public function create_bill(User $user, Klass $klass)
    {
        return UserKlass::where([
            'user_npm' => $user->npm,
            'klass_id' => $klass->id
        ])
            ->whereIn('role_id', [1, 3])
            ->exists()
                ? true
                : false;
    }
    
    public function update_bill(User $user, Klass $klass)
    {
        return UserKlass::where(['user_npm' => $user->npm,'klass_id' => $klass->id, 'role_id' => 3])->exists()
            ? true
            : false;
    }
}

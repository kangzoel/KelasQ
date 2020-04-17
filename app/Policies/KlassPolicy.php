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
}

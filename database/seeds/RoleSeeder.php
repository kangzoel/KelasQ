<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    public $roles = [
        'admin', 'secretary', 'treasurer', 'regular_member'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $role_name) {
            $role = new Role;
            $role->name = $role_name;
            $role->save();
        }
    }
}

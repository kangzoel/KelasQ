<?php

use Illuminate\Database\Seeder;
use App\UserKlass;
use App\Role;
use App\Klass;
use App\Subject;
use App\PaidBill;
use App\User;
use App\Task;
use App\Bill;

class KlassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Klass::class)
            ->create()
            ->each(function($klass) {
                // Admin seeder
                $admin = factory(User::class)->create([
                    'email' => 'admin@admin.com'
                ]);

                $admin_klass = new UserKlass;
                $admin_klass->klass_id = $klass->id;
                $admin_klass->user_npm = $admin->npm;
                $admin_klass->role_id = Role::where('name', 'admin')->first()->id;
                $admin_klass->save();

                // Secretary seeder
                $secretary = factory(User::class)->create([
                    'email' => 'secretary@secretary.com'
                ]);
                $secretary_klass = new UserKlass;
                $secretary_klass->klass_id = $klass->id;
                $secretary_klass->user_npm = $secretary->npm;
                $secretary_klass->role_id = Role::where('name', 'secretary')->first()->id;
                $secretary_klass->save();

                // Treasurer seeder
                $treasurer = factory(User::class)->create([
                    'email' => 'treasurer@treasurer.com'
                ]);
                $treasurer_klass = new UserKlass;
                $treasurer_klass->klass_id = $klass->id;
                $treasurer_klass->user_npm = $treasurer->npm;
                $treasurer_klass->role_id = Role::where('name', 'treasurer')->first()->id;
                $treasurer_klass->save();

                // Regular member seeder
                $regular_member = factory(User::class)->create([
                    'email' => 'member@member.com'
                ]);
                $regular_member_klass = new UserKlass;
                $regular_member_klass->klass_id = $klass->id;
                $regular_member_klass->user_npm = $regular_member->npm;
                $regular_member_klass->role_id = Role::where('name', 'regular_member')->first()->id;
                $regular_member_klass->save();

                // Subject seeder
                $subjects = factory(Subject::class, 5)
                    ->create([
                        'klass_id' => $klass->id
                    ])
                    ->each(function($subject) {
                        // Task seeder
                        factory(Task::class, 2)
                            ->create([
                                'subject_id' => $subject->id
                            ]);
                    });

                // Klass bill
                $klass_bill = factory(Bill::class)
                    ->create([
                        'klass_id' => $klass->id,
                    ]);

                // Paid klass bill
                $paid_klass_bill = new PaidBill;
                $paid_klass_bill->bill_id = $klass_bill->id;
                $paid_klass_bill->user_npm = User::inRandomOrder()->first()->npm;
                $paid_klass_bill->save();

                // Subject bill
                $subject_bill = factory(Bill::class)
                    ->create([
                        'klass_id' => $klass->id,
                        'subject_id' => $subjects[1]->id
                    ]);

                // Paid subject bill
                $paid_subject_bill = new PaidBill;
                $paid_subject_bill->bill_id = $subject_bill->id;
                $paid_subject_bill->user_npm = User::inRandomOrder()->first()->npm;
                $paid_subject_bill->save();
            });

        factory(User::class)->create([
            'email' => 'user@user.com'
        ]);
    }
}

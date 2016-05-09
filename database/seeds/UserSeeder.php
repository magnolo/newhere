<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $superAdmin = Role::where('name', 'superadmin')->firstOrFail();

        $user = new User();

        $user->email = "super@admin.at";
        $user->password = Hash::make('admin');
        $user->name = "Administrator";

        $user->save();
        $user->attachRole($superAdmin);
    }
}

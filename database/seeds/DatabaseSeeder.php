<?php

use App\Pain;
use App\Specialty;
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456789'),
        ]);
        $adminType=\App\User_type::create(['role'=>\App\Sd::$adminRole]);
        \App\User_type::create(['role'=>\App\Sd::$doctorRole]);
        \App\User_type::create(['role'=>\App\Sd::$userRole]);
        $admin->update(['type_id'=>$adminType->id]);


        $specialty1= Specialty::create(['name'=>'Dermatology']);
        $specialty2= Specialty::create(['name'=>'ophthalmology']);
        $specialty1->pains()->saveMany([
            new Pain(['description' => 'dermatitis ']),
            new Pain(['description' => 'urticaria']),
        ]);
        $specialty2->pains()->saveMany([
            new Pain(['description' => 'cataract']),
            new Pain(['description' => 'glucoma']),
        ]);
    }
}

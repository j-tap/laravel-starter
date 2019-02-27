<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      =>  'Root',
            'email'     =>  'root@example.com',
            'password'  =>  bcrypt('root'),
			'is_verified' => 1
        ]);
		User::create([
            'name'      =>  'John',
            'email'     =>  'john@example.com',
            'password'  =>  bcrypt('john'),
			'is_verified' => 0
        ]);
    }
}

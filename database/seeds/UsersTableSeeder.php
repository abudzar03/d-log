<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ADMIN USER INITIATION
        $adminUser = [
        	[
        		'name' => 'admin',
        		'email' => 'admin@d-log.dev',
        		'password' => bcrypt('iamthemaster'),
                'alamat' => '',
                'nomor_telepon' => ''
        	]
        ];
        
        foreach ($adminUser as $key => $value) {
        	$createdAdminUser = User::create($value);
        	$adminRole = Role::where('name', '=', 'admin')->first();
        	$createdAdminUser->attachRole($adminRole);
        }
    }
}

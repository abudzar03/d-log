<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ROLES INITIATION
        $roles = [
        	[
        		'name' => 'admin',
        		'display_name' => 'Administrator',
        		'description' => 'Manager of all things.'
        	],
        	[
        		'name' => 'perusahaan',
        		'display_name' => 'Perusahaan',
        		'description' => 'Akun Perusahaan'
        	],
        	[
        		'name' => 'pemilik_gudang',
        		'display_name' => 'Pemilik Gudang',
        		'description' => 'Akun Pemilik Gudang'
        	]
        ];
        
        foreach ($roles as $key => $value) {
        	Role::create($value);
        }
    }
}

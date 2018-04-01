<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // define role
        $roles = [
        	[
        		'name' => 'admin',
        		'display_name' => 'Administration',
        		'description' => 'only one and only admin',
        	],
        	[
        		'name' => 'user',
        		'display_name' => 'Registed User',
        		'description' => 'access for registed user',
        	],
        ];

        foreach ($roles as $key => $value) {
			// check role in database
			$check = Role::where('name', $value['name'])->first();
			if (!is_null($check)) {
				// skip
				continue;
			}
			// save to database
        	Role::create($value);
        }

		// define users
        $users = [
        	[
        		'name' => 'admin1',
        		'email' => 'admin1@local.local',
				'password' => bcrypt('admin1'),
				'role' => 'admin',
        	],
        	[
        		'name' => 'user1',
        		'email' => 'user1@local.local',
				'password' => bcrypt('user1'),
				'role' => 'user'
        	],
        ];
        
		// Save user to database
		foreach ($users as $array) {
			// check user
			$check = User::where('email', $array['email'])->first();
			if (is_null($check)) {
				continue;
			}
			$role = $array['role']; unset($array['role']);
			$user = User::create($array);
			
			// check role in database
			$check = Role::where('name', $role)->first();
			if (!is_null($check)) {
				$user->attachRole($check);
			}
		}
    }
}

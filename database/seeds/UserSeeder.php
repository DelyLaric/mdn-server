<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Repositories\Users;

class UserSeeder extends Seeder
{
	protected $roles = [
		['name' => 'developer'],
		['name' => 'designer'],
		['name' => 'tester'],
		['name' => 'admin']
	];

	protected $users = [
		[
			'name' => 'zhanglan',
			'password' => 'aeoikj',
			'username' => 'zhanglan',
			'roles' => ['developer', 'tester', 'designer']
		]
	];

	public function __construct(Users $userRepo)
	{
		$this->userRepo = $userRepo;
	}

	public function run()
	{
		$this->insertRoles();
		$this->insertUsers();
	}

	public function insertUsers()
	{
		foreach ($this->users as $user) {
			$this->userRepo->createByRoleName($user);
		}
	}

	public function insertRoles()
	{
		$roles = array_map(function ($role) {
			return ['name' => $role['name'], 'is_developing' => true];
		}, $this->roles);

		DB::table('_system.roles')->insert($roles);
	}
}

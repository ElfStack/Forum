<?php
namespace ElfStack\Bbs\Drivers;

use Exception;
use ElfStack\Bbs\Models\User as MUser;

class User extends Driver
{
	public function all()
	{
		return MUser::all();
	}

	public function create(array $attr, $throws = false)
	{
		$user = new MUser;
		foreach ($attr as $key => $value) {
			$user->$key = $value;
		}
		try {
			$user->save();
		} catch (Exception $e) {
			if ($throws) {
				throw new Exception('Invalid attribute passed to create a `User`');
			}
			return false;
		}
		return $user;
	}
}

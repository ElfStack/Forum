<?php
namespace ElfStack\Forum\Drivers;

use Exception;
use ElfStack\Forum\Models\User as MUser;

class User extends Driver
{
	public function __construct(&$forum)
	{
		parent::__construct($forum);
		$this->forum->registerEvent(['login.auth']);
	}

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

		foreach (MUser::requiredAttr as $key) {
			if (!isset($user->$key)) {
				throw new Exception("Attribute `$key` is required when create a new user.");
			}
		}
		$user->encryptPassword();
		$user->save();
		return $user;
	}

	public function login($username, $password)
	{
		if ($this->forum->session('user') !== null) {
			return $this->forum->session('user');
		}
		$result = $this->auth($username, $password);
		if (empty($result)) {
			return false;
		}
		return $this->forum->session('user', $result);
	}

	public function logout()
	{
		$this->forum->session('user', null);
	}

	public function current()
	{
		return $this->forum->session('user');
	}

	public function auth($username, $password)
	{
		$event = $this->forum->trigger('login.auth', [$username, $password]);
		if ($event->overide['override']) {
			return $event->overide['result'];
		}

		if ($user->auth($password)) {
			return $user;
		}
		return false;
	}

	private $current;
	public function __get($key) {
		switch($key)
		{
			case 'current':
				return $this->current();
			default:
				trigger_error('Undefined property: '.$key);
				return null;
		}
	}
}

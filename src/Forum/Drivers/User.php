<?php
namespace ElfStack\Forum\Drivers;

use Exception;
use ElfStack\Forum\Models\User as MUser;
use ElfStack\Forum\Core\Helper;

class User extends Driver
{
	public $forum;
	public function __construct(&$forum)
	{
		parent::__construct($forum);
		$this->forum->registerEvent(['login.auth']);
	}

	public function all()
	{
		return MUser::all()->toArray();
	}

	public function create(array $attr, $throws = true)
	{
		$user = new MUser($attr);
		Helper::ensureCanSave($user, $throws);
		$user->encryptPassword();
		$user->save();
		return $user->toArray();
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
			return $user->toArray();
		}
		return false;
	}

	// 使得使用 current 属性也能完成 current() 函数的功能
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

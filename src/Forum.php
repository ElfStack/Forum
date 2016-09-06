<?php

namespace ElfStack;

use Illuminate\Database\Capsule\Manager as Capsule;
use ElfStack\Event\Manager as EventManager;

/**
 * Forum接口类
 *
 * 控制 Forum 模块执行流程和供其它系统/控制器调用接口的类
 *
 * @package Forum
 * @subpackage Core
 * @category Core
 * @copyright ElfStack Dev Team
 * @author ElfStack Dev Team
 */
class Forum
{
	use EventManager;

	public $capsule;
	public $prefix;
	public function __construct(array $config)
	{
		// Start Session
		if (empty(session_id())) {
			session_start();
		}

		// Set prefix
		$this->prefix = isset($config['prefix']) ? $config['prefix'] : '';
		$config['db']['prefix'] = isset($config['db']['prefix']) ? $config['db']['prefix'] : $this->prefix;

		// Set up database connection and boot Eloquent ORM
		$this->capsule = new Capsule();
		$this->capsule->addConnection($config['db']);
		$this->capsule->setAsGlobal();
		$this->capsule->bootEloquent();

		// Set up drivers
		$drivers = isset($config['drivers']) ? $config['drivers'] : ['User', 'Post', 'Category'];
		foreach ($drivers as $driver) {
			$attr = strtolower($driver);
			$driver = 'ElfStack\Forum\Drivers\\'.$driver;
			$this->{$attr} = new $driver($this);
		}
	}

	public function session($key, $value = '')
	{
		// Value equals '', we return the value of that key
		if ($value === '') {
			return isset($_SESSION['forum'.$this->prefix][$key]) ? $_SESSION['forum'.$this->prefix][$key] : null;
		}
		// Value equals null, we unset that key
		if ($value === null) {
			unset($_SESSION['forum'.$this->prefix][$key]);
			return;
		}
		// Or we will set the value of that key
		return $_SESSION['forum'.$this->prefix][$key] = $value;
	}
}

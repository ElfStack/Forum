<?php

namespace ElfStack;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * ElfBbs接口类
 *
 * 控制 BBS 模块执行流程和供其它系统/控制器调用接口的类
 *
 * @package ElfBbs
 * @subpackage Core
 * @category Core
 * @copyright ElfStack Dev Team
 * @author ElfStack Dev Team
 */
class Bbs
{
	public $capsule;
	public function __construct(array $config)
	{
		// Set up database connection and boot Eloquent ORM
		$this->capsule = new Capsule();
		$this->capsule->addConnection($config['db']);
		$this->capsule->setAsGlobal();
		$this->capsule->bootEloquent();

		// Set up drivers
		$drivers = ['User'];
		foreach ($drivers as $driver) {
			$attr = strtolower($driver);
			$driver = 'ElfStack\Bbs\Drivers\\'.$driver;
			$this->{$attr} = new $driver($this);
		}
	}
}

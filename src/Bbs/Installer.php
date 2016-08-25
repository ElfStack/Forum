<?php
namespace ElfStack\Bbs;

use ElfStack\Bbs;
use ElfStack\Bbs\Models\User;

class Installer
{
	public $bbs;
	public function __construct(array $dbConfig)
	{
		$this->bbs = new Bbs(['db' => $dbConfig]);
	}

	public function setUp()
	{
		$builder = $this->bbs->capsule->schema();
		User::setUpDatabase($builder);
		return $this->bbs;
	}
}

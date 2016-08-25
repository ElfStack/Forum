<?php
namespace ElfStack\Bbs\Drivers;

use ElfStack\Bbs;

class Driver
{
	public function __construct(Bbs &$instance)
	{
		$this->bbs = &$instance;
	}
}

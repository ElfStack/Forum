<?php
namespace ElfStack\Forum\Drivers;

use ElfStack\Forum;

class Driver
{
	public function __construct(Forum &$instance)
	{
		$this->forum = &$instance;
	}
}

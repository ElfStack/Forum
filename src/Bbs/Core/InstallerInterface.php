<?php
namespace ElfStack\Bbs\Core;

use Illuminate\Database\Schema\MySqlBuilder;

interface InstallerInterface
{
	static public function setUpDatabase(MySqlBuilder $builder);
}

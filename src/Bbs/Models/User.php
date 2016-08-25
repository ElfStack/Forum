<?php
namespace ElfStack\Bbs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\MySqlBuilder;
use ElfStack\Bbs\Core\InstallerInterface;

class User extends Model implements InstallerInterface
{
	protected $table = 'user';

	static public function setUpDatabase(MySqlBuilder $builder)
	{
		$builder->dropIfExists('user');
		$builder->create('user', function ($table) {
			$table->increments('id');
			$table->string('username')->unique();
			$table->string('nick')->unique();
			$table->text('password');
			$table->string('email')->unique();
			$table->timestamps();
		});
	}
}

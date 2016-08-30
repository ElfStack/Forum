<?php
namespace ElfStack\Forum\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\MySqlBuilder;
use ElfStack\Forum\Core\InstallerInterface;

class Group extends Model implements InstallerInterface
{
	protected $table = 'group';

	public static const $requiredAttr = ['name', 'privilege'];

	protected $fillable = self::requiredAttr;

	protected $casts = [
		'privilege' => 'array',
		'extra' => 'array'
	];

	static public function setupDatabase(MySqlBuilder $builder)
	{
		$builder->dropIfExists('comment');
		$builder->create('comment', function ($table) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->text('privilege');
			$table->text('extra')->nullable();
			$table->text('_reserved_')->nullable();
			$table->timestamps();
		});
	}

	public function users()
	{
		return $this->hasMany(__NAMESPACE__.'\User', 'groupId');
	}
}

<?php
namespace ElfStack\Forum\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\MySqlBuilder;
use ElfStack\Forum\Core\InstallerInterface;
use ElfStack\Forum\Core\RequiredAttrInterface;

class Group extends Model implements InstallerInterface, RequiredAttrInterface
{
	protected $table = 'group';

	const requiredAttr = ['name', 'privilege'];

	protected $fillable = self::requiredAttr;

	protected $casts = [
		'extra' => 'array'
	];

	public function validateAttr()
	{
		foreach (self::requiredAttr as $key) {
			if (!isset($this->{$key})) {
				return "Key `$key` is required when creating a `Group`.";
			}
		}
		return true;
	}

	static public function setupDatabase(MySqlBuilder $builder)
	{
		$builder->dropIfExists('group');
		$builder->create('group', function ($table) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->text('extra')->nullable();
			$table->text('_reserved_')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function users()
	{
		return $this->hasMany(__NAMESPACE__.'\User', 'groupId');
	}
}

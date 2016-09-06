<?php
namespace ElfStack\Forum\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\MySqlBuilder;
use ElfStack\Forum\Core\InstallerInterface;
use ElfStack\Forum\Core\RequiredAttrInterface;

class Category extends Model implements InstallerInterface, RequiredAttrInterface
{
	protected $table = 'category';

	const requiredAttr = ['title', 'privilege'];

	protected $fillable = self::requiredAttr;

	protected $casts = ['extra' => 'array', 'privilege' => 'array'];

	protected $hidden = ['privilege'];

	public function validateAttr()
	{
		foreach (self::requiredAttr as $key) {
			if (!isset($this->{$key})) {
				return "Key `$key` is required when creating a `Category`.";
			}
		}
		return true;
	}

	static public function setupDatabase(MySqlBuilder $builder)
	{
		$builder->dropIfExists('category');
		$builder->create('category', function ($table) {
			$table->increments('id');
			$table->string('title');
			$table->text('extra')->nullable();
			$table->text('privilege');
			$table->text('_reserved_')->nullable();
			$table->text('_reserved2_')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function posts()
	{
		return $this->hasMany(__NAMESPACE__.'\Post', 'categoryId');
	}
}

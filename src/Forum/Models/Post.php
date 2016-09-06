<?php
namespace ElfStack\Forum\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\MySqlBuilder;
use ElfStack\Forum\Core\InstallerInterface;
use ElfStack\Forum\Core\RequiredAttrInterface;

class Post extends Model implements InstallerInterface, RequiredAttrInterface
{
	protected $table = 'post';

	const requiredAttr = ['title', 'content', 'summary', 'authorId', 'categoryId'];

	protected $fillable = self::requiredAttr;

	protected $casts = [
		'privilege' => 'array'
	];

	public function validateAttr()
	{
		foreach (self::requiredAttr as $key) {
			if (!isset($this->{$key})) {
				return "Key `$key` is required when creating a `Post`.";
			}
		}
		return true;
	}

	static public function setupDatabase(MySqlBuilder $builder)
	{
		$builder->dropIfExists('post');
		$builder->create('post', function ($table) {
			$table->increments('id');
			$table->string('title');
			$table->text('content');
			$table->text('summary');
			$table->integer('authorId')->unsigned();
			$table->integer('categoryId')->unsigned();
			$table->text('privilege')->nullable();
			$table->text('_reserved_')->nullable();
			$table->text('_reserved2_')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function author()
	{
		return $this->belongsTo(__NAMESPACE__.'\User', 'authorId');
	}

	public function category()
	{
		return $this->belongsTo(__NAMESPACE__.'\Category', 'categoryId');
	}
}

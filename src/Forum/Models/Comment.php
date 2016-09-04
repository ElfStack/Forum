<?php
namespace ElfStack\Forum\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\MySqlBuilder;
use ElfStack\Forum\Core\InstallerInterface;

class Comment extends Model implements InstallerInterface
{
	protected $table = 'comment';

	public static const $requiredAttr = ['content', 'authorId', 'postId'];

	protected $fillable = self::requiredAttr;

	public function validateAttr()
	{
		foreach (self::requiredAttr as $key) {
			if (!isset($this->{$key})) {
				return false;
			}
		}
		return true;
	}

	static public function setupDatabase(MySqlBuilder $builder)
	{
		$builder->dropIfExists('comment');
		$builder->create('comment', function ($table) {
			$table->increments('id');
			$table->string('title')->nullable();
			$table->text('content');
			$table->integer('authorId')->unsigned();
			$table->integer('postId')->unsigned();
			$table->text('_reserved_')->nullable();
			$table->text('_reserved2_')->nullable();
			$table->timestamps();
		});
	}

	public function author()
	{
		return $this->belongsTo(__NAMESPACE__.'\User', 'authorId');
	}

	public function post()
	{
		return $this->belongsTo(__NAMESPACE__.'\Post', 'postId');
	}
}

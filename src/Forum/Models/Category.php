<?php
namespace ElfStack\Forum\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\MySqlBuilder;
use ElfStack\Forum\Core\InstallerInterface;

class Category extends Model implements InstallerInterface
{
	protected $table = 'category';

	public static const $requiredAttr = ['content', 'authorId', 'postId'];

	protected $fillable = self::requiredAttr;

	protected $casts = ['extra' => 'array'];

	static public function setupDatabase(MySqlBuilder $builder)
	{
		$builder->dropIfExists('category');
		$builder->create('category', function ($table) {
			$table->increments('id');
			$table->string('title');
			$table->text('extra')->nullable();
			$table->integer('level')->default(0);
			$table->text('_reserved_')->nullable();
			$table->text('_reserved2_')->nullable();
			$table->timestamps();
		});
	}

	public function posts()
	{
		return $this->hasMany(__NAMESPACE__.'\Post', 'categoryId');
	}
}

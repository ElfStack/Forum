<?php
namespace ElfStack\Forum;

use ElfStack\Forum;

class Installer
{
	public $forum;
	public function __construct(array $dbConfig)
	{
		$this->forum = new Forum(['db' => $dbConfig]);
	}

	public function setUp()
	{
		$models = ['User', 'Post', 'Comment', 'Category'];
		$builder = $this->forum->capsule->schema();
		foreach ($models as $model) {
			$model = 'ElfStack\Forum\Models\\' . $model;
			$model::setUpDatabase($builder);
		}
		return $this->forum;
	}
}

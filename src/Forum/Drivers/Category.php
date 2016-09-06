<?php
namespace ElfStack\Forum\Drivers;

use ElfStack\Forum\Models\Category as MCategory;
use ElfStack\Forum\Core\Helper;

class Category extends Driver
{
	public function all()
	{
		return MCategory::all();
	}

	public function create(array $attr, $throws = true)
	{
		$category = new MCategory($attr);
		Helper::ensureCanSave($category, $throws);
		$category->save();
		return $category;
	}
}

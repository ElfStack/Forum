<?php
namespace ElfStack\Forum\Drivers;

use ElfStack\Forum\Models\Post as MPost;
use ElfStack\Forum\Core\Helper;

class Post
{
	public $postPerPage = 30;
	public function all()
	{
		return MPost::all()->toArray();
	}

	public function page($page = 1)
	{
		return MPost::forPage($page, $this->postPerPage)->get()->toArray();
	}

	public function create(array $attr, $throws = true)
	{
		$post = new MPost($attr);
		Helper::ensureCanSave($post, $throws);
		$post->save();
		return $post->toArray();
	}
}

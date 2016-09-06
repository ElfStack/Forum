<?php

// 测试时直接从全局中拿取 forum
class Controller
{
	// 临时用的加载视图方法
	// 此接口在实际的 Controller 中可能发生变化
	function loadView($file, $data = [], $statusCode = null, $path = __DIR__.'/../view/')
	{
		extract($data);
		if (!empty($statusCode)) {
			http_response_code($statusCode);
		}
		include($path.$file.'.php');
	}

	public function css($path, $return = false)
	{
		$buf = '<link href="'.$path.'" rel="stylesheet" />';
		if (!$return) {
			echo $buf;
		}
		return $buf;
	}

	public function js($path, $return = false)
	{
		$buf = '<script src="'.$path.'"></script>';
		if (!$return) {
			echo $buf;
		}
		return $buf;
	}

	// ==============================================
	// 以上为测试临时用的方法，实际情况下会使用相同的接口构建一个 Controller类
	// ==============================================
	// 从此往下为该次测试使用的自定义处理请求的方法

	function postList()
	{
		global $forum;
		echo 'postList()<br>';
		var_dump($forum->post->all());
	}

	function postPage($page = 1)
	{
		global $forum;
		echo "postPage($page)<br>";
		var_dump($forum->post->page($page));
	}

	function categoryList()
	{
		global $forum;
		$this->loadView('categoryList', ['data' => $forum->category->all()->toArray()]);
	}

	function createCategory()
	{
		global $forum;
		echo 'createCategory()<br>';
		var_dump($forum->category->create(json_decode(file_get_contents('php://input'), true)));
	}
}

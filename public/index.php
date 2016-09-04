<pre>
<?php
require __DIR__ . '/../vendor/autoload.php';

use ElfStack\Forum;
use ElfStack\Router;

$forum = new Forum(['db' => require __DIR__.'/include/config.php']);

function postList()
{
	global $forum;
	var_dump($forum->post->all());
}

function postPage($n)
{
	var_dump($forum->post->page($n));
}

Router::get('/list', 'postList');
Router::get('/install', function () {
	require 'include/install.php';
});
Router::route('*', function() {echo '404';});

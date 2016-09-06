<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';
// 引入测试用到的模拟 Controller
require 'include/common.php';

use ElfStack\Forum;
use ElfStack\Router;

// 实例化论坛
$forum = new Forum(['db' => require __DIR__.'/include/config.php']);

Router::get('/post/([0-9]+)', 'Controller@postPage');
Router::get('/post', 'Controller@postList');
Router::get('/category', 'Controller@categoryList');
Router::post('/category', 'Controller@createCategory');
Router::get('/install', function () {
	require 'include/install.php';
});
Router::route('*', function() {header('HTTP/1.1 404 Not Found'); echo '404';});

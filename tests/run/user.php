<?php
require __DIR__ . '/../../vendor/autoload.php';

use ElfStack\Unit;
use ElfStack\Forum;

$unit = new Unit();
$unit->start('User Driver Test Group');

$forum = new Forum(['db' => require __DIR__.'/../config.php']);

$unit->assert('Ensure User Driver is load successfully', function () use ($forum) {
	var_dump(get_class($forum->user));
	return $forum->user instanceof ElfStack\Forum\Drivers\User;
});

$unit->assert('Test get all', function () use ($forum) {
	$result = $forum->user->all();
	foreach ($result as $row) {
		foreach (['username', 'nick', 'email', 'password'] as $key) {
			echo "$key => {$row->{$key}} <br>";
		}
		echo '<hr>';
	}
	return true;
});

$unit->assert('Test encrypt', function () use ($forum) {
	$result = $forum->user->all()[0];
	var_dump($result->password);
	$result->encryptPassword();
	var_dump($result->password);
	return true;
});

$unit->assert('Test event', function () use ($forum) {
	var_dump($forum);
});

$unit->printResult();

<?php
require __DIR__ . '/../../vendor/autoload.php';

use ElfStack\Unit;
use ElfStack\Bbs;

$unit = new Unit();
$unit->start('User Driver Test Group');

$bbs = new Bbs(['db' => require __DIR__.'/../config.php']);

$unit->assert('Ensure User Driver is load successfully', function () use ($bbs) {
	var_dump(get_class($bbs->user));
	return $bbs->user instanceof ElfStack\Bbs\Drivers\User;
});

$unit->assert('Test get all', function () use ($bbs) {
	$result = $bbs->user->all();
	foreach ($result as $row) {
		foreach (['username', 'nick', 'email', 'password'] as $key) {
			echo "$key => {$row->{$key}} <br>";
		}
		echo '<hr>';
	}
	return true;
});


$unit->printResult();

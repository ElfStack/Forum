<?php
require __DIR__ . '/../../vendor/autoload.php';

use ElfStack\Unit;
use ElfStack\Forum;
use ElfStack\Forum\Installer;

$unit = new Unit();
$unit->start('Install Tests Group');

$unit->assert('Use Installer to install', function () {
	$installer = new Installer(require __DIR__.'/config.php');
	$installer->setUp();
	return $installer;
}, 'You need to check database manually. I return `Installer` instance here.');

$unit->printResult();

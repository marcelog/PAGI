 <?php
$stub =
'<?php
Phar::mapPhar();
include "phar://PAGI.phar/PAGI/Autoloader/Autoloader.php";
\PAGI\Autoloader\Autoloader::register();
__HALT_COMPILER();
?>';
$phar = new Phar($argv[1]);
$phar->setAlias('PAGI.phar');
$phar->buildFromDirectory($argv[2]);
$phar->setStub($stub);

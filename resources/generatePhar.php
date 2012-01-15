 <?php
$stub =
'<?php
Phar::mapPhar();
include "phar://pagi.phar/PAGI/Autoloader/Autoloader.php";
\PAGI\Autoloader\Autoloader::register();
__HALT_COMPILER();
?>';
$phar = new Phar($argv[1]);
$phar->setAlias('pagi.phar');
$phar->buildFromDirectory($argv[2]);
$phar->setStub($stub);

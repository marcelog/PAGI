 <?php
$stub =
'<?php
Phar::mapPhar();
spl_autoload_register(function ($class) {
    $classFile = "phar://pagi.phar/" . str_replace("\\\", "/", $class) . ".php";
    if (file_exists($classFile)) {
        require_once $classFile;
        return true;
    }
});
include "phar://pagi.phar/PAGI/Autoloader/Autoloader.php";
\PAGI\Autoloader\Autoloader::register();
__HALT_COMPILER();
?>';
$phar = new Phar($argv[1]);
$phar->setAlias('pagi.phar');
$phar->buildFromDirectory($argv[2]);
$phar->setStub($stub);


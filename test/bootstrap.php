<?php
ini_set(
    'include_path',
    implode(
        PATH_SEPARATOR,
        array(
            ini_get('include_path'),
            realpath(implode(
                DIRECTORY_SEPARATOR, array(__DIR__, '..', 'src', 'mg')
            ))
        )
    )
);
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'PAGI/Autoloader/Autoloader.php'; // Include PAGI autoloader.
\PAGI\Autoloader\Autoloader::register(); // Call autoloader register for PAGI autoloader.



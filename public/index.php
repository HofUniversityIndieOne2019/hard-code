<?php
call_user_func(function() {
    $rootDirectory = dirname(__DIR__);
    $GLOBALS['ROOT_DIRECTORY'] = $rootDirectory;
    require($rootDirectory . '/vendor/autoload.php');

    $renderer = new \OliverHader\HardCode\Application\Renderer($rootDirectory);
    $renderer->render();
    $renderer->output();
});
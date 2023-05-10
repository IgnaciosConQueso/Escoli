<?php

require_once __DIR__ . '/includes/config.php';

$app->logout();
$app->redirige($app->resuelve('/index.php'));

?>
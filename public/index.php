<?php
// vendor 放独立文件夹 需要建立DOC_ROOT
define('DOC_ROOT', dirname(__DIR__));

// 框架路径
define('KERNEL_PATH', DOC_ROOT . '/..');

require DOC_ROOT . '/bootstrap/autoload.php';

$app = require_once DOC_ROOT . '/bootstrap/start.php';

$app->run();

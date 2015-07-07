<?php

define('APPLICATION_PATH', dirname(__FILE__));
define('BASE_URL',"http://www.programcat.com/");
define('CACHE_TIME', 3600);

$application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini");

$application->bootstrap()->run();
?>

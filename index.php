<?php
header ( "Content-Type:text/html; charset=utf-8" );
define ( 'DEBUG', true );
// define('APP_NAME','');
require dirname ( __FILE__ ) . '/Ezs/ezs.php';
$ezs=new ezs();
$ezs->run();
//echo '<br>所用时间'.T();
/**测试是否更新*/
<?php
/**
	生成缓存文件,用于生产环境提升性能
 */
	$content='$time = $_SERVER [\'REQUEST_TIME\'];';
    $content.=file_get_contents(EZS_PATH.'/Common/common.php');
    $content.='T($time);';
    $content.="defined('APP_NAME') or define('APP_NAME','');";
    $content.=file_get_contents(CONF_PATH.'/define.php');
    $content.='if(defined(\'DEBUG\')&&DEBUG==true){$content.=file_get_contents(INIT_PATH.\'/createFolder.php\');}';
    $content.='C('.var_export(C(),true).');';
    $content.='date_default_timezone_set(C(\'DEFAULT_TIMEZONE\'));'; 
    $content.='if(C(\'SESSION_AUTO\')==true){ini_set ( "session.cookie_httponly", 1 );session_start ();}';
    $content.=file_get_contents(CORE_PATH.'/Dispatcher.class.php');
    $content.='Dispatcher::app();';
    $content.=file_get_contents(INIT_PATH.'/loadFunction.php');//这个步骤还可以继续优化
    $content.=file_get_contents(CORE_PATH.'/AutoLoad.class.php');
    $content.=file_get_contents(CORE_PATH.'/Controller.class.php');
    $content.='$controller_vo = CONTROLLER_NAME . \'Controller\';';
    $content.='$controller = new $controller_vo ();';
    $content.='$method_name = METHOD_NAME;';
    $content.='if (C ( \'LANG_LIST\' )) {Lang::app ( $controller );}';
    $content.='call_user_func ( array ($controller,METHOD_NAME ) );';
    
    //$content=preg_replace('/\<\?php/','',$content);
    $content=phpStripWhitespace($content);
    //删除php开头
    $content=preg_replace('/\<\?php/','',$content);
    $content='<?php '.$content;
    
    file_put_contents(CACHE_PATH.'/runtime.php',$content);

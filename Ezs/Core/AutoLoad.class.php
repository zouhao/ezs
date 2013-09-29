<?php
/**
 * 自动加载机制 位于框架Core目录下的类可以不用加载直接使用
 * @author ZouHao  zouhao619@gmail.com
 */
/*
class AutoLoad {
	// 自动加载入口
	// @param string $className
	public static function load($className) {
	    //echo '包含了这个类'.$className.'<br>';
		$core=array('Controller','Model','View','Lang','Mysql','Validate','Token');
		$extend=array('CacheModel','RelationModel');
		if (in_array($className,$extend)) {
            $path = EXTEND_PATH;
        }else if(in_array($className,$core)){
            $path = CORE_PATH;
        }else if (substr ( $className, - 10 ) == 'Controller') {
            $path=CONTROLLER_PATH.GROUP_NAME_LEFT;
        }else if (substr ( $className, - 5 ) == 'Model') {
            $path = MODEL_PATH;
        }else{
            $path=CLASS_PATH;
        }
		require_once ( $path . '/' . $className . '.class.php' );
	}
}
// 注册自动加载 用于代替__autoload() 
spl_autoload_register ( array (
		AutoLoad,
		'load' 
) );
*/
/**
 * 自动加载函数
 * @param string $className
 */
function autoLoad($className){
	//echo '包含了这个类'.$className.'<br>';
	$core=array('Controller','Model','View','Lang','Mysql','Validate','Token');
	$extend=array('CacheModel','RelationModel');
	if (in_array($className,$extend)) {
		$path = EXTEND_PATH;
	}else if(in_array($className,$core)){
		$path = CORE_PATH;
	}else if (substr ( $className, - 10 ) == 'Controller') {
		$path=CONTROLLER_PATH.GROUP_NAME_LEFT;
	}else if (substr ( $className, - 5 ) == 'Model') {
		$path = MODEL_PATH;
	}else{
		$path=CLASS_PATH;
	}
	if(file_exists($path . '/' . $className . '.class.php')){
		require_once ( $path . '/' . $className . '.class.php' );
	}else{
		die($path . '/' . $className . '.class.php文件不存在');
	}
}
//自动加载函数注册
spl_autoload_register('autoLoad');
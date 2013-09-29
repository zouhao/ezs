<?php
/**
 * 宏定义文件
 * @author ZouHao  zouhao619@gmail.com
 */
define('EZS_VISION','0.1 bate版本');
define('ROOT_PATH',dirname(dirname(dirname(__FILE__))));
    define('EZS_PATH',ROOT_PATH.'/Ezs');
    	define('COMMON_PATH',EZS_PATH.'/Common');
    	define('CONF_PATH',EZS_PATH.'/Conf');
    	define('CORE_PATH',EZS_PATH.'/Core');
    	define('INIT_PATH',EZS_PATH.'/Init');
    	define('EXTEND_PATH',EZS_PATH.'/Extend');
	
	define('CONTROLLER_PATH',ROOT_PATH.'/Controller'.APP_NAME);
	define('MODEL_PATH',ROOT_PATH.'/Model');
	define('VIEW_PATH',ROOT_PATH.'/View'.APP_NAME);
	define('EXTRA_PATH',ROOT_PATH.'/Extra');
	define('CONFIG_PATH',ROOT_PATH.'/Config');
    	define('CACHE_PATH',EXTRA_PATH.'/Cache');
        	define('CACHE_FILE_PATH',CACHE_PATH.'/File');
            define('CACHE_TPL_PATH',CACHE_PATH.'/Tpl'.APP_NAME);
            define('CACHE_TABLE_PATH',CACHE_PATH.'/Table');
            define('CACHE_EXPORT_PATH',CACHE_PATH.'/Export');
            define('CACHE_HTML_PATH',CACHE_PATH.'/Html');
    	define('FUNCTION_PATH',EXTRA_PATH.'/Function');
    	define('CLASS_PATH',EXTRA_PATH.'/Class');
    	define('LANG_PATH',EXTRA_PATH.'/Lang');
    	define('LIBRARY_PATH',EXTRA_PATH.'/Library');
    define('UPLOAD_PATH',ROOT_PATH.'/Uploads');
	define('CONTENT_PATH',ROOT_PATH.'/Content');
	if(in_array(dirname($_SERVER['SCRIPT_NAME']),array('\\','/'))){
		$root='';
	}else{
		$root=dirname($_SERVER['SCRIPT_NAME']);
	}
	define('__ROOT__',$root);
	define('__APP__',$_SERVER['SCRIPT_NAME']);
	define('__CONTENT__',__ROOT__.'/Content');
	define('__UPLOAD__',__ROOT__.'/Uploads');
	
	//URL模式
	define ( 'URL_COMMON', 1 );
	define ( 'URL_PATHINFO', 2 );
	define ( 'URL_REWRITE', 3 );
	
	define('EZS_VISUAL',0.1);	

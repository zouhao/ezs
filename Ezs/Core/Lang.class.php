<?php
/**
 * 多语言处理类
 * @author ZouHao  zouhao619@gmail.com
 */
class Lang {
	/**
	 * 多语言处理入口
	 * @param Object $controller        	
	 */
	public static function app($controller) {
		is_dir(LANG_PATH) or mkdir ( LANG_PATH,0777,true );
		$currentLang = self::getCurrentLang ();
		$langFile = array (
				LANG_PATH . '/' . $currentLang . '/common.php',
				LANG_PATH . '/' . $currentLang . '/' . strtolower ( CONTROLLER_NAME ) . '.php',
				LANG_PATH . '/' . $currentLang . '/' . strtolower ( CONTROLLER_NAME ) . '/' . strtolower ( METHOD_NAME ) . '.php' 
		);
		$lang = array ();
		foreach ( $langFile as $file ) {
			$fileArray = array ();
			if (file_exists ( $file )) {
				$fileArray = require ($file);
			}
			$lang = array_merge ( $lang, $fileArray );
		}
		empty ( $lang ) or $controller->assign ( C ( 'LANG_GET_VAR' ), $lang );
	}
	/**
	 * 获取当前语言
	 * 如果不存在,则设置当前语言
	 * 
	 * @return string
	 */
	public static function getCurrentLang() {
		static $currentLang = null;
		if (! empty ( $currentLang )) {
			return $currentLang;
		}
		$langList = explode ( ',', C ( 'LANG_LIST' ) );
		if (isset ( $_GET [C ( 'LANG_GET_VAR' )] ) && in_array ( $_GET [C ( 'LANG_GET_VAR' )], $langList )) {
			$currentLang = $_GET [C ( 'LANG_GET_VAR' )];
			setcookie ( C ( 'LANG_COOKIE_VAR' ), $currentLang );
			return $currentLang;
		} else {
			$currentLang = $_COOKIE[C( 'LANG_COOKIE_VAR' )];
			if (empty ( $currentLang )) {
				$currentLang = $langList [0];
				setcookie ( C ( 'LANG_COOKIE_VAR' ), $currentLang );
			}
			return $currentLang;
		}
	}
}

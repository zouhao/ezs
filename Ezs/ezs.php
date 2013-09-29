<?php
/**
 * 入口文件
 * @author zouhao zouhao619@gamil.com
 */
header ( "Content-Type:text/html; charset=utf-8" );
class ezs {
	public function run($type = 'index') {
		// 默认为debug模式
		defined ( 'DEBUG' ) or define ( 'DEBUG', true );
		define ( 'APP_NAME', $type == 'index' ? '' : '/' . ucfirst ( $type ) );
		if (DEBUG == false && file_exists ( dirname ( dirname ( __FILE__ ) ) . '/Extra/Cache/runtime.php' )) {
			require dirname ( dirname ( __FILE__ ) ) . '/Extra/Cache/runtime.php';
		} else {
			error_reporting ( DEBUG == true ? E_ALL : 0 );
			// 加载常用函数
			require dirname ( __FILE__ ) . '/Common/common.php';
			// 加载宏定义文件
			require dirname ( __FILE__ ) . '/Conf/define.php';
			// 创建目录文件夹
			/*
			 * if (DEBUG == true) { // 定义各个文件夹 require INIT_PATH . '/createFolder.php'; }
			 */
			// 加载配置文件
			$config = require CONF_PATH . '/config.php';
			C ( $config ); // 注册全局变量
			               // 如果存在配置文件就加入
			if (file_exists ( CONFIG_PATH . '/config.php' )) {
				$config = require CONFIG_PATH . '/config.php';
				C ( $config );
			}
			// 设置时区
			date_default_timezone_set ( C ( 'DEFAULT_TIMEZONE' ) );
			// 设置session自动开启
			if (C ( 'SESSION_AUTO' ) == true) {
				ini_set ( 'session.cookie_httponly', 1 ); // 设置http_only,防御xss
				session_start ();
			}
			// 解析路由,解析出当前controller和method
			require CORE_PATH . '/Dispatcher.class.php';
			Dispatcher::app ();
			require INIT_PATH . '/loadFunction.php';
			require CORE_PATH . '/AutoLoad.class.php';
			require CORE_PATH . '/View.class.php';
			// 加载基类Controller 和基类View
			$controller_vo = CONTROLLER_NAME . 'Controller';
			$controller = new $controller_vo ();
			$method_name = METHOD_NAME;
			// 多语言加载判断
			if (C ( 'LANG_LIST' )) {
				Lang::app ( $controller );
			}
			call_user_func ( array (
					$controller,
					METHOD_NAME 
			) );
			if (DEBUG == false) {
				$this->compile ();
			}
		}
	}
	/**
	 * 缓存文件
	 * 将各个必须文件压缩到一个文件里
	 */
	private function compile() {
		$content = 'error_reporting ( DEBUG == true ? E_ALL : 0 );';
		$content .= file_get_contents ( EZS_PATH . '/Common/common.php' );
		$content .= file_get_contents ( CONF_PATH . '/define.php' );
		$content .= 'C(' . var_export ( C (), true ) . ');';
		$content .= '$this->config=' . var_export ( C (), true ) . ';';
		$content .= 'date_default_timezone_set(C(\'DEFAULT_TIMEZONE\'));';
		$content .= 'if(C(\'SESSION_AUTO\')==true){ini_set ( \'session.cookie_httponly\', 1 );session_start ();}';
		$content .= file_get_contents ( CORE_PATH . '/Dispatcher.class.php' );
		$content .= 'Dispatcher::app();';
		$content .= file_get_contents ( INIT_PATH . '/loadFunction.php' ); // 这个步骤还可以继续优化,读取loadfunction里面的
		$content .= file_get_contents ( CORE_PATH . '/AutoLoad.class.php' );
		$content .= file_get_contents ( CORE_PATH . '/Controller.class.php' );
		$content .= file_get_contents ( CORE_PATH . '/View.class.php' );
		$content .= '$controller_vo = CONTROLLER_NAME . \'Controller\';';
		$content .= '$controller = new $controller_vo ();';
		$content .= '$method_name = METHOD_NAME;';
		$content .= 'if (C ( \'LANG_LIST\' )) {Lang::app ( $controller );}';
		$content .= 'call_user_func ( array ($controller,METHOD_NAME ) );';
		
		// $content=preg_replace('/\<\?php/','',$content);
		$content = phpStripWhitespace ( $content );
		// 删除php开头
		$content = preg_replace ( '/\<\?php/', '', $content );
		$content = '<?php ' . $content;
		
		file_put_contents ( CACHE_PATH . '/runtime.php', $content );
	}
}


<?php
/**
 * 配置文件
 * @author ZouHao  zouhao619@gmail.com
 */
	return $config=array(
		//数据库配置
		'DB_TYPE'=>'mysql',
		'DB_HOST'=>'localhost',
		'DB_NAME'=>'ezscms',
		'DB_USER'=>'root',
		'DB_PWD'=>'zouhao619@gmail.com',
		'DB_PORT'=>'3306',
		'DB_PREFIX'=>'zs_',
		'DB_CHARSET'=>'utf8',

		'URL_SUFFIX'=>'.html',//伪静态后缀
		/**
		 * URL访问模式 
		 * URL_COMMON:?c=Index&m=index
		 * URL_PATHINFO:/index.php/Index/index
		 * URL_REWRITE:/Index/index  需要开启rewrite 重定向页面到index.php
		 */
		'URL_MODEL'=>URL_REWRITE,
		
		'HTML_SUFFIX'=>'.html',//模板默认后缀
		
		'CACHE_EXPIRE'=>3600,//缓存有效期,单位为秒
		'CACHE_TPL_SUFFIX'=>'.php',		//缓存文件后缀
	    
	    'SESSION_AUTO'         =>true,     //自动开启session
		'SESSION_CACHE_EXPIRE'=>'3600',   //设置session有效期
		
		'COOKIE_CACHE_EXPIRE'=>'3600',		//cookie有效期
		'COOKIE_DOMAIN'         => '',      // Cookie有效域名
        'COOKIE_PATH'           => '/',     // Cookie路径
        'COOKIE_PREFIX'         => 'zh_',      // Cookie前缀 避免冲突
		//'GROUP_LIST'=>'Home,Admin',//分组   默认第一个为默认访问分组
		
		'VIEW_START_TAG'		=>'{', //模板解析开始标签
		'VIEW_END_TAG'			=>'}', //模板解析结束标签
		'CONTROLLER_DEFAULT'=>'Index',//默认访问controller
		'METHOD_DEFAULT'=>'index',//默认访问方法	
		//只在URL_COMMON下有效
		'CONTROLLER_PARAM'=>'c',//URL_COMMON模式下url controller参数
		'METHOD_PARAM'=>'m',//URL_COMMON模式下url method参数
		'GROUP_PARAM'=>'g',//分组情况下
		'VAR_PAGE'=>'p',
		/*多语言
		'LANG_LIST'=>'zh-cn,en-us',//多语言
		'LANG_COOKIE_VAR'=>'language',//lang在cookie里的变量
		'LANG_GET_VAR'=>'l',//Lang在URL上的变量
		*/
		'DEFAULT_TIMEZONE'      => 'PRC', // 默认时区
		'ERROR_LOG'=>CACHE_PATH.'/error.log', //数据库错误日志记录
		'TOKEN_POWER'=>false,
		'TOKEN_NAME'=>'__TOKEN__',
		'TOKEN_KEY'=>'ezs',
	);

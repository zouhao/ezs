<?php
/**
 * 公共函数定义文件
 * @author ZouHao  zouhao619@gmail.com
 */
/**
 * 实例化Model.class.php模型
 * 
 * @param string $table        	
 * @return object
 */
function M($table = null) {
	return Model::instance ( $table, C () );
}
/**
 * 实例化模型 (与M的区别是会实例化自定义的模型)
 * 
 * @param string $table        	
 * @return object
 */
function D($table = null) {
	static $_model=array();
	! is_string ( $table ) or $tableName = $table;
	if (is_array ( $table )) {
		$each = each ( $table );
		$tableName = $each ['key'];
	}
	if(isset($_model[$tableName])){
		return $_model[$tableName];
	}
	if (file_exists ( MODEL_PATH . '/' . $tableName . 'Model.class.php' )) {
		$modelName = $tableName . 'Model';
		$_model[$tableName]=new $modelName($table,C());
		return $_model[$tableName];
	} else {
		return M ( $table );
	}
}
/**
 * 设置/读取 配置
 *
 * @param string $name        	
 * @param string $value        	
 */
function C($name = null, $value = null) {
	static $_config = array ();
	if ($name===null) {
		return $_config;
	}
	if (is_string ( $name )) {
		if (empty ( $value ))
			if(isset($_config[$name])){
				return $_config [$name];
			}else{
				return null;
			}
		else
			$_config [$name] = $value;
	}
	if (is_array ( $name ))
		$_config = array_merge ( $_config, array_change_key_case ( $name, CASE_UPPER ) );
	return null;
}
/**
 * 设置/读取缓存 和fileExport的区别是,读大文件速度快
 *
 * @param string $name        	
 * @param anytype $data        	
 * @param int $time
 *        	单位为秒 读取时才判断
 * @throws Exception
 * @return mixed NULL
 */
function F($name, $data = null, $time = null, $path = null) {
	empty ( $path ) and $path = CACHE_FILE_PATH;
	if (isset ( $data )) {
		if (is_dir($path)||mkdir ( $path,0777,true )) {
			if (file_put_contents ( $path . '/' . $name . C ( 'CACHE_TPL_SUFFIX' ), serialize ( $data ) ) > 0) {
				return true;
			} else {
				throw new Exception ( "生成缓存文件失败" );
			}
		} else {
			throw new Exception ( "权限不够,生成缓存目录失败" );
		}
	} else {
		if (file_exists ( $file = $path . '/' . $name . C ( 'CACHE_TPL_SUFFIX' ) )) {
			( int ) $time = is_null ( $time ) ? C ( 'CACHE_EXPIRE' ) : $time;
			if ($time == 0 || $time + filemtime ( $file ) >= strtotime ( 'now' )) {
				return unserialize ( file_get_contents ( $file ) );
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
}
/**
 * 设置/读取缓存 和F的区别是不用序列化字段,小文件速度更快
 *
 * @param string $name        	
 * @param anytype $data        	
 * @param int $time
 *        	单位为秒 读取时才判断
 * @throws Exception
 * @return mixed NULL
 */
function fileExport($name, $data = null, $time = null, $path = null) {
	empty ( $path ) and $path = CACHE_EXPORT_PATH;
	if (isset ( $data )) {
		if (is_dir($path)||mkdir ( $path ,0777,true)) {
			if (file_put_contents ( $path . '/' . $name . C ( 'CACHE_TPL_SUFFIX' ), '<?php return ' . var_export ( $data, true ) . ';' ) > 0) {
				return true;
			} else {
				throw new Exception ( "生成缓存文件失败" );
			}
		} else {
			throw new Exception ( "权限不够,生成缓存目录失败" );
		}
	} else {
		if (file_exists ( $file = $path . '/' . $name . C ( 'CACHE_TPL_SUFFIX' ) )) {
			is_null ( $time ) and $time = C ( 'CACHE_EXPIRE' );
			if ($time == 0 || $time + filemtime ( $file ) >= strtotime ( 'now' )) {
				$content = require $file;
				return $content;
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
}
/**
 * 时间记录函数
 *
 * @return string
 */
function T($time = null) {
	static $_time = null;
	if (! empty ( $time )) {
		$_time = $time;
	} else if (empty ( $_time )) {
		$_time = $_SERVER ['REQUEST_TIME'];
	} else {
		$starttime = explode ( " ", $_time );
		$endtime = explode ( " ", microtime () );
		return sprintf ( "%s", $endtime [0] - $starttime [0] + $endtime [1] - $starttime [1] );
	}
}
/**
 * 优化的require_once
 * @param string $fileName
 *        	绝对路径
 */
function require_cache($fileName) {
	static $_require = array ();
	$key = md5_file ( $fileName );
	if (empty ( $_require [$key] )) {
		$_require [$key] = true;
		if (file_exists ( $fileName )) {
			require $fileName;
			return true;
		} else {
			return false;
		}
	} else {
		return true;
	}
}
/**
 * url生成函数
 *
 * @param string $url
 *        	只支持/Index/Index这样的模式
 * @return boolean 是否需要添加token
 */
function U($url, $isToken = false) {
	$url = Dispatcher::getUrl ( $url, $isToken );
	return $url;
}
/**
 * 游览器友好输出
 */
function dump($var, $echo = true, $label = null, $strict = true) {
	$label = ($label === null) ? '' : rtrim ( $label ) . ' ';
	if (! $strict) {
		if (ini_get ( 'html_errors' )) {
			$output = print_r ( $var, true );
			$output = '<pre>' . $label . htmlspecialchars ( $output, ENT_QUOTES ) . '</pre>';
		} else {
			$output = $label . print_r ( $var, true );
		}
	} else {
		ob_start ();
		var_dump ( $var );
		$output = ob_get_clean ();
		if (! extension_loaded ( 'xdebug' )) {
			$output = preg_replace ( '/\]\=\>\n(\s+)/m', '] => ', $output );
			$output = '<pre>' . $label . htmlspecialchars ( $output, ENT_QUOTES ) . '</pre>';
		}
	}
	echo ($output);
}
/**
 * 从左边查询子串,找到则删除子串,只删除一次
 *
 * @param string $str        	
 * @param string $find        	
 * @return string
 */
function substr_left_once($str, $find) {
	$start = strpos ( $str, $find );
	if (is_bool ( $start )) {
		return $str;
	} else {
		return substr ( $str, $start + strlen ( $find ), strlen ( $str ) );
	}
}
/**
 * 从右边查询子串,找到则删除子串,只删除一次
 *
 * @param string $str        	
 * @param string $find        	
 * @return string
 */
function substr_right_once($str, $find) {
	$end = strrpos ( $str, $find );
	if (is_bool ( $end )) {
		return $str;
	} else {
		return substr ( $str, 0, $end );
	}
}
// URL重定向
function redirect($url, $time = 0, $msg = '') {
	// 多行URL地址支持
	$url = str_replace ( array (
			"\n",
			"\r" 
	), '', $url );
	if (empty ( $msg ))
		$msg = "系统将在{$time}秒之后自动跳转到{$url}！";
	if (! headers_sent ()) {
		// redirect
		if (0 === $time) {
			header ( 'Location: ' . $url );
		} else {
			header ( "refresh:{$time};url={$url}" );
			echo ($msg);
		}
		exit ();
	} else {
		$str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
		if ($time != 0)
			$str .= $msg;
		exit ( $str );
	}
}
/**
 * 截取字符串(可截取utf8的)
 *
 * @param string $str        	
 * @param int $start        	
 * @param int $length        	
 * @param string $trim        	
 * @param string $charset        	
 * @return string
 */
function sub($str, $start, $length, $trim = "...", $charset = 'UTF-8') {
	$length+=2;
	if (function_exists ( 'mb_get_info' )) {
		$iLength = mb_strlen ( $str, $charset );
		$str = mb_substr ( $str, $start, $length, $charset );
		if($length< $iLength - $start){
			$length-=2;
			return mb_substr ( $str, $start, $length, $charset ).$trim;
		}else{
			return $str;
		}
	} else {
		preg_match_all ( "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $str, $info );
		$str = join ( "", array_slice ( $info [0], $start, $length ) );
		return ($length < (sizeof ( $info [0] ) - $start)) ? $str . $trim : $str;
	}
}
/**
 * 遍历删除文件夹
 *
 * @param string $path
 *        	文件夹地址
 * @return boolean
 */
function deleteFile($path) {
	if (is_file ( $path )) {
		return unlink ( $path );
	}
	if (is_dir ( $path )) {
		$handle = opendir ( $path );
		if ($handle != false) {
			while ( false !== ($file = readdir ( $handle )) ) {
				if (in_array ( $file, array (
						'.',
						'..' 
				) ))
					continue;
				$file = $path . '/' . $file;
				if (is_dir ( $file )) {
					deleteFile ( $file );
				} else if (is_file ( $file )) {
					if (unlink ( $file ) == false)
						return false;
				}
			}
			closedir ( $handle );
		}
		return true;
	}
}
/**
 * 将字符串转换为驼峰式命名
 * 
 * @param string $str        	
 * @param boolean $big
 *        	true大驼峰式 false小驼峰式
 * @return string
 */
function humpType($str, $big = false) {
	$str = strtolower ( $str );
	$big and ucfirst ( $str );
	$str = preg_replace ( "/_([a-zA-Z])/e", "strtoupper('\\1')", $str );
	return $str;
}
/**
 * 过滤xss
 * 
 * @param string $val        	
 * @return string
 */
function remove_xss($val) {
	// remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
	// this prevents some character re-spacing such as <java\0script>
	// note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
	$val = preg_replace ( '/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val );
	// straight replacements, the user should never need these since they're normal characters
	// this prevents like <IMG SRC=@avascript:alert('XSS')>
	$search = 'abcdefghijklmnopqrstuvwxyz';
	$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$search .= '1234567890!@#$%^&*()';
	$search .= '~`";:?+/={}[]-_|\'\\';
	for($i = 0; $i < strlen ( $search ); $i ++) {
		// ;? matches the ;, which is optional
		// 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
		// @ @ search for the hex values
		$val = preg_replace ( '/(&#[xX]0{0,8}' . dechex ( ord ( $search [$i] ) ) . ';?)/i', $search [$i], $val ); // with a ;
		                                                                                           // @ @ 0{0,7} matches '0' zero to seven times
		$val = preg_replace ( '/(�{0,8}' . ord ( $search [$i] ) . ';?)/', $search [$i], $val ); // with a ;
	}
	// now the only remaining whitespace attacks are \t, \n, and \r
	$ra1 = array (
			'javascript',
			'vbscript',
			'expression',
			'applet',
			'meta',
			'xml',
			'blink',
			'link',
			'style',
			'script',
			'embed',
			'object',
			'iframe',
			'frame',
			'frameset',
			'ilayer',
			'layer',
			'bgsound',
			'title',
			'base' 
	);
	$ra2 = array (
			'onabort',
			'onactivate',
			'onafterprint',
			'onafterupdate',
			'onbeforeactivate',
			'onbeforecopy',
			'onbeforecut',
			'onbeforedeactivate',
			'onbeforeeditfocus',
			'onbeforepaste',
			'onbeforeprint',
			'onbeforeunload',
			'onbeforeupdate',
			'onblur',
			'onbounce',
			'oncellchange',
			'onchange',
			'onclick',
			'oncontextmenu',
			'oncontrolselect',
			'oncopy',
			'oncut',
			'ondataavailable',
			'ondatasetchanged',
			'ondatasetcomplete',
			'ondblclick',
			'ondeactivate',
			'ondrag',
			'ondragend',
			'ondragenter',
			'ondragleave',
			'ondragover',
			'ondragstart',
			'ondrop',
			'onerror',
			'onerrorupdate',
			'onfilterchange',
			'onfinish',
			'onfocus',
			'onfocusin',
			'onfocusout',
			'onhelp',
			'onkeydown',
			'onkeypress',
			'onkeyup',
			'onlayoutcomplete',
			'onload',
			'onlosecapture',
			'onmousedown',
			'onmouseenter',
			'onmouseleave',
			'onmousemove',
			'onmouseout',
			'onmouseover',
			'onmouseup',
			'onmousewheel',
			'onmove',
			'onmoveend',
			'onmovestart',
			'onpaste',
			'onpropertychange',
			'onreadystatechange',
			'onreset',
			'onresize',
			'onresizeend',
			'onresizestart',
			'onrowenter',
			'onrowexit',
			'onrowsdelete',
			'onrowsinserted',
			'onscroll',
			'onselect',
			'onselectionchange',
			'onselectstart',
			'onstart',
			'onstop',
			'onsubmit',
			'onunload' 
	);
	$ra = array_merge ( $ra1, $ra2 );
	$found = true; // keep replacing as long as the previous round replaced something
	while ( $found == true ) {
		$val_before = $val;
		for($i = 0; $i < sizeof ( $ra ); $i ++) {
			$pattern = '/';
			for($j = 0; $j < strlen ( $ra [$i] ); $j ++) {
				if ($j > 0) {
					$pattern .= '(';
					$pattern .= '(&#[xX]0{0,8}([9ab]);)';
					$pattern .= '|';
					$pattern .= '|(�{0,8}([9|10|13]);)';
					$pattern .= ')*';
				}
				$pattern .= $ra [$i] [$j];
			}
			$pattern .= '/i';
			$replacement = substr ( $ra [$i], 0, 2 ) . '<x>' . substr ( $ra [$i], 2 ); // add in <> to nerf the tag
			$val = preg_replace ( $pattern, $replacement, $val ); // filter out the hex tags
			if ($val_before == $val) {
				// no replacements were made, so exit the loop
				$found = false;
			}
		}
	}
	return $val;
}
/**
 * 获取客户端ip
 * @param number $type
 * @return string
 */
function getClientIp($type = 0) {
	$type       =  $type ? 1 : 0;
	static $ip  =   NULL;
	if ($ip !== NULL) return $ip[$type];
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		$pos    =   array_search('unknown',$arr);
		if(false !== $pos) unset($arr[$pos]);
		$ip     =   trim($arr[0]);
	}elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$ip     =   $_SERVER['HTTP_CLIENT_IP'];
	}elseif (isset($_SERVER['REMOTE_ADDR'])) {
		$ip     =   $_SERVER['REMOTE_ADDR'];
	}
	// IP地址合法验证
	$long = sprintf("%u",ip2long($ip));
	$ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
	return $ip[$type];
}
/**
 * 将二维数组转化为一维数组
 * @param array $arr	二维数组
 * @return array		一维数组
 */
function TwoArrayToOneArray($arr){
	empty($arr) and $arr=array();
	foreach($arr as $vo){
		$list=each($vo);
		$data[]=$list['value'];
	}
	empty($data) and $data=array();
	return $data;
}

/**
 * 去掉php注释
 * @param string $content
 * @return string
 */
function phpStripWhitespace($content){
	//去掉PHP注释
	$content=preg_replace('/\/\/.*/','',$content);
	$content=preg_replace('/\/\*[\s\S]*?\*\/+/','',$content);
	//去除空格太多的地方
	$content=preg_replace('/\s{2,}/',' ',$content);
	$content=str_replace("\n",' ',$content);
	return $content;
}
/**
 * 二维数组按键值排序
 * @param array $arr 		二维数组
 * @param string $keys		键值
 * @param string $type		升序:asc,降序:desc(else)
 * @return array
 */
function array_sort($arr,$keys,$type='asc'){
	$keysvalue = $new_array = array();
	foreach ($arr as $k=>$v){
		$keysvalue[$k] = $v[$keys];
	}
	if($type == 'asc'){
		asort($keysvalue);
	}else{
		arsort($keysvalue);
	}
	reset($keysvalue);
	foreach ($keysvalue as $k=>$v){
		$new_array[$k] = $arr[$k];
	}
	return $new_array;
}
/**
 * curl模拟http get请求
 * @param string $url			请求网址
 * @param string|array $data	请求参数
 * @return string				网址内容
 */
function curlGet($url,$data=null){
	$url=rtrim($url,'/');
	if(!empty($data)){
		is_array($data) and $data=http_build_query($data);
		$data=ltrim($data,'?');
		$url.='?'.$data;
	}
	$ch = curl_init($url) ;
	curl_setopt($ch,CURLOPT_HEADER,false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
	$content = curl_exec($ch);
	curl_close($ch);
	return $content;
}
/**
 * curl模拟http post请求
 * @param string $url			请求网址
 * @param array $data			请求参数
 * @return string				网址内容
 */
function curlPost($url,$data){
	$ch = curl_init($url) ;
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true) ; // 获取数据返回
	curl_setopt($ch, CURLOPT_POST,true) ; // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。
	curl_setopt($ch, CURLOPT_POSTFIELDS,$data); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名
	$content=curl_exec($ch);
	curl_close($ch) ;
	return $content;
}
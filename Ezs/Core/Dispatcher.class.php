<?php
/**
 * 路由解析类
 * @author ZouHao  zouhao619@gmail.com
 */
class Dispatcher {
	/**
	 * 路由入口
	 *
	 * @param array $config        	
	 */
	public static function app($config = null) {
		$rs=self::parseUrl($_SERVER ['REQUEST_URI']);
		$controllerName=$rs['controller'];
		$methodName=$rs['method'];
		$groupName=$rs['group'];
		$groupList = C ( 'GROUP_LIST' );
		empty ( $controllerName ) and $controllerName = C ( 'CONTROLLER_DEFAULT' );
		empty ( $methodName ) and $methodName = C ( 'METHOD_DEFAULT' );
		if (empty ( $groupList )) {
			$groupNameBoth = $groupNameLeft = $groupNameRight = $groupName = '';
		} else if (empty ( $groupName )) {
			list ( $groupName ) = explode ( ',', C ( 'GROUP_LIST' ) );
		}
		if(!empty($rs['params'])&&is_array($rs['params'])){
			foreach($rs['params'] as $key=>$value){
				$_REQUEST[$key]=$_GET[$key]=$value;
			}
		}
		$groupNameLeft = '/' . $groupName;
		$groupNameRight = $groupName . '/';
		$groupNameBoth = '/' . $groupName . '/';
		define ( 'CONTROLLER_NAME', $controllerName );
		define ( 'METHOD_NAME', $methodName );
		define ( 'GROUP_NAME', $groupName );
		define ( 'GROUP_NAME_LEFT', $groupNameLeft );
		define ( 'GROUP_NAME_RIGHT', $groupNameRight );
		define ( 'GROUP_NAME_BOTH', $groupNameBoth );
		// 判断是否有分组
		// var_dump(GROUP_NAME,CONTROLLER_NAME,METHOD_NAME,$_GET);
	}
	public static function parseUrl($url){
		$config = empty ( $config ) ? C () : $config;
		$groupList = C ( 'GROUP_LIST' );
		$groupName=$params='';
		$controllerName=C('CONTROLLER_DEFAULT');
		$methodName=C('METHOD_DEFAULT');
		switch (( int ) $config ['URL_MODEL']) {
			case URL_COMMON :
				$groupName = $_GET [C ( 'GROUP_PARAM' )];
				$controllerName = $_GET [C ( 'CONTROLLER_PARAM' )];
				$methodName = $_GET [C ( 'METHOD_PARAM' )];
				break;
			case URL_PATHINFO :
				$url = parse_url ( $url );
				$url = $url ['path'];
				$url = ltrim ( $url, $_SERVER ['SCRIPT_NAME'] );
				$url = substr_right_once ( $url, $config ['URL_SUFFIX'] );
				$url = trim ( $url, '/' );
				if (! empty ( $url )) {
					$url = explode ( '/', $url );
					if (! empty ( $groupList )) {
						list ( $groupName, $controllerName, $methodName ) = $url;
						$url = array_slice ( $url, 3 );
					} else {
						list ( $controllerName, $methodName ) = $url;
						$url = array_slice ( $url, 2 );
						$groupName = '';
					}
					if (! empty ( $url )) {
						$count = count ( $url );
						for($i = 0; $i < $count; $i = $i + 2) {
							list ( $key, $value ) = $url;
							$url = array_slice ( $url, 2 );
							$params[$key]=$value;
						}
					}
				}
				break;
			case URL_REWRITE :
				$url = parse_url ( $url );
				$url = $url ['path'];
				$url = ltrim ( $url, $_SERVER ['SCRIPT_NAME'] );
				$url = substr_right_once ( $url, $config ['URL_SUFFIX'] );
				$url = trim ( $url, '/' );
				if (! empty ( $url )) {
					$url = explode ( '/', $url );
					if (! empty ( $groupList )) {
						isset($url['0']) and $groupName=$url['0'];
						isset($url['1']) and $controllerName=$url['1'];
						isset($url['2']) and $methodName=$url['2'];
						$url = array_slice ( $url, 3 );
					} else {
						isset($url['0']) and $controllerName=$url['0'];
						isset($url['1']) and $methodName=$url['1'];
						$url = array_slice ( $url, 2 );
						$groupName = '';
					}
					if (! empty ( $url )) {
						$count = count ( $url );
						for($i = 0; $i < $count; $i = $i + 2) {
							list ( $key, $value ) = $url;
							$url = array_slice ( $url, 2 );
							$params[$key]=$value;
						}
					}
				}
				break;
		}
		return array('group'=>$groupName,'controller'=>$controllerName,'method'=>$methodName,'params'=>$params);
	}
	/**
	 * 生成url
	 * @param string $url
	 * @return string
	 */
	public static function getUrl($url,$isToken){
		$str = parse_url ( $url );
		$groupList=C('GROUP_LIST');
		$vo=array_reverse ( explode ( '/', $str ['path'] ) );
		$method=isset($vo['0'])?$vo['0']:METHOD_NAME;
		$controller=isset($vo['1'])?$vo['1']:CONTROLLER_NAME;
		if(empty($groupList)){
			$group='';
		}else{
			$group=isset($vo['2'])?$vo['2']:GROUP_NAME;
		}
		switch (( int ) C ( 'URL_MODEL' )) {
			case URL_COMMON :
				$url = __APP__ . '?';
				GROUP_NAME != '' and $url .= C ( 'GROUP_PARAM' ) . '=' . $group . '&';
				$url .= C ( 'CONTROLLER_PARAM' ) . '=' . $controller . '&' . C ( 'METHOD_PARAM' ) . '=' . $method;
				! empty ( $str ['query'] ) and $url .= '&' . $str ['query'];
				break;
			case URL_PATHINFO :
				$url=__APP__;
				GROUP_NAME!='' and $url.='/'.$group;
				$url.='/'.$controller.'/'.$method;
				if(!empty($str['query'])){
					parse_str($str['query'],$params);
					foreach($params as $key=>$value){
						$url.='/'.$key.'/'.$value;
					}
				}
				$isToken and $url.='/'.C('TOKEN_NAME').'/'.Token::getToken();
				$url.=C('HTML_SUFFIX');
				break;
			case URL_REWRITE :
				$url=strcasecmp (basename(__APP__),'index.php')==0?dirname(__APP__):__APP__;
				if($url=='\\'||$url=='/'){
					$url='';
				}
				GROUP_NAME!='' and $url.='/'.$group;
				$url.='/'.$controller.'/'.$method;
				if(!empty($str['query'])){
					parse_str($str['query'],$params);
					foreach($params as $key=>$value){
						$url.='/'.$key.'/'.$value;
					}
				}
				$isToken and $url.='/'.C('TOKEN_NAME').'/'.Token::getToken();
				$url.=C('HTML_SUFFIX');
				break;
		}
		return $url;
	}
}

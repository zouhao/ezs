<?php
class Token {
	const specialChar = '!';
	private static $error = null;
	/**
	 * 自动根据当前key sessionid 当前时间 分组 模块 方法生成token
	 * 
	 * @return string
	 */
	public static function getToken() {
		$data [] = C ( 'TOKEN_KEY' );
		$data [] = session_id ();
		$data [] = $_SERVER ['REQUEST_TIME'];
		$data [] = GROUP_NAME;
		$data [] = CONTROLLER_NAME;
		$data [] = METHOD_NAME;
		$token = base64_encode ( implode ( self::specialChar, $data ) );
		return $token;
	}
	/**
	 * 验证当前token是佛u正确
	 * 
	 * @param string $token        	
	 * @return boolean
	 */
	public static function validateToken($token = null) {
		empty ( $token ) and $token = $_REQUEST [C ( 'TOKEN_NAME' )];
		if (isset ( $_SESSION [C ( 'TOKEN_NAME' )] [$token] )) {
			self::$error = '请不要重复提交表单';
			return false;
		} else {
			list ( $key, $sessionId, $time, $group, $controller, $method ) = explode ( self::specialChar, base64_decode ( $token ) );
			$url = Dispatcher::parseUrl ( $_SERVER ['HTTP_REFERER'] );
			if ($key == C ( 'TOKEN_KEY' ) && $sessionId == session_id () && $group == $url ['group'] && $controller == $url ['controller'] && $method = $url ['method']) {
				$_SESSION[C('TOKEN_NAME')][$token]=true;
				return true;
			} else {
				self::$error='Token验证错误';
				return false;
			}
		}
	}
	/**
	 * 获取错误信息
	 * @return string
	 */
	public static function getError() {
		return self::$error;
	}
}
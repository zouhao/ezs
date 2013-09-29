<?php
/**
 * 字段验证类
 * @author ZouHao  zouhao619@gmail.com
 */
class Validate {
	CONST varString = '/^[a-z,A-Z,_]\w*$/';
	CONST number='/\d+/';
	CONST float='/\d+\.?\d*';
	public static function varString($var) {
		return preg_match ( self::varString, $var );
	}
}
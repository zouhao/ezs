<?php
/**
 * zouhao zouhao619@gmail.com
 */
class AdminModel extends Model{
	protected $_auto=array(
		array('password','callback','md5',self::MODEL_BOTH)
	);
}
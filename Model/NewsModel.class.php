<?php
/**
 * zouhao zouhao619@gmail.com
 */
class NewsModel extends Model{
	protected $_auto=array(
		array('is_hidden','const',0,self::MODEL_BOTH),
		array('admin_id','function','getAdminId')
	);
}
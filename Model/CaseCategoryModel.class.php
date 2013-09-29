<?php
/**
 * zouhao zouhao619@gmail.com
 */
class CaseCategoryModel extends Model{
	protected $_auto=array(
		array('admin_id','function','getAdminId'),
		array('is_hidden','const','0',self::MODEL_BOTH)
	);
}
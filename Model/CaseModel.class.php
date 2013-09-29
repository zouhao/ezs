<?php
/**
 * zouhao zouhao619@gmail.com
 */
class CaseModel extends Model{
	protected $_auto=array(
		array('is_hidden','const',0,self::MODEL_BOTH),
		array('admin_id','function','getAdminId')
	);
}
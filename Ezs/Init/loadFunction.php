<?php
	$loadFile[]='common.php';
	$loadFile[]='dict.php';
	$loadFile[]=GROUP_NAME.'/common.php';
	$loadFile[]=GROUP_NAME_RIGHT.CONTROLLER_NAME.'/common.php';
	$loadFile[]=GROUP_NAME_RIGHT.CONTROLLER_NAME.'/'.METHOD_NAME.'.php';
	foreach($loadFile as $file){
		if(file_exists(FUNCTION_PATH.'/'.$file)){
			require_once(FUNCTION_PATH.'/'.$file);
		}
	}
	unset($loadFile);

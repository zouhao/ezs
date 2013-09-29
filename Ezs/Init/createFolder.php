<?php
$mkdir_file = array (
		CONTROLLER_PATH,
			CONTROLLER_PATH.'/'.GROUP_NAME.'/'.CONTROLLER_NAME,
		MODEL_PATH,
		VIEW_PATH,
		UPLOAD_PATH,
		EXTRA_PATH,
			CACHE_PATH,
			FUNCTION_PATH,
			CLASS_PATH,
			LIBRARY_PATH,
			CONFIG_PATH,
			LANG_PATH,
);
foreach ( $mkdir_file as $dir ) {
	is_dir($dir) or mkdir ( $dir,0777,true );
}
/*
if (! file_exists ( CONTROLLER_PATH . '/IndexController.class.php' )) {
	file_put_contents (CONTROLLER_PATH . '/IndexController.class.php','<?php
					class IndexController extends Controller{
							public function index(){
								echo "ok";
							}
					}
					' );
}
*/
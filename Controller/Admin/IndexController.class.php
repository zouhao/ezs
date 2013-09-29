<?php
class IndexController extends CommonController {
	public function index()
	{
		$this->display();
	}
	public function setting(){
		if($this->isGet()){
			$this->display();
		}else{
			file_put_contents(CONFIG_PATH.'/config.setting.php','<?php return ' . var_export ( $_POST, true ) . ';');
			$this->success('修改成功',U('setting'));
		}
	}
}
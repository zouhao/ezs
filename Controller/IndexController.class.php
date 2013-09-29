<?php
/**
 * @author zouhao zouhao619@gmail.com
 * QQ:16852868
 */
class IndexController extends CommonController {
	public function index()
	{
		$profile = M("special")->where("name='profile'")->find();
		$this->assign("profile", $profile);
		$productList=M('Product')->where('is_hidden=0 and is_home=1')->order('sort desc')->select();
		$this->assign('productList',$productList);
		$this->display();
	}
}
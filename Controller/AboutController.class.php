<?php
/**
 * @author zouhao zouhao619@gmail.com
 * QQ:16852868
 */
class AboutController extends CommonController {
	public function cultural(){
		$cultural = M("special")->where("name='cultural'")->find();
		$this->assign("cultural", $cultural);
		$this->display();
	}
	
	public function profile(){
		$profile = M("special")->where("name='profile'")->find();
		$this->assign("profile", $profile);
		$this->display();
	}
	
	public function honor(){
		$count=M('honor')->count();
		$page=new Page($count);
		$honorList = M("honor")->order("id desc")->limit("{$page->firstRow},{$page->listRows}")->select();
		$this->assign('honorList',$honorList);
		$this->assign('page',$page->show());
		$this->display();
	}
}

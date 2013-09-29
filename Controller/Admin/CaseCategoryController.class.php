<?php
/**
 * @author zouhao
 *	qq:16852868
 *	zouhao619@gmail.com
 */
class CaseCategoryController extends CommonController{
	public function index(){
		$list=M(CONTROLLER_NAME)->order('sort desc')->select();
		$this->assign('list',$list);
		$this->display('NewsCategory/index');
	}
	public function saveBefore(){
		$this->tpl='NewsCategory/save';
	}
	public function updateBefore(){
		$this->saveBefore();
	}
	public function deleteBefore(){
		$n=new NewsCategoryController();
		$n->deleteBefore();
	}
}
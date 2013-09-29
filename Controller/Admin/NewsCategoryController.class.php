<?php
/**
 * @author zouhao
 *	qq:16852868
 *	zouhao619@gmail.com
 */
class NewsCategoryController extends CommonController{
	/**
	 * 新闻类别首页
	 */
	public function index(){
		$list=M(CONTROLLER_NAME)->order('sort desc')->select();
		$this->assign('list',$list);
		$this->display();
	}
	/**
	 * AOP delete方法
	 */
	public function deleteBefore(){
		$id=intval($_GET['id']);
		$controller=substr(CONTROLLER_NAME,0,-8);
		$info=M($controller)->where("category_id={$id}")->find();
		if(!empty($info)){
			$this->error('删除失败!分类下还存在数据!必须先删除分类下的数据!');
		}
	}
}
<?php
/**
 * @author zouhao
 *	qq:16852868
 *	zouhao619@gmail.com
 */
class NewsController extends CommonController{
	public function index(){
		$db = M(CONTROLLER_NAME);
		$count = $db->count();    //计算总数
		$p = new Page($count);
		$list = $db->table ( array (
				'News' => 'n',
				'Admin' => 'a',
				'NewsCategory'=>'c'
		) )->field ( 'n.*,a.username,c.title as category_name' )->where ( 'n.admin_id=a.id and n.category_id=c.id' )->order("n.id desc")->limit($p->firstRow . ',' . $p->listRows)->select();
		$page = $p->show();
		$this->assign("page", $page);
		$this->assign("list", $list);
		$this->display();
	}
	public function saveBefore(){
		if($this->isGet()){
			$this->assign('categoryList',M('NewsCategory')->order('sort desc')->select());
		}
	}
	public function updateBefore(){
		$this->saveBefore();
	}
}
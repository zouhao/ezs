<?php
/**
 * 特殊主题管理
 * @author zouhao
 *	qq:16852868
 *	zouhao619@gmail.com
 */
class SpecialController extends CommonController{
	public function index(){
		$db = M(CONTROLLER_NAME);
		$count = $db->count();    //计算总数
		$p = new Page($count);
		$list = $db->order("sort desc")->limit($p->firstRow . ',' . $p->listRows)->select();
		$page = $p->show();
		$this->assign("page", $page);
		$this->assign("list", $list);
		$this->display($this->tpl);
	}
	public function saveBefore() {
		if ($this->isGet ()) {
			$this->clearImg();
		} else {
			$_POST ['small_img'] = $_SESSION ['small_img'];
			$_POST ['big_img'] = $_SESSION ['big_img'];
		}
	}
	public function update() {
		if ($this->isGet ()) {
			$this->saveBefore();
			$info = M ( CONTROLLER_NAME )->where ( 'id=' . intval ( $_GET ['id'] ) )->find ();
			$this->assign ( 'info', $info );
			$_SESSION['small_img']=$info['small_img'];
			$_SESSION['big_img']=$info['big_img'];
			$this->display ( 'save' );
		} else {
			$_POST ['small_img'] = $_SESSION ['small_img'];
			$_POST ['big_img'] = $_SESSION ['big_img'];
			parent::update ();
		}
	}
}
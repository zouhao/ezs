<?php
/**
 * 图片轮播管理
 * @author zouhao
 *	qq:16852868
 *	zouhao619@gmail.com
 */
class AdController extends CommonController {
	public function index(){
		$db = M(CONTROLLER_NAME);
		$count = $db->count();    //计算总数
		$p = new Page($count);
		$list = $db->table ( array (
				'Ad' => 'd',
				'Admin' => 'a'
		) )->field ( 'd.*,a.username' )->where ( 'a.id=d.admin_id' )->order("d.sort desc")->limit($p->firstRow . ',' . $p->listRows)->select();
		$page = $p->show();
		$this->assign("page", $page);
		$this->assign("list", $list);
		$this->display();
	}
	public function saveBefore() {
		if ($this->isGet ()) {
			$this->clearImg();
		} else {
			$_POST ['img'] = $_SESSION ['big_img'];
		}
	}
	public function update() {
		if ($this->isGet ()) {
			$this->saveBefore();
			$info = M ( CONTROLLER_NAME )->where ( 'id=' . intval ( $_GET ['id'] ) )->find ();
			$this->assign ( 'info', $info );
			$_SESSION['small_img']=$_SESSION['big_img']=$info['img'];
			$this->display ( 'save' );
		} else {
			$_POST ['img'] = $_SESSION ['big_img'];
			parent::update ();
		}
	}
}
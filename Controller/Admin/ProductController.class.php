<?php
/**
 * @author zouhao
 *	qq:16852868
 *	zouhao619@gmail.com
 */
class ProductController extends CommonController {
	public function index() {
		$db = M ( CONTROLLER_NAME );
		$count = $db->count (); // 计算总数
		$p = new Page ( $count );
		$list = $db->table ( array (
				CONTROLLER_NAME => 'n',
				'Admin' => 'a',
				CONTROLLER_NAME.'Category' => 'c' 
		) )->field ( 'n.*,a.username,c.title as category_name' )->where ( 'n.admin_id=a.id and n.category_id=c.id' )->order ( "n.sort desc" )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$page = $p->show ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		$this->display ();
	}
	public function saveBefore() {
		if ($this->isGet ()) {
			$this->clearImg();
			$this->assign ( 'categoryList', M ( 'ProductCategory' )->order ( 'sort desc' )->select () );
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
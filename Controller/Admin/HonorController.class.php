<?php
/**
 * 荣誉控制器
 * @author zouhao
 *	qq:16852868
 *	zouhao619@gmail.com
 */
class HonorController extends CommonController {
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
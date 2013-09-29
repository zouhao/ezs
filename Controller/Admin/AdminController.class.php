<?php
/**
 * 管理员管理
 * @author zouhao zouhao619@gmail.com
 * QQ:16852868
 */
class AdminController extends CommonController {
	// 职位管理界面
	public function index() {
		$db = M ( CONTROLLER_NAME );
		$count = $db->count (); // 计算总数
		$p = new Page ( $count );
		$list = $db->table ( array (
				'Admin' => 'a',
				'Role' => 'r' 
		) )->field ( 'a.*,r.name' )->where ( 'a.role_id=r.id' )->order ( "a.id asc" )->limit ( $p->firstRow . ',' . $p->listRows )->select ();
		$page = $p->show ();
		$this->assign ( "page", $page );
		$this->assign ( "list", $list );
		$this->display ();
	}
	public function saveBefore() {
		if ($this->isGet ()) {
			$roleList = M ( 'Role' )->select ();
			$this->assign ( 'roleList', $roleList );
		}
	}
	public function updateBefore() {
		if ($this->isGet ()) {
			$this->saveBefore ();
		}else{
			if(empty($_POST['password'])){
				unset($_POST['password']);
			}
		}
	}
}

<?php
/**
 * 验证控制器
 * @author zouhao
 *	qq:16852868
 *	zouhao619@gmail.com
 */
class ValidateController extends Controller{
	/**
	 * 判断是否用户名是否存在
	 */
	public function isUserNameExist(){
		$admin=M('Admin')->where(array('username'=>$_REQUEST['username']))->find();
		if(empty($admin)){
			echo 'true';
		}else{
			echo 'false';
		}
	}
	/**
	 * 判断是否角色是否存在
	 */
	public function isRoleNameExist(){
		$role=M('Role')->where(array('name'=>$_REQUEST['name']))->find();
		if(empty($role)){
			echo 'true';
		}else{
			echo 'false';
		}
	}
	/**
	 * 判断是否有缩略图上传
	 */
	public function upload(){
		if(empty($_SESSION['small_img'])){
			echo 'false';
		}else{
			echo 'true';
		}
	}
}
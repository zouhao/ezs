<?php
/**
 * @author zouhao
 *	qq:16852868
 *	zouhao619@gmail.com
 */
class RoleController extends CommonController{
	/**
	 * 角色保存
	 */
	public function save(){
	    if($this->isGet()){
	    	$menuList=require CONFIG_PATH.'/config.menu.php';
	    	$this->assign('menuList',$menuList);
            $this->display();
	    }else{
            $db=M(CONTROLLER_NAME);
            $data['name']=$_POST['name'];
            $data['remark']=$_POST['remark'];
            isset($_POST['is_forbid']) and $data['is_forbid']=$_POST['is_forbid'];
            if(!$db->create($data)){
                $this->error($db->getError());
            }
            $db->begin();
            $rs=$db->save($data);
            if($rs==false){
                $db->rollback();
                $this->error('添加失败,请联系管理员');
            }
            $access['role_id']=$rs;
            empty($_POST['menu_id']) and $_POST['menu_id']=array();
            foreach($_POST['menu_id'] as $vo){
                $access['menu_id']=$vo;
                $result=M('RoleMenu')->save($access);
                if(!$result){
                    $db->rollback();
                    $this->error('添加失败,请联系管理员');
                }
            }
            $rs=$db->commit();
            if($rs){
                $this->redirect('index');
            }else{
                $this->error('添加角色失败,请联系角色');
            }
	    }
	}
	public function updateBefore(){
	    if($this->isGet()){
	        $roleMenuList=M('RoleMenu')->where('role_id='.intval($_GET['id']))->select();
	        $this->assign('roleMenuList',$roleMenuList);
	        $menuList=require CONFIG_PATH.'/config.menu.php';
	        $this->assign('menuList',$menuList);
	    }else{
	    	$id=intval($_POST['id']);
	    	$db=M('RoleMenu');
	        $db->delete(array('role_id'=>$id));
	        empty($_POST['menu_id']) and $_POST['menu_id']=array();
	        $db->begin();
	        foreach($_POST['menu_id'] as $v){
	        	$roleMenu['role_id']=$id;
	        	$roleMenu['menu_id']=$v;
	        	$result=$db->save($roleMenu);
                if(!$result){
                    $db->rollback();
                    $this->error('添加失败,请联系管理员');
                }
	        }
	        $db->commit();
	    }
	}
}
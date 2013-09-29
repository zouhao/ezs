<?php
/**
 * 用户管理
 * @author zouhao
 *	qq:16852868
 *	zouhao619@gmail.com
 */
class UserController extends CommonController{
	public function add(){
	    if($this->isGet()){
	        $this->assign('title',"添加管理员");
            $role=M('Role')->field(array('id','name'))->select();
            $this->assign('role',$role);
            $this->display();
	    }else{
	        $db=M(CONTROLLER_NAME);
            if(!$db->create()){
                $this->error($db->getError());
            }
            unset($_POST['repassword']);
            $rs=$db->save($_POST);    
            if($rs){
                $this->success('添加管理员成功',U('index'));
            }else{
                $this->error('添加管理员失败,请联系管理员');
            }
	    }
	}
	//职位管理界面
	public function index(){
		$db = M(CONTROLLER_NAME); 
		$count = $db->count();    //计算总数 
		$p = new Page($count); 
		$list = $db->field('`id`,`username`')->order("id asc")->limit($p->firstRow . ',' . $p->listRows)->select(); 
		$page = $p->show(); 
		$this->assign("page", $page); 
		$this->assign("list", $list); 
		$this->assign('title','管理员管理');
		$this->display(); 
	}
	public function edit(){
	    if($this->isGet()){
	        $list=M(CONTROLLER_NAME)->where(array('id'=>$_GET['id']))->find();
            $this->assign('list',$list);
            $role=M('Role')->field(array('id','name'))->select();
            $this->assign('role',$role);
            $this->assign('title','编辑管理员');
            $this->display();
	    }else{
	        $db=M(CONTROLLER_NAME);
	        if(!empty($_POST['password'])){
	            $data['password']=md5($_POST['password']);
	            $data['repassword']=md5($_POST['repassword']);
            }
            $data['id']=$_POST['id'];
            $data['email']=$_POST['email'];
            $data['username']=$_POST['username'];
            if(!$db->create($data)){
                $this->error($db->getError());
            }
            $rs=$db->update($data);   
            $this->success('编辑管理员成功',U('index'));
	    }
	}
}

<?php
/**
 * @author zouhao
 *	qq:16852868
 *	zouhao619@gmail.com
 */
class JobController extends CommonController{
	public function add(){
		if($this->isGet()){
			$this->assign('title',"添加职务");
			$this->display();
		}else{
			$db=M(CONTROLLER_NAME);
			if(!$db->create()){
				$this->error($db->getError());
			}
			$rs=$db->save($_POST); 
			if($rs){
				$this->success('添加职位成功',U('index'));
			}else{
				$this->error('添加职位失败,请联系管理员');
			}
		}
	}
	//职位管理界面
	public function index(){
		$db = M(CONTROLLER_NAME); 
		$count = $db->count();    //计算总数 
		$p = new Page($count); 
		$list = $db->order("id desc")->limit($p->firstRow . ',' . $p->listRows)->select(); 
		$page = $p->show(); 
		$this->assign("page", $page); 
		$this->assign("list", $list); 
		$this->assign('title','职位管理');
		$this->display(); 
	}
	public function edit(){
		if($this->isGet()){
			$list=M(CONTROLLER_NAME)->where(array('id'=>$_GET['id']))->find();
			$this->assign('list',$list);
			$this->assign('title','编辑职位');
			$this->display();
		}else{
			$db=M(CONTROLLER_NAME);
			if(!$db->create()){
				$this->error($db->getError());
			}
			$rs=$db->update($_POST);    
			if($rs){
				$this->success('编辑职位成功',U('index'));
			}else{
				$this->error('编辑职位失败,请联系管理员');
			}
		}
	}
	public function reply(){
		$db = M(CONTROLLER_NAME."_Reply"); 
		$count = $db->count();    //计算总数 
		$p = new Page($count,C('PAGE_LISTROWS')); 
		$list = $db->order("id desc")->limit($p->firstRow . ',' . $p->listRows)->select(); 
		$page = $p->show(); 
		$this->assign("page", $page); 
		$this->assign("list", $list); 
		$this->assign('title','职位应聘');
		$this->display(); 
	}
	public function replyDelete(){
		parent::delete(CONTROLLER_NAME.'_Reply');
	}
	public function read(){
		$list=M(array(CONTROLLER_NAME."_Reply"=>'reply'))->field('reply.*,job.title')->join('join '.C('DB_PREFIX').'job job on job.id=reply.job_id')->where(array('reply.id'=>$_GET['id']))->find();
		$this->assign('list',$list);
		$this->assign('sex',sex());
		$this->assign('marry',marry());
		$this->assign('education',education());
		$this->assign('title','查看应聘');
		$this->display();
	}
}
?>

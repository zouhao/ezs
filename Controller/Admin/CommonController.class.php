<?php
/**
 * @author zouhao
 *	qq:16852868
 *	zouhao619@gmail.com
 */
class CommonController extends Controller {	
	protected $tpl=null;
	public function init()
	{
		if(empty($_SESSION['admin'])){
			$this->redirect('Public/login');
		}
		if(!in_array(CONTROLLER_NAME.'/'.METHOD_NAME,$_SESSION['accessList'])){
			$this->error('权限不够!');
		}
		$this->assign('title',array_search(CONTROLLER_NAME.'/'.METHOD_NAME,$_SESSION['accessList']));
	}
	public function index(){
		$db = M(CONTROLLER_NAME);
		$count = $db->count();    //计算总数
		$p = new Page($count);
		$list = $db->order("id desc")->limit($p->firstRow . ',' . $p->listRows)->select();
		$page = $p->show();
		$this->assign("page", $page);
		$this->assign("list", $list);
		$this->display($this->tpl);
	}
	public function save(){
		if($this->isGet()){
			$this->display($this->tpl);
		}else{
			$db=D(CONTROLLER_NAME);
			$db->create() or $this->error($db->getError());
			if($db->save($_POST)){
				$this->redirect('index');
			}else{
				$this->error('添加失败');
			}
		}
	}
	public function update(){
		if($this->isGet()){
			$info=M(CONTROLLER_NAME)->where('id='.intval($_GET['id']))->find();
			$this->assign('info',$info);
			if($this->tpl==null)
			$this->display('save');
			else 
				$this->display($this->tpl);			
		}else{
			$db=D(CONTROLLER_NAME);
			$db->create() or $this->error($db->getError());
			if($db->update($_POST)){
				$this->redirect('index');
			}else{
				$this->error('编辑失败');
			}
		}
	}
	public function delete(){
		$db=M(CONTROLLER_NAME);
		if(isset($_GET['id'])){
			$rs=$db->delete(array('id'=>$_GET['id']));
		}else{
			$rs=$db->delete(array('id'=>array('in',$_POST['id'])));
		}
		if($rs){
			$this->redirect('index');
		}else{
			$this->error('删除失败,请联系管理员');
		}   		
	}
	protected function clearImg(){
		$_SESSION['img']=null;
		$_SESSION['small_img']=null;
		$_SESSION['big_img']=null;
	}
}

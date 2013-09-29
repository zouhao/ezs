<?php
/**
 * @author zouhao
 *	qq:16852868
 *	zouhao619@gmail.com
 */
class LinkController extends CommonController {
	public function index()
	{
	    $db = M(CONTROLLER_NAME); 
        $count = $db->count();    //计算总数 
        $p = new Page($count); 
        $list = $db->order("sort desc")->limit($p->firstRow . ',' . $p->listRows)->select(); 
        $page = $p->show(); 
        $this->assign("page", $page); 
        $this->assign("list", $list); 
        $this->assign('title','友情链接管理');
		$this->display();
	}
	public function add(){
	    if($this->isGet()){
	       $this->assign('title','添加友情链接');
	       $this->display();
        }else{
            $db=M(CONTROLLER_NAME);
            if(!$db->create()){
                $this->error($db->getError());
            }
            $rs=$db->save($_POST);
            if($rs){
                $this->success('添加友情连接成功',U('index'));
            }else{
                $this->error('添加友情连接失败,请联系管理员');
            }
        }
	}
	public function edit(){
	    if($this->isGet()){
	       $link=M(CONTROLLER_NAME)->where(array('id'=>$_GET['id']))->find();
	       $this->assign('link',$link);
           $this->assign('title','编辑友情链接');
           $this->display();
        }else{
            $db=M(CONTROLLER_NAME);
            if(!$db->create()){
                $this->error($db->getError());
            }
            $rs=$db->update($_POST); 
            if($rs){
                $this->success('编辑友情连接成功',U('index'));
            }else{
                $this->error('编辑友情连接失败,请联系管理员');
            }
        }
	}
}
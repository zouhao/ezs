<?php
/**
 * @author zouhao zouhao619@gmail.com
 * QQ:16852868
 */
class ProductController extends CommonController{
	public $v_title='型号';
	public $title='产品中心';
	public function index(){
		$map['is_hidden']=0;
		if(isset($_GET['id'])){
			$map['category_id']=intval($_GET['id']);
		}
		$db = M(CONTROLLER_NAME);
		$count = $db->where($map)->count();    //计算总数
		$p = new Page($count,9);
		$list = $db->where($map)->order("sort desc")->limit($p->firstRow . ',' . $p->listRows)->select();
		$page = $p->show();
		$this->assign("page", $page);
		$this->assign("list", $list);
		$this->assign('title',$this->title);
		$this->assign('v_title',$this->v_title);
		$this->assign('categoryList',M(CONTROLLER_NAME.'Category')->order('sort desc')->select());
		$this->display('Product/index');
	}
}
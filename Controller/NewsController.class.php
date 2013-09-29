<?php
/**
 * @author zouhao zouhao619@gmail.com
 * QQ:16852868
 */
class NewsController extends CommonController {
	public function index(){
		$id=isset($_GET['id'])?intval($_GET['id']):0;
		if($id == 0){
			$where='is_hidden = 0';
		}else{
			$where="is_hidden = 0 and category_id={$id}";
		}
		$count=M('News')->where($where)->count();
		$page=new Page($count);
 		$newsList = M("News")->where($where)->order("id desc")->limit("{$page->firstRow},{$page->listRows}")->select();
		$this->assign('newsList',$newsList);
		$this->assign('page',$page->show());
		$this->display();
	}
	
	public function read()
	{
		$id=intval($_GET['id']);
		$news = M("news")->where('id='.$id.' and is_hidden=0')->find();
		$this->assign("news", $news);
		$this->display();
	}
}
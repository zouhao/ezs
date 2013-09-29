<?php
/**
 * @author zouhao zouhao619@gmail.com
 * QQ:16852868
 */
class CaseController extends CommonController{
	public function index(){
		$p=new ProductController();
		$p->v_title='名称';
		$p->title='工程案例';
		$p->index();
	}
}
<?php
/**
 * @author zouhao zouhao619@gmail.com
 * QQ:16852868
 */
class ContactController extends CommonController{
	public function contact(){
		$contact = M("special")->where("name = 'contact'")->find();
		$this->assign("contact", $contact);
		$this->display();
	}
}
<?php
/**
 * 控制器基类
 * @author ZouHao  zouhao619@gmail.com
 */
abstract class Controller{
	protected $config;//配置文件类
	private $view;//视图类
	/**
	 * 控制器构造函数
	 * 初始化View类
	 * 并判断是否存在init AOP切面编程
	 */
	public function Controller() {
		$this->view = View::getInstance ();
		$this->config=C();
		//构造自定义构造函数
		if (method_exists ( $this, 'init' )) {
			$this->init ();
		}
		//AOP切面置前执行
		$before = METHOD_NAME . 'Before';
		if (method_exists ( $this, $before )) {
			$this->$before ();
		}
	}
	/**
	 * 析构函数,添加AOP 置后方法
	 */
	public function __destruct() {
		$after = METHOD_NAME . 'After';
		if (method_exists ( $this, $after )) {
			$this->$after ();
		}
	}
	/**
	 * 魔术方法,当找不方法时调用此函数(默认调用display方法)
	 * @param string $method
	 * @param array $arg
	 */
	public function __call($method,$arg){
		$this->display();
	}
	/**
	 * 获取当前访问Controller
	 * 
	 * @return string
	 */
	protected function getControllerName() {
		return CONTROLLER_NAME;
	}
	/**
	 * 获取当前访问method
	 * 
	 * @return string
	 */
	protected function getMethodName() {
		return METHOD_NAME;
	}
	/**
	 * 传值
	 * 
	 * @param int|float|string|array $name        	
	 * @param int|float|string|array| $value        	
	 */
	public function assign($name, $value = null) {
		$this->view->assign ( $name, $value );
	}
	/**
	 * 根据模板输出html
	 * 
	 * @param string $tpl        	
	 */
	public function display($tpl = null, $createTpl = true) {
		$this->view->display ( $tpl, $createTpl );
	}
	/**
	 * 获取模板html
	 * 
	 * @param string $tpl        	
	 * @return string
	 */
	protected function fetch($tpl = null) {
		return $this->view->fetch ( $tpl );
	}
	/**
	 * 判断是否是get提交
	 * 
	 * @return boolean
	 */
	protected function isGet() {
		if ($_SERVER ['REQUEST_METHOD'] == 'GET')
			return true;
		else
			return false;
	}
	/**
	 * 判断是否是post提交
	 * 
	 * @return boolean
	 */
	protected function isPost() {
		if ($_SERVER ['REQUEST_METHOD'] == 'POST')
			return true;
		else
			return false;
	}
	/**
	 * 基础方法,用于实现跳转页面
	 * 
	 * @param string $msg        	
	 * @param string $jumpUrl        	
	 * @param int $waitSecond        	
	 * @param string $tpl        	
	 */
	private function jumpUrl($flag, $message, $jumpUrl = null, $waitSecond, $tpl = null) {
		empty ( $tpl ) and $tpl = 'Common/jump';
		$this->assign ( 'flag', $flag );
		$this->assign ( 'message', $message );
		$this->assign ( 'jumpUrl', $jumpUrl );
		$this->assign ( 'waitSecond', $waitSecond );
		$this->display ( $tpl, false );
		exit ();
	}
	
	/**
	 * 成功跳转页面
	 * 
	 * @param string $msg        	
	 * @param string $jumpUrl        	
	 * @param int $waitSecond        	
	 */
	protected function success($message, $jumpUrl = null, $waitSecond = 1) {
		empty ( $jumpUrl ) and $jumpUrl = $_SERVER ["HTTP_REFERER"];
		$this->jumpUrl ( 'success', $message, $jumpUrl, $waitSecond );
	}
	
	/**
	 * 失败跳转页面
	 * 
	 * @param string $msg        	
	 * @param string $jumpUrl        	
	 * @param int $waitSecond        	
	 */
	protected function error($message, $jumpUrl = null, $waitSecond = 3) {
		empty ( $jumpUrl ) and $jumpUrl = 'javascript:history.back(-1);';
		$this->jumpUrl ( 'error', $message, $jumpUrl, $waitSecond );
	}
	/**
	 * 跳转页面
	 * 
	 * @param string $url
	 *        	链接地址
	 * @param boolean $isStation
	 *        	是否是站内
	 */
	protected function redirect($url, $isStation = true) {
		$isStation and $url = U ( $url );
		header ( "location:{$url}" );
		exit ();
	}
}
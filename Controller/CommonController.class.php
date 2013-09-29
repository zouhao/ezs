<?php
//公共基类,这里做修改必须要通知
/**
 * @author zouhao zouhao619@gmail.com
 * QQ:16852868
 */
class CommonController extends Controller {	
	public function init(){
		$map['is_hidden']=0;
		$map['type']=0;
		$adTop=M('Ad')->where($map)->order('sort desc')->select();
		$map['type']=1;
		$adDown=M('Ad')->where($map)->order('sort desc')->select();
		$adTmp=array();	
		foreach($adTop as $v){
			$adTmp[]=__UPLOAD__.'/'.$v['img'];
		}
		$bigImg=implode('|',$adTmp);
		$this->assign('bigImg',$bigImg);
		$this->assign('adDown',$adDown);
	}
	protected function upload(){
		$upload = new UploadFile();// 实例化上传类
		if(!$upload->upload(UPLOAD_PATH.'/')) {// 上传错误提示错误信息
			$this->error($upload->getErrorMsg());
		}else{// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();
		}
		return $info;
	}
}

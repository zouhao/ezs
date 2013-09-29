<?php
/**
 * 是否禁止
 * @param int $k
 * @return mix
 */
function isForbid($k=null){
	$f=array('否','是');
	if($f==null){
		return $f;
	}else{
		return $f[$k];
	}
}
/**
 * 是否隐藏
 * @param int $k
 * @return mix
 */
function isHidden($k=null){
	$h=array('显示','隐藏');
	if($k==null){
		return $h;
	}else{
		return $h[$k];
	}
}
/**
 * 获取管理员id
 */
function getAdminId(){
	return $_SESSION['admin']['id'];
}
/**
 * 广告数据字典
 * @param string $k
 * @return mix
 */
function adType($k=null){
	$t=array('图片轮播(上)','图片轮播(下)');
	if($k==null){
		return $t;
	}else{
		return $t[$k];
	}
}
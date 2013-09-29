<?php
/**
 * 数组生成Excel
 * @author zouhao  zouhao619@gmail.com
 * 使用示例
 * $excel =new Excel();
	$data=array(
			array('id'=>1,'name'=>'天命1'),
			array('id'=>2,'name'=>'天命2')
		);
	$header=array('ID','角色名');
	$excel->setFileName('aaa');
	$excel->setTitle('工作区1');
	$excel->create($data,$header);
 */
class Excel {
	private $excelObj;
	private $fileName='download.xls';
	/**
	 * 设置下载时文件名
	 * @param string $fileName
	 */
	public function setFileName($fileName){
		$this->fileName=$fileName.'.xls';
	}
	/**
	 * 设置标题
	 * @param string $title        	
	 */
	public function setTitle($title) {
		$this->excelObj->getActiveSheet ()->setTitle ( $title );
	}
	public function __construct() {
		// 先取消原框架的自动注册机制,避免和excel自动加载机制冲突
		spl_autoload_unregister ( 'autoload' );
		require LIBRARY_PATH . '/PHPExcel/PHPExcel.php';
		$this->excelObj = new PHPExcel ();
	}
	/**
	 * 根据总数,返回列数组
	 * 
	 * @param int $count        	
	 * @return array
	 */
	private function getCharByNumber($data) {
		// 自动减去头部
		$count = count ( $data ['0'] );
		$keys=array();
		for($number = 1; $number <=$count; $number ++) {
			$divisor= intval($number / 26);
			$char = chr ( 64 + $number % 26 );
			$char = $divisor == 0 ? $char : chr ( 64 +$divisor) . $char;
			$keys [] = $char;
		}
		return $keys;
	}
	/**
	 * 生成Excel表格
	 * @param array $data		二维数组
	 * @param array $replace	需要替换的数组
	 */
	public function create($data,$header=array(),$replace = null) {
		empty($data) and exit('没有数据');
		$keys = $this->getCharByNumber ( $data );
		$this->createHeader ( $header, $keys );
		$j=0;
		foreach ( $data as $i=>$vo ) {
			$j=0;
			foreach ( $vo as $key => $item ) {
				if (isset ( $replace [$key] )){
					$this->excelObj->setActiveSheetIndex ( 0 )->setCellValue ( $keys [$j] . ($i + 2), $replace [$key] [$item] );
				}else{
					$this->excelObj->setActiveSheetIndex ( 0 )->setCellValue ( $keys [$j] . ($i + 2), $item );
				}
				++$j;
			}
		}
		//输出到临时缓冲区  提供下载
		header ( "Content-Type: application/force-download" );
		header ( "Content-Type: application/octet-stream" );
		header ( "Content-Type: application/download" );
		header ( 'Content-Disposition:inline;filename="'.$this->fileName.'"' );
		header ( "Content-Transfer-Encoding: binary" );
		header ( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
		header ( "Pragma: no-cache" );
		$objWriter = PHPExcel_IOFactory::createWriter ( $this->excelObj, 'Excel5' );
		$objWriter->save ( 'php://output' );
	}
	/**
	 * 创建头部
	 * 
	 * @param array $data        	
	 */
	private function createHeader($header, $keys) {
		$header = array_combine ( $keys, $header );
		foreach ( $header as $key => $vo ) {
			$this->excelObj->setActiveSheetIndex ( 0 )->setCellValue ( "{$key}1", $vo );
		}
	}
}
<?php
/**
 * 数据库处理类
 * @author ZouHao  zouhao619@gmail.com
 */
class Mysql {
	private $conn;
	private $config;
	private $oneField=null;
	private $oneArray=null;
	private $twoArrayField=null;
	private $keyField=null;
	private $field=null;
	private static $instance = null;
	public function __set($name, $value) {
		$this->$name = $value;
	}
	/**
	 * 单例入口
	 */
	public static function getInstance($config) {
		if (is_null ( self::$instance )) {
			self::$instance = new Mysql ();
			self::$instance->config = $config;
		}
		return self::$instance;
	}
	public function __construct() {
		if (! is_null ( self::$instance )) {
			die ( '单例模式,不允许在实例化!' );
		}
	}
	public function __destruct(){
		if($this->conn)
			mysql_close($this->conn);
	}
	/**
	 * mysql连接
	 */
	private function connect() {
		if (! ($this->conn = mysql_connect ( $this->config ['DB_HOST'], $this->config ['DB_USER'], $this->config ['DB_PWD'] ))) {
			die ( '连接不上Mysql数据库' );
		}
		mysql_select_db ( $this->config ['DB_NAME'],$this->conn );
		if (mysql_get_server_info () > '4.1') {
			mysql_query ( "set names " . $this->config ['DB_CHARSET'] );
		}
	}
	public function mysqlQuery($sql){
		if (! $this->conn)
			$this->connect ();
		return mysql_query($sql);
	}
	public function mysqlFetchArray($result){
		return mysql_fetch_array($result,MYSQL_ASSOC);
	}
	/**
	 * 执行sql语句
	 *
	 * @param string $sql   
	 * @throws Exception
	 * @return 查询语句返回查询结构
	 */
	public function query($sql, $error = false) {
		if (! $this->conn)
			$this->connect ();
		$rs = mysql_query ( $sql,$this->conn );
		if (is_bool ( $rs )) {
			if ($error == false) {
				$errorLog = C ( 'ERROR_LOG' );
				if (! empty ( $errorLog ) && $rs == false) {
					error_log ( date('Y-m-j H:i:s').' ID:'.$_SESSION[C('USER_AUTH_ID')].$sql . "\r\n", 3, C ( 'ERROR_LOG' ) );
				}
			}
			return $rs;
		} else {
			$data = array ();
			if($this->oneArray==true){
				if($this->keyField==null){
					while ( $row = mysql_fetch_array ( $rs, MYSQL_ASSOC ) ) {
						$data [] = $row[$this->oneField];
					}
				}else{
					while ( $row = mysql_fetch_array ( $rs, MYSQL_ASSOC ) ) {
						$data [$row[$this->keyField]] = $row[$this->oneField];
					}
				}
			}elseif($this->twoArrayField!=null){
				while ( $row = mysql_fetch_array ( $rs, MYSQL_ASSOC ) ) {
					$data [$row[$this->twoArrayField]] = $row;
				}
			}else{
				while ( $row = mysql_fetch_array ( $rs, MYSQL_ASSOC ) ) {
					$data [] = $row;
				}
			}
			empty($data) and $data=array();
			return $data;
		}
	}
}

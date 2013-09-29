<?php
/**
 * 基于Model
 * 关联查询功能
 * @author ZouHao zouhao619@gmail.com
 */
class RelationModel extends Model {
	const ONE_TO_ONE = 1;
	const ONE_TO_MANY = 2;
	const UPDATE = 1;
	const DELETE = 2;
	protected $relation = null;
	private function getParentKey($key) {
		static $_parentKey = array ();
		if (! empty ( $_parentKey [$key] ))
			return $_parentKey [$key];
		if (isset ( $this->_relation [$key] ['parent_key'] ))
			$_parentKey [$key] = $this->_relation [$key] ['parent_key'];
		else
			$_parentKey [$key] = $this->getPrimaryKey ();
		return $_parentKey [$key];
	}
	private function getForeignKey($key) {
		static $_foreignKey = array ();
		if (! empty ( $_foreignKey [$key] ))
			return $_foreignKey [$key];
		if (isset ( $this->_relation [$key] ['foreign_key'] ))
			$_foreignKey [$key] = $this->_relation [$key] ['foreign_key'];
		else
			$_foreignKey [$key] = $this->getPrimaryKey ( C ( 'DB_PREFIX' ) .$this->upperToUnderline (  $this->_relation [$key] ['table'] ) );
		return $_foreignKey [$key];
	}
	public function relation($relation = true) {
		$this->relation = $relation;
		return $this;
	}
	public function find() {
		if (! empty ( $this->_relation ) && $this->relation == true) {
			foreach ( $this->_relation as $key => $vo ) {
				$data = parent::find ();
				$map [$this->getForeignKey ( $key )] = $data [$this->getParentKey ( $key )];
				isset ( $vo ['where'] ) and is_array ( $vo ['where'] ) and $map = array_merge ( $map, $vo ['where'] );
				$this->table ( $vo ['table'] )->where ( $map )->field ( $vo ['field'] )->group ( $vo ['group'] )->order ( $vo ['order'] )->limit ( $vo ['limit'] );
				switch ($vo ['type']) {
					case self::ONE_TO_ONE :
						$mapData = parent::find ();
						break;
					case self::ONE_TO_MANY :
						$mapData = parent::select ();
						break;
				}
				$data [$key] = $mapData;
				return $data;
			}
		} else {
			return parent::find ();
		}
	}
	public function select() {
		if (! empty ( $this->_relation ) && $this->relation == true) {
			foreach ( $this->_relation as $key => $vo ) {
				$data = parent::select ();
				foreach ( $data as $i => $dataVo ) {
					$id [] = $dataVo [$this->getParentKey ( $key )];
				}
				$map [$this->getForeignKey ( $key )] = array (
						'in',
						$id 
				);
				is_array ( $vo ['where'] ) and $map = array_merge ( $map, $vo ['where'] );
				$this->table ( $vo ['table'] )->where ( $map )->field ( $vo ['field'] )->group ( $vo ['group'] )->order ( $vo ['order'] )->limit ( $vo ['limit'] );
				$mapData = parent::select ();
				switch ($vo ['type']) {
					case self::ONE_TO_ONE :
						foreach ( $data as $i => $dataVo ) {
							foreach ( $mapData as $mapDataVo ) {
								if ($mapDataVo [$this->getForeignKey ( $key )] == $dataVo [$this->getParentKey ( $key )]) {
									$data [$i] [$key] = $mapDataVo;
									break;
								}
							}
						}
						break;
					case self::ONE_TO_MANY :
						foreach ( $data as $i => $dataVo ) {
							foreach ( $mapData as $mapDataVo ) {
								if ($mapDataVo [$this->getForeignKey ( $key )] == $dataVo [$this->getParentKey ( $key )]) {
									$data [$i] [$key] [] = $mapDataVo;
								}
							}
						}
						break;
				}
				$data [$key] = $mapData;
				return $data;
			}
		} else {
			return parent::select ();
		}
	}
	public function save($data) {
		if (! empty ( $this->_relation ) && $this->relation == true) {
			$rs = parent::save ( $data );
			foreach ( $this->_relation as $key => $vo ) {
				if (! array_key_exists ( $this->getParentKey ( $key ), $data )) {
					$data [$this->getParentKey ( $key )] = $rs;
				}
				$map = array ();
				is_array ( $vo ['where'] ) and $map = $vo ['where'];
				$this->table ( $vo ['table'] )->where ( $map )->field ( $vo ['field'] )->group ( $vo ['group'] )->order ( $vo ['order'] )->limit ( $vo ['limit'] );
				switch ($vo ['type']) {
					case self::ONE_TO_ONE :
						$data [$key] [$this->getForeignKey ( $key )] = $data [$this->getParentKey ( $key )];
						break;
					case self::ONE_TO_MANY :
						foreach ( $data [$key] as $i => $dataVo ) {
							$data [$key] [$i] [$this->getForeignKey ( $key )] = $data [$this->getParentKey ( $key )];
						}
						break;
				}
				if (! parent::save ( $data [$key] )) {
					return false;
				}
			}
			return true;
		} else {
			return parent::save ( $data );
		}
	}
	public function update($data) {
		$primaryKey=$this->getPrimaryKey();
		if (! empty ( $this->_relation ) && $this->relation == true) {
			$rs = parent::update ( $data );
			foreach ( $this->_relation as $key => $vo ) {
				$this->table ( $vo ['table'] );
				switch ($vo ['type']) {
					case self::ONE_TO_ONE :
						if (array_key_exists ( $this->strtolower ( C ( 'DB_PREFIX' ) . $vo ['table'] ), $data [$key] )) {
							parent::update ( $data [$key] );
						} else {
							parent::save ( $data [$key] );
						}
						break;
					case self::ONE_TO_MANY :
						$this->delete(array($this->getForeignKey($key)=>$data[$primaryKey]));
						empty($data[$key]) or $rs=parent::save($data[$key]);
						if(!$rs)
							return false;
						return true;
						break;
				}
			}
		} else {
			return parent::update ( $data );
		}
	}
}

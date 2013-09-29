<?php
/**
 * 基于Model
 * 增加查询缓存功能
 */
class CacheModel extends Model{
    protected $cache = null; // 是否查询缓存
    protected $cacheTime = null; // 缓存时间
    /**
     * 是否缓存结构
     * @param boolean $cache            
     * @param int $cacheTime            
     * @return Model
     */
    public function cache($cache = true, $cacheTime = null) {
        $this->cache = $cache;
        empty($cacheTime) and $this->cacheTime =C('CACHE_EXPIRE');
        return $this;
    }
    /**
     * 从缓存中获取结果,如果没有则查询并放入数据库
     * @return array
     */
    private function selectCache() {
    	$this->getSql ();
        $cacheName = md5 ( $this->sql );
        $data = empty ( $this->cacheTime ) ? F ( $cacheName ) : F ( $cacheName, null, $this->cacheTime );
        if ($data == null) {
            $data = $this->query ( $this->sql );
            F ( $cacheName, $data );
        }else{
            $this->initVar();
        }
        return $data;
    }
    /**
     * 查询数据库,获取二维数组
     * @return array bool
     */
    public function select() {
        if ($this->cache == true) {
            return $this->selectCache ();
        } else {
            return parent::select();
        }
    }
    /**
     * 查询数据 获取一行
     * @return array
     */
    public function find() {
        if ($this->cache == true) {
            $this->sql .= ' limit 1';
            $data = $this->selectCache ();
            return $data [0];
        } else {
            return parent::find();
        }
    }
}

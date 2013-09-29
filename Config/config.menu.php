<?php
$i = 0;
return array (
		array (
				'name' => '首页',
				'children' => array (
						array (
								'id' => ++ $i,
								'name' => '个人桌面',
								'url' => 'Index/index',
								'is_open' => true ,
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '基本信息',
								'url' => 'Index/home',
								'is_open' => true
						),
						array (
								'id' => ++ $i,
								'name' => '站点配置',
								'url' => 'Index/setting' 
						) 
				) 
		),
		array (
				'name' => '用户管理',
				'children' => array (
						array (
								'id' => ++ $i,
								'name' => '管理员管理',
								'url' => 'Admin/index' 
						),
						array (
								'id' => ++ $i,
								'name' => '管理员添加',
								'url' => 'Admin/save',
								'is_hidden' => true 
						),
						array (
								'id' => ++ $i,
								'name' => '管理员编辑',
								'url' => 'Admin/update',
								'is_hidden' => true 
						),
						array (
								'id' => ++ $i,
								'name' => '管理员删除',
								'url' => 'Admin/delete',
								'is_hidden' => true 
						),
						array (
								'id' => ++ $i,
								'name' => '角色管理',
								'url' => 'Role/index' 
						),
						array (
								'id' => ++ $i,
								'name' => '角色添加',
								'url' => 'Role/save',
								'is_hidden' => true 
						),
						array (
								'id' => ++ $i,
								'name' => '角色编辑',
								'url' => 'Role/update',
								'is_hidden' => true 
						),
						array (
								'id' => ++ $i,
								'name' => '角色删除',
								'url' => 'Role/delete',
								'is_hidden' => true 
						) 
				) 
		),
		array (
				'name' => '新闻管理',
				'children' => array (
						array (
								'id' => ++ $i,
								'name' => '新闻管理',
								'url' => 'News/index' 
						),
						array (
								'id' => ++ $i,
								'name' => '新闻添加',
								'url' => 'News/save',
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '新闻编辑',
								'url' => 'News/update',
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '新闻删除',
								'url' => 'News/delete',
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '新闻类别管理',
								'url' => 'NewsCategory/index' 
						) ,
						array (
								'id' => ++ $i,
								'name' => '新闻类别添加',
								'url' => 'NewsCategory/save',
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '新闻类别编辑',
								'url' => 'NewsCategory/update',
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '新闻类别删除',
								'url' => 'NewsCategory/delete',
								'is_hidden'=>true
						),
				) 
		),
		array (
				'name' => '产品管理',
				'children' => array (
						array (
								'id' => ++ $i,
								'name' => '产品管理',
								'url' => 'Product/index' 
						),
						array (
								'id' => ++ $i,
								'name' => '产品添加',
								'url' => 'Product/save',
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '产品编辑',
								'url' => 'Product/update',
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '产品删除',
								'url' => 'Product/delete',
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '产品类别管理',
								'url' => 'ProductCategory/index' 
						),
						array (
								'id' => ++ $i,
								'name' => '产品类别添加',
								'url' => 'ProductCategory/save',
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '产品类别编辑',
								'url' => 'ProductCategory/update',
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '产品类别删除',
								'url' => 'ProductCategory/delete',
								'is_hidden'=>true
						)
				) 
		),
		array (
				'name' => '工程案例',
				'children' => array (
						array (
								'id' => ++ $i,
								'name' => '案例管理',
								'url' => 'Case/index' 
						),
						array (
								'id' => ++ $i,
								'name' => '案例添加',
								'url' => 'Case/save',
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '案例编辑',
								'url' => 'Case/update',
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '案例删除',
								'url' => 'Case/delete',
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '案例类别管理',
								'url' => 'CaseCategory/index' 
						),
						array (
								'id' => ++ $i,
								'name' => '案例类别添加',
								'url' => 'CaseCategory/save',
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '案例类别编辑',
								'url' => 'CaseCategory/update',
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '案例类别删除',
								'url' => 'CaseCategory/delete',
								'is_hidden'=>true
						)
				) 
		),
		array (
				'name' => '图片轮播管理',
				'children' => array (
						array (
								'id' => ++ $i,
								'name' => '图片轮播管理',
								'url' => 'Ad/index' 
						),
						array (
								'id' => ++ $i,
								'name' => '图片轮播添加',
								'url' => 'Ad/save',
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '图片轮播编辑',
								'url' => 'Ad/update',
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '图片轮播删除',
								'url' => 'Ad/delete',
								'is_hidden'=>true
						)
				) 
		),
		array (
				'name' => '特殊主题',
				'children' => array (
						array (
								'id' => ++ $i,
								'name' => '特殊主题管理',
								'url' => 'Special/index' 
						),
						array(
								'id'=>++$i,
								'name'=>'编辑特殊主题',
								'url'=>'Special/update',
								'is_hidden'=>true
						)
						 
				) 
		),
		array (
				'name' => '公司荣誉',
				'children' => array (
						array (
								'id' => ++ $i,
								'name' => '荣誉管理',
								'url' => 'Honor/index'
						),
						array (
								'id' => ++ $i,
								'name' => '荣誉添加',
								'url' => 'Honor/save',
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '荣誉编辑',
								'url' => 'Honor/update',
								'is_hidden'=>true
						),
						array (
								'id' => ++ $i,
								'name' => '荣誉删除',
								'url' => 'Honor/delete',
								'is_hidden'=>true
						)
				)
		),
);
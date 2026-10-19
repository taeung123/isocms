<?php
	$listTableInDb = array(); 
	
	/*Table _city*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='_city'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:5:"_city";s:23:"Tables_in_vietnamlan_db";s:5:"_city";}';
			
	$fieldTableInDb['city_id'] = "`city_id` int(10) unsigned NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['url'] = "`url` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['type_url'] = "`type_url` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` longtext NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['type_cat'] = "`type_cat` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['country_id'] = "`country_id` int(10) NOT NULL DEFAULT '1' ";
				
	$fieldTableInDb['top_tour'] = "`top_tour` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_top_hotel'] = "`is_top_hotel` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_show_top'] = "`is_show_top` tinyint(1) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "city_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `_city` (
	`city_id` int(10) unsigned NOT NULL  AUTO_INCREMENT,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`url` varchar(255) NOT NULL  ,
				`type_url` tinyint(1) NOT NULL  ,
				`intro` longtext NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`image` varchar(255) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`type_cat` varchar(255) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`country_id` int(10) NOT NULL DEFAULT '1' ,
				`top_tour` tinyint(1) NOT NULL  ,
				`is_top_hotel` tinyint(1) NOT NULL  ,
				`is_show_top` tinyint(1) NOT NULL  ,
				PRIMARY KEY (`city_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table _country*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='_country'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:8:"_country";s:23:"Tables_in_vietnamlan_db";s:8:"_country";}';
			
	$fieldTableInDb['country_id'] = "`country_id` int(10) unsigned NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['_area_id'] = "`_area_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['area_code'] = "`area_code` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` longtext NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['last_update'] = "`last_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['first_update'] = "`first_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['flag'] = "`flag` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_lock'] = "`is_lock` tinyint(1) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "country_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `_country` (
	`country_id` int(10) unsigned NOT NULL  AUTO_INCREMENT,
				`_area_id` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`area_code` varchar(255) NOT NULL  ,
				`intro` longtext NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`image` varchar(255) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`last_update` int(10) NOT NULL  ,
				`first_update` int(10) NOT NULL  ,
				`flag` varchar(255) NOT NULL  ,
				`is_lock` tinyint(1) NOT NULL  ,
				PRIMARY KEY (`country_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_activitylog*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_activitylog'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:19:"default_activitylog";s:23:"Tables_in_vietnamlan_db";s:19:"default_activitylog";}';
			
	$fieldTableInDb['id'] = "`id` int(10) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['date'] = "`date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ";
				
	$fieldTableInDb['description'] = "`description` text NOT NULL  ";
				
	$fieldTableInDb['user'] = "`user` text NOT NULL  ";
				
	$fieldTableInDb['userid'] = "`userid` int(10) NOT NULL  ";
				
	$fieldTableInDb['ipaddr'] = "`ipaddr` text NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_activitylog` (
	`id` int(10) NOT NULL  AUTO_INCREMENT,
				`date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ,
				`description` text NOT NULL  ,
				`user` text NOT NULL  ,
				`userid` int(10) NOT NULL  ,
				`ipaddr` text NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_adminbutton*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_adminbutton'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:19:"default_adminbutton";s:23:"Tables_in_vietnamlan_db";s:19:"default_adminbutton";}';
			
	$fieldTableInDb['adminbutton_id'] = "`adminbutton_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['parent_id'] = "`parent_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_group'] = "`is_group` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['title_page'] = "`title_page` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['mod_page'] = "`mod_page` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['act_page'] = "`act_page` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['url_page'] = "`url_page` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['class_page'] = "`class_page` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['class_iconpage'] = "`class_iconpage` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['CONFIGURATION_KEY'] = "`CONFIGURATION_KEY` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['_type'] = "`_type` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['permiss_access'] = "`permiss_access` text NOT NULL  ";
				
	$fieldTableInDb['dev_access'] = "`dev_access` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_active'] = "`is_active` tinyint(1) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "adminbutton_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_adminbutton` (
	`adminbutton_id` int(11) NOT NULL  AUTO_INCREMENT,
				`parent_id` int(10) NOT NULL  ,
				`is_group` tinyint(1) NOT NULL  ,
				`title_page` varchar(255) NOT NULL  ,
				`mod_page` varchar(255) NOT NULL  ,
				`act_page` varchar(255) NOT NULL  ,
				`url_page` varchar(255) NOT NULL  ,
				`class_page` varchar(255) NOT NULL  ,
				`class_iconpage` varchar(255) NOT NULL  ,
				`CONFIGURATION_KEY` varchar(255) NOT NULL  ,
				`_type` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`image` varchar(255) NOT NULL  ,
				`permiss_access` text NOT NULL  ,
				`dev_access` tinyint(1) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_active` tinyint(1) NOT NULL  ,
				PRIMARY KEY (`adminbutton_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_adminlog*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_adminlog'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:16:"default_adminlog";s:23:"Tables_in_vietnamlan_db";s:16:"default_adminlog";}';
			
	$fieldTableInDb['id'] = "`id` int(10) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['adminusername'] = "`adminusername` text NOT NULL  ";
				
	$fieldTableInDb['logintime'] = "`logintime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ";
				
	$fieldTableInDb['logouttime'] = "`logouttime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ";
				
	$fieldTableInDb['ipaddress'] = "`ipaddress` text NOT NULL  ";
				
	$fieldTableInDb['sessionid'] = "`sessionid` text NOT NULL  ";
				
	$fieldTableInDb['lastvisit'] = "`lastvisit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_adminlog` (
	`id` int(10) NOT NULL  AUTO_INCREMENT,
				`adminusername` text NOT NULL  ,
				`logintime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ,
				`logouttime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ,
				`ipaddress` text NOT NULL  ,
				`sessionid` text NOT NULL  ,
				`lastvisit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_ads*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_ads'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:11:"default_ads";s:23:"Tables_in_vietnamlan_db";s:11:"default_ads";}';
			
	$fieldTableInDb['ads_id'] = "`ads_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['type'] = "`type` varchar(50)   ";
				
	$fieldTableInDb['url'] = "`url` varchar(255)   ";
				
	$fieldTableInDb['list_id'] = "`list_id` varchar(255)   ";
				
	$fieldTableInDb['start_date'] = "`start_date` int(10)   ";
				
	$fieldTableInDb['end_date'] = "`end_date` int(10)   ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1)  DEFAULT '1' ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "ads_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_ads` (
	`ads_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`type` varchar(50)   ,
				`url` varchar(255)   ,
				`list_id` varchar(255)   ,
				`start_date` int(10)   ,
				`end_date` int(10)   ,
				`order_no` int(10) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_online` tinyint(1)  DEFAULT '1' ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`ads_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_ads_group*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_ads_group'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:17:"default_ads_group";s:23:"Tables_in_vietnamlan_db";s:17:"default_ads_group";}';
			
	$fieldTableInDb['ads_group_id'] = "`ads_group_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['parent_id'] = "`parent_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['mod_page'] = "`mod_page` text NOT NULL  ";
				
	$fieldTableInDb['act_page'] = "`act_page` text NOT NULL  ";
				
	$fieldTableInDb['_code'] = "`_code` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['_width'] = "`_width` int(10) NOT NULL  ";
				
	$fieldTableInDb['_height'] = "`_height` int(10) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['second_change'] = "`second_change` int(8) NOT NULL  ";
				
	$fieldTableInDb['max_share'] = "`max_share` int(8) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "ads_group_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_ads_group` (
	`ads_group_id` int(11) NOT NULL  AUTO_INCREMENT,
				`parent_id` int(8) NOT NULL  ,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`mod_page` text NOT NULL  ,
				`act_page` text NOT NULL  ,
				`_code` varchar(255) NOT NULL  ,
				`_width` int(10) NOT NULL  ,
				`_height` int(10) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`second_change` int(8) NOT NULL  ,
				`max_share` int(8) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`ads_group_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_app_language*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_app_language'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:20:"default_app_language";s:23:"Tables_in_vietnamlan_db";s:20:"default_app_language";}';
			
	$fieldTableInDb['code'] = "`code` char(2) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['name'] = "`name` varchar(20) NOT NULL  ";
				
	$fieldTableInDb['icon'] = "`icon` text NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "code";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_app_language` (
	`code` char(2) NOT NULL  AUTO_INCREMENT,
				`name` varchar(20) NOT NULL  ,
				`icon` text NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				PRIMARY KEY (`code`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_app_translation*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_app_translation'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:23:"default_app_translation";s:23:"Tables_in_vietnamlan_db";s:23:"default_app_translation";}';
			
	$fieldTableInDb['app_translation_id'] = "`app_translation_id` bigint(20) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['colname'] = "`colname` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['tbl_name'] = "`tbl_name` varchar(20) NOT NULL  ";
				
	$fieldTableInDb['tbl_field'] = "`tbl_field` varchar(20) NOT NULL  ";
				
	$fieldTableInDb['tbl_pval'] = "`tbl_pval` bigint(20) NOT NULL  ";
				
	$fieldTableInDb['value'] = "`value` longtext NOT NULL  ";
				
	$fieldTableInDb['app_language'] = "`app_language` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "app_translation_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_app_translation` (
	`app_translation_id` bigint(20) NOT NULL  AUTO_INCREMENT,
				`colname` varchar(255) NOT NULL  ,
				`tbl_name` varchar(20) NOT NULL  ,
				`tbl_field` varchar(20) NOT NULL  ,
				`tbl_pval` bigint(20) NOT NULL  ,
				`value` longtext NOT NULL  ,
				`app_language` varchar(2) NOT NULL  ,
				PRIMARY KEY (`app_translation_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_area*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_area'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:12:"default_area";s:23:"Tables_in_vietnamlan_db";s:12:"default_area";}';
			
	$fieldTableInDb['area_id'] = "`area_id` int(10) unsigned NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['continent_id'] = "`continent_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['country_id'] = "`country_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` longtext NOT NULL  ";
				
	$fieldTableInDb['content'] = "`content` text NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "area_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_area` (
	`area_id` int(10) unsigned NOT NULL  AUTO_INCREMENT,
				`continent_id` int(10) NOT NULL  ,
				`country_id` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` longtext NOT NULL  ,
				`content` text NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`image` varchar(255) NOT NULL  ,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`area_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_blog*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_blog'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:12:"default_blog";s:23:"Tables_in_vietnamlan_db";s:12:"default_blog";}';
			
	$fieldTableInDb['blog_id'] = "`blog_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['cat_id'] = "`cat_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['list_cat_id'] = "`list_cat_id` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['permalink'] = "`permalink` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['content'] = "`content` longtext NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['updateImage'] = "`updateImage` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_sitemap'] = "`is_sitemap` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "blog_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_blog` (
	`blog_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`cat_id` int(10) NOT NULL  ,
				`list_cat_id` varchar(255) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`permalink` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`content` longtext NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`updateImage` tinyint(1) NOT NULL  ,
				`is_sitemap` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`blog_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_blogcat*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_blogcat'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:15:"default_blogcat";s:23:"Tables_in_vietnamlan_db";s:15:"default_blogcat";}';
			
	$fieldTableInDb['blogcat_id'] = "`blogcat_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['parent_id'] = "`parent_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "blogcat_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_blogcat` (
	`blogcat_id` int(11) NOT NULL  AUTO_INCREMENT,
				`parent_id` int(10) NOT NULL  ,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`blogcat_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_booking*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_booking'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:15:"default_booking";s:23:"Tables_in_vietnamlan_db";s:15:"default_booking";}';
			
	$fieldTableInDb['booking_id'] = "`booking_id` int(10) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['target_id'] = "`target_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['clsTable'] = "`clsTable` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(50) NOT NULL  ";
				
	$fieldTableInDb['first_name'] = "`first_name` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['last_name'] = "`last_name` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['country_id'] = "`country_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['phone'] = "`phone` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['address'] = "`address` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['email'] = "`email` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['take_care'] = "`take_care` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['booking_code'] = "`booking_code` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['booking_store'] = "`booking_store` longtext NOT NULL  ";
				
	$fieldTableInDb['booking_html'] = "`booking_html` longtext NOT NULL  ";
				
	$fieldTableInDb['BOOK_VALUE'] = "`BOOK_VALUE` longtext NOT NULL  ";
				
	$fieldTableInDb['booking_type'] = "`booking_type` longtext NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['ip_booking'] = "`ip_booking` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['note'] = "`note` text NOT NULL  ";
				
	$fieldTableInDb['status'] = "`status` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['totalRate'] = "`totalRate` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['totalRateVND'] = "`totalRateVND` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['payment_choice'] = "`payment_choice` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['payment_status'] = "`payment_status` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['status_date'] = "`status_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['ret_url'] = "`ret_url` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_send_email'] = "`is_send_email` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_send_success'] = "`is_send_success` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['rate_exchange'] = "`rate_exchange` double NOT NULL  ";
				
	$fieldTableInDb['deposite'] = "`deposite` double NOT NULL  ";
				
	$fieldTableInDb['depositeVND'] = "`depositeVND` double NOT NULL  ";
				
	$fieldTableInDb['vpc_MerchTxnRef'] = "`vpc_MerchTxnRef` varchar(255) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "booking_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_booking` (
	`booking_id` int(10) NOT NULL  AUTO_INCREMENT,
				`target_id` int(10) NOT NULL  ,
				`clsTable` varchar(255) NOT NULL  ,
				`title` varchar(50) NOT NULL  ,
				`first_name` varchar(255) NOT NULL  ,
				`last_name` varchar(255) NOT NULL  ,
				`country_id` int(10) NOT NULL  ,
				`phone` varchar(255) NOT NULL  ,
				`address` varchar(255) NOT NULL  ,
				`email` varchar(255) NOT NULL  ,
				`take_care` tinyint(1) NOT NULL  ,
				`booking_code` varchar(255) NOT NULL  ,
				`booking_store` longtext NOT NULL  ,
				`booking_html` longtext NOT NULL  ,
				`BOOK_VALUE` longtext NOT NULL  ,
				`booking_type` longtext NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`ip_booking` varchar(255) NOT NULL  ,
				`note` text NOT NULL  ,
				`status` tinyint(1) NOT NULL  ,
				`totalRate` varchar(255) NOT NULL  ,
				`totalRateVND` varchar(255) NOT NULL  ,
				`payment_choice` tinyint(1) NOT NULL  ,
				`payment_status` tinyint(1) NOT NULL  ,
				`status_date` int(10) NOT NULL  ,
				`ret_url` varchar(255) NOT NULL  ,
				`is_send_email` tinyint(1) NOT NULL  ,
				`is_send_success` tinyint(1) NOT NULL  ,
				`rate_exchange` double NOT NULL  ,
				`deposite` double NOT NULL  ,
				`depositeVND` double NOT NULL  ,
				`vpc_MerchTxnRef` varchar(255) NOT NULL  ,
				PRIMARY KEY (`booking_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_category*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_category'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:16:"default_category";s:23:"Tables_in_vietnamlan_db";s:16:"default_category";}';
			
	$fieldTableInDb['cat_id'] = "`cat_id` int(5) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['list_domain_id'] = "`list_domain_id` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['_type'] = "`_type` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['parent_id'] = "`parent_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['code'] = "`code` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['permalink'] = "`permalink` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` longtext NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['min_val'] = "`min_val` int(10) NOT NULL  ";
				
	$fieldTableInDb['max_val'] = "`max_val` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "cat_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_category` (
	`cat_id` int(5) NOT NULL  AUTO_INCREMENT,
				`list_domain_id` varchar(255) NOT NULL  ,
				`_type` varchar(255) NOT NULL  ,
				`parent_id` int(8) NOT NULL  ,
				`code` varchar(255) NOT NULL  ,
				`user_id` int(8) NOT NULL  ,
				`permalink` varchar(255) NOT NULL  ,
				`intro` longtext NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`min_val` int(10) NOT NULL  ,
				`max_val` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`cat_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_city*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_city'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:12:"default_city";s:23:"Tables_in_vietnamlan_db";s:12:"default_city";}';
			
	$fieldTableInDb['city_id'] = "`city_id` int(10) unsigned NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['continent_id'] = "`continent_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['country_id'] = "`country_id` int(10) NOT NULL DEFAULT '1' ";
				
	$fieldTableInDb['region_id'] = "`region_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` longtext NOT NULL  ";
				
	$fieldTableInDb['intro_tour'] = "`intro_tour` longtext NOT NULL  ";
				
	$fieldTableInDb['intro_attraction'] = "`intro_attraction` longtext NOT NULL  ";
				
	$fieldTableInDb['intro_travel'] = "`intro_travel` longtext NOT NULL  ";
				
	$fieldTableInDb['intro_hotel'] = "`intro_hotel` longtext NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['map_lo'] = "`map_lo` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['map_la'] = "`map_la` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "city_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_city` (
	`city_id` int(10) unsigned NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`continent_id` int(10) NOT NULL  ,
				`country_id` int(10) NOT NULL DEFAULT '1' ,
				`region_id` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` longtext NOT NULL  ,
				`intro_tour` longtext NOT NULL  ,
				`intro_attraction` longtext NOT NULL  ,
				`intro_travel` longtext NOT NULL  ,
				`intro_hotel` longtext NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`map_lo` varchar(255) NOT NULL  ,
				`map_la` varchar(255) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`city_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_citystore*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_citystore'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:17:"default_citystore";s:23:"Tables_in_vietnamlan_db";s:17:"default_citystore";}';
			
	$fieldTableInDb['citystore_id'] = "`citystore_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['city_id'] = "`city_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['country_id'] = "`country_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['type'] = "`type` varchar(50) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "citystore_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_citystore` (
	`citystore_id` int(11) NOT NULL  AUTO_INCREMENT,
				`city_id` int(8) NOT NULL  ,
				`country_id` int(8) NOT NULL  ,
				`type` varchar(50) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`citystore_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_configuration*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_configuration'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:21:"default_configuration";s:23:"Tables_in_vietnamlan_db";s:21:"default_configuration";}';
			
	$fieldTableInDb['setting'] = "`setting` text NOT NULL  ";
				
	$fieldTableInDb['value'] = "`value` text NOT NULL  ";
				
	$itemTableInDb["pkey"] = "";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_configuration` (
	`setting` text NOT NULL  ,
				`value` text NOT NULL  ,
				  KEY `setting` (`setting`(32))		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_continent*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_continent'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:17:"default_continent";s:23:"Tables_in_vietnamlan_db";s:17:"default_continent";}';
			
	$fieldTableInDb['continent_id'] = "`continent_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "continent_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_continent` (
	`continent_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(8) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` varchar(255) NOT NULL  ,
				`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`image` varchar(255) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`continent_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_country*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_country'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:15:"default_country";s:23:"Tables_in_vietnamlan_db";s:15:"default_country";}';
			
	$fieldTableInDb['country_id'] = "`country_id` int(10) unsigned NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['continent_id'] = "`continent_id` int(8)   ";
				
	$fieldTableInDb['area_id'] = "`area_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['currency'] = "`currency` varchar(255)   ";
				
	$fieldTableInDb['intro'] = "`intro` longtext NOT NULL  ";
				
	$fieldTableInDb['intro_hotel'] = "`intro_hotel` longtext   ";
				
	$fieldTableInDb['intro_tour'] = "`intro_tour` longtext   ";
				
	$fieldTableInDb['intro_guide'] = "`intro_guide` longtext   ";
				
	$fieldTableInDb['content'] = "`content` longtext   ";
				
	$fieldTableInDb['flag'] = "`flag` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['banner'] = "`banner` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['user_id'] = "`user_id` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_lock'] = "`is_lock` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1)  DEFAULT '0' ";
				
	$fieldTableInDb['map_lo'] = "`map_lo` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['map_la'] = "`map_la` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "country_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_country` (
	`country_id` int(10) unsigned NOT NULL  AUTO_INCREMENT,
				`continent_id` int(8)   ,
				`area_id` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`currency` varchar(255)   ,
				`intro` longtext NOT NULL  ,
				`intro_hotel` longtext   ,
				`intro_tour` longtext   ,
				`intro_guide` longtext   ,
				`content` longtext   ,
				`flag` varchar(255) NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`banner` varchar(255) NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`user_id` varchar(255) NOT NULL  ,
				`user_id_update` varchar(255) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_lock` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1)  DEFAULT '0' ,
				`map_lo` varchar(255) NOT NULL  ,
				`map_la` varchar(255) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`country_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_cruise*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_cruise'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:14:"default_cruise";s:23:"Tables_in_vietnamlan_db";s:14:"default_cruise";}';
			
	$fieldTableInDb['cruise_id'] = "`cruise_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['cruise_cat_id'] = "`cruise_cat_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['cruise_code'] = "`cruise_code` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['price'] = "`price` bigint(10) NOT NULL  ";
				
	$fieldTableInDb['price_old'] = "`price_old` bigint(10) NOT NULL  ";
				
	$fieldTableInDb['hot_deals'] = "`hot_deals` int(10) NOT NULL  ";
				
	$fieldTableInDb['build'] = "`build` int(10) NOT NULL  ";
				
	$fieldTableInDb['star_number'] = "`star_number` int(1) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` longtext NOT NULL  ";
				
	$fieldTableInDb['overview'] = "`overview` longtext NOT NULL  ";
				
	$fieldTableInDb['policies'] = "`policies` longtext NOT NULL  ";
				
	$fieldTableInDb['retaurant'] = "`retaurant` longtext NOT NULL  ";
				
	$fieldTableInDb['deck_plan'] = "`deck_plan` longtext NOT NULL  ";
				
	$fieldTableInDb['room'] = "`room` longtext NOT NULL  ";
				
	$fieldTableInDb['bar'] = "`bar` longtext NOT NULL  ";
				
	$fieldTableInDb['activity'] = "`activity` longtext NOT NULL  ";
				
	$fieldTableInDb['note'] = "`note` longtext NOT NULL  ";
				
	$fieldTableInDb['note_price'] = "`note_price` longtext NOT NULL  ";
				
	$fieldTableInDb['what_include'] = "`what_include` longtext NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['view_num'] = "`view_num` int(10) NOT NULL  ";
				
	$fieldTableInDb['list_cat_id'] = "`list_cat_id` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['listService'] = "`listService` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['listTravelAs'] = "`listTravelAs` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['listCruiseBudget'] = "`listCruiseBudget` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['listCruiseFacilities'] = "`listCruiseFacilities` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['listCruiseFaActivities'] = "`listCruiseFaActivities` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "cruise_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_cruise` (
	`cruise_id` int(11) NOT NULL  AUTO_INCREMENT,
				`cruise_cat_id` int(10) NOT NULL  ,
				`cruise_code` varchar(255) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`price` bigint(10) NOT NULL  ,
				`price_old` bigint(10) NOT NULL  ,
				`hot_deals` int(10) NOT NULL  ,
				`build` int(10) NOT NULL  ,
				`star_number` int(1) NOT NULL  ,
				`intro` longtext NOT NULL  ,
				`overview` longtext NOT NULL  ,
				`policies` longtext NOT NULL  ,
				`retaurant` longtext NOT NULL  ,
				`deck_plan` longtext NOT NULL  ,
				`room` longtext NOT NULL  ,
				`bar` longtext NOT NULL  ,
				`activity` longtext NOT NULL  ,
				`note` longtext NOT NULL  ,
				`note_price` longtext NOT NULL  ,
				`what_include` longtext NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`view_num` int(10) NOT NULL  ,
				`list_cat_id` varchar(255) NOT NULL  ,
				`listService` varchar(255) NOT NULL  ,
				`listTravelAs` varchar(255) NOT NULL  ,
				`listCruiseBudget` varchar(255) NOT NULL  ,
				`listCruiseFacilities` varchar(255) NOT NULL  ,
				`listCruiseFaActivities` varchar(255) NOT NULL  ,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`cruise_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_cruise_cabin*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_cruise_cabin'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:20:"default_cruise_cabin";s:23:"Tables_in_vietnamlan_db";s:20:"default_cruise_cabin";}';
			
	$fieldTableInDb['cruise_cabin_id'] = "`cruise_cabin_id` int(10) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['cruise_id'] = "`cruise_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` longtext NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['price'] = "`price` int(8) NOT NULL  ";
				
	$fieldTableInDb['cabin_size'] = "`cabin_size` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['bed_size'] = "`bed_size` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['extra_bed'] = "`extra_bed` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['list_cabin_facilities'] = "`list_cabin_facilities` text NOT NULL  ";
				
	$fieldTableInDb['single_bed'] = "`single_bed` int(8) NOT NULL  ";
				
	$fieldTableInDb['double_bed'] = "`double_bed` int(8) NOT NULL  ";
				
	$fieldTableInDb['twin_bed'] = "`twin_bed` int(8) NOT NULL  ";
				
	$fieldTableInDb['triple_bed'] = "`triple_bed` int(8) NOT NULL  ";
				
	$fieldTableInDb['quad_bed'] = "`quad_bed` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "cruise_cabin_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_cruise_cabin` (
	`cruise_cabin_id` int(10) NOT NULL  AUTO_INCREMENT,
				`cruise_id` int(8) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` longtext NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`price` int(8) NOT NULL  ,
				`cabin_size` varchar(255) NOT NULL  ,
				`bed_size` varchar(255) NOT NULL  ,
				`extra_bed` tinyint(1) NOT NULL  ,
				`list_cabin_facilities` text NOT NULL  ,
				`single_bed` int(8) NOT NULL  ,
				`double_bed` int(8) NOT NULL  ,
				`twin_bed` int(8) NOT NULL  ,
				`triple_bed` int(8) NOT NULL  ,
				`quad_bed` int(8) NOT NULL  ,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(8) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`order_no` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`cruise_cabin_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_cruise_cat*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_cruise_cat'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:18:"default_cruise_cat";s:23:"Tables_in_vietnamlan_db";s:18:"default_cruise_cat";}';
			
	$fieldTableInDb['cruise_cat_id'] = "`cruise_cat_id` int(5) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['parent_id'] = "`parent_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['country_id'] = "`country_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` longtext NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "cruise_cat_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_cruise_cat` (
	`cruise_cat_id` int(5) NOT NULL  AUTO_INCREMENT,
				`parent_id` int(8) NOT NULL  ,
				`country_id` int(8) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` longtext NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`cruise_cat_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_cruise_customfield*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_cruise_customfield'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:26:"default_cruise_customfield";s:23:"Tables_in_vietnamlan_db";s:26:"default_cruise_customfield";}';
			
	$fieldTableInDb['cruise_customfield_id'] = "`cruise_customfield_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL  ";
				
	$fieldTableInDb['cruise_id'] = "`cruise_id` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['fieldname'] = "`fieldname` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['fieldname_slug'] = "`fieldname_slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['fieldvalue'] = "`fieldvalue` longtext NOT NULL  ";
				
	$fieldTableInDb['fieldtype'] = "`fieldtype` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(8) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "cruise_customfield_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_cruise_customfield` (
	`cruise_customfield_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(8) NOT NULL  ,
				`cruise_id` varchar(255) NOT NULL  ,
				`fieldname` varchar(255) NOT NULL  ,
				`fieldname_slug` varchar(255) NOT NULL  ,
				`fieldvalue` longtext NOT NULL  ,
				`fieldtype` varchar(255) NOT NULL  ,
				`order_no` int(8) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`cruise_customfield_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_cruise_destination*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_cruise_destination'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:26:"default_cruise_destination";s:23:"Tables_in_vietnamlan_db";s:26:"default_cruise_destination";}';
			
	$fieldTableInDb['cruise_destination_id'] = "`cruise_destination_id` int(8) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['cruise_id'] = "`cruise_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['chauluc_id'] = "`chauluc_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['country_id'] = "`country_id` int(4) NOT NULL  ";
				
	$fieldTableInDb['region_id'] = "`region_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['city_id'] = "`city_id` int(4) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['val'] = "`val` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_draft'] = "`is_draft` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "cruise_destination_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_cruise_destination` (
	`cruise_destination_id` int(8) NOT NULL  AUTO_INCREMENT,
				`cruise_id` int(8) NOT NULL  ,
				`chauluc_id` int(10) NOT NULL  ,
				`country_id` int(4) NOT NULL  ,
				`region_id` int(10) NOT NULL  ,
				`city_id` int(4) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`val` tinyint(1) NOT NULL  ,
				`is_draft` tinyint(1) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`cruise_destination_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_cruise_image*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_cruise_image'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:20:"default_cruise_image";s:23:"Tables_in_vietnamlan_db";s:20:"default_cruise_image";}';
			
	$fieldTableInDb['cruise_image_id'] = "`cruise_image_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['table_id'] = "`table_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "cruise_image_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_cruise_image` (
	`cruise_image_id` int(11) NOT NULL  AUTO_INCREMENT,
				`table_id` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`user_id` int(10) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`cruise_image_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_cruise_itinerary*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_cruise_itinerary'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:24:"default_cruise_itinerary";s:23:"Tables_in_vietnamlan_db";s:24:"default_cruise_itinerary";}';
			
	$fieldTableInDb['cruise_itinerary_id'] = "`cruise_itinerary_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['cruise_id'] = "`cruise_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['number_day'] = "`number_day` int(10) NOT NULL  ";
				
	$fieldTableInDb['number_night'] = "`number_night` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['highlight'] = "`highlight` text NOT NULL  ";
				
	$fieldTableInDb['content'] = "`content` text NOT NULL  ";
				
	$fieldTableInDb['destination'] = "`destination` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['table_price_title'] = "`table_price_title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['high_season_title'] = "`high_season_title` text NOT NULL  ";
				
	$fieldTableInDb['low_season_title'] = "`low_season_title` text NOT NULL  ";
				
	$fieldTableInDb['trip_price'] = "`trip_price` double NOT NULL DEFAULT '1' ";
				
	$fieldTableInDb['trip_code'] = "`trip_code` tinyint(1) NOT NULL DEFAULT '1' ";
				
	$fieldTableInDb['price_note'] = "`price_note` text NOT NULL  ";
				
	$fieldTableInDb['is_show_price'] = "`is_show_price` tinyint(1) NOT NULL DEFAULT '1' ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$fieldTableInDb['low_season_month'] = "`low_season_month` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['high_season_month'] = "`high_season_month` varchar(255) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "cruise_itinerary_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_cruise_itinerary` (
	`cruise_itinerary_id` int(11) NOT NULL  AUTO_INCREMENT,
				`cruise_id` int(10) NOT NULL  ,
				`number_day` int(10) NOT NULL  ,
				`number_night` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` varchar(255) NOT NULL  ,
				`highlight` text NOT NULL  ,
				`content` text NOT NULL  ,
				`destination` varchar(255) NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`table_price_title` varchar(255) NOT NULL  ,
				`high_season_title` text NOT NULL  ,
				`low_season_title` text NOT NULL  ,
				`trip_price` double NOT NULL DEFAULT '1' ,
				`trip_code` tinyint(1) NOT NULL DEFAULT '1' ,
				`price_note` text NOT NULL  ,
				`is_show_price` tinyint(1) NOT NULL DEFAULT '1' ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				`low_season_month` varchar(255) NOT NULL  ,
				`high_season_month` varchar(255) NOT NULL  ,
				PRIMARY KEY (`cruise_itinerary_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_cruise_itinerary_day*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_cruise_itinerary_day'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:28:"default_cruise_itinerary_day";s:23:"Tables_in_vietnamlan_db";s:28:"default_cruise_itinerary_day";}';
			
	$fieldTableInDb['cruise_itinerary_day_id'] = "`cruise_itinerary_day_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['cruise_itinerary_id'] = "`cruise_itinerary_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['day'] = "`day` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['content'] = "`content` text NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_update_image'] = "`is_update_image` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "cruise_itinerary_day_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_cruise_itinerary_day` (
	`cruise_itinerary_day_id` int(11) NOT NULL  AUTO_INCREMENT,
				`cruise_itinerary_id` int(10) NOT NULL  ,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`day` varchar(255) NOT NULL  ,
				`content` text NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_update_image` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`cruise_itinerary_day_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_cruise_price_range*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_cruise_price_range'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:26:"default_cruise_price_range";s:23:"Tables_in_vietnamlan_db";s:26:"default_cruise_price_range";}';
			
	$fieldTableInDb['cruise_price_range_id'] = "`cruise_price_range_id` bigint(11) unsigned NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['min_rate'] = "`min_rate` double NOT NULL  ";
				
	$fieldTableInDb['max_rate'] = "`max_rate` double NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "cruise_price_range_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_cruise_price_range` (
	`cruise_price_range_id` bigint(11) unsigned NOT NULL  AUTO_INCREMENT,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`min_rate` double NOT NULL  ,
				`max_rate` double NOT NULL  ,
				`order_no` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`cruise_price_range_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_cruise_price_table*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_cruise_price_table'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:26:"default_cruise_price_table";s:23:"Tables_in_vietnamlan_db";s:26:"default_cruise_price_table";}';
			
	$fieldTableInDb['cruise_price_table_id'] = "`cruise_price_table_id` int(10) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['cruise_itinerary_id'] = "`cruise_itinerary_id` int(8)   ";
				
	$fieldTableInDb['cruise_cabin_id'] = "`cruise_cabin_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['cruise_property_id'] = "`cruise_property_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['cruise_id'] = "`cruise_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['price'] = "`price` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['season'] = "`season` tinyint(1) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "cruise_price_table_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_cruise_price_table` (
	`cruise_price_table_id` int(10) NOT NULL  AUTO_INCREMENT,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`cruise_itinerary_id` int(8)   ,
				`cruise_cabin_id` int(8) NOT NULL  ,
				`cruise_property_id` int(8) NOT NULL  ,
				`cruise_id` int(8) NOT NULL  ,
				`price` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`season` tinyint(1) NOT NULL  ,
				PRIMARY KEY (`cruise_price_table_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_cruise_property*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_cruise_property'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:23:"default_cruise_property";s:23:"Tables_in_vietnamlan_db";s:23:"default_cruise_property";}';
			
	$fieldTableInDb['cruise_property_id'] = "`cruise_property_id` int(10) unsigned NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['property_code'] = "`property_code` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['type'] = "`type` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL DEFAULT '1' ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "cruise_property_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_cruise_property` (
	`cruise_property_id` int(10) unsigned NOT NULL  AUTO_INCREMENT,
				`property_code` varchar(255) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`image` varchar(255) NOT NULL  ,
				`type` varchar(255) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL DEFAULT '1' ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`cruise_property_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_cruise_season_price*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_cruise_season_price'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:27:"default_cruise_season_price";s:23:"Tables_in_vietnamlan_db";s:27:"default_cruise_season_price";}';
			
	$fieldTableInDb['cruise_season_price_id'] = "`cruise_season_price_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['cruise_id'] = "`cruise_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['cruise_itinerary_id'] = "`cruise_itinerary_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['cruise_cabin_id'] = "`cruise_cabin_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['cabin_type_id'] = "`cabin_type_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['season'] = "`season` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['price'] = "`price` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_hide'] = "`is_hide` tinyint(1) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "cruise_season_price_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_cruise_season_price` (
	`cruise_season_price_id` int(11) NOT NULL  AUTO_INCREMENT,
				`cruise_id` int(10) NOT NULL  ,
				`cruise_itinerary_id` int(10) NOT NULL  ,
				`cruise_cabin_id` int(10) NOT NULL  ,
				`cabin_type_id` int(10) NOT NULL  ,
				`season` varchar(255) NOT NULL  ,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`price` varchar(255) NOT NULL  ,
				`is_hide` tinyint(1) NOT NULL  ,
				PRIMARY KEY (`cruise_season_price_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_cruise_service*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_cruise_service'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:22:"default_cruise_service";s:23:"Tables_in_vietnamlan_db";s:22:"default_cruise_service";}';
			
	$fieldTableInDb['cruise_service_id'] = "`cruise_service_id` int(5) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` longtext NOT NULL  ";
				
	$fieldTableInDb['price'] = "`price` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "cruise_service_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_cruise_service` (
	`cruise_service_id` int(5) NOT NULL  AUTO_INCREMENT,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` longtext NOT NULL  ,
				`price` varchar(255) NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`cruise_service_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_cruise_store*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_cruise_store'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:20:"default_cruise_store";s:23:"Tables_in_vietnamlan_db";s:20:"default_cruise_store";}';
			
	$fieldTableInDb['cruise_store_id'] = "`cruise_store_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['cruise_id'] = "`cruise_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['_type'] = "`_type` varchar(50) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "cruise_store_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_cruise_store` (
	`cruise_store_id` int(11) NOT NULL  AUTO_INCREMENT,
				`cruise_id` int(8) NOT NULL  ,
				`_type` varchar(50) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`cruise_store_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_currencies*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_currencies'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:18:"default_currencies";s:23:"Tables_in_vietnamlan_db";s:18:"default_currencies";}';
			
	$fieldTableInDb['id'] = "`id` int(10) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['code'] = "`code` text NOT NULL  ";
				
	$fieldTableInDb['prefix'] = "`prefix` text NOT NULL  ";
				
	$fieldTableInDb['suffix'] = "`suffix` text NOT NULL  ";
				
	$fieldTableInDb['format'] = "`format` int(1) NOT NULL  ";
				
	$fieldTableInDb['rate'] = "`rate` decimal(10,5) NOT NULL DEFAULT '1.00000' ";
				
	$fieldTableInDb['default'] = "`default` int(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_currencies` (
	`id` int(10) NOT NULL  AUTO_INCREMENT,
				`code` text NOT NULL  ,
				`prefix` text NOT NULL  ,
				`suffix` text NOT NULL  ,
				`format` int(1) NOT NULL  ,
				`rate` decimal(10,5) NOT NULL DEFAULT '1.00000' ,
				`default` int(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_customfields*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_customfields'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:20:"default_customfields";s:23:"Tables_in_vietnamlan_db";s:20:"default_customfields";}';
			
	$fieldTableInDb['id'] = "`id` int(10) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['type'] = "`type` text NOT NULL  ";
				
	$fieldTableInDb['relid'] = "`relid` int(10) NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['fieldname'] = "`fieldname` text NOT NULL  ";
				
	$fieldTableInDb['fieldtype'] = "`fieldtype` text NOT NULL  ";
				
	$fieldTableInDb['description'] = "`description` text NOT NULL  ";
				
	$fieldTableInDb['fieldoptions'] = "`fieldoptions` text NOT NULL  ";
				
	$fieldTableInDb['regexpr'] = "`regexpr` text NOT NULL  ";
				
	$fieldTableInDb['adminonly'] = "`adminonly` text NOT NULL  ";
				
	$fieldTableInDb['required'] = "`required` text NOT NULL  ";
				
	$fieldTableInDb['showorder'] = "`showorder` text NOT NULL  ";
				
	$fieldTableInDb['showinvoice'] = "`showinvoice` text NOT NULL  ";
				
	$fieldTableInDb['sortorder'] = "`sortorder` int(10) NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_customfields` (
	`id` int(10) NOT NULL  AUTO_INCREMENT,
				`type` text NOT NULL  ,
				`relid` int(10) NOT NULL DEFAULT '0' ,
				`fieldname` text NOT NULL  ,
				`fieldtype` text NOT NULL  ,
				`description` text NOT NULL  ,
				`fieldoptions` text NOT NULL  ,
				`regexpr` text NOT NULL  ,
				`adminonly` text NOT NULL  ,
				`required` text NOT NULL  ,
				`showorder` text NOT NULL  ,
				`showinvoice` text NOT NULL  ,
				`sortorder` int(10) NOT NULL DEFAULT '0' ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_customfieldsvalues*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_customfieldsvalues'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:26:"default_customfieldsvalues";s:23:"Tables_in_vietnamlan_db";s:26:"default_customfieldsvalues";}';
			
	$fieldTableInDb['fieldid'] = "`fieldid` int(10) NOT NULL  ";
				
	$fieldTableInDb['relid'] = "`relid` int(10) NOT NULL  ";
				
	$fieldTableInDb['value'] = "`value` text NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_customfieldsvalues` (
	`fieldid` int(10) NOT NULL  ,
				`relid` int(10) NOT NULL  ,
				`value` text NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_download*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_download'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:16:"default_download";s:23:"Tables_in_vietnamlan_db";s:16:"default_download";}';
			
	$fieldTableInDb['download_id'] = "`download_id` int(5) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['downloadcat_id'] = "`downloadcat_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['attachment_file'] = "`attachment_file` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL DEFAULT '1' ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "download_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_download` (
	`download_id` int(5) NOT NULL  AUTO_INCREMENT,
				`downloadcat_id` int(8) NOT NULL  ,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(8) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`attachment_file` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL DEFAULT '1' ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`download_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_downloadcat*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_downloadcat'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:19:"default_downloadcat";s:23:"Tables_in_vietnamlan_db";s:19:"default_downloadcat";}';
			
	$fieldTableInDb['downloadcat_id'] = "`downloadcat_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['parent_id'] = "`parent_id` int(10) unsigned NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "downloadcat_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_downloadcat` (
	`downloadcat_id` int(11) NOT NULL  AUTO_INCREMENT,
				`parent_id` int(10) unsigned NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(8) NOT NULL  ,
				`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`downloadcat_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_email*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_email'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:13:"default_email";s:23:"Tables_in_vietnamlan_db";s:13:"default_email";}';
			
	$fieldTableInDb['email_id'] = "`email_id` int(10) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['userid'] = "`userid` int(10) NOT NULL  ";
				
	$fieldTableInDb['subject'] = "`subject` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['message'] = "`message` longtext NOT NULL  ";
				
	$fieldTableInDb['date'] = "`date` int(10) NOT NULL  ";
				
	$fieldTableInDb['to'] = "`to` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['cc'] = "`cc` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['bcc'] = "`bcc` longtext NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "email_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_email` (
	`email_id` int(10) NOT NULL  AUTO_INCREMENT,
				`userid` int(10) NOT NULL  ,
				`subject` varchar(255) NOT NULL  ,
				`message` longtext NOT NULL  ,
				`date` int(10) NOT NULL  ,
				`to` varchar(255) NOT NULL  ,
				`cc` varchar(255) NOT NULL  ,
				`bcc` longtext NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				PRIMARY KEY (`email_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_email_template*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_email_template'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:22:"default_email_template";s:23:"Tables_in_vietnamlan_db";s:22:"default_email_template";}';
			
	$fieldTableInDb['email_template_id'] = "`email_template_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['fromname'] = "`fromname` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['fromemail'] = "`fromemail` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['copyto'] = "`copyto` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['subject'] = "`subject` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['content'] = "`content` longtext NOT NULL  ";
				
	$fieldTableInDb['type'] = "`type` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "email_template_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_email_template` (
	`email_template_id` int(11) NOT NULL  AUTO_INCREMENT,
				`fromname` varchar(255) NOT NULL  ,
				`fromemail` varchar(255) NOT NULL  ,
				`copyto` varchar(255) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`subject` varchar(255) NOT NULL  ,
				`content` longtext NOT NULL  ,
				`type` varchar(255) NOT NULL  ,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`email_template_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_faq*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_faq'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:11:"default_faq";s:23:"Tables_in_vietnamlan_db";s:11:"default_faq";}';
			
	$fieldTableInDb['faq_id'] = "`faq_id` int(5) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['faqcat_id'] = "`faqcat_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['content'] = "`content` longtext NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL DEFAULT '1' ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "faq_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_faq` (
	`faq_id` int(5) NOT NULL  AUTO_INCREMENT,
				`faqcat_id` int(8) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`content` longtext NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(8) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL DEFAULT '1' ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`faq_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_faqcat*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_faqcat'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:14:"default_faqcat";s:23:"Tables_in_vietnamlan_db";s:14:"default_faqcat";}';
			
	$fieldTableInDb['faqcat_id'] = "`faqcat_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['parent_id'] = "`parent_id` int(10) unsigned NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['getNAV'] = "`getNAV` text NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "faqcat_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_faqcat` (
	`faqcat_id` int(11) NOT NULL  AUTO_INCREMENT,
				`parent_id` int(10) unsigned NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` varchar(255) NOT NULL  ,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(8) NOT NULL  ,
				`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`image` varchar(255) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`getNAV` text NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`faqcat_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_feedback*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_feedback'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:16:"default_feedback";s:23:"Tables_in_vietnamlan_db";s:16:"default_feedback";}';
			
	$fieldTableInDb['feedback_id'] = "`feedback_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['feedback_code'] = "`feedback_code` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['first_name'] = "`first_name` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['last_name'] = "`last_name` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['email'] = "`email` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['phone'] = "`phone` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['address'] = "`address` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['country_id'] = "`country_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['feedback_store'] = "`feedback_store` longtext NOT NULL  ";
				
	$fieldTableInDb['feedback_html'] = "`feedback_html` longtext NOT NULL  ";
				
	$fieldTableInDb['feedback_type'] = "`feedback_type` varchar(50) NOT NULL  ";
				
	$fieldTableInDb['note'] = "`note` text NOT NULL  ";
				
	$fieldTableInDb['user_ip'] = "`user_ip` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_process'] = "`is_process` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "feedback_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_feedback` (
	`feedback_id` int(11) NOT NULL  AUTO_INCREMENT,
				`feedback_code` varchar(255) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`first_name` varchar(255) NOT NULL  ,
				`last_name` varchar(255) NOT NULL  ,
				`email` varchar(255) NOT NULL  ,
				`phone` varchar(255) NOT NULL  ,
				`address` varchar(255) NOT NULL  ,
				`country_id` int(10) NOT NULL  ,
				`feedback_store` longtext NOT NULL  ,
				`feedback_html` longtext NOT NULL  ,
				`feedback_type` varchar(50) NOT NULL  ,
				`note` text NOT NULL  ,
				`user_ip` varchar(255) NOT NULL  ,
				`is_process` tinyint(1) NOT NULL  ,
				`reg_date` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				PRIMARY KEY (`feedback_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_guidecat*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_guidecat'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:16:"default_guidecat";s:23:"Tables_in_vietnamlan_db";s:16:"default_guidecat";}';
			
	$fieldTableInDb['guidecat_id'] = "`guidecat_id` int(5) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['parent_id'] = "`parent_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` longtext NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['list_country_id'] = "`list_country_id` varchar(255)   ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_lock'] = "`is_lock` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$fieldTableInDb['nav'] = "`nav` text NOT NULL  ";
				
	$itemTableInDb["pkey"] = "guidecat_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_guidecat` (
	`guidecat_id` int(5) NOT NULL  AUTO_INCREMENT,
				`parent_id` int(8) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` longtext NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`list_country_id` varchar(255)   ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_lock` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				`nav` text NOT NULL  ,
				PRIMARY KEY (`guidecat_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_guidecat_store*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_guidecat_store'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:22:"default_guidecat_store";s:23:"Tables_in_vietnamlan_db";s:22:"default_guidecat_store";}';
			
	$fieldTableInDb['guidecat_store_id'] = "`guidecat_store_id` int(10) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['guidecat_id'] = "`guidecat_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['country_id'] = "`country_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['content'] = "`content` longtext NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "guidecat_store_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_guidecat_store` (
	`guidecat_store_id` int(10) NOT NULL  AUTO_INCREMENT,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`guidecat_id` int(10) NOT NULL  ,
				`country_id` int(10) NOT NULL  ,
				`content` longtext NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				PRIMARY KEY (`guidecat_store_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_help*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_help'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:12:"default_help";s:23:"Tables_in_vietnamlan_db";s:12:"default_help";}';
			
	$fieldTableInDb['setting'] = "`setting` text NOT NULL  ";
				
	$fieldTableInDb['value'] = "`value` text NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_help` (
	`setting` text NOT NULL  ,
				`value` text NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_hotel*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_hotel'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:13:"default_hotel";s:23:"Tables_in_vietnamlan_db";s:13:"default_hotel";}';
			
	$fieldTableInDb['hotel_id'] = "`hotel_id` int(8) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_update_id'] = "`user_update_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['list_domain_id'] = "`list_domain_id` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['continent_id'] = "`continent_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['country_id'] = "`country_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['region_id'] = "`region_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['city_id'] = "`city_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['content'] = "`content` longtext NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['address'] = "`address` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['location'] = "`location` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['check_in_out_rule'] = "`check_in_out_rule` longtext NOT NULL  ";
				
	$fieldTableInDb['hotel_booking_policy'] = "`hotel_booking_policy` longtext NOT NULL  ";
				
	$fieldTableInDb['note'] = "`note` longtext NOT NULL  ";
				
	$fieldTableInDb['phone'] = "`phone` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['star_id'] = "`star_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['hotel_rating'] = "`hotel_rating` int(8) NOT NULL  ";
				
	$fieldTableInDb['price'] = "`price` int(8) NOT NULL  ";
				
	$fieldTableInDb['map_la'] = "`map_la` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['map_lo'] = "`map_lo` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['list_HotelFacilities'] = "`list_HotelFacilities` text NOT NULL  ";
				
	$fieldTableInDb['list_HotelFreeService'] = "`list_HotelFreeService` text NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "hotel_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_hotel` (
	`hotel_id` int(8) NOT NULL  AUTO_INCREMENT,
				`user_id` int(8) NOT NULL  ,
				`user_update_id` int(8) NOT NULL  ,
				`list_domain_id` varchar(255) NOT NULL  ,
				`continent_id` int(8) NOT NULL  ,
				`country_id` int(8) NOT NULL  ,
				`region_id` int(8) NOT NULL  ,
				`city_id` int(8) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`content` longtext NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`address` varchar(255) NOT NULL  ,
				`location` varchar(255) NOT NULL  ,
				`check_in_out_rule` longtext NOT NULL  ,
				`hotel_booking_policy` longtext NOT NULL  ,
				`note` longtext NOT NULL  ,
				`phone` varchar(255) NOT NULL  ,
				`star_id` int(8) NOT NULL  ,
				`hotel_rating` int(8) NOT NULL  ,
				`price` int(8) NOT NULL  ,
				`map_la` varchar(255) NOT NULL  ,
				`map_lo` varchar(255) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`list_HotelFacilities` text NOT NULL  ,
				`list_HotelFreeService` text NOT NULL  ,
				`order_no` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`hotel_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_hotel_customfield*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_hotel_customfield'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:25:"default_hotel_customfield";s:23:"Tables_in_vietnamlan_db";s:25:"default_hotel_customfield";}';
			
	$fieldTableInDb['hotel_customfield_id'] = "`hotel_customfield_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL  ";
				
	$fieldTableInDb['hotel_id'] = "`hotel_id` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['fieldname'] = "`fieldname` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['fieldname_slug'] = "`fieldname_slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['fieldvalue'] = "`fieldvalue` longtext NOT NULL  ";
				
	$fieldTableInDb['fieldtype'] = "`fieldtype` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(8) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "hotel_customfield_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_hotel_customfield` (
	`hotel_customfield_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(8) NOT NULL  ,
				`hotel_id` varchar(255) NOT NULL  ,
				`fieldname` varchar(255) NOT NULL  ,
				`fieldname_slug` varchar(255) NOT NULL  ,
				`fieldvalue` longtext NOT NULL  ,
				`fieldtype` varchar(255) NOT NULL  ,
				`order_no` int(8) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`hotel_customfield_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_hotel_image*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_hotel_image'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:19:"default_hotel_image";s:23:"Tables_in_vietnamlan_db";s:19:"default_hotel_image";}';
			
	$fieldTableInDb['hotel_image_id'] = "`hotel_image_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['table_id'] = "`table_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "hotel_image_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_hotel_image` (
	`hotel_image_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`table_id` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`hotel_image_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_hotel_price_col*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_hotel_price_col'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:23:"default_hotel_price_col";s:23:"Tables_in_vietnamlan_db";s:23:"default_hotel_price_col";}';
			
	$fieldTableInDb['hotel_price_col_id'] = "`hotel_price_col_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['hotel_id'] = "`hotel_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "hotel_price_col_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_hotel_price_col` (
	`hotel_price_col_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`hotel_id` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`hotel_price_col_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_hotel_price_range*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_hotel_price_range'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:25:"default_hotel_price_range";s:23:"Tables_in_vietnamlan_db";s:25:"default_hotel_price_range";}';
			
	$fieldTableInDb['hotel_price_range_id'] = "`hotel_price_range_id` bigint(11) unsigned NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['min_rate'] = "`min_rate` double NOT NULL  ";
				
	$fieldTableInDb['max_rate'] = "`max_rate` double NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "hotel_price_range_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_hotel_price_range` (
	`hotel_price_range_id` bigint(11) unsigned NOT NULL  AUTO_INCREMENT,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`min_rate` double NOT NULL  ,
				`max_rate` double NOT NULL  ,
				`order_no` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`hotel_price_range_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_hotel_price_val*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_hotel_price_val'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:23:"default_hotel_price_val";s:23:"Tables_in_vietnamlan_db";s:23:"default_hotel_price_val";}';
			
	$fieldTableInDb['hotel_price_val_id'] = "`hotel_price_val_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['hotel_id'] = "`hotel_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['hotel_price_col_id'] = "`hotel_price_col_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['hotel_price_row_id'] = "`hotel_price_row_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['price'] = "`price` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "hotel_price_val_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_hotel_price_val` (
	`hotel_price_val_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`hotel_id` int(10) NOT NULL  ,
				`hotel_price_col_id` int(10) NOT NULL  ,
				`hotel_price_row_id` int(10) NOT NULL  ,
				`price` varchar(255) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`hotel_price_val_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_hotel_property*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_hotel_property'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:22:"default_hotel_property";s:23:"Tables_in_vietnamlan_db";s:22:"default_hotel_property";}';
			
	$fieldTableInDb['hotel_property_id'] = "`hotel_property_id` int(10) unsigned NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['code'] = "`code` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['type'] = "`type` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "hotel_property_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_hotel_property` (
	`hotel_property_id` int(10) unsigned NOT NULL  AUTO_INCREMENT,
				`code` varchar(255) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`image` varchar(255) NOT NULL  ,
				`type` varchar(255) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`hotel_property_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_hotel_room*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_hotel_room'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:18:"default_hotel_room";s:23:"Tables_in_vietnamlan_db";s:18:"default_hotel_room";}';
			
	$fieldTableInDb['hotel_room_id'] = "`hotel_room_id` int(8) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['hotel_id'] = "`hotel_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` longtext NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['list_RoomFacilities'] = "`list_RoomFacilities` text NOT NULL  ";
				
	$fieldTableInDb['list_RoomServices'] = "`list_RoomServices` text NOT NULL  ";
				
	$fieldTableInDb['number_room'] = "`number_room` int(8) NOT NULL  ";
				
	$fieldTableInDb['rate_room'] = "`rate_room` int(8) NOT NULL  ";
				
	$fieldTableInDb['extra_bed'] = "`extra_bed` int(8) NOT NULL  ";
				
	$fieldTableInDb['rate_note'] = "`rate_note` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['rate_include'] = "`rate_include` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['number_people'] = "`number_people` int(8) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_new'] = "`is_new` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "hotel_room_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_hotel_room` (
	`hotel_room_id` int(8) NOT NULL  AUTO_INCREMENT,
				`hotel_id` int(8) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` longtext NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`list_RoomFacilities` text NOT NULL  ,
				`list_RoomServices` text NOT NULL  ,
				`number_room` int(8) NOT NULL  ,
				`rate_room` int(8) NOT NULL  ,
				`extra_bed` int(8) NOT NULL  ,
				`rate_note` varchar(255) NOT NULL  ,
				`rate_include` varchar(255) NOT NULL  ,
				`number_people` int(8) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`order_no` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_new` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`hotel_room_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_hoteltop*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_hoteltop'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:16:"default_hoteltop";s:23:"Tables_in_vietnamlan_db";s:16:"default_hoteltop";}';
			
	$fieldTableInDb['hoteltop_id'] = "`hoteltop_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL  ";
				
	$fieldTableInDb['target_id'] = "`target_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['hotel_id'] = "`hotel_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['fromid'] = "`fromid` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "hoteltop_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_hoteltop` (
	`hoteltop_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(8) NOT NULL  ,
				`target_id` int(8) NOT NULL  ,
				`hotel_id` int(8) NOT NULL  ,
				`fromid` varchar(255) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`hoteltop_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_image*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_image'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:13:"default_image";s:23:"Tables_in_vietnamlan_db";s:13:"default_image";}';
			
	$fieldTableInDb['image_id'] = "`image_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['table_id'] = "`table_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['type'] = "`type` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "image_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_image` (
	`image_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`table_id` int(10) NOT NULL  ,
				`type` varchar(255) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`image_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_image_size*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_image_size'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:18:"default_image_size";s:23:"Tables_in_vietnamlan_db";s:18:"default_image_size";}';
			
	$fieldTableInDb['image_size_id'] = "`image_size_id` int(10) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['width'] = "`width` int(11) NOT NULL  ";
				
	$fieldTableInDb['height'] = "`height` int(11) NOT NULL  ";
				
	$fieldTableInDb['type'] = "`type` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "image_size_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_image_size` (
	`image_size_id` int(10) NOT NULL  AUTO_INCREMENT,
				`width` int(11) NOT NULL  ,
				`height` int(11) NOT NULL  ,
				`type` varchar(255) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`image_size_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_image_thumb*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_image_thumb'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:19:"default_image_thumb";s:23:"Tables_in_vietnamlan_db";s:19:"default_image_thumb";}';
			
	$fieldTableInDb['image_thumb_id'] = "`image_thumb_id` int(10) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['pvaltable'] = "`pvaltable` int(10) NOT NULL  ";
				
	$fieldTableInDb['image_size_id'] = "`image_size_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "image_thumb_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_image_thumb` (
	`image_thumb_id` int(10) NOT NULL  AUTO_INCREMENT,
				`title` varchar(255) NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`pvaltable` int(10) NOT NULL  ,
				`image_size_id` int(10) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`image_thumb_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_infoset*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_infoset'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:15:"default_infoset";s:23:"Tables_in_vietnamlan_db";s:15:"default_infoset";}';
			
	$fieldTableInDb['infoset_id'] = "`infoset_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['module'] = "`module` varchar(50) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "infoset_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_infoset` (
	`infoset_id` int(11) NOT NULL  AUTO_INCREMENT,
				`title` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`module` varchar(50) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`infoset_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_ip*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_ip'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:10:"default_ip";s:23:"Tables_in_vietnamlan_db";s:10:"default_ip";}';
			
	$fieldTableInDb['ip_id'] = "`ip_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['value'] = "`value` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "ip_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_ip` (
	`ip_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`value` varchar(255) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				PRIMARY KEY (`ip_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_lang*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_lang'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:12:"default_lang";s:23:"Tables_in_vietnamlan_db";s:12:"default_lang";}';
			
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['name'] = "`name` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['val_en'] = "`val_en` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['val_fr'] = "`val_fr` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_lang` (
	`user_id` int(10) NOT NULL  ,
				`name` varchar(255) NOT NULL  ,
				`val_en` varchar(255) NOT NULL  ,
				`val_fr` varchar(255) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_log*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_log'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:11:"default_log";s:23:"Tables_in_vietnamlan_db";s:11:"default_log";}';
			
	$fieldTableInDb['log_id'] = "`log_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['type'] = "`type` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['pkeyTable'] = "`pkeyTable` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['pvalTable'] = "`pvalTable` int(10) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "log_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_log` (
	`log_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`is_trash` tinyint(1) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`type` varchar(255) NOT NULL  ,
				`pkeyTable` varchar(255) NOT NULL  ,
				`pvalTable` int(10) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`log_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_menu*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_menu'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:12:"default_menu";s:23:"Tables_in_vietnamlan_db";s:12:"default_menu";}';
			
	$fieldTableInDb['menu_id'] = "`menu_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['target_id'] = "`target_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['clsTable'] = "`clsTable` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['parent_id'] = "`parent_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['level_id'] = "`level_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['label'] = "`label` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['link'] = "`link` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['location_id'] = "`location_id` text NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "menu_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_menu` (
	`menu_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`target_id` int(10) NOT NULL  ,
				`clsTable` varchar(255) NOT NULL  ,
				`parent_id` int(10) NOT NULL  ,
				`level_id` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`label` varchar(255) NOT NULL  ,
				`link` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`location_id` text NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`menu_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_menu_location*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_menu_location'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:21:"default_menu_location";s:23:"Tables_in_vietnamlan_db";s:21:"default_menu_location";}';
			
	$fieldTableInDb['location_id'] = "`location_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL  ";
				
	$fieldTableInDb['name'] = "`name` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['name_slug'] = "`name_slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['position'] = "`position` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` int(10) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "location_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_menu_location` (
	`location_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(8) NOT NULL  ,
				`name` varchar(255) NOT NULL  ,
				`name_slug` varchar(255) NOT NULL  ,
				`position` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`lang_id` int(10) NOT NULL  ,
				PRIMARY KEY (`location_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_meta*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_meta'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:12:"default_meta";s:23:"Tables_in_vietnamlan_db";s:12:"default_meta";}';
			
	$fieldTableInDb['meta_id'] = "`meta_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_update_id'] = "`user_update_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['config_value_title'] = "`config_value_title` text NOT NULL  ";
				
	$fieldTableInDb['config_value_intro'] = "`config_value_intro` text NOT NULL  ";
				
	$fieldTableInDb['config_value_keyword'] = "`config_value_keyword` text NOT NULL  ";
				
	$fieldTableInDb['config_link'] = "`config_link` text NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['meta_index'] = "`meta_index` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['meta_follow'] = "`meta_follow` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "meta_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_meta` (
	`meta_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`user_update_id` int(10) NOT NULL  ,
				`config_value_title` text NOT NULL  ,
				`config_value_intro` text NOT NULL  ,
				`config_value_keyword` text NOT NULL  ,
				`config_link` text NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`meta_index` tinyint(1) NOT NULL  ,
				`meta_follow` tinyint(1) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`meta_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_module*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_module'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:14:"default_module";s:23:"Tables_in_vietnamlan_db";s:14:"default_module";}';
			
	$fieldTableInDb['moduleid'] = "`moduleid` int(10) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['site'] = "`site` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['name'] = "`name` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['status'] = "`status` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['anonymous'] = "`anonymous` char(3) NOT NULL  ";
				
	$fieldTableInDb['fsize'] = "`fsize` int(10) NOT NULL  ";
				
	$fieldTableInDb['upddate'] = "`upddate` int(10) NOT NULL  ";
				
	$fieldTableInDb['config'] = "`config` text NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "moduleid";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_module` (
	`moduleid` int(10) NOT NULL  AUTO_INCREMENT,
				`site` varchar(255) NOT NULL  ,
				`name` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`status` varchar(255) NOT NULL  ,
				`anonymous` char(3) NOT NULL  ,
				`fsize` int(10) NOT NULL  ,
				`upddate` int(10) NOT NULL  ,
				`config` text NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`moduleid`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_news*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_news'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:12:"default_news";s:23:"Tables_in_vietnamlan_db";s:12:"default_news";}';
			
	$fieldTableInDb['news_id'] = "`news_id` int(5) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['newscat_id'] = "`newscat_id` int(8)   ";
				
	$fieldTableInDb['list_cat_id'] = "`list_cat_id` varchar(255)   ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8)   ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8)   ";
				
	$fieldTableInDb['title'] = "`title` varchar(255)   ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255)   ";
				
	$fieldTableInDb['intro'] = "`intro` text   ";
				
	$fieldTableInDb['content'] = "`content` longtext NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255)   ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8)   ";
				
	$fieldTableInDb['public_date'] = "`public_date` int(8)   ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8)   ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1)  DEFAULT '1' ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "news_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_news` (
	`news_id` int(5) NOT NULL  AUTO_INCREMENT,
				`newscat_id` int(8)   ,
				`list_cat_id` varchar(255)   ,
				`user_id` int(8)   ,
				`user_id_update` int(8)   ,
				`title` varchar(255)   ,
				`slug` varchar(255)   ,
				`intro` text   ,
				`content` longtext NOT NULL  ,
				`image` varchar(255)   ,
				`order_no` int(10) NOT NULL  ,
				`reg_date` int(8)   ,
				`public_date` int(8)   ,
				`upd_date` int(8)   ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1)  DEFAULT '1' ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`news_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_newscat*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_newscat'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:15:"default_newscat";s:23:"Tables_in_vietnamlan_db";s:15:"default_newscat";}';
			
	$fieldTableInDb['newscat_id'] = "`newscat_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['parent_id'] = "`parent_id` int(10) unsigned NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['getNAV'] = "`getNAV` text NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "newscat_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_newscat` (
	`newscat_id` int(11) NOT NULL  AUTO_INCREMENT,
				`parent_id` int(10) unsigned NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` varchar(255) NOT NULL  ,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(8) NOT NULL  ,
				`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`image` varchar(255) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`getNAV` text NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`newscat_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_online_support*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_online_support'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:22:"default_online_support";s:23:"Tables_in_vietnamlan_db";s:22:"default_online_support";}';
			
	$fieldTableInDb['online_support_id'] = "`online_support_id` int(10) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['nick'] = "`nick` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['type'] = "`type` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "online_support_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_online_support` (
	`online_support_id` int(10) NOT NULL  AUTO_INCREMENT,
				`title` varchar(255) NOT NULL  ,
				`nick` varchar(255) NOT NULL  ,
				`type` varchar(255) NOT NULL  ,
				`order_no` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				PRIMARY KEY (`online_support_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_page*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_page'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:12:"default_page";s:23:"Tables_in_vietnamlan_db";s:12:"default_page";}';
			
	$fieldTableInDb['page_id'] = "`page_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['link'] = "`link` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['type'] = "`type` varchar(50) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$fieldTableInDb['is_plink'] = "`is_plink` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_fix'] = "`is_fix` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['url'] = "`url` varchar(255) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "page_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_page` (
	`page_id` int(11) NOT NULL  AUTO_INCREMENT,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`link` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`type` varchar(50) NOT NULL  ,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(8) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				`is_plink` tinyint(1) NOT NULL  ,
				`is_fix` tinyint(1) NOT NULL  ,
				`url` varchar(255) NOT NULL  ,
				PRIMARY KEY (`page_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_price_range*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_price_range'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:19:"default_price_range";s:23:"Tables_in_vietnamlan_db";s:19:"default_price_range";}';
			
	$fieldTableInDb['price_range_id'] = "`price_range_id` bigint(11) unsigned NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['min_rate'] = "`min_rate` double NOT NULL  ";
				
	$fieldTableInDb['max_rate'] = "`max_rate` double NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['type'] = "`type` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "price_range_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_price_range` (
	`price_range_id` bigint(11) unsigned NOT NULL  AUTO_INCREMENT,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`min_rate` double NOT NULL  ,
				`max_rate` double NOT NULL  ,
				`order_no` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`type` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`price_range_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_promotion*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_promotion'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:17:"default_promotion";s:23:"Tables_in_vietnamlan_db";s:17:"default_promotion";}';
			
	$fieldTableInDb['promotion_id'] = "`promotion_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['tour_id'] = "`tour_id` int(11) NOT NULL  ";
				
	$fieldTableInDb['list_domain_id'] = "`list_domain_id` text NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255)   ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['permalink'] = "`permalink` varchar(255)   ";
				
	$fieldTableInDb['intro'] = "`intro` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['content'] = "`content` longtext NOT NULL  ";
				
	$fieldTableInDb['price'] = "`price` int(10)   ";
				
	$fieldTableInDb['date_begin'] = "`date_begin` int(10)   ";
				
	$fieldTableInDb['date_end'] = "`date_end` int(10)   ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1)   ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "promotion_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_promotion` (
	`promotion_id` int(11) NOT NULL  AUTO_INCREMENT,
				`tour_id` int(11) NOT NULL  ,
				`list_domain_id` text NOT NULL  ,
				`title` varchar(255)   ,
				`slug` varchar(255) NOT NULL  ,
				`permalink` varchar(255)   ,
				`intro` varchar(255) NOT NULL  ,
				`content` longtext NOT NULL  ,
				`price` int(10)   ,
				`date_begin` int(10)   ,
				`date_end` int(10)   ,
				`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`user_id` int(10) unsigned NOT NULL DEFAULT '0' ,
				`user_id_update` int(10) unsigned NOT NULL DEFAULT '0' ,
				`image` varchar(255) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1)   ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`promotion_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_recruit*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_recruit'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:15:"default_recruit";s:23:"Tables_in_vietnamlan_db";s:15:"default_recruit";}';
			
	$fieldTableInDb['recruit_id'] = "`recruit_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['cat_id'] = "`cat_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` longtext NOT NULL  ";
				
	$fieldTableInDb['content'] = "`content` longtext NOT NULL  ";
				
	$fieldTableInDb['permalink'] = "`permalink` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "recruit_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_recruit` (
	`recruit_id` int(11) NOT NULL  AUTO_INCREMENT,
				`cat_id` int(8) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` longtext NOT NULL  ,
				`content` longtext NOT NULL  ,
				`permalink` varchar(255) NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`image` varchar(255) NOT NULL  ,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`recruit_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_region*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_region'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:14:"default_region";s:23:"Tables_in_vietnamlan_db";s:14:"default_region";}';
			
	$fieldTableInDb['region_id'] = "`region_id` int(10) unsigned NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['continent_id'] = "`continent_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['area_id'] = "`area_id` int(10) NOT NULL DEFAULT '1' ";
				
	$fieldTableInDb['country_id'] = "`country_id` int(10) NOT NULL DEFAULT '1' ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` longtext NOT NULL  ";
				
	$fieldTableInDb['content'] = "`content` text NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "region_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_region` (
	`region_id` int(10) unsigned NOT NULL  AUTO_INCREMENT,
				`continent_id` int(10) NOT NULL  ,
				`area_id` int(10) NOT NULL DEFAULT '1' ,
				`country_id` int(10) NOT NULL DEFAULT '1' ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` longtext NOT NULL  ,
				`content` text NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`image` varchar(255) NOT NULL  ,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`region_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_room_slot*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_room_slot'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:17:"default_room_slot";s:23:"Tables_in_vietnamlan_db";s:17:"default_room_slot";}';
			
	$fieldTableInDb['room_slot_id'] = "`room_slot_id` int(11) unsigned NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['datetime'] = "`datetime` int(10) NOT NULL  ";
				
	$fieldTableInDb['d'] = "`d` int(2) NOT NULL  ";
				
	$fieldTableInDb['m'] = "`m` int(2) NOT NULL  ";
				
	$fieldTableInDb['y'] = "`y` int(4) NOT NULL  ";
				
	$fieldTableInDb['slot'] = "`slot` int(8) NOT NULL  ";
				
	$fieldTableInDb['slot_sale'] = "`slot_sale` int(8) NOT NULL  ";
				
	$fieldTableInDb['slot_avai'] = "`slot_avai` int(8) NOT NULL  ";
				
	$fieldTableInDb['room_id'] = "`room_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(8) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_active'] = "`is_active` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "room_slot_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_room_slot` (
	`room_slot_id` int(11) unsigned NOT NULL  AUTO_INCREMENT,
				`user_id` int(8) NOT NULL  ,
				`datetime` int(10) NOT NULL  ,
				`d` int(2) NOT NULL  ,
				`m` int(2) NOT NULL  ,
				`y` int(4) NOT NULL  ,
				`slot` int(8) NOT NULL  ,
				`slot_sale` int(8) NOT NULL  ,
				`slot_avai` int(8) NOT NULL  ,
				`room_id` int(8) NOT NULL  ,
				`order_no` int(8) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`is_active` tinyint(1) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				PRIMARY KEY (`room_slot_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_service*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_service'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:15:"default_service";s:23:"Tables_in_vietnamlan_db";s:15:"default_service";}';
			
	$fieldTableInDb['service_id'] = "`service_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` longtext NOT NULL  ";
				
	$fieldTableInDb['content'] = "`content` longtext NOT NULL  ";
				
	$fieldTableInDb['permalink'] = "`permalink` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['image_child'] = "`image_child` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "service_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_service` (
	`service_id` int(11) NOT NULL  AUTO_INCREMENT,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` longtext NOT NULL  ,
				`content` longtext NOT NULL  ,
				`permalink` varchar(255) NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`image` varchar(255) NOT NULL  ,
				`image_child` varchar(255) NOT NULL  ,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`service_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_setting*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_setting'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:15:"default_setting";s:23:"Tables_in_vietnamlan_db";s:15:"default_setting";}';
			
	$fieldTableInDb['setting_id'] = "`setting_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['site_multiple_country'] = "`site_multiple_country` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_intro'] = "`tour_intro` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_price_table'] = "`tour_price_table` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_itinerary_table'] = "`tour_itinerary_table` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_itinerary'] = "`tour_itinerary` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_inclusion'] = "`tour_inclusion` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_exclusion'] = "`tour_exclusion` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_additional'] = "`tour_additional` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_city_around'] = "`tour_city_around` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_groupsize'] = "`tour_groupsize` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_guarantee'] = "`tour_guarantee` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_trip_valid'] = "`tour_trip_valid` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_type_id'] = "`tour_type_id` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_quality_id'] = "`tour_quality_id` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_day_night'] = "`tour_day_night` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_trip_code'] = "`tour_trip_code` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_duplicate_name'] = "`tour_duplicate_name` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_destination_around'] = "`tour_destination_around` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['itinerary_meal'] = "`itinerary_meal` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['itinerary_transport_type'] = "`itinerary_transport_type` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_photo_gallery'] = "`tour_photo_gallery` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_seo_advanced'] = "`tour_seo_advanced` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_hotel_recomment'] = "`tour_hotel_recomment` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tour_category_seo_advanced'] = "`tour_category_seo_advanced` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['destination_gallery'] = "`destination_gallery` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['destination_review'] = "`destination_review` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['destination_seo_advanced'] = "`destination_seo_advanced` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['destination_hotel_recomment'] = "`destination_hotel_recomment` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['hotel_price_table'] = "`hotel_price_table` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['hotel_photo_gallery'] = "`hotel_photo_gallery` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['hotel_seo_advanced'] = "`hotel_seo_advanced` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['hotel_check_in_out_time'] = "`hotel_check_in_out_time` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['hotel_check_in_out_rule'] = "`hotel_check_in_out_rule` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['hotel_promotion'] = "`hotel_promotion` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['hotel_facility'] = "`hotel_facility` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['hotel_room_facility'] = "`hotel_room_facility` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['hotel_sport'] = "`hotel_sport` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['hotel_parking'] = "`hotel_parking` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['hotel_style'] = "`hotel_style` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['hotel_interest'] = "`hotel_interest` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['hotel_review'] = "`hotel_review` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['hotel_review_rate'] = "`hotel_review_rate` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['guide_create_root'] = "`guide_create_root` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['guide_intro'] = "`guide_intro` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['guide_seo_advanced'] = "`guide_seo_advanced` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['guide_use_image_url'] = "`guide_use_image_url` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['testimonial_image'] = "`testimonial_image` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['testimonial_date_review'] = "`testimonial_date_review` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tailor_made'] = "`tailor_made` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['home_admin_note'] = "`home_admin_note` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['faq_table_content'] = "`faq_table_content` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['vietiso_live_help'] = "`vietiso_live_help` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['information_have_image'] = "`information_have_image` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['news_category'] = "`news_category` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['news_category_seo_advanced'] = "`news_category_seo_advanced` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['news_category_image'] = "`news_category_image` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['sitemap_intro'] = "`sitemap_intro` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['sitemap_image'] = "`sitemap_image` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['news_seo_advanced'] = "`news_seo_advanced` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['config_public_mode'] = "`config_public_mode` tinyint(1) NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['config_site_mod_link'] = "`config_site_mod_link` tinyint(1) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "setting_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_setting` (
	`setting_id` int(11) NOT NULL  AUTO_INCREMENT,
				`site_multiple_country` tinyint(1) NOT NULL  ,
				`tour_intro` tinyint(1) NOT NULL  ,
				`tour_price_table` tinyint(1) NOT NULL  ,
				`tour_itinerary_table` tinyint(1) NOT NULL  ,
				`tour_itinerary` tinyint(1) NOT NULL  ,
				`tour_inclusion` tinyint(1) NOT NULL  ,
				`tour_exclusion` tinyint(1) NOT NULL  ,
				`tour_additional` tinyint(1) NOT NULL  ,
				`tour_city_around` tinyint(1) NOT NULL  ,
				`tour_groupsize` tinyint(1) NOT NULL  ,
				`tour_guarantee` tinyint(1) NOT NULL  ,
				`tour_trip_valid` tinyint(1) NOT NULL  ,
				`tour_type_id` tinyint(1) NOT NULL  ,
				`tour_quality_id` tinyint(1) NOT NULL  ,
				`tour_day_night` tinyint(1) NOT NULL  ,
				`tour_trip_code` tinyint(1) NOT NULL  ,
				`tour_duplicate_name` tinyint(1) NOT NULL  ,
				`tour_destination_around` tinyint(1) NOT NULL  ,
				`itinerary_meal` tinyint(1) NOT NULL  ,
				`itinerary_transport_type` tinyint(1) NOT NULL  ,
				`tour_photo_gallery` tinyint(1) NOT NULL  ,
				`tour_seo_advanced` tinyint(1) NOT NULL  ,
				`tour_hotel_recomment` tinyint(1) NOT NULL  ,
				`tour_category_seo_advanced` tinyint(1) NOT NULL  ,
				`destination_gallery` tinyint(1) NOT NULL  ,
				`destination_review` tinyint(1) NOT NULL  ,
				`destination_seo_advanced` tinyint(1) NOT NULL  ,
				`destination_hotel_recomment` tinyint(1) NOT NULL  ,
				`hotel_price_table` tinyint(1) NOT NULL  ,
				`hotel_photo_gallery` tinyint(1) NOT NULL  ,
				`hotel_seo_advanced` tinyint(1) NOT NULL  ,
				`hotel_check_in_out_time` tinyint(1) NOT NULL  ,
				`hotel_check_in_out_rule` tinyint(1) NOT NULL  ,
				`hotel_promotion` tinyint(1) NOT NULL  ,
				`hotel_facility` tinyint(1) NOT NULL  ,
				`hotel_room_facility` tinyint(1) NOT NULL  ,
				`hotel_sport` tinyint(1) NOT NULL  ,
				`hotel_parking` tinyint(1) NOT NULL  ,
				`hotel_style` tinyint(1) NOT NULL  ,
				`hotel_interest` tinyint(1) NOT NULL  ,
				`hotel_review` tinyint(1) NOT NULL  ,
				`hotel_review_rate` tinyint(1) NOT NULL  ,
				`guide_create_root` tinyint(1) NOT NULL  ,
				`guide_intro` tinyint(1) NOT NULL  ,
				`guide_seo_advanced` tinyint(1) NOT NULL  ,
				`guide_use_image_url` tinyint(1) NOT NULL  ,
				`testimonial_image` tinyint(1) NOT NULL  ,
				`testimonial_date_review` tinyint(1) NOT NULL  ,
				`tailor_made` tinyint(1) NOT NULL  ,
				`home_admin_note` tinyint(1) NOT NULL  ,
				`faq_table_content` tinyint(1) NOT NULL  ,
				`vietiso_live_help` tinyint(1) NOT NULL  ,
				`information_have_image` tinyint(1) NOT NULL  ,
				`news_category` tinyint(1) NOT NULL  ,
				`news_category_seo_advanced` tinyint(1) NOT NULL  ,
				`news_category_image` tinyint(1) NOT NULL  ,
				`sitemap_intro` tinyint(1) NOT NULL  ,
				`sitemap_image` tinyint(1) NOT NULL  ,
				`news_seo_advanced` tinyint(1) NOT NULL  ,
				`config_public_mode` tinyint(1) NOT NULL DEFAULT '0' ,
				`config_site_mod_link` tinyint(1) NOT NULL  ,
				PRIMARY KEY (`setting_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_slide*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_slide'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:13:"default_slide";s:23:"Tables_in_vietnamlan_db";s:13:"default_slide";}';
			
	$fieldTableInDb['slide_id'] = "`slide_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL  ";
				
	$fieldTableInDb['target_id'] = "`target_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['type'] = "`type` varchar(50) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['link'] = "`link` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['text'] = "`text` text NOT NULL  ";
				
	$fieldTableInDb['large_text'] = "`large_text` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['small_text'] = "`small_text` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['image_mobile'] = "`image_mobile` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['mod_page'] = "`mod_page` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['act_page'] = "`act_page` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "slide_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_slide` (
	`slide_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(8) NOT NULL  ,
				`target_id` int(8) NOT NULL  ,
				`type` varchar(50) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`link` varchar(255) NOT NULL  ,
				`text` text NOT NULL  ,
				`large_text` varchar(255) NOT NULL  ,
				`small_text` varchar(255) NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`image_mobile` varchar(255) NOT NULL  ,
				`mod_page` varchar(255) NOT NULL  ,
				`act_page` varchar(255) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				PRIMARY KEY (`slide_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_slide_group*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_slide_group'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:19:"default_slide_group";s:23:"Tables_in_vietnamlan_db";s:19:"default_slide_group";}';
			
	$fieldTableInDb['ads_group_id'] = "`ads_group_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['mod_page'] = "`mod_page` text NOT NULL  ";
				
	$fieldTableInDb['act_page'] = "`act_page` text NOT NULL  ";
				
	$fieldTableInDb['_width'] = "`_width` int(10) NOT NULL  ";
				
	$fieldTableInDb['_height'] = "`_height` int(10) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "ads_group_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_slide_group` (
	`ads_group_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`mod_page` text NOT NULL  ,
				`act_page` text NOT NULL  ,
				`_width` int(10) NOT NULL  ,
				`_height` int(10) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`ads_group_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_subscribe*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_subscribe'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:17:"default_subscribe";s:23:"Tables_in_vietnamlan_db";s:17:"default_subscribe";}';
			
	$fieldTableInDb['subscribe_id'] = "`subscribe_id` int(10) unsigned NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['fullname'] = "`fullname` varchar(255)   ";
				
	$fieldTableInDb['email'] = "`email` varchar(255)  DEFAULT '0' ";
				
	$fieldTableInDb['user_ip'] = "`user_ip` varchar(255)   ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10)   ";
				
	$fieldTableInDb['receive_newsletter'] = "`receive_newsletter` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "subscribe_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_subscribe` (
	`subscribe_id` int(10) unsigned NOT NULL  AUTO_INCREMENT,
				`fullname` varchar(255)   ,
				`email` varchar(255)  DEFAULT '0' ,
				`user_ip` varchar(255)   ,
				`reg_date` int(10)   ,
				`receive_newsletter` tinyint(1) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`subscribe_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tag*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tag'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:11:"default_tag";s:23:"Tables_in_vietnamlan_db";s:11:"default_tag";}';
			
	$fieldTableInDb['tag_id'] = "`tag_id` int(10) unsigned NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['type_id'] = "`type_id` int(2) NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['view_num'] = "`view_num` bigint(20) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tag_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tag` (
	`tag_id` int(10) unsigned NOT NULL  AUTO_INCREMENT,
				`type_id` int(2) NOT NULL DEFAULT '0' ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`view_num` bigint(20) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tag_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tag_module*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tag_module'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:18:"default_tag_module";s:23:"Tables_in_vietnamlan_db";s:18:"default_tag_module";}';
			
	$fieldTableInDb['tag_module_id'] = "`tag_module_id` int(10) unsigned NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['tag_id'] = "`tag_id` int(10) NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['for_id'] = "`for_id` int(10) NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['type'] = "`type` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['val'] = "`val` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tag_module_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tag_module` (
	`tag_module_id` int(10) unsigned NOT NULL  AUTO_INCREMENT,
				`tag_id` int(10) NOT NULL DEFAULT '0' ,
				`for_id` int(10) NOT NULL DEFAULT '0' ,
				`type` varchar(255) NOT NULL  ,
				`val` tinyint(1) NOT NULL  ,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				PRIMARY KEY (`tag_module_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tailor*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tailor'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:14:"default_tailor";s:23:"Tables_in_vietnamlan_db";s:14:"default_tailor";}';
			
	$fieldTableInDb['tailor_id'] = "`tailor_id` int(10) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['domain_id'] = "`domain_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['tour_id'] = "`tour_id` int(11)   ";
				
	$fieldTableInDb['fullname'] = "`fullname` varchar(255)   ";
				
	$fieldTableInDb['subject'] = "`subject` varchar(255)   ";
				
	$fieldTableInDb['booking_code'] = "`booking_code` varchar(255)   ";
				
	$fieldTableInDb['ip_booking'] = "`ip_booking` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['booking_information'] = "`booking_information` longtext NOT NULL  ";
				
	$fieldTableInDb['note'] = "`note` text NOT NULL  ";
				
	$fieldTableInDb['is_process'] = "`is_process` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['type'] = "`type` tinyint(1)   ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['html_booking'] = "`html_booking` longtext NOT NULL  ";
				
	$fieldTableInDb['is_send_email_admin'] = "`is_send_email_admin` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_send_email_customer'] = "`is_send_email_customer` tinyint(1) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tailor_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tailor` (
	`tailor_id` int(10) NOT NULL  AUTO_INCREMENT,
				`domain_id` int(10) NOT NULL  ,
				`tour_id` int(11)   ,
				`fullname` varchar(255)   ,
				`subject` varchar(255)   ,
				`booking_code` varchar(255)   ,
				`ip_booking` varchar(255) NOT NULL  ,
				`booking_information` longtext NOT NULL  ,
				`note` text NOT NULL  ,
				`is_process` tinyint(1) NOT NULL  ,
				`type` tinyint(1)   ,
				`reg_date` int(8) NOT NULL  ,
				`html_booking` longtext NOT NULL  ,
				`is_send_email_admin` tinyint(1) NOT NULL  ,
				`is_send_email_customer` tinyint(1) NOT NULL  ,
				PRIMARY KEY (`tailor_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tailor_property*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tailor_property'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:23:"default_tailor_property";s:23:"Tables_in_vietnamlan_db";s:23:"default_tailor_property";}';
			
	$fieldTableInDb['tailor_property_id'] = "`tailor_property_id` int(10) unsigned NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['type'] = "`type` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tailor_property_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tailor_property` (
	`tailor_property_id` int(10) unsigned NOT NULL  AUTO_INCREMENT,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`type` varchar(255) NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tailor_property_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_testimonial*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_testimonial'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:19:"default_testimonial";s:23:"Tables_in_vietnamlan_db";s:19:"default_testimonial";}';
			
	$fieldTableInDb['testimonial_id'] = "`testimonial_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['country_id'] = "`country_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255)   ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255)   ";
				
	$fieldTableInDb['name'] = "`name` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text   ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL DEFAULT '1' ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "testimonial_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_testimonial` (
	`testimonial_id` int(11) NOT NULL  AUTO_INCREMENT,
				`country_id` int(8) NOT NULL  ,
				`title` varchar(255)   ,
				`slug` varchar(255)   ,
				`name` varchar(255) NOT NULL  ,
				`intro` text   ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(8) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL DEFAULT '1' ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`testimonial_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tips*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tips'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:12:"default_tips";s:23:"Tables_in_vietnamlan_db";s:12:"default_tips";}';
			
	$fieldTableInDb['tips_id'] = "`tips_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['list_domain_id'] = "`list_domain_id` text NOT NULL  ";
				
	$fieldTableInDb['cat_id'] = "`cat_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['country_id'] = "`country_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['city_id'] = "`city_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['list_cat_id'] = "`list_cat_id` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) unsigned NOT NULL  ";
				
	$fieldTableInDb['user_upd_id'] = "`user_upd_id` int(8) unsigned NOT NULL  ";
				
	$fieldTableInDb['title_en'] = "`title_en` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['title_vn'] = "`title_vn` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug_en'] = "`slug_en` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug_vn'] = "`slug_vn` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro_en'] = "`intro_en` text NOT NULL  ";
				
	$fieldTableInDb['intro_vn'] = "`intro_vn` text NOT NULL  ";
				
	$fieldTableInDb['content_en'] = "`content_en` text NOT NULL  ";
				
	$fieldTableInDb['content_vn'] = "`content_vn` text NOT NULL  ";
				
	$fieldTableInDb['contact_info_en'] = "`contact_info_en` text   ";
				
	$fieldTableInDb['contact_info_vn'] = "`contact_info_vn` text   ";
				
	$fieldTableInDb['permalink_en'] = "`permalink_en` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['permalink_vn'] = "`permalink_vn` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['image_current'] = "`image_current` varchar(255)   ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['last_update'] = "`last_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['end_date'] = "`end_date` int(10)   ";
				
	$fieldTableInDb['view_num'] = "`view_num` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_highlight'] = "`is_highlight` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_home'] = "`is_home` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['order_home'] = "`order_home` int(8) NOT NULL  ";
				
	$fieldTableInDb['update_image'] = "`update_image` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['tags'] = "`tags` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['list_country_id'] = "`list_country_id` varchar(50)   ";
				
	$fieldTableInDb['list_city_id'] = "`list_city_id` varchar(50)   ";
				
	$itemTableInDb["pkey"] = "tips_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tips` (
	`tips_id` int(11) NOT NULL  AUTO_INCREMENT,
				`list_domain_id` text NOT NULL  ,
				`cat_id` int(10) NOT NULL  ,
				`country_id` int(10) NOT NULL  ,
				`city_id` int(10) NOT NULL  ,
				`list_cat_id` varchar(255) NOT NULL  ,
				`user_id` int(8) unsigned NOT NULL  ,
				`user_upd_id` int(8) unsigned NOT NULL  ,
				`title_en` varchar(255) NOT NULL  ,
				`title_vn` varchar(255) NOT NULL  ,
				`slug_en` varchar(255) NOT NULL  ,
				`slug_vn` varchar(255) NOT NULL  ,
				`intro_en` text NOT NULL  ,
				`intro_vn` text NOT NULL  ,
				`content_en` text NOT NULL  ,
				`content_vn` text NOT NULL  ,
				`contact_info_en` text   ,
				`contact_info_vn` text   ,
				`permalink_en` varchar(255) NOT NULL  ,
				`permalink_vn` varchar(255) NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`image` varchar(255) NOT NULL  ,
				`image_current` varchar(255)   ,
				`reg_date` int(10) NOT NULL  ,
				`last_update` int(10) NOT NULL  ,
				`end_date` int(10)   ,
				`view_num` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_highlight` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`is_home` tinyint(1) NOT NULL  ,
				`order_home` int(8) NOT NULL  ,
				`update_image` tinyint(1) NOT NULL  ,
				`tags` varchar(255) NOT NULL  ,
				`list_country_id` varchar(50)   ,
				`list_city_id` varchar(50)   ,
				PRIMARY KEY (`tips_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:12:"default_tour";s:23:"Tables_in_vietnamlan_db";s:12:"default_tour";}';
			
	$fieldTableInDb['tour_id'] = "`tour_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['tour_group_id'] = "`tour_group_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['list_group_id'] = "`list_group_id` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['tour_type_id'] = "`tour_type_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['list_type_id'] = "`list_type_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['cat_id'] = "`cat_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['list_cat_id'] = "`list_cat_id` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['number_day'] = "`number_day` int(10) NOT NULL  ";
				
	$fieldTableInDb['number_night'] = "`number_night` int(10) NOT NULL  ";
				
	$fieldTableInDb['trip_code'] = "`trip_code` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['trip_price'] = "`trip_price` int(8) NOT NULL  ";
				
	$fieldTableInDb['trip_old_price'] = "`trip_old_price` int(8) NOT NULL  ";
				
	$fieldTableInDb['departure_point_id'] = "`departure_point_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['return_from'] = "`return_from` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['departure_date'] = "`departure_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['return_date'] = "`return_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['pickup_point'] = "`pickup_point` text NOT NULL  ";
				
	$fieldTableInDb['return_point'] = "`return_point` text NOT NULL  ";
				
	$fieldTableInDb['highlight'] = "`highlight` text   ";
				
	$fieldTableInDb['inclusion'] = "`inclusion` text NOT NULL  ";
				
	$fieldTableInDb['exclusion'] = "`exclusion` text NOT NULL  ";
				
	$fieldTableInDb['information'] = "`information` text NOT NULL  ";
				
	$fieldTableInDb['number_seat'] = "`number_seat` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_number_seat'] = "`is_number_seat` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['booking_front_date'] = "`booking_front_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['tax'] = "`tax` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['deposit'] = "`deposit` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(255) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['show_price_table'] = "`show_price_table` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['note_price_table'] = "`note_price_table` text NOT NULL  ";
				
	$fieldTableInDb['hour_in'] = "`hour_in` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['hour_out'] = "`hour_out` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['bookingOnline'] = "`bookingOnline` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['hot_deals'] = "`hot_deals` int(8) NOT NULL  ";
				
	$fieldTableInDb['table_price_title'] = "`table_price_title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['table_price_header'] = "`table_price_header` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['config_markup_tour'] = "`config_markup_tour` int(10) NOT NULL  ";
				
	$fieldTableInDb['config_markup_tour_agent'] = "`config_markup_tour_agent` int(10) NOT NULL  ";
				
	$fieldTableInDb['tour_low_from'] = "`tour_low_from` int(10) NOT NULL  ";
				
	$fieldTableInDb['tour_low_to'] = "`tour_low_to` int(10) NOT NULL  ";
				
	$fieldTableInDb['tour_high_from'] = "`tour_high_from` int(10) NOT NULL  ";
				
	$fieldTableInDb['tour_high_to'] = "`tour_high_to` int(10) NOT NULL  ";
				
	$fieldTableInDb['price_low'] = "`price_low` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['price_low_agent'] = "`price_low_agent` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['price_high'] = "`price_high` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['price_high_agent'] = "`price_high_agent` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$fieldTableInDb['LIST_SERVICESADDONS'] = "`LIST_SERVICESADDONS` text NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour` (
	`tour_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(8) NOT NULL DEFAULT '0' ,
				`user_id_update` int(8) NOT NULL DEFAULT '0' ,
				`tour_group_id` int(8) NOT NULL  ,
				`list_group_id` varchar(255) NOT NULL  ,
				`tour_type_id` int(8) NOT NULL  ,
				`list_type_id` int(8) NOT NULL  ,
				`cat_id` int(8) NOT NULL  ,
				`list_cat_id` varchar(255) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`number_day` int(10) NOT NULL  ,
				`number_night` int(10) NOT NULL  ,
				`trip_code` varchar(255) NOT NULL  ,
				`trip_price` int(8) NOT NULL  ,
				`trip_old_price` int(8) NOT NULL  ,
				`departure_point_id` int(8) NOT NULL  ,
				`return_from` varchar(255) NOT NULL  ,
				`departure_date` int(10) NOT NULL  ,
				`return_date` int(10) NOT NULL  ,
				`pickup_point` text NOT NULL  ,
				`return_point` text NOT NULL  ,
				`highlight` text   ,
				`inclusion` text NOT NULL  ,
				`exclusion` text NOT NULL  ,
				`information` text NOT NULL  ,
				`number_seat` int(8) NOT NULL  ,
				`is_number_seat` tinyint(1) NOT NULL  ,
				`booking_front_date` int(8) NOT NULL  ,
				`tax` varchar(255) NOT NULL  ,
				`deposit` int(10) NOT NULL  ,
				`reg_date` int(255) NOT NULL  ,
				`upd_date` int(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`show_price_table` tinyint(1) NOT NULL  ,
				`note_price_table` text NOT NULL  ,
				`hour_in` varchar(255) NOT NULL  ,
				`hour_out` varchar(255) NOT NULL  ,
				`bookingOnline` tinyint(1) NOT NULL  ,
				`hot_deals` int(8) NOT NULL  ,
				`table_price_title` varchar(255) NOT NULL  ,
				`table_price_header` varchar(255) NOT NULL  ,
				`config_markup_tour` int(10) NOT NULL  ,
				`config_markup_tour_agent` int(10) NOT NULL  ,
				`tour_low_from` int(10) NOT NULL  ,
				`tour_low_to` int(10) NOT NULL  ,
				`tour_high_from` int(10) NOT NULL  ,
				`tour_high_to` int(10) NOT NULL  ,
				`price_low` varchar(255) NOT NULL  ,
				`price_low_agent` varchar(255) NOT NULL  ,
				`price_high` varchar(255) NOT NULL  ,
				`price_high_agent` varchar(255) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				`LIST_SERVICESADDONS` text NOT NULL  ,
				PRIMARY KEY (`tour_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_category*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_category'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:21:"default_tour_category";s:23:"Tables_in_vietnamlan_db";s:21:"default_tour_category";}';
			
	$fieldTableInDb['tourcat_id'] = "`tourcat_id` int(10) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['parent_id'] = "`parent_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['list_parent_id'] = "`list_parent_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['tour_group_id'] = "`tour_group_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['list_group_id'] = "`list_group_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` longtext NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tourcat_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_category` (
	`tourcat_id` int(10) NOT NULL  AUTO_INCREMENT,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`parent_id` int(10) NOT NULL  ,
				`list_parent_id` int(10) NOT NULL  ,
				`tour_group_id` int(10) NOT NULL  ,
				`list_group_id` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` longtext NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tourcat_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_customfield*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_customfield'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:24:"default_tour_customfield";s:23:"Tables_in_vietnamlan_db";s:24:"default_tour_customfield";}';
			
	$fieldTableInDb['tour_customfield_id'] = "`tour_customfield_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['tour_id'] = "`tour_id` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['fieldname'] = "`fieldname` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['fieldname_slug'] = "`fieldname_slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['fieldvalue'] = "`fieldvalue` longtext NOT NULL  ";
				
	$fieldTableInDb['fieldtype'] = "`fieldtype` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(8) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_customfield_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_customfield` (
	`tour_customfield_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(8) NOT NULL  ,
				`tour_id` varchar(255) NOT NULL  ,
				`fieldname` varchar(255) NOT NULL  ,
				`fieldname_slug` varchar(255) NOT NULL  ,
				`fieldvalue` longtext NOT NULL  ,
				`fieldtype` varchar(255) NOT NULL  ,
				`order_no` int(8) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tour_customfield_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_destination*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_destination'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:24:"default_tour_destination";s:23:"Tables_in_vietnamlan_db";s:24:"default_tour_destination";}';
			
	$fieldTableInDb['tour_destination_id'] = "`tour_destination_id` int(8) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['tour_id'] = "`tour_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['chauluc_id'] = "`chauluc_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['destination_id'] = "`destination_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['area_id'] = "`area_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['country_id'] = "`country_id` int(4) NOT NULL  ";
				
	$fieldTableInDb['region_id'] = "`region_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['city_id'] = "`city_id` int(4) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['val'] = "`val` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_destination_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_destination` (
	`tour_destination_id` int(8) NOT NULL  AUTO_INCREMENT,
				`tour_id` int(8) NOT NULL  ,
				`chauluc_id` int(10) NOT NULL  ,
				`destination_id` int(10) NOT NULL  ,
				`area_id` int(10) NOT NULL  ,
				`country_id` int(4) NOT NULL  ,
				`region_id` int(10) NOT NULL  ,
				`city_id` int(4) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`val` tinyint(1) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tour_destination_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_extension*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_extension'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:22:"default_tour_extension";s:23:"Tables_in_vietnamlan_db";s:22:"default_tour_extension";}';
			
	$fieldTableInDb['tour_extension_id'] = "`tour_extension_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['tour_1_id'] = "`tour_1_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['tour_2_id'] = "`tour_2_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_extension_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_extension` (
	`tour_extension_id` int(11) NOT NULL  AUTO_INCREMENT,
				`tour_1_id` int(8) NOT NULL  ,
				`tour_2_id` int(8) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tour_extension_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_group*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_group'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:18:"default_tour_group";s:23:"Tables_in_vietnamlan_db";s:18:"default_tour_group";}';
			
	$fieldTableInDb['tour_group_id'] = "`tour_group_id` int(5) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['parent_id'] = "`parent_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` longtext NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_group_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_group` (
	`tour_group_id` int(5) NOT NULL  AUTO_INCREMENT,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`parent_id` int(8) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` longtext NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				PRIMARY KEY (`tour_group_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_hotel*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_hotel'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:18:"default_tour_hotel";s:23:"Tables_in_vietnamlan_db";s:18:"default_tour_hotel";}';
			
	$fieldTableInDb['tour_hotel_id'] = "`tour_hotel_id` int(11) unsigned NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['tour_id'] = "`tour_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['tour_start_date_id'] = "`tour_start_date_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['tour_itinerary_id'] = "`tour_itinerary_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['hotel_id'] = "`hotel_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_hotel_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_hotel` (
	`tour_hotel_id` int(11) unsigned NOT NULL  AUTO_INCREMENT,
				`tour_id` int(8) NOT NULL  ,
				`tour_start_date_id` int(8) NOT NULL  ,
				`tour_itinerary_id` int(8) NOT NULL  ,
				`hotel_id` int(8) NOT NULL  ,
				`user_id` int(8) NOT NULL DEFAULT '0' ,
				`user_id_update` int(8) NOT NULL DEFAULT '0' ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tour_hotel_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_image*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_image'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:18:"default_tour_image";s:23:"Tables_in_vietnamlan_db";s:18:"default_tour_image";}';
			
	$fieldTableInDb['tour_image_id'] = "`tour_image_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['table_id'] = "`table_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_image_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_image` (
	`tour_image_id` int(11) NOT NULL  AUTO_INCREMENT,
				`table_id` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`user_id` int(10) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tour_image_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_itinerary*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_itinerary'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:22:"default_tour_itinerary";s:23:"Tables_in_vietnamlan_db";s:22:"default_tour_itinerary";}';
			
	$fieldTableInDb['tour_itinerary_id'] = "`tour_itinerary_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['tour_id'] = "`tour_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['day'] = "`day` int(10) NOT NULL  ";
				
	$fieldTableInDb['date_title'] = "`date_title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['content'] = "`content` text NOT NULL  ";
				
	$fieldTableInDb['meals'] = "`meals` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_show_image'] = "`is_show_image` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['transport_id'] = "`transport_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_update_image'] = "`is_update_image` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_itinerary_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_itinerary` (
	`tour_itinerary_id` int(11) NOT NULL  AUTO_INCREMENT,
				`tour_id` int(10) NOT NULL  ,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`day` int(10) NOT NULL  ,
				`date_title` varchar(255) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`content` text NOT NULL  ,
				`meals` varchar(255) NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`is_show_image` tinyint(1) NOT NULL  ,
				`transport_id` int(8) NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`is_update_image` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tour_itinerary_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_price_age_type*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_price_age_type'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:27:"default_tour_price_age_type";s:23:"Tables_in_vietnamlan_db";s:27:"default_tour_price_age_type";}';
			
	$fieldTableInDb['tour_price_age_type_id'] = "`tour_price_age_type_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['tour_id'] = "`tour_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['age_type_id'] = "`age_type_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['copy_from'] = "`copy_from` int(10) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_price_age_type_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_price_age_type` (
	`tour_price_age_type_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`tour_id` int(10) NOT NULL  ,
				`age_type_id` int(10) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`copy_from` int(10) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tour_price_age_type_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_price_cat*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_price_cat'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:22:"default_tour_price_cat";s:23:"Tables_in_vietnamlan_db";s:22:"default_tour_price_cat";}';
			
	$fieldTableInDb['tour_price_cat_id'] = "`tour_price_cat_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['tour_start_date_id'] = "`tour_start_date_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['tour_id'] = "`tour_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['cat_id'] = "`cat_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['price'] = "`price` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['copy_from'] = "`copy_from` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_price_cat_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_price_cat` (
	`tour_price_cat_id` int(11) NOT NULL  AUTO_INCREMENT,
				`tour_start_date_id` int(10) NOT NULL  ,
				`tour_id` int(10) NOT NULL  ,
				`cat_id` int(10) NOT NULL  ,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`price` varchar(255) NOT NULL  ,
				`copy_from` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tour_price_cat_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_price_col*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_price_col'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:22:"default_tour_price_col";s:23:"Tables_in_vietnamlan_db";s:22:"default_tour_price_col";}';
			
	$fieldTableInDb['tour_price_col_id'] = "`tour_price_col_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['tour_id'] = "`tour_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_price_col_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_price_col` (
	`tour_price_col_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`tour_id` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tour_price_col_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_price_customer_type*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_price_customer_type'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:32:"default_tour_price_customer_type";s:23:"Tables_in_vietnamlan_db";s:32:"default_tour_price_customer_type";}';
			
	$fieldTableInDb['tour_price_customer_type_id'] = "`tour_price_customer_type_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['tour_id'] = "`tour_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['customer_type_id'] = "`customer_type_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['copy_from'] = "`copy_from` int(10) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_price_customer_type_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_price_customer_type` (
	`tour_price_customer_type_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`tour_id` int(10) NOT NULL  ,
				`customer_type_id` int(10) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`copy_from` int(10) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tour_price_customer_type_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_price_row*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_price_row'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:22:"default_tour_price_row";s:23:"Tables_in_vietnamlan_db";s:22:"default_tour_price_row";}';
			
	$fieldTableInDb['tour_price_row_id'] = "`tour_price_row_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['tour_id'] = "`tour_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_price_row_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_price_row` (
	`tour_price_row_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`tour_id` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tour_price_row_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_price_unit*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_price_unit'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:23:"default_tour_price_unit";s:23:"Tables_in_vietnamlan_db";s:23:"default_tour_price_unit";}';
			
	$fieldTableInDb['tour_price_unit_id'] = "`tour_price_unit_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['tour_id'] = "`tour_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['tour_start_date_id'] = "`tour_start_date_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['tour_price_customer_type_id'] = "`tour_price_customer_type_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['tour_price_age_type_id'] = "`tour_price_age_type_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['price'] = "`price` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['copy_from'] = "`copy_from` int(10) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_price_unit_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_price_unit` (
	`tour_price_unit_id` int(11) NOT NULL  AUTO_INCREMENT,
				`tour_id` int(10) NOT NULL  ,
				`tour_start_date_id` int(10) NOT NULL  ,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`tour_price_customer_type_id` int(10) NOT NULL  ,
				`tour_price_age_type_id` int(10) NOT NULL  ,
				`price` varchar(255) NOT NULL  ,
				`copy_from` int(10) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tour_price_unit_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_price_val*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_price_val'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:22:"default_tour_price_val";s:23:"Tables_in_vietnamlan_db";s:22:"default_tour_price_val";}';
			
	$fieldTableInDb['tour_price_val_id'] = "`tour_price_val_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['tour_id'] = "`tour_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['tour_price_col_id'] = "`tour_price_col_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['tour_price_row_id'] = "`tour_price_row_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['price'] = "`price` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_price_val_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_price_val` (
	`tour_price_val_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`tour_id` int(10) NOT NULL  ,
				`tour_price_col_id` int(10) NOT NULL  ,
				`tour_price_row_id` int(10) NOT NULL  ,
				`price` varchar(255) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tour_price_val_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_property*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_property'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:21:"default_tour_property";s:23:"Tables_in_vietnamlan_db";s:21:"default_tour_property";}';
			
	$fieldTableInDb['tour_property_id'] = "`tour_property_id` int(10) unsigned NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['content'] = "`content` text NOT NULL  ";
				
	$fieldTableInDb['value'] = "`value` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['type'] = "`type` char(20) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_property_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_property` (
	`tour_property_id` int(10) unsigned NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`content` text NOT NULL  ,
				`value` varchar(255) NOT NULL  ,
				`type` char(20) NOT NULL  ,
				`order_no` int(10) unsigned NOT NULL DEFAULT '0' ,
				`reg_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`upd_date` int(10) unsigned NOT NULL DEFAULT '0' ,
				`image` varchar(255) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tour_property_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_review*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_review'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:19:"default_tour_review";s:23:"Tables_in_vietnamlan_db";s:19:"default_tour_review";}';
			
	$fieldTableInDb['tour_review_id'] = "`tour_review_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['booking_code'] = "`booking_code` varchar(255)   ";
				
	$fieldTableInDb['tour_id'] = "`tour_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['country_id'] = "`country_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['fullname'] = "`fullname` varchar(255)   ";
				
	$fieldTableInDb['phone'] = "`phone` varchar(255)   ";
				
	$fieldTableInDb['email'] = "`email` varchar(255)   ";
				
	$fieldTableInDb['title'] = "`title` varchar(255)   ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255)   ";
				
	$fieldTableInDb['content'] = "`content` longtext   ";
				
	$fieldTableInDb['image'] = "`image` varchar(255)   ";
				
	$fieldTableInDb['number_rate'] = "`number_rate` int(8)   ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['ip_address'] = "`ip_address` varchar(255)   ";
				
	$fieldTableInDb['html_booking'] = "`html_booking` longtext   ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(8)   ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_process'] = "`is_process` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_review_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_review` (
	`tour_review_id` int(11) NOT NULL  AUTO_INCREMENT,
				`booking_code` varchar(255)   ,
				`tour_id` int(8) NOT NULL  ,
				`country_id` int(8) NOT NULL  ,
				`fullname` varchar(255)   ,
				`phone` varchar(255)   ,
				`email` varchar(255)   ,
				`title` varchar(255)   ,
				`slug` varchar(255)   ,
				`content` longtext   ,
				`image` varchar(255)   ,
				`number_rate` int(8)   ,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(8) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`ip_address` varchar(255)   ,
				`html_booking` longtext   ,
				`order_no` int(8)   ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`is_process` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tour_review_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_season_price*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_season_price'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:25:"default_tour_season_price";s:23:"Tables_in_vietnamlan_db";s:25:"default_tour_season_price";}';
			
	$fieldTableInDb['tour_season_price_id'] = "`tour_season_price_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['_type'] = "`_type` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['tour_id'] = "`tour_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['tour_class_id'] = "`tour_class_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['season'] = "`season` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['price'] = "`price` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_hide'] = "`is_hide` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_season_price_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_season_price` (
	`tour_season_price_id` int(11) NOT NULL  AUTO_INCREMENT,
				`_type` varchar(255) NOT NULL  ,
				`tour_id` int(10) NOT NULL  ,
				`tour_class_id` int(10) NOT NULL  ,
				`season` varchar(255) NOT NULL  ,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`price` varchar(255) NOT NULL  ,
				`is_hide` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tour_season_price_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_start_date*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_start_date'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:23:"default_tour_start_date";s:23:"Tables_in_vietnamlan_db";s:23:"default_tour_start_date";}';
			
	$fieldTableInDb['tour_start_date_id'] = "`tour_start_date_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['tour_id'] = "`tour_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['start_date'] = "`start_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['end_date'] = "`end_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['allotment'] = "`allotment` int(10) NOT NULL  ";
				
	$fieldTableInDb['seat_sale'] = "`seat_sale` int(10) NOT NULL  ";
				
	$fieldTableInDb['seat_available'] = "`seat_available` int(10) NOT NULL  ";
				
	$fieldTableInDb['price'] = "`price` int(10) NOT NULL  ";
				
	$fieldTableInDb['price_old'] = "`price_old` varchar(10) NOT NULL  ";
				
	$fieldTableInDb['is_active'] = "`is_active` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_start_date_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_start_date` (
	`tour_start_date_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`tour_id` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`start_date` int(10) NOT NULL  ,
				`end_date` int(10) NOT NULL  ,
				`allotment` int(10) NOT NULL  ,
				`seat_sale` int(10) NOT NULL  ,
				`seat_available` int(10) NOT NULL  ,
				`price` int(10) NOT NULL  ,
				`price_old` varchar(10) NOT NULL  ,
				`is_active` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				PRIMARY KEY (`tour_start_date_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_store*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_store'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:18:"default_tour_store";s:23:"Tables_in_vietnamlan_db";s:18:"default_tour_store";}';
			
	$fieldTableInDb['tour_store_id'] = "`tour_store_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['tour_id'] = "`tour_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['_type'] = "`_type` varchar(50) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_store_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_store` (
	`tour_store_id` int(11) NOT NULL  AUTO_INCREMENT,
				`tour_id` int(8) NOT NULL  ,
				`_type` varchar(50) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tour_store_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tour_type*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tour_type'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:17:"default_tour_type";s:23:"Tables_in_vietnamlan_db";s:17:"default_tour_type";}';
			
	$fieldTableInDb['tour_type_id'] = "`tour_type_id` int(5) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['parent_id'] = "`parent_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` longtext NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tour_type_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tour_type` (
	`tour_type_id` int(5) NOT NULL  AUTO_INCREMENT,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`parent_id` int(8) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` longtext NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tour_type_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_tourservice*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_tourservice'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:19:"default_tourservice";s:23:"Tables_in_vietnamlan_db";s:19:"default_tourservice";}';
			
	$fieldTableInDb['tourservice_id'] = "`tourservice_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(10) NOT NULL  ";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['content'] = "`content` text NOT NULL  ";
				
	$fieldTableInDb['price'] = "`price` double NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(10) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "tourservice_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_tourservice` (
	`tourservice_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_id` int(10) NOT NULL  ,
				`user_id_update` int(10) NOT NULL  ,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`content` text NOT NULL  ,
				`price` double NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`reg_date` int(10) NOT NULL  ,
				`upd_date` int(10) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`tourservice_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_user*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_user'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:12:"default_user";s:23:"Tables_in_vietnamlan_db";s:12:"default_user";}';
			
	$fieldTableInDb['user_id'] = "`user_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['user_group_id'] = "`user_group_id` int(11) NOT NULL  ";
				
	$fieldTableInDb['user_name'] = "`user_name` varchar(50) NOT NULL  ";
				
	$fieldTableInDb['user_pass'] = "`user_pass` varchar(50) NOT NULL  ";
				
	$fieldTableInDb['first_name'] = "`first_name` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['last_name'] = "`last_name` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_active'] = "`is_active` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_super'] = "`is_super` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['address'] = "`address` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['phone'] = "`phone` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['fax'] = "`fax` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['yahoo'] = "`yahoo` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['skype'] = "`skype` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['notes'] = "`notes` text NOT NULL  ";
				
	$itemTableInDb["pkey"] = "user_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_user` (
	`user_id` int(11) NOT NULL  AUTO_INCREMENT,
				`user_group_id` int(11) NOT NULL  ,
				`user_name` varchar(50) NOT NULL  ,
				`user_pass` varchar(50) NOT NULL  ,
				`first_name` varchar(255) NOT NULL  ,
				`last_name` varchar(255) NOT NULL  ,
				`is_active` tinyint(1) NOT NULL  ,
				`is_super` tinyint(1) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`address` varchar(255) NOT NULL  ,
				`phone` varchar(255) NOT NULL  ,
				`fax` varchar(255) NOT NULL  ,
				`yahoo` varchar(255) NOT NULL  ,
				`skype` varchar(255) NOT NULL  ,
				`notes` text NOT NULL  ,
				PRIMARY KEY (`user_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_user_group*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_user_group'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:18:"default_user_group";s:23:"Tables_in_vietnamlan_db";s:18:"default_user_group";}';
			
	$fieldTableInDb['user_group_id'] = "`user_group_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['name'] = "`name` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['list_access_action'] = "`list_access_action` text NOT NULL  ";
				
	$fieldTableInDb['list_menu_action'] = "`list_menu_action` text NOT NULL  ";
				
	$fieldTableInDb['name_slug'] = "`name_slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['parent_id'] = "`parent_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['access_permiss'] = "`access_permiss` text NOT NULL  ";
				
	$fieldTableInDb['permiss_mod'] = "`permiss_mod` text NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_super'] = "`is_super` tinyint(1) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "user_group_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_user_group` (
	`user_group_id` int(11) NOT NULL  AUTO_INCREMENT,
				`name` varchar(255) NOT NULL  ,
				`list_access_action` text NOT NULL  ,
				`list_menu_action` text NOT NULL  ,
				`name_slug` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`parent_id` int(10) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`access_permiss` text NOT NULL  ,
				`permiss_mod` text NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_super` tinyint(1) NOT NULL  ,
				PRIMARY KEY (`user_group_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table default_why*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='default_why'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:11:"default_why";s:23:"Tables_in_vietnamlan_db";s:11:"default_why";}';
			
	$fieldTableInDb['why_id'] = "`why_id` int(11) NOT NULL  AUTO_INCREMENT";
				
	$fieldTableInDb['title'] = "`title` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['slug'] = "`slug` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['intro'] = "`intro` text NOT NULL  ";
				
	$fieldTableInDb['image'] = "`image` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['order_no'] = "`order_no` int(10) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(8) NOT NULL  ";
				
	$fieldTableInDb['user_id_update'] = "`user_id_update` int(8) NOT NULL  ";
				
	$fieldTableInDb['reg_date'] = "`reg_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['upd_date'] = "`upd_date` int(8) NOT NULL  ";
				
	$fieldTableInDb['is_trash'] = "`is_trash` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['is_online'] = "`is_online` tinyint(1) NOT NULL  ";
				
	$fieldTableInDb['lang_id'] = "`lang_id` varchar(2) NOT NULL  ";
				
	$itemTableInDb["pkey"] = "why_id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `default_why` (
	`why_id` int(11) NOT NULL  AUTO_INCREMENT,
				`title` varchar(255) NOT NULL  ,
				`slug` varchar(255) NOT NULL  ,
				`intro` text NOT NULL  ,
				`image` varchar(255) NOT NULL  ,
				`order_no` int(10) NOT NULL  ,
				`user_id` int(8) NOT NULL  ,
				`user_id_update` int(8) NOT NULL  ,
				`reg_date` int(8) NOT NULL  ,
				`upd_date` int(8) NOT NULL  ,
				`is_trash` tinyint(1) NOT NULL  ,
				`is_online` tinyint(1) NOT NULL  ,
				`lang_id` varchar(2) NOT NULL  ,
				PRIMARY KEY (`why_id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	/*Table isosessionhandlertable*/		
	$itemTableInDb = array(); $itemTableInDb['tbl']='isosessionhandlertable'; $fieldTableInDb = array();
	$itemTableInDb['arr']='a:2:{i:0;s:22:"isosessionhandlertable";s:23:"Tables_in_vietnamlan_db";s:22:"isosessionhandlertable";}';
			
	$fieldTableInDb['id'] = "`id` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['data'] = "`data` mediumtext NOT NULL  ";
				
	$fieldTableInDb['timestamp'] = "`timestamp` int(255) NOT NULL  ";
				
	$fieldTableInDb['user_id'] = "`user_id` int(10) NOT NULL  ";
				
	$fieldTableInDb['_site_root'] = "`_site_root` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['_ip'] = "`_ip` varchar(255) NOT NULL  ";
				
	$fieldTableInDb['browser'] = "`browser` text NOT NULL  ";
				
	$itemTableInDb["pkey"] = "id";	
	$itemTableInDb["sqlCreate"] = "CREATE TABLE IF NOT EXISTS `isosessionhandlertable` (
	`id` varchar(255) NOT NULL  ,
				`data` mediumtext NOT NULL  ,
				`timestamp` int(255) NOT NULL  ,
				`user_id` int(10) NOT NULL  ,
				`_site_root` varchar(255) NOT NULL  ,
				`_ip` varchar(255) NOT NULL  ,
				`browser` text NOT NULL  ,
				PRIMARY KEY (`id`)		
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8
			";	
	$itemTableInDb["field"] = $fieldTableInDb;
	$listTableInDb[] = $itemTableInDb;		
	
	?>
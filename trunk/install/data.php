<?php

/**
 * @Project VNP
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2012 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  30/09/2012, 00:30
 */

if( !defined( 'VNP' ) || !defined( 'VN' ) || !defined( 'VNP_INSTALL' ) ) die( 'ILN' );

//Ten cac table cua CSDL dung chung cho he thong
define( 'VNP_ADMIN', $db_info['prefix'] . '_admins' );
define( 'VNP_ADMIN_PERMISS', $db_info['prefix'] . '_admin_permiss' );
define( 'VNP_USER', $db_info['prefix'] . '_users' );
define( 'USER_PROFILE', $db_info['prefix'] . '_users_profile' );
define( 'SESSION', $db_info['prefix'] . '_session' );
define( 'GLOBAL_CONFIG', $db_info['prefix'] . '_global_config' );
//
define( 'CONTENT_TYPE', $db_info['prefix'] . '_content_type' );
define( 'CONTENT_FIELD', $db_info['prefix'] . '_content_field' );
define( 'GLOBAL_URL', $db_info['prefix'] . '_global_url' );

//define( 'NV_CRONJOBS_GLOBALTABLE', $db_info['prefix'] . '_cronjobs' );

$sql_create_table[] = "CREATE TABLE `" . VNP_USER . "` (
  `userid` mediumint(8) unsigned NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `realname` varchar(255) NOT NULL default '',
  `password` varchar(100) NOT NULL,
  `salt` varchar(100) NOT NULL,
  `groupid` int(11) DEFAULT NULL,
  `second_group_id` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `permission` mediumtext NOT NULL,
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `main_avatar` varchar(100) NOT NULL,
  `squestion` varchar(100) NOT NULL,
  `sanswer` varchar(100) NOT NULL,
  `jointime` int(11) NOT NULL DEFAULT '0',
  `last_login` int(11) NOT NULL DEFAULT '0',
  `last_ip` varchar(100) NOT NULL,
  `remember` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM";

$sql_create_table[] = "CREATE TABLE `" . USER_PROFILE . "` (
  `upid` mediumint(8) unsigned NOT NULL auto_increment,
  `userid` mediumint(8) unsigned NOT NULL,
  `realname` varchar(255) NOT NULL default '',
  `gender` tinyint(1) NOT NULL default '0',
  `birthyear` smallint(6) unsigned NOT NULL default '0',
  `birthmonth` tinyint(3) unsigned NOT NULL default '0',
  `birthday` tinyint(3) unsigned NOT NULL default '0',
  `constellation` varchar(255) NOT NULL default '',
  `telephone` varchar(255) NOT NULL default '',
  `mobile` varchar(255) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `zipcode` varchar(255) NOT NULL default '',
  `nationality` varchar(255) NOT NULL default '',
  `graduateschool` varchar(255) NOT NULL default '',
  `company` varchar(255) NOT NULL default '',
  PRIMARY KEY (`upid`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM";

$sql_create_table[] = "CREATE TABLE `" . VNP_ADMIN . "` (
  `admin_id` mediumint(8) unsigned NOT NULL auto_increment,
  `userid` mediumint(8) unsigned NOT NULL,
  `permission` mediumtext NOT NULL,
  `title` varchar(100) NOT NULL,
  `admin_class` varchar(100) NOT NULL,
  `expired` int(11) NOT NULL DEFAULT '0',
  `last_login` int(11) NOT NULL DEFAULT '0',
  `last_ip` varchar(100) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM";

$sql_create_table[] = "CREATE TABLE `" . VNP_ADMIN_PERMISS . "` (
  `permission_id` int(11) NOT NULL auto_increment,
  `permission_name` varchar(100) NOT NULL,
  `content_type` varchar(100) NOT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=MyISAM";

$sql_create_table[] = "CREATE TABLE `" . GLOBAL_CONFIG . "` (
  `config_id` int(11) NOT NULL auto_increment,
  `config_name` varchar(100) NOT NULL,
  `config_key` varchar(100) NOT NULL,
  `config_value` mediumtext NOT NULL,
  PRIMARY KEY (`config_id`)
) ENGINE=MyISAM";

$sql_create_table[] = "CREATE TABLE `" . SESSION . "` (
  `session_id` varchar(32) NOT NULL default '',
  `http_user_agent` varchar(32) NOT NULL default '',
  `session_data` blob NOT NULL,
  `session_expire` int(11) NOT NULL default '0',
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

/////////////////////////////////////
$sql_create_table[] = "CREATE TABLE `" . CONTENT_TYPE . "` (
  `content_type_id` mediumint(8) unsigned NOT NULL auto_increment,
  `content_type_name` varchar(255) NOT NULL,
  `content_type_title` varchar(255) NOT NULL,
  `content_type_note` varchar(255) default '',
  `content_type_icon` varchar(255) NOT NULL default '',
  `content_type_page` varchar(255) NOT NULL default '',
  `add_method` varchar(255) NOT NULL default '',
  `del_method` varchar(255) NOT NULL default '',
  `manage_method` varchar(255) NOT NULL default '',
  `comment` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `rating` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_type_id`),
  UNIQUE KEY `content_type_name` (`content_type_name`)
) ENGINE=MyISAM";

$sql_create_table[] = "CREATE TABLE `" . CONTENT_FIELD . "` (
  `field_id` mediumint(8) unsigned NOT NULL auto_increment,
  `content_type_id` mediumint(8) unsigned NOT NULL,
  `content_type_name` varchar(255) NOT NULL default '',
  `field_name` varchar(255) NOT NULL default '',
  `field_label` varchar(255) NOT NULL default '',
  `field_type` varchar(255) NOT NULL default '',
  `field_length` varchar(255) default '',
  `default_value` varchar(255) NOT NULL default '',
  `ref_field` mediumint(8) unsigned,
  `require` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`field_id`),
  UNIQUE KEY `field_name` (`field_name`)
) ENGINE=MyISAM";

$sql_create_table[] = "CREATE TABLE `" . GLOBAL_URL . "` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `url` varchar(255) NOT NULL default '',
  `controller` varchar(255) NOT NULL default '',
  `content_type` varchar(255) NOT NULL default '',
  `thumbnail` varchar(255) NOT NULL default '',
  `db_table` varchar(255) NOT NULL default '',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=MyISAM";
/////////////////////////////////////

$sql_create_table[] = "INSERT INTO `" . VNP_ADMIN_PERMISS . "` (`permission_id`, `permission_name`, `content_type`) VALUES
(1, 'full', 'global')";
?>
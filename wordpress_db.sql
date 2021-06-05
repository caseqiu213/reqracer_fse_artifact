-- MySQL dump 10.13  Distrib 5.6.44, for Linux (x86_64)
--
-- Host: localhost    Database: 11073
-- ------------------------------------------------------
-- Server version	5.6.44

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `11073`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `11073` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `11073`;

--
-- Table structure for table `wp_commentmeta`
--

DROP TABLE IF EXISTS `wp_commentmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_commentmeta`
--

LOCK TABLES `wp_commentmeta` WRITE;
/*!40000 ALTER TABLE `wp_commentmeta` DISABLE KEYS */;
/*!40000 ALTER TABLE `wp_commentmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_comments`
--

DROP TABLE IF EXISTS `wp_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) NOT NULL DEFAULT '',
  `comment_type` varchar(20) NOT NULL DEFAULT '',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_approved` (`comment_approved`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_comments`
--

LOCK TABLES `wp_comments` WRITE;
/*!40000 ALTER TABLE `wp_comments` DISABLE KEYS */;
INSERT INTO `wp_comments` VALUES (1,1,'Mr WordPress','','http://wordpress.org/','','2019-10-17 17:11:40','2019-10-17 17:11:40','Hi, this is a comment.<br />To delete a comment, just log in and view the post&#039;s comments. There you will have the option to edit or delete them.',0,'1','','',0,0),(89,170,'admin','admin@xample.com','','::1','2020-02-10 21:13:30','2020-02-10 21:13:30','comment',0,'1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36','',0,1);
/*!40000 ALTER TABLE `wp_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_links`
--

DROP TABLE IF EXISTS `wp_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_name` varchar(255) NOT NULL DEFAULT '',
  `link_image` varchar(255) NOT NULL DEFAULT '',
  `link_target` varchar(25) NOT NULL DEFAULT '',
  `link_description` varchar(255) NOT NULL DEFAULT '',
  `link_visible` varchar(20) NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) NOT NULL DEFAULT '',
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_links`
--

LOCK TABLES `wp_links` WRITE;
/*!40000 ALTER TABLE `wp_links` DISABLE KEYS */;
INSERT INTO `wp_links` VALUES (1,'http://codex.wordpress.org/','Documentation','','','','Y',1,0,'0000-00-00 00:00:00','','',''),(2,'http://wordpress.org/development/','Development Blog','','','','Y',1,0,'0000-00-00 00:00:00','','','http://wordpress.org/development/feed/'),(3,'http://wordpress.org/extend/ideas/','Suggest Ideas','','','','Y',1,0,'0000-00-00 00:00:00','','',''),(4,'http://wordpress.org/support/','Support Forum','','','','Y',1,0,'0000-00-00 00:00:00','','',''),(5,'http://wordpress.org/extend/plugins/','Plugins','','','','Y',1,0,'0000-00-00 00:00:00','','',''),(6,'http://wordpress.org/extend/themes/','Themes','','','','Y',1,0,'0000-00-00 00:00:00','','',''),(7,'http://planet.wordpress.org/','WordPress Planet','','','','Y',1,0,'0000-00-00 00:00:00','','','');
/*!40000 ALTER TABLE `wp_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_options`
--

DROP TABLE IF EXISTS `wp_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL DEFAULT '0',
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB AUTO_INCREMENT=400 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_options`
--

LOCK TABLES `wp_options` WRITE;
/*!40000 ALTER TABLE `wp_options` DISABLE KEYS */;
INSERT INTO `wp_options` VALUES (1,0,'_transient_random_seed','c9abb04e52bc30b94078edab99e71db7','yes'),(2,0,'siteurl','http://localhost:8080/11073','yes'),(3,0,'blogname','11073','yes'),(4,0,'blogdescription','Just another WordPress weblog','yes'),(5,0,'users_can_register','0','yes'),(6,0,'admin_email','admin@example.com','yes'),(7,0,'start_of_week','1','yes'),(8,0,'use_balanceTags','0','yes'),(9,0,'use_smilies','1','yes'),(10,0,'require_name_email','1','yes'),(11,0,'comments_notify','1','yes'),(12,0,'posts_per_rss','10','yes'),(13,0,'rss_use_excerpt','0','yes'),(14,0,'mailserver_url','mail.example.com','yes'),(15,0,'mailserver_login','login@example.com','yes'),(16,0,'mailserver_pass','password','yes'),(17,0,'mailserver_port','110','yes'),(18,0,'default_category','1','yes'),(19,0,'default_comment_status','open','yes'),(20,0,'default_ping_status','open','yes'),(21,0,'default_pingback_flag','0','yes'),(22,0,'default_post_edit_rows','10','yes'),(23,0,'posts_per_page','10','yes'),(24,0,'date_format','F j, Y','yes'),(25,0,'time_format','g:i a','yes'),(26,0,'links_updated_date_format','F j, Y g:i a','yes'),(27,0,'links_recently_updated_prepend','<em>','yes'),(28,0,'links_recently_updated_append','</em>','yes'),(29,0,'links_recently_updated_time','120','yes'),(30,0,'comment_moderation','0','yes'),(31,0,'moderation_notify','1','yes'),(32,0,'permalink_structure','','yes'),(33,0,'gzipcompression','0','yes'),(34,0,'hack_file','0','yes'),(35,0,'blog_charset','UTF-8','yes'),(36,0,'moderation_keys','','no'),(37,0,'active_plugins','a:0:{}','yes'),(38,0,'home','http://localhost/11073','yes'),(39,0,'category_base','','yes'),(40,0,'ping_sites','http://rpc.pingomatic.com/','yes'),(41,0,'advanced_edit','0','yes'),(42,0,'comment_max_links','2','yes'),(43,0,'gmt_offset','0','yes'),(44,0,'default_email_category','1','yes'),(45,0,'recently_edited','','no'),(46,0,'use_linksupdate','0','yes'),(47,0,'template','default','yes'),(48,0,'stylesheet','default','yes'),(49,0,'comment_whitelist','1','yes'),(50,0,'blacklist_keys','','no'),(51,0,'comment_registration','0','yes'),(52,0,'rss_language','en','yes'),(53,0,'html_type','text/html','yes'),(54,0,'use_trackback','0','yes'),(55,0,'default_role','subscriber','yes'),(56,0,'db_version','12329','yes'),(57,0,'uploads_use_yearmonth_folders','1','yes'),(58,0,'upload_path','','yes'),(59,0,'secret','F5ERGa!b&0FPzTJ@UFAc5eHwN7z$SlOT7^t8qt2d)m2D^loprLwz$um!yp$sKeII','yes'),(60,0,'blog_public','0','yes'),(61,0,'default_link_category','2','yes'),(62,0,'show_on_front','posts','yes'),(63,0,'tag_base','','yes'),(64,0,'show_avatars','1','yes'),(65,0,'avatar_rating','G','yes'),(66,0,'upload_url_path','','yes'),(67,0,'thumbnail_size_w','150','yes'),(68,0,'thumbnail_size_h','150','yes'),(69,0,'thumbnail_crop','1','yes'),(70,0,'medium_size_w','300','yes'),(71,0,'medium_size_h','300','yes'),(72,0,'avatar_default','mystery','yes'),(73,0,'enable_app','0','yes'),(74,0,'enable_xmlrpc','0','yes'),(75,0,'large_size_w','1024','yes'),(76,0,'large_size_h','1024','yes'),(77,0,'image_default_link_type','file','yes'),(78,0,'image_default_size','','yes'),(79,0,'image_default_align','','yes'),(80,0,'close_comments_for_old_posts','0','yes'),(81,0,'close_comments_days_old','14','yes'),(82,0,'thread_comments','0','yes'),(83,0,'thread_comments_depth','5','yes'),(84,0,'page_comments','1','yes'),(85,0,'comments_per_page','50','yes'),(86,0,'default_comments_page','newest','yes'),(87,0,'comment_order','asc','yes'),(88,0,'sticky_posts','a:0:{}','yes'),(89,0,'widget_categories','a:2:{i:2;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(90,0,'widget_text','a:2:{i:2;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(91,0,'widget_rss','a:2:{i:2;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(92,0,'timezone_string','','yes'),(93,0,'embed_autourls','1','yes'),(94,0,'embed_size_w','','yes'),(95,0,'embed_size_h','600','yes'),(96,0,'wp_user_roles','a:5:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:54:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:34:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}}','yes'),(97,0,'cron','a:3:{i:1622913113;a:3:{s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1622913123;a:1:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}s:7:\"version\";i:2;}','yes'),(98,0,'_transient_doing_cron','1622879672','yes'),(103,0,'_transient_update_core','O:8:\"stdClass\":3:{s:7:\"updates\";a:1:{i:0;O:8:\"stdClass\":5:{s:8:\"response\";s:7:\"upgrade\";s:3:\"url\";s:31:\"https://wordpress.org/download/\";s:7:\"package\";s:58:\"http://downloads.wordpress.org/release/wordpress-5.7.2.zip\";s:7:\"current\";s:5:\"5.7.2\";s:6:\"locale\";s:5:\"en_US\";}}s:12:\"last_checked\";i:1622879672;s:15:\"version_checked\";s:8:\"2.9-rare\";}','yes'),(104,0,'_transient_update_plugins','O:8:\"stdClass\":3:{s:12:\"last_checked\";i:1622879672;s:7:\"checked\";a:1:{s:9:\"hello.php\";s:5:\"1.5.1\";}s:8:\"response\";a:0:{}}','yes'),(105,0,'_transient_update_themes','O:8:\"stdClass\":3:{s:12:\"last_checked\";i:1622879672;s:7:\"checked\";a:2:{s:7:\"classic\";s:3:\"1.5\";s:7:\"default\";s:3:\"1.6\";}s:8:\"response\";a:2:{s:7:\"classic\";a:4:{s:5:\"theme\";s:7:\"classic\";s:11:\"new_version\";s:3:\"1.6\";s:3:\"url\";s:37:\"https://wordpress.org/themes/classic/\";s:7:\"package\";s:52:\"http://downloads.wordpress.org/theme/classic.1.6.zip\";}s:7:\"default\";a:4:{s:5:\"theme\";s:7:\"default\";s:11:\"new_version\";s:5:\"1.7.2\";s:3:\"url\";s:37:\"https://wordpress.org/themes/default/\";s:7:\"package\";s:54:\"http://downloads.wordpress.org/theme/default.1.7.2.zip\";}}}','yes'),(106,0,'auth_salt','5E9pQPJdRzOlWfcBed5Cc$!fSpPqQUyaEXi*$2omTioJ^yciTzpY*tFOPGb3GE@b','yes'),(107,0,'logged_in_salt','(Kiu*SSJ1BfGre^HK1Ztpya@0Jd8Sx@eEHNDnNz491h8qwoW^WwhFh$b0(1xbt(g','yes'),(108,0,'widget_pages','a:2:{i:2;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(109,0,'widget_calendar','a:2:{i:2;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(110,0,'widget_archives','a:2:{i:2;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(111,0,'widget_links','a:2:{i:2;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(112,0,'widget_meta','a:2:{i:2;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(113,0,'widget_search','a:2:{i:2;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(114,0,'widget_recent-posts','a:2:{i:2;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(115,0,'widget_recent-comments','a:2:{i:2;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(116,0,'widget_tag_cloud','a:2:{i:2;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),(117,0,'dashboard_widget_options','a:3:{s:24:\"dashboard_incoming_links\";a:5:{s:4:\"home\";s:27:\"http://localhost:8080/11073\";s:4:\"link\";s:103:\"http://blogsearch.google.com/blogsearch?scoring=d&partner=wordpress&q=link:http://localhost:8080/11073/\";s:3:\"url\";s:131:\"http://blogsearch.google.com/blogsearch_feeds?scoring=d&ie=utf-8&num=10&output=rss&partner=wordpress&q=link:http://localhost/11073/\";s:5:\"items\";i:10;s:9:\"show_date\";b:0;}s:17:\"dashboard_primary\";a:7:{s:4:\"link\";s:33:\"http://wordpress.org/development/\";s:3:\"url\";s:38:\"http://wordpress.org/development/feed/\";s:5:\"title\";s:26:\"WordPress Development Blog\";s:5:\"items\";i:2;s:12:\"show_summary\";i:1;s:11:\"show_author\";i:0;s:9:\"show_date\";i:1;}s:19:\"dashboard_secondary\";a:4:{s:4:\"link\";s:28:\"http://planet.wordpress.org/\";s:3:\"url\";s:33:\"http://planet.wordpress.org/feed/\";s:5:\"title\";s:20:\"Other WordPress News\";s:5:\"items\";i:5;}}','yes'),(118,0,'nonce_salt','FBe^(#U@5DPymWkaC$u9^&pxp7FLRLH@WQ3NpnuhY#lr&kH^czmR4%c5(DEynIWD','yes'),(119,0,'current_theme','WordPress Default','yes'),(120,0,'can_compress_scripts','1','yes'),(287,0,'_transient_timeout_feed_mod_867bd5c64f85878d03a060509cd2f92c','1574411483','no'),(386,0,'category_children','a:1:{i:1;a:1:{i:0;s:1:\"4\";}}','yes'),(388,0,'_transient_timeout_plugin_slugs','1582819375','no'),(389,0,'_transient_plugin_slugs','a:2:{i:0;s:19:\"akismet/akismet.php\";i:1;s:9:\"hello.php\";}','no'),(394,0,'_transient_timeout_feed_0ff4b43bd116a9d8720d689c80e7dfd4','1622011587','no'),(395,0,'_transient_timeout_feed_867bd5c64f85878d03a060509cd2f92c','1622011588','no'),(398,0,'_site_transient_timeout_theme_roots','1622886872','yes'),(399,0,'_site_transient_theme_roots','a:2:{s:7:\"classic\";s:7:\"/themes\";s:7:\"default\";s:7:\"/themes\";}','yes');
/*!40000 ALTER TABLE `wp_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_postmeta`
--

DROP TABLE IF EXISTS `wp_postmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB AUTO_INCREMENT=226 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_postmeta`
--

LOCK TABLES `wp_postmeta` WRITE;
/*!40000 ALTER TABLE `wp_postmeta` DISABLE KEYS */;
INSERT INTO `wp_postmeta` VALUES (4,1,'_edit_lock','1574223683'),(5,1,'_edit_last','1'),(154,115,'_wp_attached_file','2019/11/Screenshot-from-2019-06-20-15-36-34.png'),(155,115,'_wp_attachment_metadata','a:6:{s:5:\"width\";s:3:\"420\";s:6:\"height\";s:3:\"506\";s:14:\"hwstring_small\";s:22:\"height=\'96\' width=\'79\'\";s:4:\"file\";s:47:\"2019/11/Screenshot-from-2019-06-20-15-36-34.png\";s:5:\"sizes\";a:2:{s:9:\"thumbnail\";a:3:{s:4:\"file\";s:47:\"Screenshot-from-2019-06-20-15-36-34-150x150.png\";s:5:\"width\";s:3:\"150\";s:6:\"height\";s:3:\"150\";}s:6:\"medium\";a:3:{s:4:\"file\";s:47:\"Screenshot-from-2019-06-20-15-36-34-249x300.png\";s:5:\"width\";s:3:\"249\";s:6:\"height\";s:3:\"300\";}}s:10:\"image_meta\";a:10:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";}}'),(219,170,'_edit_lock','1581369191'),(220,170,'_edit_last','1');
/*!40000 ALTER TABLE `wp_postmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_posts`
--

DROP TABLE IF EXISTS `wp_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_status` varchar(20) NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) NOT NULL DEFAULT 'open',
  `post_password` varchar(20) NOT NULL DEFAULT '',
  `post_name` varchar(200) NOT NULL DEFAULT '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` text NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`)
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_posts`
--

LOCK TABLES `wp_posts` WRITE;
/*!40000 ALTER TABLE `wp_posts` DISABLE KEYS */;
INSERT INTO `wp_posts` VALUES (1,1,'2019-10-17 17:11:40','2019-10-17 17:11:40','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','publish','open','open','','hello-world','','','2019-12-16 20:23:53','2019-12-16 20:23:53','',0,'http://localhost:8080/11073/?p=1',0,'post','',1),(2,1,'2019-10-17 17:11:40','2019-10-17 17:11:40','This is an example of a WordPress page, you could edit this to put information about yourself or your site so readers know where you are coming from. You can create as many pages like this one or sub-pages as you like and manage all of your content inside of WordPress.','About','','publish','open','open','','about','','','2019-10-17 17:11:40','2019-10-17 17:11:40','',0,'http://localhost:8080/11073/?page_id=2',0,'page','',0),(7,1,'2019-11-11 19:32:37','2019-11-11 19:32:37','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-autosave','','','2019-11-11 19:32:37','2019-11-11 19:32:37','',1,'http://localhost:8080/11073/?p=7',0,'revision','',0),(115,2,'2019-11-22 21:54:38','2019-11-22 21:54:38','','Screenshot from 2019-06-20 15-36-34','','inherit','open','open','','screenshot-from-2019-06-20-15-36-34','','','2019-11-22 21:54:38','2019-11-22 21:54:38','',0,'http://localhost:8080/11073/wp-content/uploads/2019/11/Screenshot-from-2019-06-20-15-36-34.png',0,'attachment','image/png',0),(135,2,'2019-10-17 17:11:40','2019-10-17 17:11:40','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision','','','2019-10-17 17:11:40','2019-10-17 17:11:40','',1,'http://localhost:8080/11073/?p=135',0,'revision','',0),(136,2,'2019-11-23 05:24:21','2019-11-23 05:24:21','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision-2','','','2019-11-23 05:24:21','2019-11-23 05:24:21','',1,'http://localhost:8080/11073/?p=136',0,'revision','',0),(137,1,'2019-11-23 05:24:28','2019-11-23 05:24:28','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision-3','','','2019-11-23 05:24:28','2019-11-23 05:24:28','',1,'http://localhost:8080/11073/?p=137',0,'revision','',0),(138,1,'2019-12-16 19:24:31','2019-12-16 19:24:31','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision-4','','','2019-12-16 19:24:31','2019-12-16 19:24:31','',1,'http://localhost:8080/11073/?p=138',0,'revision','',0),(139,1,'2019-12-16 19:25:40','2019-12-16 19:25:40','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision-5','','','2019-12-16 19:25:40','2019-12-16 19:25:40','',1,'http://localhost:8080/11073/?p=139',0,'revision','',0),(140,1,'2019-12-16 19:47:32','2019-12-16 19:47:32','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision-6','','','2019-12-16 19:47:32','2019-12-16 19:47:32','',1,'http://localhost:8080/11073/?p=140',0,'revision','',0),(141,1,'2019-12-16 19:50:06','2019-12-16 19:50:06','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision-7','','','2019-12-16 19:50:06','2019-12-16 19:50:06','',1,'http://localhost:8080/11073/?p=141',0,'revision','',0),(142,1,'2019-12-16 19:52:59','2019-12-16 19:52:59','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision-8','','','2019-12-16 19:52:59','2019-12-16 19:52:59','',1,'http://localhost:8080/11073/?p=142',0,'revision','',0),(143,1,'2019-12-16 19:55:32','2019-12-16 19:55:32','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision-9','','','2019-12-16 19:55:32','2019-12-16 19:55:32','',1,'http://localhost:8080/11073/?p=143',0,'revision','',0),(144,1,'2019-12-16 20:01:56','2019-12-16 20:01:56','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision-10','','','2019-12-16 20:01:56','2019-12-16 20:01:56','',1,'http://localhost:8080/11073/?p=144',0,'revision','',0),(145,1,'2019-12-16 20:04:48','2019-12-16 20:04:48','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision-11','','','2019-12-16 20:04:48','2019-12-16 20:04:48','',1,'http://localhost:8080/11073/?p=145',0,'revision','',0),(146,1,'2019-12-16 20:06:22','2019-12-16 20:06:22','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision-12','','','2019-12-16 20:06:22','2019-12-16 20:06:22','',1,'http://localhost:8080/11073/?p=146',0,'revision','',0),(147,1,'2019-12-16 20:07:04','2019-12-16 20:07:04','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision-13','','','2019-12-16 20:07:04','2019-12-16 20:07:04','',1,'http://localhost:8080/11073/?p=147',0,'revision','',0),(148,1,'2019-12-16 20:11:44','2019-12-16 20:11:44','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision-14','','','2019-12-16 20:11:44','2019-12-16 20:11:44','',1,'http://localhost:8080/11073/?p=148',0,'revision','',0),(149,1,'2019-12-16 20:11:56','2019-12-16 20:11:56','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision-15','','','2019-12-16 20:11:56','2019-12-16 20:11:56','',1,'http://localhost:8080/11073/?p=149',0,'revision','',0),(150,1,'2019-12-16 20:12:27','2019-12-16 20:12:27','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision-16','','','2019-12-16 20:12:27','2019-12-16 20:12:27','',1,'http://localhost:8080/11073/?p=150',0,'revision','',0),(151,1,'2019-12-16 20:13:54','2019-12-16 20:13:54','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision-17','','','2019-12-16 20:13:54','2019-12-16 20:13:54','',1,'http://localhost:8080/11073/?p=151',0,'revision','',0),(152,1,'2019-12-16 20:18:42','2019-12-16 20:18:42','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision-18','','','2019-12-16 20:18:42','2019-12-16 20:18:42','',1,'http://localhost:8080/11073/?p=152',0,'revision','',0),(153,1,'2019-12-16 20:20:23','2019-12-16 20:20:23','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision-19','','','2019-12-16 20:20:23','2019-12-16 20:20:23','',1,'http://localhost:8080/11073/?p=153',0,'revision','',0),(154,1,'2019-12-16 20:22:50','2019-12-16 20:22:50','Welcome to WordPress. This is your first post. Edit or delete it, then start blogging!','Hello world!','','inherit','open','open','','1-revision-20','','','2019-12-16 20:22:50','2019-12-16 20:22:50','',1,'http://localhost:8080/11073/?p=154',0,'revision','',0),(170,1,'2020-02-10 21:13:09','2020-02-10 21:13:09','content','post1','','publish','open','open','','post1','','','2020-02-10 21:13:48','2020-02-10 21:13:48','',0,'http://localhost:8080/11073/?p=170',0,'post','',1),(171,1,'2020-02-10 21:13:00','2020-02-10 21:13:00','','post','','inherit','open','open','','170-revision','','','2020-02-10 21:13:00','2020-02-10 21:13:00','',170,'http://localhost:8080/11073/?p=171',0,'revision','',0),(172,1,'2020-02-10 21:13:09','2020-02-10 21:13:09','content','post1','','inherit','open','open','','170-revision-2','','','2020-02-10 21:13:09','2020-02-10 21:13:09','',170,'http://localhost:8080/11073/?p=172',0,'revision','',0),(173,1,'2020-02-10 21:13:43','2020-02-10 21:13:43','content','post1','','inherit','open','open','','170-revision-3','','','2020-02-10 21:13:43','2020-02-10 21:13:43','',170,'http://localhost:8080/11073/?p=173',0,'revision','',0);
/*!40000 ALTER TABLE `wp_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_term_relationships`
--

DROP TABLE IF EXISTS `wp_term_relationships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_term_relationships`
--

LOCK TABLES `wp_term_relationships` WRITE;
/*!40000 ALTER TABLE `wp_term_relationships` DISABLE KEYS */;
INSERT INTO `wp_term_relationships` VALUES (1,1,0),(1,2,0),(2,2,0),(3,2,0),(4,1,0),(4,2,0),(5,1,0),(5,2,0),(6,1,0),(6,2,0),(7,1,0),(7,2,0),(8,1,0),(9,1,0),(10,1,0),(11,1,0),(12,1,0),(13,1,0),(14,1,0),(15,1,0),(16,1,0),(17,1,0),(18,1,0),(19,1,0),(20,1,0),(21,1,0),(22,1,0),(24,1,0),(25,1,0),(26,1,0),(27,1,0),(28,1,0),(30,1,0),(31,1,0),(32,1,0),(33,1,0),(34,1,0),(35,1,0),(37,1,0),(38,1,0),(39,1,0),(40,1,0),(41,1,0),(42,1,0),(43,1,0),(45,1,0),(46,1,0),(47,1,0),(48,1,0),(50,1,0),(51,1,0),(52,1,0),(54,1,0),(55,1,0),(57,1,0),(58,1,0),(59,1,0),(60,1,0),(61,1,0),(62,1,0),(63,1,0),(64,1,0),(65,1,0),(66,1,0),(67,1,0),(68,1,0),(70,1,0),(71,1,0),(72,1,0),(73,1,0),(75,1,0),(76,1,0),(78,1,0),(79,1,0),(80,1,0),(81,1,0),(83,1,0),(84,1,0),(85,1,0),(87,1,0),(88,1,0),(89,1,0),(90,1,0),(94,1,0),(95,1,0),(96,1,0),(97,1,0),(102,1,0),(103,1,0),(104,1,0),(107,1,0),(108,1,0),(109,1,0),(113,1,0),(114,1,0),(115,1,0),(116,1,0),(117,1,0),(118,1,0),(119,1,0),(120,1,0),(121,1,0),(122,1,0),(124,1,0),(125,1,0),(126,1,0),(127,1,0),(128,1,0),(130,1,0),(131,1,0),(132,1,0),(133,1,0),(134,1,0),(135,1,0),(136,1,0),(137,1,0),(138,1,0),(139,1,0),(140,1,0),(141,1,0),(142,1,0),(143,1,0),(144,1,0),(145,1,0),(146,1,0),(147,1,0),(148,1,0),(149,1,0),(150,1,0),(151,1,0),(152,1,0),(153,1,0),(154,1,0),(156,1,0),(158,1,0),(159,1,0),(160,1,0),(161,1,0),(163,1,0),(164,1,0),(166,1,0),(167,1,0),(168,1,0),(169,1,0),(170,1,0),(171,1,0),(172,1,0),(173,1,0);
/*!40000 ALTER TABLE `wp_term_relationships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_term_taxonomy`
--

DROP TABLE IF EXISTS `wp_term_taxonomy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_term_taxonomy`
--

LOCK TABLES `wp_term_taxonomy` WRITE;
/*!40000 ALTER TABLE `wp_term_taxonomy` DISABLE KEYS */;
INSERT INTO `wp_term_taxonomy` VALUES (1,1,'category','',0,2),(2,2,'link_category','',0,7),(4,4,'category','',1,0);
/*!40000 ALTER TABLE `wp_term_taxonomy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_terms`
--

DROP TABLE IF EXISTS `wp_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_terms`
--

LOCK TABLES `wp_terms` WRITE;
/*!40000 ALTER TABLE `wp_terms` DISABLE KEYS */;
INSERT INTO `wp_terms` VALUES (1,'Uncategorized','uncategorized',0),(2,'Blogroll','blogroll',0),(4,'child','child',0);
/*!40000 ALTER TABLE `wp_terms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_usermeta`
--

DROP TABLE IF EXISTS `wp_usermeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_usermeta`
--

LOCK TABLES `wp_usermeta` WRITE;
/*!40000 ALTER TABLE `wp_usermeta` DISABLE KEYS */;
INSERT INTO `wp_usermeta` VALUES (1,1,'nickname','admin'),(2,1,'rich_editing','true'),(3,1,'comment_shortcuts','false'),(4,1,'admin_color','fresh'),(5,1,'wp_capabilities','a:1:{s:13:\"administrator\";b:1;}'),(6,1,'default_password_nag','1'),(7,1,'wp_user_level','10'),(8,1,'wp_autosave_draft_ids','a:19:{i:-1571333345;i:3;i:-1574020134;i:23;i:-1574130271;i:29;i:-1574190567;i:36;i:-1574195020;i:44;i:-1574197939;i:49;i:-1574221761;i:53;i:-1574222484;i:56;i:-1574286858;i:69;i:-1574297513;i:74;i:-1574297636;i:77;i:-1574298747;i:82;i:-1574367362;i:86;i:-1574368387;i:93;i:-1577475497;i:155;i:-1577558139;i:157;i:-1580695905;i:162;i:-1580696007;i:165;i:-1581369174;i:170;}'),(9,1,'wp_usersettings','m0=o&editor=tinymce'),(10,1,'wp_usersettingstime','1574130641'),(11,2,'nickname','caseqiu'),(12,2,'rich_editing','true'),(13,2,'comment_shortcuts','false'),(14,2,'admin_color','fresh'),(15,2,'wp_capabilities','a:1:{s:13:\"administrator\";b:1;}'),(16,2,'wp_user_level','10'),(17,2,'wp_autosave_draft_ids','a:6:{i:-1574394978;i:100;i:-1574458771;i:101;i:-1574459161;i:106;i:-1574459589;i:112;i:-1574470393;i:123;i:-1574470593;i:129;}'),(18,2,'wp_usersettings','m0=o&m1=o'),(19,2,'wp_usersettingstime','1574458896');
/*!40000 ALTER TABLE `wp_usermeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wp_users`
--

DROP TABLE IF EXISTS `wp_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(64) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_users`
--

LOCK TABLES `wp_users` WRITE;
/*!40000 ALTER TABLE `wp_users` DISABLE KEYS */;
INSERT INTO `wp_users` VALUES (1,'admin','$P$BR8ZsubJP4/UxwwzYCbeYBsH3m/F6/0','admin','admin@example.com','','2019-10-17 17:11:36','',0,'admin'),(2,'caseqiu','$P$BMxaINnlrIeec5qyoe1Owt2JTLq/Mq0','caseqiu','caseqiu@example.com','','2019-11-19 00:53:42','',0,'caseqiu');
/*!40000 ALTER TABLE `wp_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Current Database: `11437`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `11437` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `11437`;

--
-- Current Database: `24933`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `24933` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `24933`;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-06-05  1:05:44

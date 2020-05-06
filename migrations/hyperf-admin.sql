-- MySQL dump 10.13  Distrib 5.7.30, for Linux (x86_64)
--
-- Host: localhost    Database: admin
-- ------------------------------------------------------
-- Server version	5.7.30-0ubuntu0.18.04.1

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
-- Table structure for table `attachment`
--

DROP TABLE IF EXISTS `attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '保存的文件名',
  `original_name` varchar(255) DEFAULT NULL COMMENT '文件原始名',
  `filename` varchar(255) DEFAULT NULL COMMENT '上传的文件名',
  `path` varchar(255) DEFAULT NULL COMMENT '保存地址',
  `type` varchar(255) DEFAULT NULL COMMENT '文件类型',
  `size` int(11) DEFAULT NULL COMMENT '文件大小',
  `url` varchar(255) DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL COMMENT '上传用户id',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'cdn路径',
  PRIMARY KEY (`id`),
  KEY `title` (`title`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='文件上传记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachment`
--

LOCK TABLES `attachment` WRITE;
/*!40000 ALTER TABLE `attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_permissions`
--

DROP TABLE IF EXISTS `system_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '权限标识',
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '显示权限名称',
  `effect_uri` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '管理的路由',
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '权限简介',
  `icon` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '小图标',
  `is_nav` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否是导航菜单1是，0否',
  `hidden` tinyint(4) NOT NULL DEFAULT '0',
  `order` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `system_permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='权限';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_permissions`
--

LOCK TABLES `system_permissions` WRITE;
/*!40000 ALTER TABLE `system_permissions` DISABLE KEYS */;
INSERT INTO `system_permissions` VALUES (1,0,'user','用户管理','/user/list','用户管理','el-icon-user-solid',1,0,0,'2020-04-14 02:42:56','2020-04-14 06:18:22'),(2,1,'userAdd','添加用户','/user/add','添加用户','',0,0,0,'2020-04-14 03:04:44','2020-04-14 03:04:44'),(3,1,'userEnableDisable','用户启用/禁用','/user/enable','用户启用/禁用','',0,0,0,'2020-04-14 03:11:02','2020-04-14 03:11:02'),(4,1,'userEdit','用户编辑','/user/update','用户编辑','',0,0,0,'2020-04-14 03:12:07','2020-04-14 03:16:17'),(5,1,'userDelete','用户删除','/user/delete','删除用户','',0,0,0,'2020-04-14 03:12:43','2020-04-14 03:12:43'),(6,0,'system','系统管理','','系统管理','el-icon-setting',1,0,0,'2020-04-14 03:17:45','2020-04-14 03:17:45'),(7,6,'roles','角色管理','/roles/list','角色管理','',1,0,0,'2020-04-14 03:18:21','2020-04-16 03:05:43'),(8,7,'rolesAdd','添加权限','/roles/add','添加权限','',0,0,0,'2020-04-14 03:20:36','2020-04-14 03:20:36'),(9,7,'rolesBinding','用户绑定','/roles/binding','用户绑定','',0,0,0,'2020-04-14 03:22:57','2020-04-14 03:22:57'),(10,7,'permissionAssign','权限分配','/assign/permission','权限分配','',0,0,0,'2020-04-14 03:24:24','2020-04-17 02:08:46'),(11,7,'rolesDelete','删除角色','/roles/Delete','删除角色','',0,0,0,'2020-04-14 03:25:17','2020-04-14 03:25:17'),(12,6,'permission','权限管理','/permission/list','权限管理','',1,0,0,'2020-04-14 03:26:27','2020-04-14 03:26:27'),(13,12,'permissionAdd','添加权限','/permission/add','添加权限组','',0,0,0,'2020-04-14 03:27:02','2020-04-16 07:23:05'),(14,12,'permissionEdit','编辑权限','/permission/update','编辑权限','',0,0,0,'2020-04-14 03:28:27','2020-04-16 08:12:28'),(15,12,'permissionDelete','删除权限','/permission/delete','删除权限','',0,0,0,'2020-04-14 03:29:06','2020-04-14 03:29:06'),(17,7,'rolesEdit','编辑角色','/roles/update','','',0,0,0,'2020-04-16 08:08:59','2020-04-16 08:08:59'),(18,6,'member','权限成员管理','/roles/member','','',1,1,0,'2020-04-16 08:41:45','2020-04-16 08:52:50'),(19,18,'memberAdd','添加成员','/member/add','添加成员','',0,0,0,'2020-04-16 09:00:18','2020-04-16 09:00:18'),(20,18,'memberDelete','删除成员','/member/delete','删除成员','',0,0,0,'2020-04-16 09:00:59','2020-04-16 09:00:59');
/*!40000 ALTER TABLE `system_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_roles`
--

DROP TABLE IF EXISTS `system_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '角色唯一标识',
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '角色名称',
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '描述',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `system_roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='角色';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_roles`
--

LOCK TABLES `system_roles` WRITE;
/*!40000 ALTER TABLE `system_roles` DISABLE KEYS */;
INSERT INTO `system_roles` VALUES (1,'super','超级管理员','超级管理员1','2020-03-31 14:07:01','2020-04-13 06:48:02'),(2,'admin','管理员','普通管理员','2020-04-13 06:50:57','2020-04-13 06:50:57');
/*!40000 ALTER TABLE `system_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_roles_permissions`
--

DROP TABLE IF EXISTS `system_roles_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_roles_permissions` (
  `system_role_id` int(10) unsigned NOT NULL COMMENT '角色id',
  `system_permission_id` int(10) unsigned NOT NULL COMMENT '权限id',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`system_role_id`,`system_permission_id`),
  KEY `system_role_id` (`system_role_id`),
  KEY `system_permissions_id` (`system_permission_id`),
  CONSTRAINT `system_roles_permissions_ibfk_1` FOREIGN KEY (`system_permission_id`) REFERENCES `system_permissions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `system_roles_permissions_ibfk_2` FOREIGN KEY (`system_role_id`) REFERENCES `system_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='用户角色权限表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_roles_permissions`
--

LOCK TABLES `system_roles_permissions` WRITE;
/*!40000 ALTER TABLE `system_roles_permissions` DISABLE KEYS */;
INSERT INTO `system_roles_permissions` VALUES (1,1,'2020-04-16 06:43:32','2020-04-16 06:43:32'),(1,2,'2020-04-16 08:04:15','2020-04-16 08:04:15'),(1,3,'2020-04-16 08:04:15','2020-04-16 08:04:15'),(1,4,'2020-04-16 08:04:15','2020-04-16 08:04:15'),(1,5,'2020-04-16 08:04:15','2020-04-16 08:04:15'),(1,6,'2020-04-14 08:59:34','2020-04-14 08:59:34'),(1,7,'2020-04-15 01:00:17','2020-04-15 01:00:17'),(1,8,'2020-04-16 08:06:03','2020-04-16 08:06:03'),(1,9,'2020-04-16 08:06:03','2020-04-16 08:06:03'),(1,10,'2020-04-16 08:06:03','2020-04-16 08:06:03'),(1,11,'2020-04-16 08:06:03','2020-04-16 08:06:03'),(1,12,'2020-04-14 08:59:34','2020-04-14 08:59:34'),(1,13,'2020-04-16 08:04:54','2020-04-16 08:04:54'),(1,14,'2020-04-16 08:04:54','2020-04-16 08:04:54'),(1,15,'2020-04-16 08:04:54','2020-04-16 08:04:54'),(1,17,'2020-04-16 08:09:18','2020-04-16 08:09:18'),(1,18,'2020-04-16 08:46:59','2020-04-16 08:46:59'),(1,19,'2020-04-17 02:09:43','2020-04-17 02:09:43'),(1,20,'2020-04-17 02:09:43','2020-04-17 02:09:43'),(2,1,'2020-04-14 09:36:53','2020-04-14 09:36:53'),(2,2,'2020-04-14 09:36:53','2020-04-14 09:36:53'),(2,3,'2020-04-14 09:36:53','2020-04-14 09:36:53'),(2,4,'2020-04-14 09:47:02','2020-04-14 09:47:02'),(2,5,'2020-04-14 09:47:47','2020-04-14 09:47:47'),(2,6,'2020-04-14 09:48:00','2020-04-14 09:48:00'),(2,9,'2020-04-15 00:54:53','2020-04-15 00:54:53'),(2,12,'2020-04-14 09:48:00','2020-04-14 09:48:00'),(2,13,'2020-04-14 09:48:00','2020-04-14 09:48:00'),(2,14,'2020-04-14 09:48:00','2020-04-14 09:48:00'),(2,15,'2020-04-14 09:48:00','2020-04-14 09:48:00');
/*!40000 ALTER TABLE `system_roles_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_roles_user`
--

DROP TABLE IF EXISTS `system_roles_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_roles_user` (
  `system_role_id` int(10) unsigned NOT NULL COMMENT '角色id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`system_role_id`,`user_id`),
  KEY `system_role_id` (`system_role_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `system_roles_user_ibfk_1` FOREIGN KEY (`system_role_id`) REFERENCES `system_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `system_roles_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='角色关联用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_roles_user`
--

LOCK TABLES `system_roles_user` WRITE;
/*!40000 ALTER TABLE `system_roles_user` DISABLE KEYS */;
INSERT INTO `system_roles_user` VALUES (1,10000,'2020-04-15 06:12:02','2020-04-15 06:12:02');
/*!40000 ALTER TABLE `system_roles_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名，长度最多50个字符',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '密码',
  `salt` varchar(4) NOT NULL COMMENT '盐值',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1启用，2禁用',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称，，长度最多50个字符',
  `avatar` int(11) NOT NULL DEFAULT '0' COMMENT '头像',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=10002 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='管理员用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (10000,'18664358258','admin','b3b73b42c487939073b4b177ae419d09','883e','test@126.com',1,'Lily',-1,'2020-03-25 07:04:40','2020-04-10 02:24:42'),(10001,'13430353872','jack','a97fd5cbf877abc038551265ad828bf9','7k6t','',1,'Jacky',0,'2020-03-30 07:46:17','2020-03-30 08:11:15');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-06 15:59:19

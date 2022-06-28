/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.1
Source Server Version : 50730
Source Host           : localhost:3306
Source Database       : tp_blog

Target Server Type    : MYSQL
Target Server Version : 50730
File Encoding         : 65001

Date: 2022-06-28 22:47:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tp_admin
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin`;
CREATE TABLE `tp_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL COMMENT '管理员账户',
  `password` varchar(20) NOT NULL COMMENT '密码',
  `nickname` varchar(20) NOT NULL COMMENT '昵称',
  `email` varchar(20) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0是禁用 1 可用',
  `is_super` enum('1','0') NOT NULL DEFAULT '0' COMMENT '0是普通管理1 是超级管理',
  `create_time` int(11) NOT NULL COMMENT '注册时间',
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_admin
-- ----------------------------
INSERT INTO `tp_admin` VALUES ('1', 'admin2', 'admin2', 'admin2', '2525115881@qq.com', '1', '0', '0', '1656078318', null);
INSERT INTO `tp_admin` VALUES ('2', 'admin3', 'admin3', 'admin3', '2521150881@qq.com', '0', '0', '55', '1656074503', null);
INSERT INTO `tp_admin` VALUES ('3', 'admin', 'admin', 'admin', '2521150881@qq.com', '1', '1', '1654607883', '1654697140', null);
INSERT INTO `tp_admin` VALUES ('4', 'admin4', 'admin3', 'admin4', 'tg2521150881@gmail.c', '0', '0', '1656070347', '1656074443', null);
INSERT INTO `tp_admin` VALUES ('5', 'admin5', 'admin5', 'admin5', '233333@qq.com', '0', '1', '1656070495', '1656070495', null);

-- ----------------------------
-- Table structure for tp_article
-- ----------------------------
DROP TABLE IF EXISTS `tp_article`;
CREATE TABLE `tp_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '文章标题',
  `desc` text NOT NULL COMMENT '概要',
  `click` int(11) NOT NULL DEFAULT '0' COMMENT '阅读量',
  `comm_num` int(11) NOT NULL DEFAULT '0' COMMENT '评论量',
  `tags` varchar(100) NOT NULL COMMENT '标签',
  `author` varchar(20) NOT NULL,
  `content` longtext NOT NULL,
  `is_top` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否是推荐 0 是未推荐 1推荐',
  `cate_id` int(11) DEFAULT NULL COMMENT '所属导航id',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_article
-- ----------------------------
INSERT INTO `tp_article` VALUES ('1', '关于Android存储目录分析', '文章1', '1', '0', '标签1', '仄辛', '<p><img src=\"http://img.baidu.com/hi/jx2/j_0052.gif\"/>5<br/></p>', '0', '1', '1655388811', '1656242095', null);
INSERT INTO `tp_article` VALUES ('2', 'Flutter原生插件开发', '文章2', '24', '0', '标签2', '文章作者2', '<p>44444</p>', '0', '3', '1655553958', '1656427317', null);
INSERT INTO `tp_article` VALUES ('3', 'phpQuery爬虫使用', '文章3', '28', '0', '标签3|标签31', '文章作者3', '<p>22</p>', '1', '5', '0', '1656427296', null);
INSERT INTO `tp_article` VALUES ('4', 'Vue2->Vue3', '文章4', '60', '0', '标签4|标签41', '文章作者4', '<p>22</p>', '1', '2', '1655826591', '1656427348', null);

-- ----------------------------
-- Table structure for tp_cate
-- ----------------------------
DROP TABLE IF EXISTS `tp_cate`;
CREATE TABLE `tp_cate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catename` varchar(20) NOT NULL COMMENT '导航名称',
  `sort` int(11) NOT NULL COMMENT '排序',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_cate
-- ----------------------------
INSERT INTO `tp_cate` VALUES ('1', 'JAVA', '1', '1654954461', '1656242095', null);
INSERT INTO `tp_cate` VALUES ('2', 'Vue', '2', '1655826553', '1655826565', null);
INSERT INTO `tp_cate` VALUES ('3', 'Flutter', '3', '0', '0', null);
INSERT INTO `tp_cate` VALUES ('5', 'PHP', '4', '1656427282', '1656427282', null);

-- ----------------------------
-- Table structure for tp_comment
-- ----------------------------
DROP TABLE IF EXISTS `tp_comment`;
CREATE TABLE `tp_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL COMMENT '评论内容',
  `article_id` int(11) NOT NULL COMMENT '评论的文章id',
  `member_id` int(11) NOT NULL COMMENT '哪一个用户评论的',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_comment
-- ----------------------------
INSERT INTO `tp_comment` VALUES ('1', '第一条评论', '1', '1', '2222', '1656242095', null);
INSERT INTO `tp_comment` VALUES ('2', '第二条评论', '2', '2', '1', '1656138274', null);
INSERT INTO `tp_comment` VALUES ('3', '第三条评论', '3', '3', '1656138274', '1656138274', null);
INSERT INTO `tp_comment` VALUES ('4', '评论4', '4', '4', '0', '0', null);

-- ----------------------------
-- Table structure for tp_member
-- ----------------------------
DROP TABLE IF EXISTS `tp_member`;
CREATE TABLE `tp_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL COMMENT '会员账号',
  `password` varchar(20) NOT NULL COMMENT '密码',
  `nickname` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `create_time` int(11) NOT NULL COMMENT '注册时间',
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_member
-- ----------------------------
INSERT INTO `tp_member` VALUES ('1', '用户1', '11', '测试用户', 'tg21@gmail.c', '1655897566', '1656137841', null);
INSERT INTO `tp_member` VALUES ('2', '用户2', '22', '测试用户2', 'tg22@gmail.c', '1655897681', '1655897681', null);
INSERT INTO `tp_member` VALUES ('3', '用户3', '33', '用户3昵称', 'tg33@gmail.c', '1655897801', '1655897801', null);
INSERT INTO `tp_member` VALUES ('4', '用户4', '44', '用户4昵称', 'tf44@qq.com', '1656415790', '0', null);

-- ----------------------------
-- Table structure for tp_system
-- ----------------------------
DROP TABLE IF EXISTS `tp_system`;
CREATE TABLE `tp_system` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `webname` varchar(50) NOT NULL COMMENT '网站标题',
  `copyright` varchar(50) NOT NULL COMMENT '版权信息',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_system
-- ----------------------------
INSERT INTO `tp_system` VALUES ('1', '开源框架', 'tg2521150881@gmail.com', '0', '1656427245', null);

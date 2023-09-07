/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50617
 Source Host           : localhost:3306
 Source Schema         : secondhand

 Target Server Type    : MySQL
 Target Server Version : 50617
 File Encoding         : 65001

 Date: 20/04/2022 02:22:23
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_carousel
-- ----------------------------
DROP TABLE IF EXISTS `admin_carousel`;
CREATE TABLE `admin_carousel`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sort_index` int(8) NULL DEFAULT NULL,
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin_carousel
-- ----------------------------
INSERT INTO `admin_carousel` VALUES (1, 9999, 'market/622b293b1a119.jpg', '2022-03-11 18:49:42', '2022-03-11 18:49:42');

-- ----------------------------
-- Table structure for admin_email
-- ----------------------------
DROP TABLE IF EXISTS `admin_email`;
CREATE TABLE `admin_email`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `remark` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统设置' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin_email
-- ----------------------------
INSERT INTO `admin_email` VALUES (1, 'host', 'smtp.163.com', NULL, '2022-03-15 10:47:19');
INSERT INTO `admin_email` VALUES (2, 'username', 'campus2ndhand@163.com', NULL, '2022-03-15 10:47:19');
INSERT INTO `admin_email` VALUES (3, 'password', 'SWHABQSBDERUKXRS', NULL, '2022-03-15 10:47:19');
INSERT INTO `admin_email` VALUES (4, 'subject', 'Second Hand Campus Trading Platform', NULL, '2022-03-15 10:47:19');

-- ----------------------------
-- Table structure for admin_keyword
-- ----------------------------
DROP TABLE IF EXISTS `admin_keyword`;
CREATE TABLE `admin_keyword`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin_keyword
-- ----------------------------
INSERT INTO `admin_keyword` VALUES (1, 'Porn | Gambling | Drugs | Toxic | Police | Military | Viruses | Decryption | Invoices | Organs | Weapon | Mods | Cash', NULL, '2022-03-15 11:40:27');

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` int(8) NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '菜单名称',
  `component` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '组件',
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '路径',
  `type` tinyint(1) NULL DEFAULT NULL COMMENT '类型',
  `icon` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图标',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT NULL COMMENT '状态',
  `sort_index` int(8) NULL DEFAULT NULL COMMENT '排序',
  `component_type` tinyint(1) NULL DEFAULT 1 COMMENT '1:内部组件 2:外部连接',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 83 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统菜单' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES (1, 0, 'System Manage', '', '', 1, '', '2019-09-18 15:38:33', '2022-03-15 10:45:49', 1, 9, 1);
INSERT INTO `admin_menu` VALUES (2, 1, '菜单管理', 'admin/menu/Index', 'admin_menu_index', 1, 'menu', '2019-09-18 15:38:33', '2022-03-15 10:46:24', 2, 10, 1);
INSERT INTO `admin_menu` VALUES (64, 1, '管理员列表', 'admin/user/Index', 'admin_user_index', 1, 'user', '2020-06-19 13:45:18', '2022-03-12 09:55:36', 2, 11, 1);
INSERT INTO `admin_menu` VALUES (69, 0, 'Data Center', '', '', 1, '', '2021-12-19 14:09:36', '2022-03-14 15:42:56', 1, 1, 1);
INSERT INTO `admin_menu` VALUES (70, 69, 'Product classification', 'dataset/classify/Index', 'dataset_classify_index', 1, 'menu', '2021-12-19 14:13:32', '2022-03-14 15:44:31', 1, 3, 1);
INSERT INTO `admin_menu` VALUES (71, 69, 'Notice manage', 'dataset/notice/Index', 'dataset_notice_index', 1, 'result', '2021-12-19 14:29:59', '2022-03-15 10:46:09', 1, 6, 1);
INSERT INTO `admin_menu` VALUES (72, 69, 'Comment manage', 'dataset/comment/Index', 'dataset_comment_index', 1, 'log', '2021-12-20 05:30:53', '2022-03-15 10:46:01', 1, 4, 1);
INSERT INTO `admin_menu` VALUES (73, 69, 'Product list', 'dataset/goods/Index', 'dataset_goods_index', 1, 'log', '2021-12-20 05:31:36', '2022-03-14 15:43:12', 1, 2, 1);
INSERT INTO `admin_menu` VALUES (74, 69, 'Order manage', 'dataset/order/Index', 'dataset_order_index', 1, 'log', '2021-12-20 05:32:17', '2022-03-15 10:46:04', 1, 5, 1);
INSERT INTO `admin_menu` VALUES (75, 69, 'User manage', 'dataset/user/Index', 'dataset_user_index', 1, 'user', '2021-12-20 15:36:27', '2022-03-15 10:46:13', 1, 8, 1);
INSERT INTO `admin_menu` VALUES (78, 1, 'Site settings', 'admin/setting/Index', 'admin_setting_index', 1, 'setting', '2022-03-11 17:11:52', '2022-03-14 15:46:08', 1, 12, 1);
INSERT INTO `admin_menu` VALUES (79, 1, 'Mailbox settings', 'admin/email/Index', 'admin_email_index', 1, 'setting', '2022-03-11 17:16:35', '2022-03-14 15:46:33', 1, 13, 1);
INSERT INTO `admin_menu` VALUES (80, 1, '轮播图管理', 'admin/carousel/Index', 'admin_carousel_index', 1, 'dashboard', '2022-03-11 18:36:43', '2022-03-12 09:55:36', 2, 14, 1);
INSERT INTO `admin_menu` VALUES (81, 1, 'Keyword filter', 'admin/keyword/Index', 'admin_keyword_index', 1, 'log', '2022-03-11 20:45:34', '2022-03-14 15:46:50', 1, 15, 1);
INSERT INTO `admin_menu` VALUES (82, 69, 'Chat manage', 'dataset/chat/Index', 'dataset_chat_index', 1, 'log', '2022-03-13 22:47:23', '2022-03-15 10:46:20', 1, 9999, 1);

-- ----------------------------
-- Table structure for admin_setting
-- ----------------------------
DROP TABLE IF EXISTS `admin_setting`;
CREATE TABLE `admin_setting`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `remark` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统设置' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin_setting
-- ----------------------------
INSERT INTO `admin_setting` VALUES (1, 'verification', '1', '是否需要验证码', '2022-03-15 11:40:48');
INSERT INTO `admin_setting` VALUES (2, 'token_expire', '24400', 'Token过期时间', '2022-03-15 11:40:48');
INSERT INTO `admin_setting` VALUES (3, 'title', 'Second Hand Campus Trading Platform', '网站标题', '2022-03-15 11:40:48');
INSERT INTO `admin_setting` VALUES (5, 'super_user', '1', '超级用户', '2022-03-15 11:40:48');
INSERT INTO `admin_setting` VALUES (6, 'logo', 'logo/62300abe63959.png', '网站logo', '2022-03-15 11:40:48');
INSERT INTO `admin_setting` VALUES (7, 'sub_title', '', '网站副标题', '2022-03-15 11:40:48');
INSERT INTO `admin_setting` VALUES (8, 'copy_right', ' XX', '版权信息', '2022-03-15 11:40:48');
INSERT INTO `admin_setting` VALUES (9, 'show_link', '2', '显示下载链接', '2022-03-15 11:40:48');

-- ----------------------------
-- Table structure for admin_user
-- ----------------------------
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密码',
  `status` tinyint(1) NULL DEFAULT NULL COMMENT '状态',
  `realname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '真实姓名',
  `avatar` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '头像',
  `dept` int(8) NULL DEFAULT NULL COMMENT '部门',
  `role` int(8) NULL DEFAULT NULL COMMENT '角色',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统用户' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin_user
-- ----------------------------
INSERT INTO `admin_user` VALUES (1, 'admin', 'bebe6548be6b249b8e1a28f2ddfd30ee', 1, 'Super manager', 'avatar/613dc39052881.jpg', 1, 1, '2019-09-12 10:21:33', '2022-03-14 15:48:57');

-- ----------------------------
-- Table structure for home_address
-- ----------------------------
DROP TABLE IF EXISTS `home_address`;
CREATE TABLE `home_address`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(8) NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `mobile` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of home_address
-- ----------------------------
INSERT INTO `home_address` VALUES (3, 5, 'demo', '18888888888', '东苑402', '2021-12-19 23:29:55');
INSERT INTO `home_address` VALUES (4, 6, 'haha', '16666666666', '东苑456', '2021-12-20 04:11:48');
INSERT INTO `home_address` VALUES (5, 2, '测试', '18666666666', '地址', '2022-03-13 17:27:31');
INSERT INTO `home_address` VALUES (6, 3, 'llll', '123456', '1234fdf', '2022-03-15 11:28:38');
INSERT INTO `home_address` VALUES (7, 1, '1', '2', '3', '2022-04-11 13:24:47');

-- ----------------------------
-- Table structure for home_cart
-- ----------------------------
DROP TABLE IF EXISTS `home_cart`;
CREATE TABLE `home_cart`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_id` int(8) NULL DEFAULT NULL,
  `user_id` int(8) NULL DEFAULT NULL,
  `create_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of home_cart
-- ----------------------------
INSERT INTO `home_cart` VALUES (4, 4, 2, '2022-03-14 16:48:59');
INSERT INTO `home_cart` VALUES (8, 2, 3, '2022-03-20 09:41:27');
INSERT INTO `home_cart` VALUES (9, 6, 5, '2022-03-22 02:05:51');
INSERT INTO `home_cart` VALUES (10, 8, 2, '2022-04-11 14:04:58');
INSERT INTO `home_cart` VALUES (11, 7, 1, '2022-04-11 14:26:17');

-- ----------------------------
-- Table structure for home_chat
-- ----------------------------
DROP TABLE IF EXISTS `home_chat`;
CREATE TABLE `home_chat`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` int(8) NULL DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `user_id` int(8) NULL DEFAULT NULL,
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of home_chat
-- ----------------------------
INSERT INTO `home_chat` VALUES (6, 0, '111.', 3, '2022-03-15 11:18:21', NULL);
INSERT INTO `home_chat` VALUES (8, 0, 'Hello guys, Here is 2nd hand capstone group', 3, '2022-03-20 09:41:17', NULL);
INSERT INTO `home_chat` VALUES (9, 0, 'test', 5, '2022-03-22 02:05:37', NULL);
INSERT INTO `home_chat` VALUES (10, 0, '123', 1, '2022-04-11 16:54:00', NULL);
INSERT INTO `home_chat` VALUES (11, 10, '22', 1, '2022-04-11 16:58:12', NULL);

-- ----------------------------
-- Table structure for home_classify
-- ----------------------------
DROP TABLE IF EXISTS `home_classify`;
CREATE TABLE `home_classify`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` int(8) NULL DEFAULT NULL,
  `title` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '菜单名称',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  `sort_index` int(8) NULL DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 90 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统菜单' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of home_classify
-- ----------------------------
INSERT INTO `home_classify` VALUES (70, 0, 'Digital', '2021-12-19 14:19:57', '2022-03-14 17:09:43', 1);
INSERT INTO `home_classify` VALUES (71, 70, 'Mobile', '2021-12-19 14:21:16', '2022-03-14 17:09:49', 2);
INSERT INTO `home_classify` VALUES (72, 70, 'Camera', '2021-12-19 14:22:15', '2022-03-14 17:09:58', 3);
INSERT INTO `home_classify` VALUES (73, 70, 'Computer', '2021-12-19 14:22:20', '2022-03-14 17:10:07', 4);
INSERT INTO `home_classify` VALUES (74, 0, 'Daily Necessities', '2021-12-19 14:22:34', '2022-03-14 17:10:36', 5);
INSERT INTO `home_classify` VALUES (75, 74, 'Furniture', '2021-12-19 14:22:39', '2022-03-14 17:10:47', 6);
INSERT INTO `home_classify` VALUES (78, 0, 'Electrical equipment', '2021-12-19 14:23:24', '2022-03-14 17:11:09', 9);
INSERT INTO `home_classify` VALUES (79, 78, 'Washing machine', '2021-12-19 14:23:30', '2022-03-14 17:11:34', 10);
INSERT INTO `home_classify` VALUES (80, 78, 'Microwave Oven', '2021-12-19 14:23:37', '2022-03-14 17:11:46', 11);
INSERT INTO `home_classify` VALUES (82, 0, 'Accessories', '2021-12-19 14:24:00', '2022-03-14 17:12:05', 13);
INSERT INTO `home_classify` VALUES (84, 82, 'Clothing', '2021-12-19 14:24:56', '2022-04-11 12:16:47', 15);
INSERT INTO `home_classify` VALUES (87, 82, 'Knapsack', '2021-12-19 14:25:16', '2022-03-14 17:12:54', 18);
INSERT INTO `home_classify` VALUES (88, 82, 'Accessories', '2021-12-19 14:25:26', '2022-03-14 17:12:34', 19);
INSERT INTO `home_classify` VALUES (89, 74, 'Books', '2022-04-11 12:15:22', '2022-04-11 12:15:22', 9999);

-- ----------------------------
-- Table structure for home_comment
-- ----------------------------
DROP TABLE IF EXISTS `home_comment`;
CREATE TABLE `home_comment`  (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `goods_id` int(8) NULL DEFAULT NULL,
  `user_id` int(8) NULL DEFAULT NULL,
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `reply` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of home_comment
-- ----------------------------
INSERT INTO `home_comment` VALUES (1, 1, 1, '牛逼666', NULL, '2022-03-11 20:24:13', '2022-03-11 20:24:13');
INSERT INTO `home_comment` VALUES (2, 5, 2, '我喜欢五年的男孩，他不优秀，学习糟糕的一塌糊涂，理科生八百二三十个人他大榜七百五，他不喜欢学习，也不想要诗和远方，他讨厌这个世界，想长大的原因甚至是想看看以后的烦恼会比现在多少倍，我知道我们之间的差距注定不会在一起，但我就是喜欢他，即使他告诉我他还忘不了她', '等我有资格结婚了，会娶一个平淡看起来舒服的女子，她不用很漂亮，也不要涂很重的口红擦很重的胭脂，也不要爱慕虚荣，她要有一个温柔善良大方的心，希望她看到我满眼的爱恋，希望她可以喜欢我的各种二到不行的笑话，如果能遇到的话我一定会捧着她的脸对她说遇到你真是我一生中最幸运的事啊。', '2022-03-12 10:56:15', '2022-03-13 16:47:19');
INSERT INTO `home_comment` VALUES (3, 5, 2, '天上的星星真好看', '等我有资格结婚了，会娶一个平淡看起来舒服的女子，她不用很漂亮，也不要涂很重的口红擦很重的胭脂，也不要爱慕虚荣，她要有一个温柔善良大方的心，希望她看到我满眼的爱恋，希望她可以喜欢我的各种二到不行的笑话，如果能遇到的话我一定会捧着她的脸对她说遇到你真是我一生中最幸运的事啊。', '2022-03-12 10:56:58', '2022-03-13 16:42:11');
INSERT INTO `home_comment` VALUES (4, 2, 3, '312', NULL, '2022-03-15 11:53:48', '2022-03-15 11:53:48');
INSERT INTO `home_comment` VALUES (5, 10, 2, '111', NULL, '2022-04-11 12:20:15', '2022-04-11 12:20:15');
INSERT INTO `home_comment` VALUES (6, 10, 2, '111', NULL, '2022-04-11 12:21:31', '2022-04-11 12:21:31');
INSERT INTO `home_comment` VALUES (7, 10, 2, '111', NULL, '2022-04-11 12:21:46', '2022-04-11 12:21:46');
INSERT INTO `home_comment` VALUES (8, 10, 2, '111', NULL, '2022-04-11 12:22:11', '2022-04-11 12:22:11');
INSERT INTO `home_comment` VALUES (9, 10, 2, '111', NULL, '2022-04-11 12:22:44', '2022-04-11 12:22:44');
INSERT INTO `home_comment` VALUES (10, 10, 2, '111', NULL, '2022-04-11 12:23:11', '2022-04-11 12:23:11');
INSERT INTO `home_comment` VALUES (11, 10, 2, '111', NULL, '2022-04-11 12:23:34', '2022-04-11 12:23:34');
INSERT INTO `home_comment` VALUES (12, 10, 1, '111', NULL, '2022-04-11 16:17:08', '2022-04-11 16:17:08');

-- ----------------------------
-- Table structure for home_favourite
-- ----------------------------
DROP TABLE IF EXISTS `home_favourite`;
CREATE TABLE `home_favourite`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_id` int(8) NULL DEFAULT NULL,
  `user_id` int(8) NULL DEFAULT NULL,
  `create_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of home_favourite
-- ----------------------------
INSERT INTO `home_favourite` VALUES (4, 4, 2, '2022-03-14 16:48:56');
INSERT INTO `home_favourite` VALUES (5, 6, 5, '2022-03-22 02:06:01');

-- ----------------------------
-- Table structure for home_goods
-- ----------------------------
DROP TABLE IF EXISTS `home_goods`;
CREATE TABLE `home_goods`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `price` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `classify_id` int(8) NULL DEFAULT NULL,
  `buy_time` date NULL DEFAULT NULL,
  `level` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `free_shipping` tinyint(1) NULL DEFAULT NULL,
  `desc` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `status` tinyint(1) NULL DEFAULT NULL,
  `picture` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `view` int(8) NULL DEFAULT NULL,
  `user_id` int(8) NULL DEFAULT NULL,
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of home_goods
-- ----------------------------
INSERT INTO `home_goods` VALUES (1, 'iphone13', '6999', 71, '2022-03-01', '9', 1, 'iphone13', 3, 'market/622b3741deb5e.jpeg,market/622b3741df31a.jpeg', 14, 1, '2022-03-11 19:49:32', '2022-03-13 22:33:07');
INSERT INTO `home_goods` VALUES (2, '头部按摩器，按着很放松、舒服。 品牌:倍轻松/breo', '5', 75, '2022-03-02', '8', 1, '头部按摩器，按着很放松、舒服。 品牌:倍轻松/breo', 1, 'market/622b410788bbe.jpg,market/622b4107897d7.jpg,market/622b410788ce3.jpg', 26, 1, '2022-03-11 20:31:20', '2022-03-11 20:31:20');
INSERT INTO `home_goods` VALUES (3, '香水打包', '150', 88, '2022-03-02', '9', 1, '香水打包', 3, 'market/622b414cf08b3.jpg', 9, 1, '2022-03-11 20:32:22', '2022-03-11 20:32:22');
INSERT INTO `home_goods` VALUES (4, '徕卡X2复古单反相机', '3200', 72, '2022-03-10', '9.9', 1, '徕卡X2复古单反相机', 3, 'market/622bfc723d486.jpg,market/622e03108b9c3.jpg', 53, 1, '2022-03-12 09:51:02', '2022-03-13 22:43:29');
INSERT INTO `home_goods` VALUES (5, 'Switch怪猎限定版日版 成色99新几乎无耗损', '200', 80, '2022-03-03', '9.9', 2, '自带怪猎游 品牌:任天堂 型号:任天堂 Switch 怪物猎人崛起限定版', 3, 'market/622bfcaacd582.jpg,market/622bfcaacd85f.jpg,market/622bfcaaccc58.jpg', 78, 1, '2022-03-12 09:51:54', '2022-03-13 17:30:26');
INSERT INTO `home_goods` VALUES (6, 'Jordan 12 Retro Playoffs (2022)', '236', 84, '2022-01-11', '', 1, 'In celebration of its 25th Anniversary, Jordan Brand brought back the shoe that Michael Jordan wore while winning his 5th NBA Title, the Air Jordan 12 Retro Playoffs. ', 1, 'market/62300883bb5a9.png', 2, 3, '2022-03-15 11:32:31', '2022-03-15 11:32:31');
INSERT INTO `home_goods` VALUES (7, 'NVIDIA GeForce RTX 3080 Founders Edition Graphics Card', '1318', 73, '2022-03-01', '', 1, 'Step up your graphics with the RTX 3080 Founders Edition. The NVIDIA-made RTX 3080 Founders Edition is advanced in its features, including a dual-fan system, 10GB of RAM, and boost clock speeds of 1.71 GHz. Like other cards in NVIDIA’s 30 Series, it was no simple task to get an RTX 3080 Founders Edition when it released in September 2020 for $700. The demand for the RTX 3080 Founders Edition was simply too high for the number of people who wanted one. Thankfully, if you haven’t been able to secure yours yet, you can Buy an RTX 3080 Founders Edition on StockX now.\nTechnology Features: 10GB GDDR6X, PCI Express 4.0 \nPlease note that any redemption codes for limited-time game downloads or subscription memberships are not guaranteed to be included.\n\nPlease refer to the manufacturer directly regarding product functionality and other product-related question. StockX facilitates the sale of products by connecting buyers and sellers and is not responsible for product-specific warranties from manufacturers.', 1, 'market/6230091deb56c.png', 5, 3, '2022-03-15 11:34:10', '2022-03-15 11:34:10');
INSERT INTO `home_goods` VALUES (8, 'Pokémon TCG 25th Anniversary Celebrations Ultra-Premium Collection Box', '271', 88, '2022-01-04', '', 1, 'Celebrate 25 years of Pokémon with the Pokémon Celebrations Ultra Premium Collection Box featuring two of the Pokémon world\'s best-loved icons: Charizard and Pikachu! This fantastic collection includes a massive set of Pokémon TCG: Celebrations boosters as well as commemorative Pikachu and Charizard cards made of solid metal, showing these characters as they first appeared in the Pokémon TCG. \n\nThe Pokémon Celebrations Ultra Premium Collection Box holds two commemorative metal cards featuring Base Set Pikachu and Charizard, one gold version of Pikachu V, one gold version of Poké Ball, a Charizard and Pikachu enamel pin, one metal Pokémon coin, 17 Pokémon Celebrations four card booster packs, eight additional Pokémon TCG booster packs, a player\'s guide to game mechanics through the history of the Pokémon TCG, three storage boxes, and a code for the online Pokémon card game. \n\nThe Pokémon Celebrations Ultra Premium Collection Box released in October 2021 for a retail price of $120. \nThis is an English Language Pokémon product.', 1, 'market/62300956167ee.png', 7, 3, '2022-03-15 11:35:05', '2022-03-15 11:35:05');
INSERT INTO `home_goods` VALUES (9, 'porn', '123', 71, '2022-03-15', '', 1, '2222', 2, 'market/62300b26b23a9.png', 1, 3, '2022-03-15 11:42:38', '2022-03-15 11:42:38');
INSERT INTO `home_goods` VALUES (10, 'StockX Vault NFT adidas Yeezy Boost 350 V2 Beluga Reflective - US M 10 A StockX token representing ownership of a physical pair. (250/500 available to date)', '299', 73, '2022-03-01', '', 1, 'This StockX Vault NFT represents and tracks proof of ownership of the actual sneaker stored within our StockX Vault, which has been verified via StockX\'s authentication process. Note only 250 out of 500 editions will be made available for initial purchase, with the remaining 250 being reserved for potential \"shock drops\" by StockX. Any future shock drops (including timing and number of editions released) will be at StockX\'s sole discretion. StockX does not guarantee that any portion of the remaining 250 editions will be released in the future. \n\nThis adidas Yeezy Boost 350 V2 Beluga Reflective builds off of the original Beluga colorway by adding reflective qualities and speckled orange accents to its Primeknit upper. Signature details like a Boost sole and orange side stripe complete the design.\n\nFor storing this card with StockX Vault, you may be granted exclusive access to StockX benefits.\n\nTo see this NFT on the blockchain, click here. You can learn more about NFTs on StockX here. \n\nThe Fine Print:\n- The Vault NFT is not affiliated or associated with, sponsored by, or officially connected to adidas, Yeezy or any of its subsidiaries or affiliates. Any adidas or Yeezy name(s), use and trademark(s) used in the Vault NFT are all the property of adidas and Yeezy and are used in the Vault NFT solely to refer to the physical product to which the Vault NFT corresponds. For more information on official adidas or Yeezy products, please visit www.adidas.com.\n- If the physical item associated with this Vault NFT is redeemed by the owner, it is removed from the StockX Vault and shipped to the owner. StockX will then remove the Vault NFT from the owner\'s Portfolio and from circulation (i.e., \"burn\" the Vault NFT). Owners can request to withdraw the physical item from the StockX Vault by filling out the Vault Redemption Form, which can be found here.\n- StockX will be releasing 250 editions of 500 total editions for initial purchase. The remaining 250 editions may be released at any time in the future, in StockX’s sole discretion. StockX does not and cannot guarantee that the maximum number of editions (i.e., 500) will ever be minted, sold or in circulation. \n- Minted on Ethereum blockchain.', 1, 'market/62300d889fd41.png', 45, 3, '2022-03-15 11:52:57', '2022-03-15 11:52:57');
INSERT INTO `home_goods` VALUES (11, 'heizi', '1000', 72, '2020-03-04', '', 2, 'Here is Sigma fp, like new. (for test only )', 4, 'market/623685b6e67e1.JPG', 4, 3, '2022-03-20 09:39:44', '2022-03-20 09:39:44');
INSERT INTO `home_goods` VALUES (12, '1', '2', 71, '2022-04-13', '', 1, '223', 3, 'market/62541bf2d3fab.jpg', 7, 1, '2022-04-11 20:15:53', '2022-04-11 20:18:14');

-- ----------------------------
-- Table structure for home_notice
-- ----------------------------
DROP TABLE IF EXISTS `home_notice`;
CREATE TABLE `home_notice`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `create_time` datetime(0) NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of home_notice
-- ----------------------------
INSERT INTO `home_notice` VALUES (2, '<p><b><font size=\"4\">Users shall not violate national laws and regulations and relevant requirements of the platform. If the platform actively discovers or verifies that the user violates this code of conduct through user reporting, the platform will deal with the user according to the specific situation and severity of the user\'s violation, and punish some users with serious circumstances, including but not limited to limiting the account number function, banning the account number and other disposal measures. At the same time, the platform will also cooperate with and transfer the suspected violations of laws and regulations of users to relevant administrative departments for handling according to law.</font></b><br/><br/><b>1、 Account registration and use</b><br/><br/>1. Users shall complete registration according to the requirements of the platform, and shall not register or authenticate on the platform with other people\'s data (including but not limited to using other people\'s wechat account, mobile phone number or identity information);<br/><br/>2. Users shall not register platform accounts maliciously by any means, including but not limited to registering multiple accounts for the purpose of making profits, cashing out and winning awards;<br/><br/>3. Do not embezzle other user accounts. The account number of the platform shall not be transferred, leased or sold without the explicit written permission of the platform.<br/><br/><b><br/>2、 When publishing commodity information, users must abide by the regulations on commodity publishing and shall not publish and trade commodities that are not allowed to be traded by national laws and regulations or that require qualification permission.</b><br/><br/><b><br/>3、 Violations</b><br/><br/>1. Release the behavior that the description of idle items is inconsistent with the actual situation;<br/><br/>2. When delivering goods or returning goods, deliberately exchanging idle goods or secretly changing parts, resulting in financial losses to others;<br/><br/>3. After the transaction, malicious acts for the purpose of making profits or taking the opportunity of extortion, or other illegal acts that obviously violate the principles of equality, fairness and voluntariness;<br/><br/>4. Use fake customer service identity, fishing links and other acts to defraud others\' property;<br/><br/>5. Frequent and abnormal transaction disputes leading to the loss of funds of others;<br/><br/>6. Guide others to leave the platform for communication or transaction in any form, resulting in the loss of others\' property;<br/><br/>7. Divulge user information, such as publishing others\' private information (including but not limited to telephone, address, name, etc.) without authorization, or providing it to a third party;<br/><br/>8. Conduct personal attacks on others by means of insult, slander, abuse, malicious slander, etc;<br/><br/>9. The behavior of non officially certified merchants selling goods on the platform;<br/><br/>10. Malicious purchase, malicious rights protection goods and / or services and other acts that disrupt the normal trading order of the platform;<br/><br/>11. Acts that affect the security of the platform, such as making up or concealing the transaction facts, using the platform payment channels for credit payment cash out, and providing payment commodities to illegal websites;<br/><br/>12. Infringement of others\' intellectual property rights when publishing goods or providing services;<br/><br/>13. Other violations of regulations or platform requirements.</p>', '2022-03-15 11:00:20', 'User behavior specification', '2021-12-20 15:29:18', 1);
INSERT INTO `home_notice` VALUES (3, '<p><b><font size=\"5\">The commodity release regulations are as follows:</font></b></p><p><b><font size=\"4\">1、 Prohibited category according to national laws and relevant regulations, it is prohibited to publish the following categories of goods:</font></b><br/><br/>1. Pornographic, vulgar and violent information: including but not limited to pornographic and obscene articles, sexual services, bloody violence, videos, audio-visual products, books and games of vulgar content, software, pictures, seed files, etc. used to disseminate vulgar and violent content, \"original\" transactions (second-hand, original underwear and socks), and other commodities or information contrary to public order and good customs;</p><p><br/>2. Gambling, gambling websites, games and related services, gambling related goods and tutorials: including but not limited to gambling, gambling websites, games, platforms, providing technology or services such as station building and recharge for gambling, gambling tools, Gambling cheating tools and tutorials, and gambling goods;&nbsp;</p><p>3. Inflammable and explosive substances, dangerous chemicals and drugs: including but not limited to gunpowder, fireworks, firecrackers, bombs, drug making raw materials / chemicals, toxic, corrosive / inflammable and explosive / toxic chemicals, addictive drugs, drug abuse tools / Accessories / relevant courses, etc;<br/><br/>4. Political reactionary, harmful information that endangers national security and undermines political and social stability: including but not limited to splitting / undermining national unity, divulging state secrets, promoting reactionary / cult, damaging national reputation, etc;<br/><br/>5. Drugs (prescription drugs, over-the-counter drugs), fake drugs, inferior drugs and other drugs, veterinary drugs and pesticides prohibited from sale;<br/><br/>6. Commodities of guns, ammunition, ammunition, simulated guns, simulated ammunition and simulated arms in any form: including but not limited to guns, imitation of guns (including but not limited to simulated guns), sub (gun) bullets, silencers, gunpowder, anesthetic injection guns, parts and components of arms, related equipment, accessories, ancillary products and manufacturing methods And related products, including but not limited to instructions, packing boxes, etc;<br/><br/>7. Police and military articles, administrative organs\' articles and related products: including but not limited to police uniforms, police badges, handcuffs, police lights, police sirens, police instruments, special goods for state organs, signs / uniforms / special tools of administrative organs;<br/><br/>8. Dangerous weapons: including but not limited to controlled knives, bows and crossbows, powerful slingshots with power assisted structure, darts, steel columns, marbles, bow and crossbow accessories, etc;<br/><br/>9. Animals and plants, products and hunting tools: including but not limited to national protected animals, endangered animals, Sanyou animals and related commodities, national protected plants, hunting tools, accessories and manufacturing methods, public welfare and regional protected animals and plants and their products, living animals and meat products for food, toxic animals and plants;<br/><br/>10. Personal privacy: including but not limited to certificates, data and inquiry services involving personal privacy, software that may be used to infringe personal privacy (personal privacy data, data and inquiry services), tools and services (illegal camera, recording, eavesdropping, candid shooting equipment, software and services), monitoring and monitoring equipment;<br/><br/>11. Prohibited goods or services: including but not limited to illegal goods and services such as theft, smuggling, cheating, harassment of others, illegally obtained goods (obtained from smuggling, theft or robbery), real name goods such as mobile phone cards, Internet breaking, wall climbing, VPN software, services and tutorials, goods and services related to Internet accounts, data fraud, false authentication, hacking, cracking Plug in and other tools, tutorials and services, illegal collection and reselling of information, fraud tool goods and services, agency, cattle and other goods and services, wool collection, cigarettes and other tobacco products;<br/><br/>12. Any kind of articles infringing the intellectual property rights of others: including but not limited to counterfeit goods, infringing the trademark right / copyright / patent right of others, and unauthorized copies (including but not limited to piracy, ripping, backup, piracy, etc.): software programs, video games, music collections, movies, TV programs or photos;<br/><br/>13. RMB and financial related goods and services: including but not limited to the sale or purchase of circulating, wrong version RMB, counterfeit currency, printing equipment, bitcoin and other virtual currencies and derivative services, goods or services that can only be provided by specific financial institutions, illegal pyramid selling, illegal fund-raising goods, illegal trading of foreign exchange, Fund payment and settlement services or related products;<br/><br/>14. Invoices: those without validity and circulation. Except for the transfer for the purpose of collection;<br/><br/>15. Stocks, corporate bonds and other securities: those that do not have effectiveness and liquidity. Except for the transfer for the purpose of collection;<br/><br/>16. Lottery tickets: not effective and circulating. Except for the transfer for the purpose of collection;<br/><br/>17. Government documents in any form: including but not limited to identity cards, archives, various licenses, letters of introduction, academic certificates, materials or documents involving state secrets, etc;<br/><br/>18. Forged and altered items: including but not limited to forged certificates, bills, coins, licenses and permits;<br/><br/>19. Human organs (including donated eggs, sperm, etc.), remains, etc;<br/><br/>20. other items that may endanger the safety or interests of others or for illegal purposes include: but not limited to the equipment of prying lock, strong effect, drugs, decryption software, missile launching program, personal, enterprise private data, automotive anti radar speedometer, electronic dog, alarm, mobile phone listener, automobile hidden spray, gravity decoder, power saver, Meter reverser, etc;<br/><br/>21. Equipment that can only be used with license or government permission: including but not limited to broadcast transmitting station and dish satellite antenna;<br/><br/>22. Products that cannot be provided with relevant licenses due to the application of license management provisions in national laws;<br/><br/>23. According to the requirements of relevant departments, in order to avoid transaction risks, users under the age of 16 are not allowed to publish motorcycles and electric vehicles;<br/><br/>24. Other circumstances where the sale and purchase are prohibited by laws and regulations.<br/><br/></p>', '2022-04-11 10:31:22', '<span style=\"color:red\">Commodity</span> release regulations', '2022-03-11 20:38:49', 1);

-- ----------------------------
-- Table structure for home_order
-- ----------------------------
DROP TABLE IF EXISTS `home_order`;
CREATE TABLE `home_order`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_id` int(8) NULL DEFAULT NULL,
  `user_id` int(8) NULL DEFAULT NULL,
  `order_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `create_time` datetime(0) NULL DEFAULT NULL,
  `owern_user_id` int(8) NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of home_order
-- ----------------------------
INSERT INTO `home_order` VALUES (1, 3, 3, 'OD6230081E8CD95', '2022-03-15 11:29:34', 1, 'llll--123456--1234fdf');
INSERT INTO `home_order` VALUES (2, 4, 3, 'OD6230081E8FE95', '2022-03-15 11:29:34', 1, 'llll--123456--1234fdf');
INSERT INTO `home_order` VALUES (3, 5, 3, 'OD6230081E90EB9', '2022-03-15 11:29:34', 1, 'llll--123456--1234fdf');
INSERT INTO `home_order` VALUES (4, 1, 3, 'OD62368615E2AD1', '2022-03-20 09:40:37', 1, 'llll--123456--1234fdf');
INSERT INTO `home_order` VALUES (5, 11, 5, 'OD6236AA5F76DC5', '2022-03-20 12:15:27', 3, 'demo--18888888888--东苑402');
INSERT INTO `home_order` VALUES (6, 12, 2, 'OD62541C9A0B05F', '2022-04-11 20:18:34', 1, '测试--18666666666--地址');

-- ----------------------------
-- Table structure for home_score
-- ----------------------------
DROP TABLE IF EXISTS `home_score`;
CREATE TABLE `home_score`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(8) NULL DEFAULT NULL,
  `desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `create_time` datetime(0) NULL DEFAULT NULL,
  `task_id` int(8) NULL DEFAULT NULL,
  `create_day` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for home_score_task
-- ----------------------------
DROP TABLE IF EXISTS `home_score_task`;
CREATE TABLE `home_score_task`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(8) NULL DEFAULT NULL,
  `day` date NULL DEFAULT NULL,
  `class_id` int(8) NULL DEFAULT NULL,
  `class_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of home_score_task
-- ----------------------------
INSERT INTO `home_score_task` VALUES (1, 2, '2022-03-14', 72, NULL, 2);
INSERT INTO `home_score_task` VALUES (2, 3, '2022-03-15', 88, NULL, 2);
INSERT INTO `home_score_task` VALUES (3, 4, '2022-03-16', 71, NULL, 2);
INSERT INTO `home_score_task` VALUES (4, 3, '2022-03-20', 75, NULL, 2);
INSERT INTO `home_score_task` VALUES (5, 5, '2022-03-20', 75, NULL, 1);
INSERT INTO `home_score_task` VALUES (6, 5, '2022-03-22', 73, NULL, 1);
INSERT INTO `home_score_task` VALUES (7, 3, '2022-03-22', 73, NULL, 1);
INSERT INTO `home_score_task` VALUES (8, 3, '2022-03-31', 84, NULL, 1);
INSERT INTO `home_score_task` VALUES (9, 3, '2022-04-05', 73, NULL, 1);
INSERT INTO `home_score_task` VALUES (10, 2, '2022-04-11', 73, NULL, 1);
INSERT INTO `home_score_task` VALUES (11, 1, '2022-04-11', 88, NULL, 1);

-- ----------------------------
-- Table structure for home_user
-- ----------------------------
DROP TABLE IF EXISTS `home_user`;
CREATE TABLE `home_user`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mobile` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密码',
  `nickname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '昵称姓名',
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  `sdu_num` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `money` int(8) NULL DEFAULT 0,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `score` int(8) NULL DEFAULT 0 COMMENT '积分',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统用户' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of home_user
-- ----------------------------
INSERT INTO `home_user` VALUES (1, '18888888888', 'be669a3c9e5f868e3496537e4598a87c', '橘子果冻', '2022-03-11 19:39:56', '2022-03-12 11:30:22', '001', '344453696@qq.com', 666365, 'avatar/622c136b7b511.jpg', 5);
INSERT INTO `home_user` VALUES (2, '18666666666', 'be669a3c9e5f868e3496537e4598a87c', '半凉未凉', '2022-03-12 10:36:31', '2022-04-11 13:12:22', '002', 'demo@qq.com', 247, 'avatar/622da920c0ae4.jpg', 21);
INSERT INTO `home_user` VALUES (3, '13949248200', 'be669a3c9e5f868e3496537e4598a87c', 'u_13949248200', '2022-03-14 20:11:15', '2022-03-14 20:11:15', '12345', '2398233699@qq.com', 121303074, 'avatar/default.jpg', 5);
INSERT INTO `home_user` VALUES (4, '13688775599', '2c79d9c3ef4e8646ad1e96816ce10637', 'u_13688775599', '2022-03-16 13:14:27', '2022-03-16 13:16:57', '1234567', 'yingchizhu@email.arizona.edu', 0, 'avatar/623172c82e8f1.jpg', 1);
INSERT INTO `home_user` VALUES (5, '5202259082', '3ad149733935fd7b911e1de596382657', 'u_5202259082', '2022-03-20 12:13:23', '2022-03-20 12:13:23', '23493668', 'gshxd123456@email.arizona.edu', 1000, 'avatar/default.jpg', 0);

SET FOREIGN_KEY_CHECKS = 1;

/*
Navicat MySQL Data Transfer

Source Server         : 54.169.207.187
Source Server Version : 50720
Source Host           : 54.169.207.187:3306
Source Database       : lam_logistik_sync

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2017-12-04 10:05:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sync_awb
-- ----------------------------
DROP TABLE IF EXISTS `sync_awb`;
CREATE TABLE `sync_awb` (
  `awb_no` char(50) DEFAULT NULL,
  `bc_no` char(50) DEFAULT NULL,
  `bc_date` date DEFAULT NULL,
  `status_awb` enum('Open','Clear') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sync_awb
-- ----------------------------
INSERT INTO `sync_awb` VALUES ('a12347', 'sdf234234', '2017-08-03', 'Clear');
INSERT INTO `sync_awb` VALUES ('a1234', '23424234', '2017-08-03', 'Clear');

/*
Navicat MySQL Data Transfer

Source Server         : 54.169.207.187
Source Server Version : 50720
Source Host           : 54.169.207.187:3306
Source Database       : lam_logistik

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2017-12-04 09:48:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for lam_customer
-- ----------------------------
DROP TABLE IF EXISTS `lam_customer`;
CREATE TABLE `lam_customer` (
  `id_customer` char(10) NOT NULL,
  `nama_customer` char(50) DEFAULT NULL,
  `cp` char(50) DEFAULT NULL,
  `phone` char(50) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `country` char(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `cust_type` enum('External','Internal') DEFAULT NULL,
  `npwp` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_customer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lam_customer
-- ----------------------------
INSERT INTO `lam_customer` VALUES ('CST000001', 'PT.Customer One', 'Mr. Bambang', '021379788987', 'lesmana@lamsolusi.com', 'USA', 'Jl apa aja bolehs', null, null);
INSERT INTO `lam_customer` VALUES ('CST000002', 'PT. Customer Two', 'Mrs.|Yuni|Sulastri', '021379788987', 'lesmana@lamsolusi.com', 'USA', 'Jl apa aja susilo', null, null);
INSERT INTO `lam_customer` VALUES ('CST000003', 'PT.  GMF', 'Mr.|Sata|Lesmana', '09876686969', 'lesmana@lamsolusi.com', 'ID', 'Cengkareng Jakarta', 'Internal', null);
INSERT INTO `lam_customer` VALUES ('CST000004', 'PT. Sriwijaya Indonesia', 'Mr.|Joko|Susilo', '021-877998877', '', 'ID', 'Jalan Tangerang Selatan', 'External', null);
INSERT INTO `lam_customer` VALUES ('CST000005', 'PT.OKKI S', 'Mr.|Okki|Setyawan', '089610595064', 'okkisetyawan@gmail.com', 'ID', 'Jl.Bintara IX', 'Internal', '009');

-- ----------------------------
-- Table structure for lam_forwarder
-- ----------------------------
DROP TABLE IF EXISTS `lam_forwarder`;
CREATE TABLE `lam_forwarder` (
  `id_forwarder` char(10) NOT NULL,
  `nama_forwrder` char(50) DEFAULT NULL,
  `cp` char(50) DEFAULT NULL,
  `phone` char(50) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `country` char(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_forwarder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lam_forwarder
-- ----------------------------
INSERT INTO `lam_forwarder` VALUES ('FWD000001', 'Alliance21', 'Ms.|Amalia|Syakira', '021379788987', 'forwarder@eskrim.com', 'IDN', 'Jl. Sudirman Jakarta Pusat');
INSERT INTO `lam_forwarder` VALUES ('FWD000002', 'Schenker Indonesia', 'Mr.|Green|Wildon', '021-877998877', '', 'IDN', 'Jl. Rawa Bokor Cengkareng \nJakarta Barat');
INSERT INTO `lam_forwarder` VALUES ('FWD000003', 'PT. AOP', 'Mr.|Ahmad |Omay', '021-95586995', 'aomay@mail.com', 'ID', 'Jl.Nangka 1');

-- ----------------------------
-- Table structure for lam_partner
-- ----------------------------
DROP TABLE IF EXISTS `lam_partner`;
CREATE TABLE `lam_partner` (
  `id_partner` char(10) NOT NULL,
  `nama_partner` char(50) DEFAULT NULL,
  `cp` char(50) DEFAULT NULL,
  `phone` char(50) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `country` char(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_partner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lam_partner
-- ----------------------------
INSERT INTO `lam_partner` VALUES ('PTR000001', 'PT. Suka suka', 'saiapa aja', '0989665789', 'suka@mail.com', 'USA', 'asdf asf');
INSERT INTO `lam_partner` VALUES ('PTR000002', 'AIRBUS', 'Ian Wright', '+187762323233', 'wright@boeing.com', 'USA', 'California, ');
INSERT INTO `lam_partner` VALUES ('PTR000003', 'BOEING', 'Sumadji', '001-12345678', 'Sumadji@boeing.bersatu', 'US', 'Sekitaran AMERIKA');
INSERT INTO `lam_partner` VALUES ('PTR000004', 'PT.AGUNG P', '089764589428', '089610595099', 'agung@mail.com', 'ID', 'Jl.Bintara');

-- ----------------------------
-- Table structure for lam_petugas
-- ----------------------------
DROP TABLE IF EXISTS `lam_petugas`;
CREATE TABLE `lam_petugas` (
  `id_petugas` varchar(20) NOT NULL DEFAULT '',
  `id_alias` varchar(20) DEFAULT NULL COMMENT 'data berisi id_customer/id_sales',
  `password_petugas` char(50) NOT NULL,
  `nama_petugas` varchar(50) NOT NULL,
  `email` char(100) DEFAULT NULL,
  `company_name` varchar(50) DEFAULT NULL,
  `jenis_petugas` char(2) NOT NULL DEFAULT '0',
  `expired_password` date NOT NULL COMMENT 'batas password expired (berakhir)',
  `status_petugas` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'status user 1:aktif, 0:non aktif',
  `user_agent` varchar(200) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL COMMENT 'identifikasi kapan user dibuat',
  `lastlogin` datetime DEFAULT NULL COMMENT 'identikasi kapan terakhir user login',
  `lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'identifikasi perubahan data user',
  PRIMARY KEY (`id_petugas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='informasi data petugas';

-- ----------------------------
-- Records of lam_petugas
-- ----------------------------
INSERT INTO `lam_petugas` VALUES ('admin', '', 'c4ca4238a0b923820dcc509a6f75849b', 'Mr.|Amalia|Lesmana', 'lesmana@lamsolusi.com', 'null', '20', '2017-09-18', '1', '0', '2017-09-11 08:39:39', '2017-07-04 08:56:48', '2017-09-11 01:39:39');
INSERT INTO `lam_petugas` VALUES ('aomay', 'FWD000003', '0cc175b9c0f1b6a831c399e269772661', 'Mr.|Ahmad |Omay', 'aomay@mail.com', 'PT. AOP', '50', '2017-12-05', '1', null, '2017-11-28 10:05:47', null, '2017-11-28 03:05:47');
INSERT INTO `lam_petugas` VALUES ('brian', 'CST000004', 'c4ca4238a0b923820dcc509a6f75849b', 'Mr.|Brian|Sudiro', 'rendy.db@gmf-aeroasia.co.id', 'PT. Sriwijaya Indonesia', '40', '2017-08-21', '1', null, '2017-08-14 11:25:40', null, '2017-08-24 07:52:41');
INSERT INTO `lam_petugas` VALUES ('brian1', 'CST000003', 'c4ca4238a0b923820dcc509a6f75849b', 'Mr.|Sata|Lesmana', 'lesmana@lamsolusi.com', 'PT. Customer Thre', '40', '2017-09-26', '1', null, '2017-09-19 11:41:26', null, '2017-09-19 04:41:26');
INSERT INTO `lam_petugas` VALUES ('cust', 'CST000005', '0cc175b9c0f1b6a831c399e269772661', 'Mr.|Okki|Setyawan', 'okkisetyawan@gmail.com', 'PT.OKKI S', '40', '2017-12-05', '1', null, '2017-11-28 10:07:03', null, '2017-11-28 03:07:03');
INSERT INTO `lam_petugas` VALUES ('customer', 'CST000002', 'c4ca4238a0b923820dcc509a6f75849b', 'Mrs.|Yuni|Sulastri', 'lesmana@lamsolusi.com', 'PT. Customer Two', '40', '2017-09-18', '1', null, '2017-09-11 08:38:55', null, '2017-09-11 01:38:55');
INSERT INTO `lam_petugas` VALUES ('dodo', 'CST000003', 'c4ca4238a0b923820dcc509a6f75849b', 'Mr.|dodo|Lesmana', 'jhonny@lamsolusi.com', 'PT. Customer Thre', '40', '2017-09-20', '1', null, '2017-09-13 12:25:33', null, '2017-09-13 05:25:33');
INSERT INTO `lam_petugas` VALUES ('finance', '', 'c4ca4238a0b923820dcc509a6f75849b', 'Mr.|finance|finance', 'finance@mail.com', '', '24', '2017-09-15', '1', null, '2017-09-08 15:37:42', null, '2017-09-08 08:37:42');
INSERT INTO `lam_petugas` VALUES ('forwarder', 'FWD000001', 'c4ca4238a0b923820dcc509a6f75849b', 'Ms.|Amalia|Syakira', null, 'Forwarder one', '50', '2017-08-07', '1', '0', '2017-07-31 08:31:08', '2017-07-04 08:56:48', '2017-08-04 11:15:08');
INSERT INTO `lam_petugas` VALUES ('green', 'FWD000002', 'c4ca4238a0b923820dcc509a6f75849b', 'Mr.|Green|Wildon', null, 'Schenker Indonesia', '50', '2017-08-21', '1', null, '2017-08-14 12:20:27', null, '2017-08-14 05:20:27');
INSERT INTO `lam_petugas` VALUES ('import', '', 'c4ca4238a0b923820dcc509a6f75849b', 'Mr.|Import|tester', 'impor@mail.com', 'null', '22', '2017-12-07', '1', null, '2017-11-30 09:56:51', null, '2017-11-30 02:56:51');
INSERT INTO `lam_petugas` VALUES ('importjames', '', '0cc175b9c0f1b6a831c399e269772661', 'Mr.|James|Sitorus', 'james@lamsolusi.com', '', '22', '2017-12-06', '1', null, '2017-11-29 11:32:24', null, '2017-11-29 04:32:24');
INSERT INTO `lam_petugas` VALUES ('injectorikko', '', 'c83cf90ac76d43233bdaabba4545cd62', 'Mr.|Okki|Setyawan', 'okkisetyawan@gmail.com', '', '10', '2017-12-05', '1', null, '2017-11-28 08:55:31', null, '2017-11-28 01:55:31');
INSERT INTO `lam_petugas` VALUES ('juli', '', 'c4ca4238a0b923820dcc509a6f75849b', 'Mr.|juli|silau', 'jhonny_1904@yahoo.com', '', '20', '2017-09-20', '1', null, '2017-09-13 12:26:17', null, '2017-09-13 05:26:17');
INSERT INTO `lam_petugas` VALUES ('lnm', '', 'c4ca4238a0b923820dcc509a6f75849b', 'Mr.|lnm|lnm', 'jhonny@lamsolusi.com', '', '23', '2017-09-18', '1', null, '2017-09-11 13:19:06', null, '2017-09-11 06:19:06');
INSERT INTO `lam_petugas` VALUES ('receiving', '', '0cc175b9c0f1b6a831c399e269772661', 'Mr.|Okki|Setyawan', 'okkisetyawan@gmail.com', '', '21', '2017-12-05', '1', null, '2017-11-28 10:10:32', null, '2017-11-28 03:10:32');
INSERT INTO `lam_petugas` VALUES ('reciving', '', 'c4ca4238a0b923820dcc509a6f75849b', 'Mr.|recive|tester', null, null, '21', '2017-08-14', '1', null, '2017-08-07 10:10:11', null, '2017-08-10 02:49:07');
INSERT INTO `lam_petugas` VALUES ('sadmin', '', 'c4ca4238a0b923820dcc509a6f75849b', 'Super Admin', null, null, '10', '2017-09-04', '1', '0', '2017-07-04 08:56:46', '2017-07-04 08:56:48', '2017-08-10 02:48:16');
INSERT INTO `lam_petugas` VALUES ('sales', 'SLS000003', 'c4ca4238a0b923820dcc509a6f75849b', 'Ms.|ella|kamela', 'lesmana@lamsolusi.com', 'null', '30', '2017-09-19', '1', null, '2017-09-12 10:43:50', null, '2017-09-12 03:43:50');
INSERT INTO `lam_petugas` VALUES ('sales1', 'SLS000004', 'c4ca4238a0b923820dcc509a6f75849b', 'Mr.|Susilo|Susilo', 'jhonny@lamsolusi.com', 'Pokonya susilo', '30', '2017-09-20', '1', null, '2017-09-13 12:27:20', null, '2017-09-13 05:27:20');
INSERT INTO `lam_petugas` VALUES ('sata', 'SLS000004', 'c4ca4238a0b923820dcc509a6f75849b', 'Mr.|Sata|Lesmana', null, 'Pokonya susilo', '30', '2017-08-04', '1', null, '2017-07-28 15:13:43', null, '2017-07-28 15:13:43');
INSERT INTO `lam_petugas` VALUES ('super', '', 'c4ca4238a0b923820dcc509a6f75849b', 'Mr.|super|admin', null, '', '10', '2017-08-21', '1', null, '2017-08-14 11:24:16', null, '2017-08-14 04:24:16');

-- ----------------------------
-- Table structure for lam_portlist
-- ----------------------------
DROP TABLE IF EXISTS `lam_portlist`;
CREATE TABLE `lam_portlist` (
  `port_id` char(10) NOT NULL,
  `port_country` char(50) DEFAULT NULL,
  `port_name` char(50) DEFAULT NULL,
  PRIMARY KEY (`port_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lam_portlist
-- ----------------------------
INSERT INTO `lam_portlist` VALUES ('CKG', 'Indonesia', 'Cengkareng');
INSERT INTO `lam_portlist` VALUES ('JKT', 'Indonesia', 'GMF');
INSERT INTO `lam_portlist` VALUES ('LAX', 'United States America', 'Port LA');

-- ----------------------------
-- Table structure for lam_sales
-- ----------------------------
DROP TABLE IF EXISTS `lam_sales`;
CREATE TABLE `lam_sales` (
  `id_sales` char(10) NOT NULL,
  `nama_sales` char(50) DEFAULT NULL,
  `phone` char(50) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `country` char(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_sales`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lam_sales
-- ----------------------------
INSERT INTO `lam_sales` VALUES ('SLS000001', 'Jaka Susilo 2', '02137978898788', 'bambang@eskrim.com', 'IDN', 'asdf asdf');
INSERT INTO `lam_sales` VALUES ('SLS000002', 'Pokonya susilo', '0213797889879', 'susilo@eskrim.com', 'IDN', 'asdf asdf');
INSERT INTO `lam_sales` VALUES ('SLS000003', 'Arya Hadinata', '0213797889879', 'bambang@eskrim.com', 'IDN', 'Jl pahlawan');
INSERT INTO `lam_sales` VALUES ('SLS000004', 'Pokonya susilo', '0213797889879', 'bambang@eskrim.com', 'IDN', 'sgfhj');
INSERT INTO `lam_sales` VALUES ('SLS000005', 'Mahmud', '089610595064', 'mahmud@mail.com', 'ID', 'Jl.Waru II');

-- ----------------------------
-- Table structure for lam_salesact
-- ----------------------------
DROP TABLE IF EXISTS `lam_salesact`;
CREATE TABLE `lam_salesact` (
  `actifity_id` char(10) NOT NULL,
  `sales_id` char(10) DEFAULT NULL,
  `customer_id` char(10) DEFAULT NULL,
  `type` char(15) DEFAULT NULL,
  `status` char(1) DEFAULT '1' COMMENT '1=>open, 2, close',
  `remark` text,
  `actifity_start` date DEFAULT NULL,
  `actifity_end` date DEFAULT NULL,
  PRIMARY KEY (`actifity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lam_salesact
-- ----------------------------
INSERT INTO `lam_salesact` VALUES ('ACT000009', 'SLS000003', 'CST000004', 'actifity one', '1', '', '2017-08-09', null);

-- ----------------------------
-- Table structure for lam_salesact_recall
-- ----------------------------
DROP TABLE IF EXISTS `lam_salesact_recall`;
CREATE TABLE `lam_salesact_recall` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actifity_id` char(10) DEFAULT NULL,
  `actifity_date` date DEFAULT NULL,
  `description` text,
  `actifity_time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lam_salesact_recall
-- ----------------------------
INSERT INTO `lam_salesact_recall` VALUES ('4', 'ACT000007', '2017-07-27', 'dgdsgf sdf asdf', '13:54:00');
INSERT INTO `lam_salesact_recall` VALUES ('5', 'ACT000007', '2017-07-27', 'asdf asdf ', '14:16:00');
INSERT INTO `lam_salesact_recall` VALUES ('6', 'ACT000007', '2017-07-27', 'fsadf asdf ', '14:23:00');
INSERT INTO `lam_salesact_recall` VALUES ('7', 'ACT000007', '2017-08-24', 'Sedang meeting dengan Pak Jaelani', '14:22:00');

-- ----------------------------
-- Table structure for lam_session
-- ----------------------------
DROP TABLE IF EXISTS `lam_session`;
CREATE TABLE `lam_session` (
  `id_petugas` varchar(27) NOT NULL DEFAULT '',
  `sessionid` varchar(32) NOT NULL DEFAULT '',
  `user_agent` varchar(200) NOT NULL DEFAULT '',
  `dtimelogin` datetime DEFAULT NULL,
  `dtimelogout` datetime DEFAULT NULL,
  `dtimeexpired` date DEFAULT NULL,
  PRIMARY KEY (`id_petugas`,`sessionid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='login activity';

-- ----------------------------
-- Records of lam_session
-- ----------------------------
INSERT INTO `lam_session` VALUES ('GREENlogistik', 'e5bdd79147f1e1307fd2640918791d87', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36 Edge', '2017-11-09 07:55:32', null, '2017-11-10');

-- ----------------------------
-- Table structure for lam_shipment_item
-- ----------------------------
DROP TABLE IF EXISTS `lam_shipment_item`;
CREATE TABLE `lam_shipment_item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` char(10) NOT NULL,
  `part_number` char(50) DEFAULT NULL,
  `part_desc` text,
  `qty` int(11) NOT NULL DEFAULT '0',
  `uom` char(50) DEFAULT NULL,
  `weight` int(11) NOT NULL DEFAULT '0',
  `dimensi` char(50) DEFAULT NULL,
  `ponumber` varchar(50) DEFAULT NULL,
  `remaark` varchar(90) DEFAULT NULL,
  `acregis` text,
  `paymentres` text,
  `value_of_goods` text,
  `curency` text,
  `packaging` text,
  `goods_category` varchar(45) DEFAULT NULL,
  `material_type` text,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lam_shipment_item
-- ----------------------------
INSERT INTO `lam_shipment_item` VALUES ('1', 'REQ000001', 'PART A', 'OIL', '100', 'L', '10', null, null, null, 'PK-GGG', 'Dodo', '1000', 'USD', '', 'Non DG', null);
INSERT INTO `lam_shipment_item` VALUES ('2', 'REQ000002', 'PN1234567', 'Obeng Kupu2', '25', 'KG', '45', '30x30x25', 'AIB-11CD', null, 'PK-AJO', 'EMPRIT AIR', '5000', 'USD', 'Carton', 'Non DG', null);
INSERT INTO `lam_shipment_item` VALUES ('3', 'REQ000004', 'PN-BAD123', 'Corrosion Liquid', '10', 'KAN', '50', '220x100x60', '430001', null, 'AX-ISZ', 'Mudjijaya Air', '6600', 'USD', 'Wooden Box', 'DG', null);
INSERT INTO `lam_shipment_item` VALUES ('4', 'REQ000005', 'PN-APOSE777', 'CARPET', '18', 'ROL', '0', null, null, '400x30x30', null, null, null, null, null, null, null);
INSERT INTO `lam_shipment_item` VALUES ('5', 'REQ000006', 'ESN12345', 'ENGINE AIRCRAFT', '1', 'KG', '10000', '543x292x298', 'E733665-01', null, 'AB-CDE', 'Umbul-Umbul Air', '5000000', 'USD', 'Loose', 'Non DG', null);
INSERT INTO `lam_shipment_item` VALUES ('8', 'REQ000008', '1234GHD', 'Sample Description', '0', 'KG', '0', '', '', '', '', '', '', '', '', 'Non DG', null);
INSERT INTO `lam_shipment_item` VALUES ('9', 'REQ000007', 'tester', 'tester', '0', 'KG', '0', '', '', '', '', '', '', '', '', 'Non DG', null);
INSERT INTO `lam_shipment_item` VALUES ('10', 'REQ000009', 'ANU-0000111', 'Sempol Knalpot', '15', 'KG', '40', '60x10x15', '54000333', '', 'PK-ANU', 'TM', '5500', 'USD', 'Carton', 'Non DG', null);
INSERT INTO `lam_shipment_item` VALUES ('11', 'REQ000010', 'PN-9999-1111', 'Gayung Metalic', '5', 'KG', '25', '30x30x30', '43000777', 'Repair', 'PK-HAH', 'TN', '15000', 'USD', 'Wooden Box', 'Non DG', null);
INSERT INTO `lam_shipment_item` VALUES ('12', 'REQ000011', 'PART A', 'OIL', '1', 'L', '10', '1x2x3', '', '', 'PK-GIA', 'TB', '1000', 'USD', '', 'Non DG', null);
INSERT INTO `lam_shipment_item` VALUES ('13', 'REQ000012', 'PART A', 'OIL', '1', 'KG', '0', '', '', '', '', '', '', '', '', 'Non DG', null);
INSERT INTO `lam_shipment_item` VALUES ('14', 'REQ000013', 'PART A', 'BAN', '1', 'KG', '0', '', '', '', '', '', '', '', '', 'Non DG', null);
INSERT INTO `lam_shipment_item` VALUES ('15', 'REQ000014', 'PART A', 'PART ASSY', '1', 'EA', '10', '1x2x3', '', '', 'PK-GIA', 'TB', '100', 'USD', 'Carton', 'Non DG', null);
INSERT INTO `lam_shipment_item` VALUES ('16', 'REQ000016', 'PN5678', 'Baut', '20', 'KG', '1', '1x1x1', '45000', '', 'PK-AAA', 'KALSTAR', '1500', 'USD', 'Carton', 'Non DG', null);
INSERT INTO `lam_shipment_item` VALUES ('17', 'REQ000017', 'Jaliabcd1234', 'Jali bewok', '1', 'EA', '98', '180X60X89', '540000123', '', 'PK-JAL', 'Jali', '1', 'USD', 'Loose', 'Non DG', null);
INSERT INTO `lam_shipment_item` VALUES ('18', 'REQ000017', 'Jaliefg567', 'Jali CSSM', '1', 'A93', '98', '180X60X89', '54000456', '', 'PK-JAL', 'Jali', '1', 'USD', 'Wooden Box', 'Non DG', null);
INSERT INTO `lam_shipment_item` VALUES ('19', 'REQ000018', 'Jali789ghi', 'Jali Gimbal', '1', 'KG', '89', '180X60X89', '54000789', '', 'PK-JAL', 'Jali', '1', 'usd', 'Carton', 'DG', null);
INSERT INTO `lam_shipment_item` VALUES ('20', 'REQ000019', 'Agus1234', 'Agustari rendi', '1', 'KG', '0', '1X1x1', '540000897', '', 'PK-AGS', 'Agus', '1', 'usd', '', 'Non DG', null);
INSERT INTO `lam_shipment_item` VALUES ('24', 'REQ000020', 'BK001', 'Mesin Diesel 4 Inline', '1', 'KG', '190', '90', 'PO009', '', 'Registered', 'OK', '55000000', 'Rp', 'Wooden Box', 'Non DG', null);
INSERT INTO `lam_shipment_item` VALUES ('25', 'REQ000020', 'BK002', 'Turbo HKS 40Psi', '1', 'KG', '10', '90-100-80', 'PO008', '', 'Registered', 'OK', '15000000', 'Rp', 'Others ', 'Non DG', null);

-- ----------------------------
-- Table structure for lam_shipment_maintenance
-- ----------------------------
DROP TABLE IF EXISTS `lam_shipment_maintenance`;
CREATE TABLE `lam_shipment_maintenance` (
  `awb` varchar(50) NOT NULL,
  `forwarder_id` char(10) DEFAULT NULL,
  `reference` tinytext,
  `eta_date` date DEFAULT NULL,
  `etd_date` date DEFAULT NULL,
  `estimate_flight_schadule` varchar(50) DEFAULT NULL,
  `ata_date` date DEFAULT NULL,
  `atd_date` date DEFAULT NULL,
  `flight_schadule` varchar(50) DEFAULT NULL,
  `port_origin` char(50) DEFAULT NULL,
  `port_dest` char(50) DEFAULT NULL,
  `awb_status` char(50) DEFAULT 'Open',
  `bc_no` varchar(50) DEFAULT NULL COMMENT 'BC16',
  `bc_date` date DEFAULT NULL COMMENT 'BC16',
  `sp_cek` char(1) DEFAULT '0' COMMENT '0/1',
  `sp_id` char(10) DEFAULT NULL,
  `reason` text,
  `kilo_colli` int(11) DEFAULT NULL,
  PRIMARY KEY (`awb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lam_shipment_maintenance
-- ----------------------------
INSERT INTO `lam_shipment_maintenance` VALUES ('074-55554444', 'FWD000002', 'REQ000001', '2017-09-21', '2017-09-19', 'KL809/ 22 Sept', '2017-09-21', '2017-09-19', 'KL809/ 22 Sept', 'JKT', 'LAX', 'Clear', 'bc333', '2017-09-20', '1', 'SPO000002', null, null);
INSERT INTO `lam_shipment_maintenance` VALUES ('126-12341234', 'FWD000002', 'REQ000018', '2017-11-09', '2017-11-09', 'GA-839', '2017-11-10', '2017-11-10', 'GA-839', 'LAX', 'JKT', 'Clear', '12456', '2017-11-10', '1', 'SPO000007', 'duit ga ada', null);
INSERT INTO `lam_shipment_maintenance` VALUES ('126-12345678', 'FWD000002', 'REQ000009,REQ000003', '2017-09-26', '2017-09-26', 'GA001', '2017-09-26', '2017-09-26', 'GA001', 'LAX', 'JKT', 'Clear', 'BC16-9999', '2017-09-26', '1', 'SPO000003', null, null);
INSERT INTO `lam_shipment_maintenance` VALUES ('126-45633543', 'FWD000001', 'REQ000017', '2017-11-09', '2017-11-09', 'GA-839', '2017-11-11', '2017-11-11', 'GA-839', 'LAX', 'JKT', 'Clear', '123457', '2017-11-10', '1', 'SPO000007', 'duit ga ada', null);
INSERT INTO `lam_shipment_maintenance` VALUES ('126-88887777', 'FWD000001', 'REQ000019', '2017-11-09', '2017-11-09', 'GA-839', '2017-11-10', '2017-11-10', 'GA-839', 'LAX', 'JKT', 'Open', null, null, '0', null, null, null);
INSERT INTO `lam_shipment_maintenance` VALUES ('160-12345678', 'FWD000002', 'REQ000002', '2017-09-22', '2017-09-19', 'CX5651/20 Sept', '2017-09-22', '2017-09-19', 'CX5651/20 Sept', 'LAX', 'JKT', 'Clear', 'BC777', '2017-09-20', '1', 'SPO000003', null, null);
INSERT INTO `lam_shipment_maintenance` VALUES ('180-12345678', 'FWD000002', 'REQ000010', '2017-09-26', '2017-09-26', '', '2017-09-26', '2017-09-26', '', 'JKT', 'LAX', 'Open', null, null, '0', null, null, null);
INSERT INTO `lam_shipment_maintenance` VALUES ('235-99996666', 'FWD000001', 'REQ000004', '2017-09-22', '2017-09-19', 'TK088/21 Sept', '2017-09-22', '2017-09-19', 'TK088/21 Sept', 'JKT', 'LAX', 'Open', null, null, '0', null, null, null);
INSERT INTO `lam_shipment_maintenance` VALUES ('5678', 'FWD000002', 'REQ000014', '2017-09-30', '2017-09-28', 'SQ-QYZ', '2017-09-30', '2017-09-28', 'SQ-QYZ', 'LAX', 'JKT', 'Clear', 'b1234', '2017-09-30', '1', 'SPO000006', null, null);
INSERT INTO `lam_shipment_maintenance` VALUES ('8877', 'FWD000002', 'REQ000011', '2017-09-27', '2017-09-27', '', '2017-09-27', '2017-09-27', 'PK-GIA', 'LAX', 'JKT', 'Clear', '1234', '2017-09-27', '1', 'SPO000004', null, null);
INSERT INTO `lam_shipment_maintenance` VALUES ('9999', 'FWD000001', 'REQ000013', '2017-09-27', '2017-09-27', 'PK-123', '2017-09-27', '2017-09-27', 'PK-BBB', 'JKT', 'LAX', 'Clear', '7766', '2017-09-27', '1', 'SPO000005', null, null);

-- ----------------------------
-- Table structure for lam_shipment_maintenance_item
-- ----------------------------
DROP TABLE IF EXISTS `lam_shipment_maintenance_item`;
CREATE TABLE `lam_shipment_maintenance_item` (
  `item_id` char(50) NOT NULL,
  `awb` char(50) NOT NULL,
  `request_id` char(10) NOT NULL,
  `part_number` char(50) DEFAULT NULL,
  `part_desc` text,
  `qty` int(11) NOT NULL DEFAULT '0',
  `weight` int(11) NOT NULL DEFAULT '0',
  `uom` char(50) DEFAULT NULL,
  `dimensi` char(50) DEFAULT NULL,
  PRIMARY KEY (`item_id`,`awb`,`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lam_shipment_maintenance_item
-- ----------------------------
INSERT INTO `lam_shipment_maintenance_item` VALUES ('1', '074-55554444', 'REQ000001', 'PART A', 'OIL', '100', '10', 'L', 'null');
INSERT INTO `lam_shipment_maintenance_item` VALUES ('10', '126-12345678', 'REQ000009', 'ANU-0000111', 'Sempol Knalpot', '15', '40', 'KG', '60x10x15');
INSERT INTO `lam_shipment_maintenance_item` VALUES ('11', '180-12345678', 'REQ000010', 'PN-9999-1111', 'Gayung Metalic', '5', '25', 'KG', '30x30x30');
INSERT INTO `lam_shipment_maintenance_item` VALUES ('12', '8877', 'REQ000011', 'PART A', 'OIL', '1', '10', 'L', '1x2x3');
INSERT INTO `lam_shipment_maintenance_item` VALUES ('14', '9999', 'REQ000013', 'PART A', 'BAN', '1', '0', 'KG', '');
INSERT INTO `lam_shipment_maintenance_item` VALUES ('15', '5678', 'REQ000014', 'PART A', 'PART ASSY', '1', '10', 'EA', '1x2x3');
INSERT INTO `lam_shipment_maintenance_item` VALUES ('17', '126-45633543', 'REQ000017', 'Jaliabcd1234', 'Jali bewok', '1', '98', 'EA', '180X60X89');
INSERT INTO `lam_shipment_maintenance_item` VALUES ('18', '126-45633543', 'REQ000017', 'Jaliefg567', 'Jali CSSM', '1', '98', 'A93', '180X60X89');
INSERT INTO `lam_shipment_maintenance_item` VALUES ('19', '126-12341234', 'REQ000018', 'Jali789ghi', 'Jali Gimbal', '1', '89', 'KG', '180X60X89');
INSERT INTO `lam_shipment_maintenance_item` VALUES ('2', '160-12345678', 'REQ000002', 'PN1234567', 'Obeng Kupu2', '25', '45', 'KG', '30x30x25');
INSERT INTO `lam_shipment_maintenance_item` VALUES ('20', '126-88887777', 'REQ000019', 'Agus1234', 'Agustari rendi', '1', '0', 'KG', '1X1x1');
INSERT INTO `lam_shipment_maintenance_item` VALUES ('3', '235-99996666', 'REQ000004', 'PN-BAD123', 'Corrosion Liquid', '10', '50', 'KAN', '220x100x60');

-- ----------------------------
-- Table structure for lam_shipment_request
-- ----------------------------
DROP TABLE IF EXISTS `lam_shipment_request`;
CREATE TABLE `lam_shipment_request` (
  `request_id` char(10) NOT NULL,
  `customer_id` char(10) DEFAULT NULL,
  `partner_id` char(10) DEFAULT NULL,
  `sales_id` char(10) DEFAULT NULL,
  `forwarder_id` char(10) DEFAULT NULL,
  `petugas_id` char(10) DEFAULT NULL,
  `request_type` enum('IMPORT','EXPORT','DOMESTIC DISTRIBUTION','WAREHOUSE LEASE','CUSTOM CLEARANCE','PACKAGING','INTERNAL DISTRIBUTION') DEFAULT NULL,
  `port_origin` char(10) DEFAULT NULL,
  `port_dest` char(10) DEFAULT NULL,
  `inco_term` char(5) DEFAULT NULL,
  `cpo` char(50) DEFAULT NULL,
  `shipment_mode` char(15) DEFAULT NULL,
  `special_request` varchar(50) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `shp_priority` varchar(45) DEFAULT NULL,
  `awb` varchar(50) DEFAULT NULL,
  `ata` varchar(45) DEFAULT NULL,
  `awb_file` text,
  `weight` int(11) DEFAULT NULL,
  `asigmen_date` date DEFAULT NULL,
  `approve_date` date DEFAULT NULL,
  `status` varchar(1) DEFAULT '1' COMMENT '1=>open, 2=>cost assigned, 3=>reject by customer, 4=>approve price by customer, 5=>reject by GMF',
  `req_desc` text,
  `pbth` varchar(45) DEFAULT NULL,
  `service_charges` int(11) DEFAULT NULL,
  `freight_charges` int(11) DEFAULT NULL,
  `transport_charges` int(11) DEFAULT NULL,
  `dg_charges` int(11) DEFAULT NULL,
  `cgx_charges` int(11) DEFAULT NULL,
  `curency_carges` int(11) DEFAULT NULL,
  `cgk_charges` int(11) DEFAULT NULL,
  `origin_charges` int(11) DEFAULT NULL,
  `destination_charges` int(11) DEFAULT NULL,
  `warehouse_charge` int(11) DEFAULT NULL,
  `packaging_charge` int(11) DEFAULT NULL,
  `fumigation_charge` int(11) DEFAULT NULL,
  `duty_charges` int(11) DEFAULT NULL,
  `allin_charges` int(11) DEFAULT NULL,
  `curency` char(50) DEFAULT NULL,
  `user_notes` text,
  `eid` date DEFAULT NULL,
  `eod` date DEFAULT NULL,
  `shp_from` varchar(45) DEFAULT NULL,
  `shp_to` varchar(45) DEFAULT NULL,
  `payment_res` varchar(45) DEFAULT NULL,
  `exsec_date` varchar(45) CHARACTER SET dec8 DEFAULT NULL,
  `copa` int(11) DEFAULT NULL,
  `copa_lock` enum('no','yes') DEFAULT 'no',
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lam_shipment_request
-- ----------------------------
INSERT INTO `lam_shipment_request` VALUES ('REQ000001', 'CST000003', 'PTR000002', null, 'FWD000002', 'brian1', 'IMPORT', 'JKT', 'LAX', 'CFR', '', 'Air', '', '2017-09-19', 'Normal', null, null, null, '0', null, null, '7', null, 'Yes', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'IDR', null, null, null, null, null, null, null, '0', 'no');
INSERT INTO `lam_shipment_request` VALUES ('REQ000002', 'CST000004', 'PTR000002', null, 'FWD000002', 'brian', 'IMPORT', 'LAX', 'JKT', 'CIF', 'INV123', 'Air', 'Deadline of arrival 30 Sept', '2017-09-19', 'Normal', null, null, null, '0', null, null, '7', null, 'No', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', 'no');
INSERT INTO `lam_shipment_request` VALUES ('REQ000003', 'CST000004', 'PTR000002', 'SLS000003', 'FWD000002', 'brian', 'IMPORT', 'LAX', 'JKT', 'CIF', 'INV123', 'Air', 'Deadline of arrival 30 Sept', '2017-09-19', 'Normal', null, null, null, '0', '2017-09-19', '2017-09-19', '7', null, 'No', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '10500', '0', '', null, null, null, null, null, null, '0', 'no');
INSERT INTO `lam_shipment_request` VALUES ('REQ000004', 'CST000004', 'PTR000001', 'SLS000003', 'FWD000001', 'brian', 'EXPORT', 'JKT', 'LAX', 'CIF', 'GMF/INV/111', 'Air', 'Should be arrived USA at Oct 1st', '2017-09-19', null, null, null, null, '0', '2017-09-19', '2017-09-19', '7', null, 'No', '0', '1500', '0', '1000', '0', '0', '500', '0', '700', '30', '0', '0', '0', '0', 'USD', '', null, null, null, null, null, null, '90', 'no');
INSERT INTO `lam_shipment_request` VALUES ('REQ000005', 'CST000004', null, 'SLS000003', null, 'brian', 'WAREHOUSE LEASE', null, null, null, null, null, null, '2017-09-19', null, null, null, null, null, '2017-09-19', '2017-09-19', '4', 'Carpet Pesawat ', 'No', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '700', 'USD', '', '2017-09-24', '2017-10-05', null, null, null, null, '0', 'no');
INSERT INTO `lam_shipment_request` VALUES ('REQ000006', 'CST000004', null, 'SLS000003', null, 'brian', 'CUSTOM CLEARANCE', null, null, null, null, null, null, '2017-09-19', null, '297-66841596', '2017-09-22', '|297-66841596.pdf', null, '2017-09-19', '2017-09-19', '4', 'Mohon diposisikan di hangar 3 line 27', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1400000', 'IDR', 'Mohon dipastikan sesuai dengan jadwal', null, null, null, null, null, null, '0', 'no');
INSERT INTO `lam_shipment_request` VALUES ('REQ000007', 'CST000002', 'PTR000001', 'SLS000003', null, 'customer', 'IMPORT', 'JKT', 'LAX', 'CFR', 'tes ter', 'Air', 'tester', '2017-09-19', 'AOG', null, null, null, '0', '2017-09-19', null, '2', null, 'No', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '5000', 'EUR', null, null, null, null, null, null, null, null, 'no');
INSERT INTO `lam_shipment_request` VALUES ('REQ000008', 'CST000002', null, 'SLS000003', null, 'customer', 'CUSTOM CLEARANCE', null, null, null, null, null, null, '2017-09-19', null, '123456', '2017-09-19', '|Print.pdf|Print1.pdf', null, '2017-09-19', null, '2', 'This is more detail description about sample request', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '700', 'USD', null, null, null, null, null, null, null, null, 'no');
INSERT INTO `lam_shipment_request` VALUES ('REQ000009', 'CST000004', 'PTR000003', 'SLS000003', 'FWD000002', 'brian', 'IMPORT', 'LAX', 'JKT', 'CIF', 'BOE555777', 'Air', 'Deadline of arrival Oct,4th', '2017-09-26', 'AOG', null, null, null, '0', '2017-09-26', '2017-09-26', '7', null, 'No', '0', '1500', '0', '0', '0', '0', '200', '350', '0', '150', '0', '0', '0', '0', 'USD', '', null, null, null, null, null, null, '0', 'no');
INSERT INTO `lam_shipment_request` VALUES ('REQ000010', 'CST000004', 'PTR000002', 'SLS000003', 'FWD000002', 'brian', 'EXPORT', 'JKT', 'LAX', 'CIF', 'GMF/INV/XXI', 'Air', 'None', '2017-09-26', null, null, null, null, '0', '2017-09-26', '2017-09-26', '7', null, 'No', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '11000', 'USD', '', null, null, null, null, null, null, '0', 'no');
INSERT INTO `lam_shipment_request` VALUES ('REQ000011', 'CST000003', 'PTR000002', 'SLS000003', 'FWD000002', 'brian1', 'IMPORT', 'LAX', 'JKT', 'CFR', '', 'Air', '', '2017-09-27', 'Normal', null, null, null, '0', '2017-09-27', '2017-09-27', '7', null, 'No', '0', '10000000', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '200000000', 'IDR', 'OK. APPROVED', null, null, null, null, null, null, '500000', 'yes');
INSERT INTO `lam_shipment_request` VALUES ('REQ000012', 'CST000003', null, 'SLS000004', null, 'brian1', 'CUSTOM CLEARANCE', null, null, null, null, null, null, '2017-09-27', null, '7766', '2017-09-27', '|PO_GMF6.pdf', null, '2017-09-27', '2017-09-27', '4', '', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '200000', 'IDR', '', null, null, null, null, null, null, '10000', 'yes');
INSERT INTO `lam_shipment_request` VALUES ('REQ000013', 'CST000003', 'PTR000002', 'SLS000004', 'FWD000001', 'brian1', 'IMPORT', 'JKT', 'LAX', 'CFR', '', 'Air', '', '2017-09-27', 'Normal', null, null, null, '0', '2017-09-27', '2017-09-27', '7', null, 'No', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '20000000', 'IDR', '', null, null, null, null, null, null, '0', 'no');
INSERT INTO `lam_shipment_request` VALUES ('REQ000014', 'CST000003', 'PTR000002', 'SLS000003', 'FWD000002', 'brian1', 'IMPORT', 'LAX', 'JKT', 'CFR', 'REF PO : 450000001', 'Air', '', '2017-09-28', 'Normal', null, null, null, '0', '2017-09-28', '2017-09-28', '7', null, 'No', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '200000000', 'IDR', 'OK', null, null, null, null, null, null, null, 'yes');
INSERT INTO `lam_shipment_request` VALUES ('REQ000015', 'CST000002', null, null, null, 'customer', 'INTERNAL DISTRIBUTION', null, null, null, null, null, null, '2017-10-12', null, null, null, null, null, null, null, '1', 'dddd', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'sdf', 'asdf', 'asdf', '2017-10-12', null, 'no');
INSERT INTO `lam_shipment_request` VALUES ('REQ000016', 'CST000004', 'PTR000002', 'SLS000003', null, 'brian', 'IMPORT', 'LAX', 'JKT', 'CIF', 'INV1234', 'Air', 'jangan lama2', '2017-11-07', 'AOG', null, null, null, '0', '2017-11-07', '2017-11-07', '3', null, 'No', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'USD', 'Target price kita 100 doang', null, null, null, null, null, null, null, 'no');
INSERT INTO `lam_shipment_request` VALUES ('REQ000017', 'CST000004', 'PTR000002', 'SLS000004', 'FWD000001', 'brian', 'IMPORT', 'LAX', 'JKT', 'CIF', 'INV.JALI1', 'Air', 'DI lamain ya', '2017-11-09', 'AOG', null, null, null, '0', '2017-11-09', '2017-11-09', '7', null, 'No', '0', '600', '0', '0', '0', '0', '0', '25', '0', '75', '0', '0', '0', '0', 'USD', 'Ok coi', null, null, null, null, null, null, '0', 'no');
INSERT INTO `lam_shipment_request` VALUES ('REQ000018', 'CST000004', 'PTR000002', 'SLS000003', 'FWD000002', 'brian', 'IMPORT', 'LAX', 'JKT', 'CIF', 'INV.JALI2', 'Air', 'Lamain aja sampe barang masuk TPS', '2017-11-09', 'AOG', null, null, null, '0', '2017-11-09', '2017-11-09', '7', null, 'No', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2000', 'USD', 'Murah banget', null, null, null, null, null, null, '0', 'no');
INSERT INTO `lam_shipment_request` VALUES ('REQ000019', 'CST000004', 'PTR000003', 'SLS000003', 'FWD000001', 'brian', 'IMPORT', 'LAX', 'JKT', 'CIF', 'Rendi Agustari', 'Air', 'Please ga usah di proses sampe sewa gudang gede', '2017-11-09', 'Normal', null, null, null, '0', '2017-11-09', '2017-11-09', '7', null, 'No', '0', '8000', '0', '0', '0', '0', '0', '80', '0', '80', '0', '0', '0', '0', 'USD', '', null, null, null, null, null, null, '0', 'no');
INSERT INTO `lam_shipment_request` VALUES ('REQ000020', 'CST000005', 'PTR000004', null, null, 'cust', 'IMPORT', 'CKG', 'LAX', 'CIP', 'R', 'Air', 'MR.GC', '2017-11-28', 'Normal', null, null, null, '0', null, null, '4', null, 'Yes', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 'IDR', null, null, null, null, null, null, null, null, 'no');

-- ----------------------------
-- Table structure for lam_shipment_sp
-- ----------------------------
DROP TABLE IF EXISTS `lam_shipment_sp`;
CREATE TABLE `lam_shipment_sp` (
  `sp_id` char(10) NOT NULL,
  `date` date DEFAULT NULL,
  `status` char(50) DEFAULT '1' COMMENT '1=>open',
  `periode_ata` varchar(50) DEFAULT NULL,
  `delivery_to` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lam_shipment_sp
-- ----------------------------
INSERT INTO `lam_shipment_sp` VALUES ('SPO000001', '2017-09-20', '1', '', '');
INSERT INTO `lam_shipment_sp` VALUES ('SPO000002', '2017-09-20', '2', '2017-09-22', 'RIC');
INSERT INTO `lam_shipment_sp` VALUES ('SPO000003', '2017-09-26', '2', '2017-09-26', 'TGL');
INSERT INTO `lam_shipment_sp` VALUES ('SPO000004', '2017-09-27', '2', '', 'JAKARTA');
INSERT INTO `lam_shipment_sp` VALUES ('SPO000005', '2017-09-27', '2', '123', 'HONGKONG');
INSERT INTO `lam_shipment_sp` VALUES ('SPO000006', '2017-09-28', '2', '', 'Gudang GADC');
INSERT INTO `lam_shipment_sp` VALUES ('SPO000007', '2017-11-11', '2', '', 'TGL2');

-- ----------------------------
-- Table structure for lam_uom
-- ----------------------------
DROP TABLE IF EXISTS `lam_uom`;
CREATE TABLE `lam_uom` (
  `uom` varchar(50) NOT NULL,
  `uom_desc` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`uom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lam_uom
-- ----------------------------
INSERT INTO `lam_uom` VALUES ('%', 'Percentage');
INSERT INTO `lam_uom` VALUES ('%O', 'Per mille');
INSERT INTO `lam_uom` VALUES ('1', 'One');
INSERT INTO `lam_uom` VALUES ('10', 'Days');
INSERT INTO `lam_uom` VALUES ('22S', 'Square millimeter/second');
INSERT INTO `lam_uom` VALUES ('2M', 'Centimeter/second');
INSERT INTO `lam_uom` VALUES ('2X', 'Meter/Minute');
INSERT INTO `lam_uom` VALUES ('4G', 'Microliter');
INSERT INTO `lam_uom` VALUES ('4O', 'Microfarad');
INSERT INTO `lam_uom` VALUES ('4T', 'Pikofarad');
INSERT INTO `lam_uom` VALUES ('A', 'Ampere');
INSERT INTO `lam_uom` VALUES ('A87', 'Gigaohm');
INSERT INTO `lam_uom` VALUES ('A93', 'Gram/Cubic meter');
INSERT INTO `lam_uom` VALUES ('ACR', 'Acre');
INSERT INTO `lam_uom` VALUES ('B34', 'Kilogram/cubic decimeter');
INSERT INTO `lam_uom` VALUES ('B45', 'Kilomol');
INSERT INTO `lam_uom` VALUES ('B47', 'Kilonewton');
INSERT INTO `lam_uom` VALUES ('B73', 'Meganewton');
INSERT INTO `lam_uom` VALUES ('B75', 'Megohm');
INSERT INTO `lam_uom` VALUES ('B78', 'Megavolt');
INSERT INTO `lam_uom` VALUES ('B84', 'Microampere');
INSERT INTO `lam_uom` VALUES ('BAG', 'Bag');
INSERT INTO `lam_uom` VALUES ('BAR', 'bar');
INSERT INTO `lam_uom` VALUES ('BLD', 'Brake Landings');
INSERT INTO `lam_uom` VALUES ('BOT', 'Bottle');
INSERT INTO `lam_uom` VALUES ('BOX', 'BOX');
INSERT INTO `lam_uom` VALUES ('BQK', 'Becquerel/kilogram');
INSERT INTO `lam_uom` VALUES ('C10', 'Millifarad');
INSERT INTO `lam_uom` VALUES ('C36', 'Mol per cubic meter');
INSERT INTO `lam_uom` VALUES ('C38', 'Mol per liter');
INSERT INTO `lam_uom` VALUES ('C39', 'Nanoampere');
INSERT INTO `lam_uom` VALUES ('C3S', 'Cubic centimeter/second');
INSERT INTO `lam_uom` VALUES ('C41', 'Nanofarad');
INSERT INTO `lam_uom` VALUES ('C56', 'Newton/Square millimeter');
INSERT INTO `lam_uom` VALUES ('CCM', 'Cubic centimeter');
INSERT INTO `lam_uom` VALUES ('CD', 'Candela');
INSERT INTO `lam_uom` VALUES ('CDM', 'Cubic decimeter');
INSERT INTO `lam_uom` VALUES ('CM', 'Centimeter');
INSERT INTO `lam_uom` VALUES ('CM2', 'Square centimeter');
INSERT INTO `lam_uom` VALUES ('CMH', 'Centimeter/hour');
INSERT INTO `lam_uom` VALUES ('CS', 'Case');
INSERT INTO `lam_uom` VALUES ('CTL', 'Centiliter');
INSERT INTO `lam_uom` VALUES ('CYC', 'CYCLES');
INSERT INTO `lam_uom` VALUES ('D10', 'Siemens per meter');
INSERT INTO `lam_uom` VALUES ('D41', 'Ton/Cubic meter');
INSERT INTO `lam_uom` VALUES ('D46', 'Voltampere');
INSERT INTO `lam_uom` VALUES ('DB', 'Decibel');
INSERT INTO `lam_uom` VALUES ('DEG', 'Degree');
INSERT INTO `lam_uom` VALUES ('DM', 'Decimeter');
INSERT INTO `lam_uom` VALUES ('DR', 'Drum');
INSERT INTO `lam_uom` VALUES ('DZ', 'Dozen');
INSERT INTO `lam_uom` VALUES ('EA', 'each');
INSERT INTO `lam_uom` VALUES ('EE', 'Enzyme Units');
INSERT INTO `lam_uom` VALUES ('EML', 'Enzyme Units / Milliliter');
INSERT INTO `lam_uom` VALUES ('F', 'Farad');
INSERT INTO `lam_uom` VALUES ('FA', 'Fahrenheit');
INSERT INTO `lam_uom` VALUES ('FT', 'Foot');
INSERT INTO `lam_uom` VALUES ('FT2', 'Square foot');
INSERT INTO `lam_uom` VALUES ('FT3', 'Cubic foot');
INSERT INTO `lam_uom` VALUES ('G', 'Gram');
INSERT INTO `lam_uom` VALUES ('G/L', 'gram act.ingrd / liter');
INSERT INTO `lam_uom` VALUES ('GAU', 'Gram Gold');
INSERT INTO `lam_uom` VALUES ('GC', 'Degrees Celsius');
INSERT INTO `lam_uom` VALUES ('GHG', 'Gram/hectogram');
INSERT INTO `lam_uom` VALUES ('GJ', 'Gigajoule');
INSERT INTO `lam_uom` VALUES ('GKG', 'Gram/kilogram');
INSERT INTO `lam_uom` VALUES ('GLI', 'Gram/liter');
INSERT INTO `lam_uom` VALUES ('GLL', 'US gallon');
INSERT INTO `lam_uom` VALUES ('GLM', 'Gallons per mile (US)');
INSERT INTO `lam_uom` VALUES ('GM', 'Gram/Mol');
INSERT INTO `lam_uom` VALUES ('GM2', 'Gram/square meter');
INSERT INTO `lam_uom` VALUES ('GPH', 'Gallons per hour (US)');
INSERT INTO `lam_uom` VALUES ('GQ', 'Microgram/cubic meter');
INSERT INTO `lam_uom` VALUES ('GRO', 'Gross');
INSERT INTO `lam_uom` VALUES ('GW', 'Gram act. ingrd.');
INSERT INTO `lam_uom` VALUES ('H', 'Hour');
INSERT INTO `lam_uom` VALUES ('HAR', 'Hectare');
INSERT INTO `lam_uom` VALUES ('HL', 'Hectoliter');
INSERT INTO `lam_uom` VALUES ('HPA', 'Hectopascal');
INSERT INTO `lam_uom` VALUES ('HRS', 'Hours');
INSERT INTO `lam_uom` VALUES ('HZ', 'Hertz (1/second)');
INSERT INTO `lam_uom` VALUES ('IN2', 'Cubic inch');
INSERT INTO `lam_uom` VALUES ('J', 'Joule');
INSERT INTO `lam_uom` VALUES ('JHR', 'Years');
INSERT INTO `lam_uom` VALUES ('JKG', 'Joule/Kilogram');
INSERT INTO `lam_uom` VALUES ('JKK', 'Spec. Heat Capacity');
INSERT INTO `lam_uom` VALUES ('JMO', 'Joule/Mol');
INSERT INTO `lam_uom` VALUES ('K', 'Kelvin');
INSERT INTO `lam_uom` VALUES ('KA', 'Kiloampere');
INSERT INTO `lam_uom` VALUES ('KAN', 'Canister');
INSERT INTO `lam_uom` VALUES ('KAR', 'Carton');
INSERT INTO `lam_uom` VALUES ('KBK', 'Kilobecquerel/kilogram');
INSERT INTO `lam_uom` VALUES ('KG', 'Kilogram');
INSERT INTO `lam_uom` VALUES ('KGF', 'Kilogram/Square meter');
INSERT INTO `lam_uom` VALUES ('KGK', 'Kilogram/Kilogram');
INSERT INTO `lam_uom` VALUES ('KGM', 'Kilogram/Mol');
INSERT INTO `lam_uom` VALUES ('KGS', 'Kilogram/second');
INSERT INTO `lam_uom` VALUES ('KGV', 'Kilogram/cubic meter');
INSERT INTO `lam_uom` VALUES ('KGW', 'Kilogram act. ingrd.');
INSERT INTO `lam_uom` VALUES ('KHZ', 'Kilohertz');
INSERT INTO `lam_uom` VALUES ('KI', 'Crate');
INSERT INTO `lam_uom` VALUES ('KIT', 'KIT');
INSERT INTO `lam_uom` VALUES ('KJ', 'Kilojoule');
INSERT INTO `lam_uom` VALUES ('KJK', 'Kilojoule/kilogram');
INSERT INTO `lam_uom` VALUES ('KJM', 'Kilojoule/Mol');
INSERT INTO `lam_uom` VALUES ('KM', 'Kilometer');
INSERT INTO `lam_uom` VALUES ('KM2', 'Square kilometer');
INSERT INTO `lam_uom` VALUES ('KMH', 'Kilometer/hour');
INSERT INTO `lam_uom` VALUES ('KMK', 'Cubic meter/Cubic meter');
INSERT INTO `lam_uom` VALUES ('KMN', 'Kelvin/Minute');
INSERT INTO `lam_uom` VALUES ('KMS', 'Kelvin/Second');
INSERT INTO `lam_uom` VALUES ('KOH', 'Kiloohm');
INSERT INTO `lam_uom` VALUES ('KPA', 'Kilopascal');
INSERT INTO `lam_uom` VALUES ('KT', 'Kilotonne');
INSERT INTO `lam_uom` VALUES ('KV', 'Kilovolt');
INSERT INTO `lam_uom` VALUES ('KVA', 'Kilovoltampere');
INSERT INTO `lam_uom` VALUES ('KW', 'Kilowatt');
INSERT INTO `lam_uom` VALUES ('KWH', 'Kilowatt hours');
INSERT INTO `lam_uom` VALUES ('KWK', 'kg act.ingrd. / kg');
INSERT INTO `lam_uom` VALUES ('L', 'Liter');
INSERT INTO `lam_uom` VALUES ('L2', 'Liter/Minute');
INSERT INTO `lam_uom` VALUES ('LB', 'US pound');
INSERT INTO `lam_uom` VALUES ('LDG', 'LANDINGS');
INSERT INTO `lam_uom` VALUES ('LE', 'Activity unit');
INSERT INTO `lam_uom` VALUES ('LHK', 'Liter per 100 km');
INSERT INTO `lam_uom` VALUES ('LMS', 'Liter/Molsecond');
INSERT INTO `lam_uom` VALUES ('LOT', 'lot');
INSERT INTO `lam_uom` VALUES ('LPH', 'Liter per hour');
INSERT INTO `lam_uom` VALUES ('M', 'Meter');
INSERT INTO `lam_uom` VALUES ('M%', 'Percent mass');
INSERT INTO `lam_uom` VALUES ('M%O', 'Permille mass');
INSERT INTO `lam_uom` VALUES ('M/S', 'Meter/second');
INSERT INTO `lam_uom` VALUES ('M2', 'Square meter');
INSERT INTO `lam_uom` VALUES ('M2I', '1 / square meter');
INSERT INTO `lam_uom` VALUES ('M2S', 'Square meter/second');
INSERT INTO `lam_uom` VALUES ('M3', 'Cubic meter');
INSERT INTO `lam_uom` VALUES ('M3S', 'Cubic meter/second');
INSERT INTO `lam_uom` VALUES ('MA', 'Milliampere');
INSERT INTO `lam_uom` VALUES ('MBA', 'Millibar');
INSERT INTO `lam_uom` VALUES ('MBZ', 'Meterbar/second');
INSERT INTO `lam_uom` VALUES ('MEJ', 'Megajoule');
INSERT INTO `lam_uom` VALUES ('MG', 'Milligram');
INSERT INTO `lam_uom` VALUES ('MGF', 'Milligram/Square centimeter');
INSERT INTO `lam_uom` VALUES ('MGG', 'Milligram/gram');
INSERT INTO `lam_uom` VALUES ('MGK', 'Milligram/kilogram');
INSERT INTO `lam_uom` VALUES ('MGL', 'Milligram/liter');
INSERT INTO `lam_uom` VALUES ('MGQ', 'Milligram/cubic meter');
INSERT INTO `lam_uom` VALUES ('MGW', 'Megawatt');
INSERT INTO `lam_uom` VALUES ('MHZ', 'Megahertz');
INSERT INTO `lam_uom` VALUES ('MI', 'Mile');
INSERT INTO `lam_uom` VALUES ('MI2', 'Square mile');
INSERT INTO `lam_uom` VALUES ('MIM', 'Micrometer');
INSERT INTO `lam_uom` VALUES ('MIN', 'Minute');
INSERT INTO `lam_uom` VALUES ('MIS', 'Microsecond');
INSERT INTO `lam_uom` VALUES ('MJ', 'Millijoule');
INSERT INTO `lam_uom` VALUES ('ML', 'Milliliter');
INSERT INTO `lam_uom` VALUES ('MLK', 'Milliliter/cubic meter');
INSERT INTO `lam_uom` VALUES ('MLW', 'Milliliter act. ingr.');
INSERT INTO `lam_uom` VALUES ('MM', 'Millimeter');
INSERT INTO `lam_uom` VALUES ('MM2', 'Square millimeter');
INSERT INTO `lam_uom` VALUES ('MMA', 'Millimeter/year');
INSERT INTO `lam_uom` VALUES ('MMG', 'Millimol/gram');
INSERT INTO `lam_uom` VALUES ('MMH', 'Millimeter/hour');
INSERT INTO `lam_uom` VALUES ('MMK', 'Millimol/kilogram');
INSERT INTO `lam_uom` VALUES ('MMO', 'Millimol');
INSERT INTO `lam_uom` VALUES ('MMQ', 'Cubic millimeter');
INSERT INTO `lam_uom` VALUES ('MMS', 'Millimeter/second');
INSERT INTO `lam_uom` VALUES ('MNM', 'Millinewton/meter');
INSERT INTO `lam_uom` VALUES ('MOK', 'Mol/kilogram');
INSERT INTO `lam_uom` VALUES ('MOL', 'Mol');
INSERT INTO `lam_uom` VALUES ('MON', 'Months');
INSERT INTO `lam_uom` VALUES ('MPA', 'Megapascal');
INSERT INTO `lam_uom` VALUES ('MPB', 'Mass parts per billion');
INSERT INTO `lam_uom` VALUES ('MPG', 'Miles per gallon (US)');
INSERT INTO `lam_uom` VALUES ('MPM', 'Mass parts per million');
INSERT INTO `lam_uom` VALUES ('MPS', 'Millipascal seconds');
INSERT INTO `lam_uom` VALUES ('MPT', 'Mass parts per trillion');
INSERT INTO `lam_uom` VALUES ('MPZ', 'Meterpascal/second');
INSERT INTO `lam_uom` VALUES ('MQH', 'Cubic meter/Hour');
INSERT INTO `lam_uom` VALUES ('MS', 'Millisecond');
INSERT INTO `lam_uom` VALUES ('MS2', 'Meter/second squared');
INSERT INTO `lam_uom` VALUES ('MTE', 'Millitesla');
INSERT INTO `lam_uom` VALUES ('MTS', 'Meter/Hour');
INSERT INTO `lam_uom` VALUES ('MV', 'Millivolt');
INSERT INTO `lam_uom` VALUES ('MVA', 'Megavoltampere');
INSERT INTO `lam_uom` VALUES ('MW', 'Milliwatt');
INSERT INTO `lam_uom` VALUES ('MWH', 'Megawatt hour');
INSERT INTO `lam_uom` VALUES ('N', 'Newton');
INSERT INTO `lam_uom` VALUES ('NAM', 'Nanometer');
INSERT INTO `lam_uom` VALUES ('NM', 'Newton/meter');
INSERT INTO `lam_uom` VALUES ('NS', 'Nanosecond');
INSERT INTO `lam_uom` VALUES ('OCM', 'Spec. Elec. Resistance');
INSERT INTO `lam_uom` VALUES ('OHM', 'Ohm');
INSERT INTO `lam_uom` VALUES ('OM', 'Spec. Elec. Resistance');
INSERT INTO `lam_uom` VALUES ('OZ', 'Ounce');
INSERT INTO `lam_uom` VALUES ('OZA', 'Fluid Ounce US');
INSERT INTO `lam_uom` VALUES ('P', 'Points');
INSERT INTO `lam_uom` VALUES ('PA', 'Pascal');
INSERT INTO `lam_uom` VALUES ('PAA', 'Pair');
INSERT INTO `lam_uom` VALUES ('PAK', 'Pack');
INSERT INTO `lam_uom` VALUES ('PAL', 'Pallet');
INSERT INTO `lam_uom` VALUES ('PAS', 'Pascal second');
INSERT INTO `lam_uom` VALUES ('PCT', 'Group proportion');
INSERT INTO `lam_uom` VALUES ('PL', 'PAIL');
INSERT INTO `lam_uom` VALUES ('PMI', '1/minute');
INSERT INTO `lam_uom` VALUES ('PMR', 'Permeation Rate SI');
INSERT INTO `lam_uom` VALUES ('PPB', 'Parts per billion');
INSERT INTO `lam_uom` VALUES ('PPM', 'Parts per million');
INSERT INTO `lam_uom` VALUES ('PPT', 'Parts per trillion');
INSERT INTO `lam_uom` VALUES ('PRM', 'Permeation Rate');
INSERT INTO `lam_uom` VALUES ('PRS', 'Number of Persons');
INSERT INTO `lam_uom` VALUES ('PS', 'Picosecond');
INSERT INTO `lam_uom` VALUES ('PT', 'Pint, US liquid');
INSERT INTO `lam_uom` VALUES ('QT', 'Quart, US liquid');
INSERT INTO `lam_uom` VALUES ('RHO', 'Gram/cubic centimeter');
INSERT INTO `lam_uom` VALUES ('RIM', 'rim');
INSERT INTO `lam_uom` VALUES ('ROL', 'Role');
INSERT INTO `lam_uom` VALUES ('S', 'Second');
INSERT INTO `lam_uom` VALUES ('SET', 'set');
INSERT INTO `lam_uom` VALUES ('SH', 'SHEET');
INSERT INTO `lam_uom` VALUES ('ST', 'items');
INSERT INTO `lam_uom` VALUES ('STD', 'Hours');
INSERT INTO `lam_uom` VALUES ('TAG', 'Days');
INSERT INTO `lam_uom` VALUES ('TC3', '1/cubic centimeter');
INSERT INTO `lam_uom` VALUES ('TES', 'Tesla');
INSERT INTO `lam_uom` VALUES ('TH', 'Thousands');
INSERT INTO `lam_uom` VALUES ('TM3', '1/cubic meter');
INSERT INTO `lam_uom` VALUES ('TO', 'Tonne');
INSERT INTO `lam_uom` VALUES ('TON', 'US ton');
INSERT INTO `lam_uom` VALUES ('UGL', 'Microgram/liter');
INSERT INTO `lam_uom` VALUES ('V', 'Volt');
INSERT INTO `lam_uom` VALUES ('V%', 'Percent volume');
INSERT INTO `lam_uom` VALUES ('V%O', 'Permille volume');
INSERT INTO `lam_uom` VALUES ('V01', 'Microsiemens per centimeter');
INSERT INTO `lam_uom` VALUES ('V02', 'Millimol per liter');
INSERT INTO `lam_uom` VALUES ('VAL', 'Value-only material');
INSERT INTO `lam_uom` VALUES ('VPB', 'Volume parts per billion');
INSERT INTO `lam_uom` VALUES ('VPM', 'Volume parts per million');
INSERT INTO `lam_uom` VALUES ('VPT', 'Volume parts per trillion');
INSERT INTO `lam_uom` VALUES ('W', 'Watt');
INSERT INTO `lam_uom` VALUES ('WCH', 'Weeks');
INSERT INTO `lam_uom` VALUES ('WMK', 'Heat Conductivity');
INSERT INTO `lam_uom` VALUES ('WTL', 'Evaporation Rate');
INSERT INTO `lam_uom` VALUES ('YD', 'Yards');
INSERT INTO `lam_uom` VALUES ('YD2', 'Square Yard');
INSERT INTO `lam_uom` VALUES ('YD3', 'Cubic yard');

/*
Navicat MySQL Data Transfer

Source Server         : theexecutive
Source Server Version : 50638
Source Host           : theexecutive.co.id:3306
Source Database       : theexecu_shop

Target Server Type    : MYSQL
Target Server Version : 50638
File Encoding         : 65001

Date: 2018-03-12 15:19:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for refund
-- ----------------------------
DROP TABLE IF EXISTS `refund`;
CREATE TABLE `refund` (
  `email` varchar(50) NOT NULL,
  `nama_customer` varchar(50) NOT NULL,
  `noorder` varchar(10) NOT NULL,
  `total_order` float NOT NULL,
  `refund` float NOT NULL,
  `alasan` text NOT NULL,
  `nama_rekening` varchar(20) NOT NULL,
  `norek` varchar(20) NOT NULL,
  `nama_bank` varchar(20) NOT NULL,
  `cabang` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;
SET FOREIGN_KEY_CHECKS=1;

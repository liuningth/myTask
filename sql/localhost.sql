-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2022-02-17 21:31:30
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `laravel7_test`
--
CREATE DATABASE IF NOT EXISTS `laravel7_test` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `laravel7_test`;

-- --------------------------------------------------------

--
-- 表的结构 `admin_user`
--

CREATE TABLE `admin_user` (
  `id` int(10) NOT NULL COMMENT 'id',
  `name` varchar(50) NOT NULL COMMENT '用户名',
  `pass` varchar(200) NOT NULL COMMENT '密码',
  `created_at` int(10) NOT NULL COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `admin_user`
--

INSERT INTO `admin_user` (`id`, `name`, `pass`, `created_at`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 1645068639);

-- --------------------------------------------------------

--
-- 表的结构 `coupon`
--

CREATE TABLE `coupon` (
  `id` int(10) NOT NULL COMMENT 'id',
  `money` int(10) NOT NULL COMMENT '金额',
  `start_time` int(10) NOT NULL COMMENT '开始时间',
  `end_time` int(10) NOT NULL COMMENT '结束时间',
  `created_at` int(10) NOT NULL COMMENT '创建时间',
  `updated_at` int(10) DEFAULT NULL COMMENT '修改时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='优惠卷';

--
-- 转存表中的数据 `coupon`
--

INSERT INTO `coupon` (`id`, `money`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(1, 10, 1645099200, 1645110000, 1645081629, 1645082135);

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL COMMENT 'id',
  `name` varchar(150) NOT NULL COMMENT '名称',
  `sku` varchar(12) NOT NULL COMMENT 'sku',
  `image` varchar(300) NOT NULL COMMENT '图片',
  `created_at` int(10) NOT NULL COMMENT '创建时间',
  `updated_at` int(10) DEFAULT NULL COMMENT '修改时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品';

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`id`, `name`, `sku`, `image`, `created_at`, `updated_at`) VALUES
(2, 'iphone 12 pro', 'sj23UUPFA9Wx', '/upload/images/XfgMPydtVgF4HwXNZb9nziXHclhCji4w9rqGWYWm.jpg', 1645081336, NULL),
(3, 'iphone 12 mini', '4LHoFUXCzztW', '/upload/images/XfgMPydtVgF4HwXNZb9nziXHclhCji4w9rqGWYWm.jpg', 1645081347, NULL),
(4, 'iphone 12 promax', 'GlOR6FRQLPqL', '/upload/images/XfgMPydtVgF4HwXNZb9nziXHclhCji4w9rqGWYWm.jpg', 1645081355, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `product_coupon`
--

CREATE TABLE `product_coupon` (
  `id` int(11) NOT NULL COMMENT 'id',
  `product_id` int(10) NOT NULL COMMENT '产品id',
  `coupon_id` int(10) NOT NULL COMMENT '优惠卷id',
  `created_at` int(10) NOT NULL COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品优惠卷';

--
-- 转存表中的数据 `product_coupon`
--

INSERT INTO `product_coupon` (`id`, `product_id`, `coupon_id`, `created_at`) VALUES
(4, 3, 1, 1645082135),
(3, 2, 1, 1645082135),
(5, 4, 1, 1645082135);

--
-- 转储表的索引
--

--
-- 表的索引 `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `product_coupon`
--
ALTER TABLE `product_coupon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_id` (`coupon_id`,`product_id`) USING BTREE;

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `product_coupon`
--
ALTER TABLE `product_coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

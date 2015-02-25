-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 18, 2015 at 10:56 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_management`
--

CREATE TABLE IF NOT EXISTS `access_management` (
`id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `access_management`
--

INSERT INTO `access_management` (`id`, `action`, `role_id`, `created_at`) VALUES
(4, 'order_cancellation', 48, '2014-10-06 09:37:00'),
(5, 'multi_order_search', 48, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `panels`
--

CREATE TABLE IF NOT EXISTS `panels` (
`panel_id` int(11) NOT NULL,
  `panel_name` varchar(50) NOT NULL,
  `panel_url` varchar(100) NOT NULL,
  `panel_description` varchar(300) NOT NULL,
  `panel_parent_id` int(11) NOT NULL,
  `panel_type` enum('display','hidden') NOT NULL DEFAULT 'display'
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COMMENT='All the panels created are stored in this table.';

--
-- Dumping data for table `panels`
--

INSERT INTO `panels` (`panel_id`, `panel_name`, `panel_url`, `panel_description`, `panel_parent_id`, `panel_type`) VALUES
(1, 'Home', '/home', '', 0, 'display'),
(2, 'users', '/users', 'Users', 8, 'display'),
(3, 'roles', '/roles', 'Roles', 8, 'display'),
(4, 'adduser', '/adduser', 'Add User', 2, 'display'),
(5, 'deleteuser', '/viewdelete', 'Delete User', 2, 'display'),
(6, 'activeuser', '/activeuser', 'Active User', 2, 'display'),
(7, 'edituser', '/edituser', 'Edit User', 2, 'display'),
(8, 'Admin Menu', '/adminMenu', '', 0, 'display'),
(9, 'View Orders', '/viewOrders', 'View Orders', 8, 'display'),
(10, 'CS', '/csMenu', '', 0, 'display'),
(11, 'Refund Status', '/viewRefundStatus', 'Refund Status', 10, 'display'),
(12, 'Returns', '/returns', '', 0, 'display'),
(13, 'Add Role', '/addrole', 'Add Role', 3, 'display'),
(14, 'Edit Role', '/editrole', 'Edit Role', 3, 'display'),
(15, 'Delete Role', '/deleterole', 'Delete Role', 3, 'display');

-- --------------------------------------------------------

--
-- Table structure for table `rights`
--

CREATE TABLE IF NOT EXISTS `rights` (
`rightsid` int(11) NOT NULL,
  `rightsname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='All the possible rights are in this table.';

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
`roleid` int(11) NOT NULL,
  `rolename` varchar(50) NOT NULL,
  `role_description` varchar(255) NOT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`roleid`, `rolename`, `role_description`, `isactive`) VALUES
(1, 'Tech', 'Tech team of happily unmarried', 1),
(2, 'Finance', 'Handles finance', 1),
(3, 'PR', 'Face of HU to the customer', 1),
(4, 'HR', 'Ensures that the right people are available at the right time', 1),
(5, 'Accounting', 'Handles the accounts of happily unmarried', 1),
(6, 'Intern', 'Intern at HU', 1);

-- --------------------------------------------------------

--
-- Table structure for table `role_panel_mapping`
--

CREATE TABLE IF NOT EXISTS `role_panel_mapping` (
`id` int(11) NOT NULL,
  `roleid` int(11) NOT NULL,
  `panel_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_panel_mapping`
--

INSERT INTO `role_panel_mapping` (`id`, `roleid`, `panel_id`) VALUES
(1, 1, 2),
(4, 1, 3),
(5, 1, 8),
(6, 1, 9),
(7, 1, 10),
(8, 1, 11),
(9, 1, 1),
(10, 1, 12),
(11, 1, 4),
(12, 1, 5),
(13, 1, 6),
(14, 1, 7),
(15, 1, 13),
(16, 1, 14),
(17, 1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `role_right_mapping`
--

CREATE TABLE IF NOT EXISTS `role_right_mapping` (
  `roleid` int(11) NOT NULL,
  `rightsid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(20) NOT NULL,
  `user_roleid` int(5) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `last_login` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='All the employee information is stored in this table.';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_roleid`, `created_at`, `updated_at`, `active`, `last_login`) VALUES
(1, 'Yash Mehrotra', 'mehrotra.yashraj@gmail.com', 'yash', 1, '2015-01-05 00:00:00', '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00'),
(2, 'test', 'test@test.com', 'test', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(3, 'test', 'test@test.com', 'test', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(4, 'thisUser', 'this@this.com', 'this', 4, '2015-02-17 12:04:39', '2015-02-17 12:04:39', 1, '0000-00-00 00:00:00'),
(5, 'Trythis', 'letstry@woah.com', 'try', 3, '2015-02-17 14:54:12', '2015-02-17 14:54:12', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_right_mapping`
--

CREATE TABLE IF NOT EXISTS `user_right_mapping` (
  `userid` int(11) NOT NULL,
  `rightsid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_management`
--
ALTER TABLE `access_management`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `panels`
--
ALTER TABLE `panels`
 ADD PRIMARY KEY (`panel_id`);

--
-- Indexes for table `rights`
--
ALTER TABLE `rights`
 ADD PRIMARY KEY (`rightsid`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
 ADD PRIMARY KEY (`roleid`);

--
-- Indexes for table `role_panel_mapping`
--
ALTER TABLE `role_panel_mapping`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_management`
--
ALTER TABLE `access_management`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `panels`
--
ALTER TABLE `panels`
MODIFY `panel_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `rights`
--
ALTER TABLE `rights`
MODIFY `rightsid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
MODIFY `roleid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `role_panel_mapping`
--
ALTER TABLE `role_panel_mapping`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `event_log_time` ON SCHEDULE EVERY 1 MINUTE STARTS '2013-07-27 07:52:57' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE inventory.Event_log SET Log_time = NOW()$$

CREATE DEFINER=`root`@`localhost` EVENT `Eve_Delete_orders_sync` ON SCHEDULE EVERY 1 DAY STARTS '2013-08-08 01:01:00' ON COMPLETION NOT PRESERVE ENABLE DO DELETE from orders_sync where created_at <DATE_SUB(NOW(), INTERVAL 30 DAY)$$

CREATE DEFINER=`root`@`localhost` EVENT `Eve_Delete_updated_prod` ON SCHEDULE EVERY 1 DAY STARTS '2013-08-08 01:01:00' ON COMPLETION NOT PRESERVE ENABLE DO DELETE from updated_products  where created_at <DATE_SUB(NOW(), INTERVAL 7 DAY)$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

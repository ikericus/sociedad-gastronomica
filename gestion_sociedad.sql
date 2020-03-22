SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `gestion_sociedad_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `gestion_sociedad_db`;

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `people` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_time` varchar(255) NOT NULL,
  `timetables` text NOT NULL,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `service_charge_value` varchar(255) NOT NULL,
  `vat_charge_value` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `currency` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `company` (`id`, `company_name`, `service_charge_value`, `vat_charge_value`, `address`, `phone`, `country`, `message`, `currency`) VALUES
(1, 'Gestión Sociedad', '', '0', 'READING', '234234235', 'Spain', 'this is just an testing', 'EUR');

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `permission` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `groups` (`id`, `group_name`, `permission`) VALUES
(1, 'Administrador', 'a:31:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:11:\"createGroup\";i:5;s:11:\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s:11:\"deleteGroup\";i:8;s:11:\"createTable\";i:9;s:11:\"updateTable\";i:10;s:9:\"viewTable\";i:11;s:11:\"deleteTable\";i:12;s:13:\"createBooking\";i:13;s:13:\"updateBooking\";i:14;s:11:\"viewBooking\";i:15;s:13:\"deleteBooking\";i:16;s:13:\"createProduct\";i:17;s:13:\"updateProduct\";i:18;s:11:\"viewProduct\";i:19;s:13:\"deleteProduct\";i:20;s:11:\"createOrder\";i:21;s:11:\"updateOrder\";i:22;s:9:\"viewOrder\";i:23;s:11:\"deleteOrder\";i:24;s:13:\"createPayment\";i:25;s:13:\"updatePayment\";i:26;s:11:\"viewPayment\";i:27;s:13:\"deletePayment\";i:28;s:10:\"viewReport\";i:29;s:13:\"updateProfile\";i:30;s:11:\"viewProfile\";}'),
(2, 'Abonado', 'a:15:{i:0;s:8:\"viewUser\";i:1;s:9:\"viewGroup\";i:2;s:13:\"createBooking\";i:3;s:13:\"updateBooking\";i:4;s:11:\"viewBooking\";i:5;s:13:\"deleteBooking\";i:6;s:11:\"viewProduct\";i:7;s:11:\"createOrder\";i:8;s:11:\"updateOrder\";i:9;s:9:\"viewOrder\";i:10;s:11:\"deleteOrder\";i:11;s:11:\"viewPayment\";i:12;s:10:\"viewReport\";i:13;s:13:\"updateProfile\";i:14;s:11:\"viewProfile\";}'),
(3, 'Socio', 'a:16:{i:0;s:8:\"viewUser\";i:1;s:9:\"viewGroup\";i:2;s:9:\"viewTable\";i:3;s:13:\"createBooking\";i:4;s:13:\"updateBooking\";i:5;s:11:\"viewBooking\";i:6;s:13:\"deleteBooking\";i:7;s:11:\"viewProduct\";i:8;s:11:\"createOrder\";i:9;s:11:\"updateOrder\";i:10;s:9:\"viewOrder\";i:11;s:11:\"deleteOrder\";i:12;s:11:\"viewPayment\";i:13;s:10:\"viewReport\";i:14;s:13:\"updateProfile\";i:15;s:11:\"viewProfile\";}'),
(4, 'Bodeguero', 'a:19:{i:0;s:8:\"viewUser\";i:1;s:9:\"viewGroup\";i:2;s:9:\"viewTable\";i:3;s:13:\"createBooking\";i:4;s:13:\"updateBooking\";i:5;s:11:\"viewBooking\";i:6;s:13:\"deleteBooking\";i:7;s:13:\"createProduct\";i:8;s:13:\"updateProduct\";i:9;s:11:\"viewProduct\";i:10;s:13:\"deleteProduct\";i:11;s:11:\"createOrder\";i:12;s:11:\"updateOrder\";i:13;s:9:\"viewOrder\";i:14;s:11:\"deleteOrder\";i:15;s:11:\"viewPayment\";i:16;s:10:\"viewReport\";i:17;s:13:\"updateProfile\";i:18;s:11:\"viewProfile\";}'),
(5, 'Junta', 'a:22:{i:0;s:8:\"viewUser\";i:1;s:9:\"viewGroup\";i:2;s:11:\"createTable\";i:3;s:11:\"updateTable\";i:4;s:9:\"viewTable\";i:5;s:11:\"deleteTable\";i:6;s:13:\"createBooking\";i:7;s:13:\"updateBooking\";i:8;s:11:\"viewBooking\";i:9;s:13:\"deleteBooking\";i:10;s:13:\"createProduct\";i:11;s:13:\"updateProduct\";i:12;s:11:\"viewProduct\";i:13;s:13:\"deleteProduct\";i:14;s:11:\"createOrder\";i:15;s:11:\"updateOrder\";i:16;s:9:\"viewOrder\";i:17;s:11:\"deleteOrder\";i:18;s:11:\"viewPayment\";i:19;s:10:\"viewReport\";i:20;s:13:\"updateProfile\";i:21;s:11:\"viewProfile\";}'),
(6, 'Tesorero', 'a:19:{i:0;s:8:\"viewUser\";i:1;s:9:\"viewGroup\";i:2;s:9:\"viewTable\";i:3;s:13:\"createBooking\";i:4;s:13:\"updateBooking\";i:5;s:11:\"viewBooking\";i:6;s:13:\"deleteBooking\";i:7;s:11:\"viewProduct\";i:8;s:11:\"createOrder\";i:9;s:11:\"updateOrder\";i:10;s:9:\"viewOrder\";i:11;s:11:\"deleteOrder\";i:12;s:13:\"createPayment\";i:13;s:13:\"updatePayment\";i:14;s:11:\"viewPayment\";i:15;s:13:\"deletePayment\";i:16;s:10:\"viewReport\";i:17;s:13:\"updateProfile\";i:18;s:11:\"viewProfile\";}');

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `bill_no` varchar(255) NOT NULL,
  `date_time` varchar(255) NOT NULL,
  `net_amount` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `paid_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` varchar(255) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `date_time` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `concept` varchar(200) NOT NULL DEFAULT 'Bizum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `capacity` varchar(255) NOT NULL,
  `available` int(11) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `gender` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `username`, `password`, `email`, `firstname`, `lastname`, `phone`, `gender`) VALUES
(1, 'IKER', '$2y$10$AvSx4Fau6HF08GsiLC9BGellapzBT8IMS6h2pY/MASex2p37yDWJG', 'ikerzuazu@gmail.com', 'Iker', 'Zuazu', '665871857', 1);

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user_group` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1);

ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;


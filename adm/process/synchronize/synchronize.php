<?php

    //DDL
    try{
        $create = "CREATE TABLE IF NOT EXISTS `allowed_remote_addresses` (
          `address_id` int(11) NOT NULL AUTO_INCREMENT,
          `ip_address` varchar(15) NOT NULL UNIQUE,
          `description` varchar(100) DEFAULT NULL,
          `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          PRIMARY KEY (`address_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $conn ->exec($create);
        $insert = "INSERT INTO `allowed_remote_addresses` (`address_id`, `ip_address`, `description`, `created`) VALUES
        (1, '127.0.0.1', 'localhost', DEFAULT)";
        $conn ->exec($insert);
    } catch (PDOException $e){
        setLog($e ->getFile());
        setLog($e ->getLine());
        setLog($e ->getMessage());
    }

    try{
        $create = "CREATE TABLE IF NOT EXISTS `branches` (
          `branch_id` int(11) NOT NULL AUTO_INCREMENT,
          `business_name` varchar(220) NOT NULL,
          `cnpj` varchar(20) NOT NULL UNIQUE,
          `address` varchar(220) NOT NULL,
          `cep` varchar(8) DEFAULT NULL,
          `created` datetime NOT NULL DEFAULT current_timestamp(),
          `modified` datetime DEFAULT NULL ON UPDATE current_timestamp(),
          PRIMARY KEY (`branch_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $conn ->exec($create);

        $insert = "INSERT INTO `branches` (`branch_id`, `business_name`, `cnpj`, `address`, `cep`, `created`, `modified`) VALUES
        (1, 'nmatec ltda,  matriz', '00000000000000', 'av. dom pedro ii, 000, campina grande - pb', '00000000', DEFAULT, NULL)";
        $conn ->exec($insert);
    } catch (PDOException $e){
        setLog($e ->getFile());
        setLog($e ->getLine());
        setLog($e ->getMessage());
    }

    try{
        $create = "CREATE TABLE IF NOT EXISTS `departments` (
          `department_id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(60) NOT NULL UNIQUE,
          PRIMARY KEY (`department_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $conn ->exec($create);

        $insert = "INSERT INTO `departments` (`department_id`, `name`) VALUES
        (1, 'tecnologia da informação')";
        $conn ->exec($insert);
    } catch (PDOException $e){
        setLog($e ->getFile());
        setLog($e ->getLine());
        setLog($e ->getMessage());
    }

    try{
        $create = "CREATE TABLE IF NOT EXISTS `positions` (
          `position_id` int(11) NOT NULL AUTO_INCREMENT,
          `department_id` int(11) NOT NULL,
          `name` varchar(60) NOT NULL UNIQUE,
          `description` text DEFAULT NULL,
          PRIMARY KEY (`position_id`),
          FOREIGN KEY (`department_id`) REFERENCES departments (`department_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $conn ->exec($create);

        $insert = "INSERT INTO `positions` (`position_id`, `department_id`, `name`, `description`) VALUES
        (1, 1, 'programador', 'atuar na manutençao, instalação, implementações de hardwares e softwares, assim como treinar novos usuários e dar suporte a clientes em geral.')";
        $conn ->exec($insert);
    } catch (PDOException $e){
        setLog($e ->getFile());
        setLog($e ->getLine());
        setLog($e ->getMessage());
    }

    try{
        $create = "CREATE TABLE IF NOT EXISTS `records_denied` (
          `record_id` int(11) NOT NULL AUTO_INCREMENT,
          `ip_address` varchar(15) NOT NULL,
          `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          PRIMARY KEY (`record_id`) 
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $conn ->exec($create);
    } catch (PDOException $e){
        setLog($e ->getFile());
        setLog($e ->getLine());
        setLog($e ->getMessage());
    }

    try {
        $create = "CREATE TABLE IF NOT EXISTS `workload` (
          `workload_id` int(11) NOT NULL AUTO_INCREMENT,
          `weekly_workload` time NOT NULL,
          `weekend_workload` time DEFAULT NULL,
          PRIMARY KEY (`workload_id`) 
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $conn ->exec($create);

        $insert = "INSERT INTO `workload` (`workload_id`, `weekly_workload`, `weekend_workload`) VALUES
        (1, '08:00:00', NULL),
        (2, '06:00:00', '06:00:00'),
        (3, '08:00:00', '04:00:00')";
        $conn ->exec($insert);
    } catch (PDOException $e){
        setLog($e ->getFile());
        setLog($e ->getLine());
        setLog($e ->getMessage());
    }

    try {
        $create = "CREATE TABLE IF NOT EXISTS `work_schedule` (
          `schedule_id` int(11) NOT NULL AUTO_INCREMENT,
          `first_weekly_shift_entry` time NOT NULL,
          `first_weekly_shift_exit` time NOT NULL,
          `second_weekly_shift_entry` time NOT NULL,
          `second_weekly_shift_exit` time NOT NULL,
          `weekend_shift_entry` time DEFAULT NULL,
          `weekend_shift_exit` time DEFAULT NULL,
          `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          PRIMARY KEY (`schedule_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $conn ->exec($create);

        $insert = "INSERT INTO `work_schedule` (`schedule_id`, `first_weekly_shift_entry`, `first_weekly_shift_exit`, `second_weekly_shift_entry`, `second_weekly_shift_exit`, `weekend_shift_entry`, `weekend_shift_exit`, `created`) VALUES
        (1, '07:00:00', '11:00:00', '13:00:00', '17:00:00', NULL, NULL, DEFAULT),
        (2, '08:00:00', '12:00:00', '14:00:00', '18:00:00', NULL, NULL, DEFAULT),
        (3, '07:00:00', '11:00:00', '13:00:00', '17:00:00', '07:00:00', '11:00:00', DEFAULT)";
        $conn ->exec($insert);
    } catch (PDOException $e){
        setLog($e ->getFile());
        setLog($e ->getLine());
        setLog($e ->getMessage());
    }

    try {
        $create = "CREATE TABLE `employees` (
          `employee_id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(60) NOT NULL,
          `phone_number` varchar(14) NOT NULL,
          `cpf` varchar(11) DEFAULT NULL UNIQUE,
          `ctps` varchar(20) DEFAULT NULL UNIQUE,
          `pis` varchar(20) DEFAULT NULL UNIQUE,
          `registration` varchar(20) DEFAULT NULL,
          `branch_id` int(11) NOT NULL,
          `position_id` int(11) NOT NULL,
          `workload_id` int(11) NOT NULL,
          `work_schedule_id` int(11) NOT NULL,
          `admission_date` date DEFAULT NULL,
          `pwd` varchar(6) NOT NULL,
          `created` timestamp NOT NULL DEFAULT current_timestamp(),
          `modified` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
          PRIMARY KEY (`employee_id`),
          FOREIGN KEY (`branch_id`) REFERENCES branches (`branch_id`),
          FOREIGN KEY (`position_id`) REFERENCES positions (`position_id`),
          FOREIGN KEY (`workload_id`) REFERENCES workload (`workload_id`),
          FOREIGN KEY (`work_schedule_id`) REFERENCES work_schedule (`schedule_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $conn ->exec($create);

        $insert = "INSERT INTO `employees` (`employee_id`, `name`, `phone_number`, `cpf`, `ctps`, `pis`, `registration`, `branch_id`, `position_id`, `workload_id`, `work_schedule_id`, `admission_date`, `pwd`, `created`, `modified`) VALUES
        (1, 'empregado teste', '00000000000', '00000000000', '0000000000000', '00000000000', '0000', 1, 1, 1, 1, '2011-11-20', '00000', '2020-12-15 15:23:14', NULL)";
        $conn ->exec($insert);
    } catch (PDOException $e){
        setLog($e ->getFile());
        setLog($e ->getLine());
        setLog($e ->getMessage());
    }

    try {
        $create = "CREATE TABLE IF NOT EXISTS `permissions_for_registration` (
          `permission_id` int(11) NOT NULL AUTO_INCREMENT,
          `employee_id` int(11) NOT NULL,
          `remote_address_id` int(11) NOT NULL,
          `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(), 
          PRIMARY KEY (`permission_id`),
          FOREIGN KEY (`employee_id`) REFERENCES employees (`employee_id`),
          FOREIGN KEY (remote_address_id) REFERENCES allowed_remote_addresses (`address_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $conn ->exec($create);

        $insert = "INSERT INTO `permissions_for_registration` (`permission_id`, `employee_id`, `remote_address_id`, `created`) VALUES
        (1, 1, 1, '2020-12-18 17:35:00')";
        $conn ->exec($insert);
    } catch (PDOException $e){
        setLog($e ->getFile());
        setLog($e ->getLine());
        setLog($e ->getMessage());
    }

    try {
        $create = "CREATE TABLE IF NOT EXISTS `daily_log` (
          `log_id` int(11) NOT NULL AUTO_INCREMENT,
          `employee_id` int(11) NOT NULL,
          `workload_id` int(11) NOT NULL,
          `work_schedule_id` int(11) NOT NULL,
          `record_a` time DEFAULT NULL,
          `record_b` time DEFAULT NULL,
          `record_c` time DEFAULT NULL,
          `record_d` time DEFAULT NULL,
          `record_e` time DEFAULT NULL,
          `record_f` time DEFAULT NULL,
          `created` datetime NOT NULL,
          `modified` datetime DEFAULT NULL, 
          PRIMARY KEY (`log_id`),
          FOREIGN KEY (`employee_id`) REFERENCES employees (`employee_id`),
          FOREIGN KEY (`workload_id`) REFERENCES workload (`workload_id`),
          FOREIGN KEY (`work_schedule_id`) REFERENCES work_schedule (`schedule_id`) 
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $conn ->exec($create);

        $insert = "INSERT INTO `daily_log` (`log_id`, `employee_id`, `workload_id`, `work_schedule_id`, `record_a`, `record_b`, `record_c`, `record_d`, `record_e`, `record_f`, `created`, `modified`) VALUES
        (1, 1, 1, 1, '06:00:00', '11:00:00', NULL, NULL, NULL, NULL, '2020-12-24 06:13:47', '2020-12-24 13:34:45'),
        (2, 1, 1, 1, '09:00:00', '14:30:00', NULL, NULL, NULL, NULL, '2020-12-28 09:00:07', '2020-12-28 14:22:58'),
        (3, 1, 1, 1, '07:30:00', '11:30:00', '13:10:00', '17:45:44', NULL, NULL, '2020-12-29 07:32:47', '2020-12-29 15:27:25'),
        (4, 1, 1, 1, '09:30:00', '15:00:00', '16:00:00', '17:00:00', NULL, NULL, '2020-12-30 09:20:10', '2020-12-30 17:00:25'),
        (5, 1, 1, 1, '08:49:46', '10:49:08', '13:37:51', '17:25:08', NULL, NULL, '2020-12-31 08:49:46', '2020-12-31 13:37:51'),
        (6, 1, 1, 1, '07:30:00', '11:30:00', '13:00:00', '17:00:00', NULL, NULL, '2021-01-04 07:27:18', '2021-01-04 17:13:55'),
        (7, 1, 1, 1, '07:17:14', '11:05:37', '13:07:22', '18:18:55', NULL, NULL, '2021-01-05 07:17:14', '2021-01-05 14:30:37'),
        (8, 1, 1, 1, '07:36:50', '11:03:42', '13:03:51', '17:03:59', NULL, NULL, '2021-01-06 07:36:50', '2021-01-06 17:03:59'),
        (9, 1, 1, 1, '08:06:40', '11:22:52', '13:49:58', '17:49:58', NULL, NULL, '2021-01-07 08:06:40', '2021-01-07 16:49:58'),
        (10, 1, 1, 1, '07:22:39', '11:03:30', '13:05:34', '17:18:25', NULL, NULL, '2021-01-08 07:22:39', '2021-01-08 11:03:30'),
        (11, 1, 1, 1, '07:07:22', '11:19:33', '13:19:41', '17:06:21', NULL, NULL, '2021-01-11 07:07:22', '2021-01-11 17:06:21'),
        (12, 1, 1, 1, '07:04:15', '11:12:34', '13:18:19', '17:25:00', NULL, NULL, '2021-01-12 07:04:15', '2021-01-12 13:18:19'),
        (13, 1, 1, 1, '07:13:57', '11:22:54', '13:16:00', '17:12:59', NULL, NULL, '2021-01-13 07:13:57', '2021-01-13 17:12:59'),
        (14, 1, 1, 1, '07:05:35', '12:10:32', '13:16:43', '17:25:59', NULL, NULL, '2021-01-14 07:05:35', '2021-01-14 13:16:43'),
        (15, 1, 1, 1, '07:02:23', '11:07:02', '13:12:31', '17:00:50', NULL, NULL, '2021-01-15 07:41:23', '2021-01-15 17:00:50'),
        (16, 1, 1, 1, '07:15:12', '11:22:56', '13:11:54', '17:55:22', NULL, NULL, '2021-01-18 07:15:12', '2021-01-18 15:11:54'),
        (17, 1, 1, 1, '07:12:07', '11:08:30', '13:12:04', '17:13:16', NULL, NULL, '2021-01-19 07:20:07', '2021-01-19 17:13:16'),
        (18, 1, 1, 1, '07:02:37', '11:01:10', '13:16:15', '17:11:05', NULL, NULL, '2021-01-20 07:02:37', '2021-01-20 17:11:05'),
        (19, 1, 1, 1, '07:28:42', '11:18:03', '13:18:52', '17:04:08', NULL, NULL, '2021-01-21 07:28:42', '2021-01-21 17:04:08'),
        (20, 1, 1, 1, '07:10:49', '11:33:39', '13:00:26', '17:01:09', NULL, NULL, '2021-01-22 07:10:50', '2021-01-22 17:01:09'),
        (21, 1, 1, 1, '07:23:32', '11:08:29', '13:14:50', '17:20:17', NULL, NULL, '2021-01-25 07:23:33', '2021-01-25 17:20:17'),
        (22, 1, 1, 1, '07:05:42', '11:09:49', '13:09:06', '16:50:35', NULL, NULL, '2021-01-26 07:05:42', '2021-01-26 16:50:35'),
        (23, 1, 1, 1, '07:10:10', '11:18:18', '13:15:09', '17:08:54', NULL, NULL, '2021-01-27 07:10:10', '2021-01-27 17:08:54'),
        (24, 1, 1, 1, '07:14:57', '11:20:35', '13:18:29', '17:10:50', NULL, NULL, '2021-01-28 07:14:58', '2021-01-28 17:10:50'),
        (25, 1, 1, 1, '07:13:24', '11:12:17', '13:19:25', '17:50:35', NULL, NULL, '2021-01-29 07:13:24', '2021-01-29 13:19:25'),
        (26, 1, 1, 1, '07:14:14', '11:35:17', '13:25:10', '17:19:56', NULL, NULL, '2021-02-01 07:14:14', '2021-02-01 17:19:56'),
        (27, 1, 1, 1, '07:06:01', '11:02:59', '13:26:30', '17:22:55', NULL, NULL, '2021-02-02 07:32:01', '2021-02-02 17:22:55'),
        (28, 1, 1, 1, '07:09:46', '11:09:00', '13:11:14', '17:11:32', NULL, NULL, '2021-02-03 07:09:46', '2021-02-03 17:11:32'),
        (29, 1, 1, 1, '07:14:41', '11:20:59', '13:45:18', '17:34:01', NULL, NULL, '2021-02-04 07:14:41', '2021-02-04 17:34:01'),
        (30, 1, 1, 1, '07:18:10', '11:14:51', '13:20:32', '17:14:51', NULL, NULL, '2021-02-05 07:18:10', '2021-02-05 17:14:51'),
        (31, 1, 1, 1, '07:15:41', '11:02:55', '13:22:13', '17:04:12', NULL, NULL, '2021-02-08 07:15:41', '2021-02-08 17:04:12'),
        (32, 1, 1, 1, '07:14:20', '11:05:00', '13:12:55', '17:03:59', NULL, NULL, '2021-02-09 07:14:21', '2021-02-09 17:03:59'),
        (33, 1, 1, 1, '07:17:02', '11:23:49', '13:23:49', '17:03:00', NULL, NULL, '2021-02-10 07:17:02', '2021-02-10 13:23:49'),
        (34, 1, 1, 1, '07:11:39', '11:04:18', '13:02:12', '17:02:12', NULL, NULL, '2021-02-11 07:11:39', '2021-02-11 17:02:12'),
        (35, 1, 1, 1, '07:17:53', '11:03:59', '13:30:00', '17:03:45', NULL, NULL, '2021-02-12 07:17:54', NULL),
        (36, 1, 1, 1, '07:27:34', '11:11:39', '13:19:58', '16:58:59', NULL, NULL, '2021-02-15 07:27:34', '2021-02-15 13:19:58'),
        (37, 1, 1, 1, '07:06:06', '11:15:00', '13:10:00', '17:22:33', NULL, NULL, '2021-02-16 07:06:07', NULL),
        (38, 1, 1, 1, '07:22:27', '11:23:15', '13:02:55', '17:10:00', NULL, NULL, '2021-04-15 09:22:27', NULL),
        (39, 1, 1, 1, '07:14:23', '11:26:55', '13:20:55', '18:05:10', NULL, NULL, '2021-04-16 14:14:23', NULL),
        (40, 1, 1, 1, '07:10:00', '11:04:55', '13:08:00', '17:25:00', NULL, NULL, '2021-04-01 07:10:00', '2021-04-01 17:25:00'),
        (41, 1, 1, 1, '07:15:46', '11:00:29', '13:30:38', '19:00:15', NULL, NULL, '2021-04-19 10:49:46', '2021-04-19 19:00:15'),
        (42, 1, 1, 1, '06:40:07', '11:28:14', '13:24:55', '17:35:56', NULL, NULL, '2021-04-20 11:28:07', '2021-04-20 17:35:57'),
        (43, 1, 1, 1, '07:15:23', '11:14:38', '13:18:02', '17:01:23', NULL, NULL, '2021-04-21 07:15:23', '2021-04-21 17:01:23'),
        (44, 1, 1, 1, '07:06:17', '11:08:25', '13:10:38', '17:01:38', NULL, NULL, '2021-04-22 07:06:17', '2021-04-22 17:01:38'),
        (45, 1, 1, 1, '07:06:20', '11:02:56', '13:14:20', '16:47:45', NULL, NULL, '2021-04-23 07:37:20', '2021-04-23 16:47:44'),
        (46, 1, 1, 1, '07:04:46', '11:10:40', '13:04:11', '17:11:11', '19:00:39', '21:42:20', '2021-04-26 07:04:46', '2021-04-26 21:42:20'),
        (47, 1, 1, 1, '06:28:22', '11:03:08', '13:33:08', '17:01:34', NULL, NULL, '2021-04-27 06:28:22', '2021-04-27 17:01:34'),
        (48, 1, 1, 1, '07:04:03', '11:05:39', '13:11:12', '17:01:53', NULL, NULL, '2021-04-28 07:04:03', '2021-04-28 17:01:53'),
        (49, 1, 1, 1, '10:01:14', '11:21:52', '13:03:12', '17:09:11', NULL, NULL, '2021-04-29 10:01:14', '2021-04-29 17:09:11'),
        (50, 1, 1, 1, '07:00:57', '13:20:17', NULL, NULL, NULL, NULL, '2021-04-30 07:00:57', '2021-04-30 13:20:17'),
        (51, 1, 1, 1, '07:06:55', '11:02:55', '13:08:56', '17:11:18', NULL, NULL, '2021-05-03 07:06:55', '2021-05-03 17:11:18'),
        (52, 1, 1, 1, '07:00:24', '11:12:06', NULL, NULL, NULL, NULL, '2021-05-04 07:00:24', '2021-05-04 11:12:06'),
        (53, 1, 1, 1, '13:49:08', NULL, NULL, NULL, NULL, NULL, '2021-05-14 13:49:08', NULL),
        (54, 1, 1, 1, '07:12:55', '11:06:33', '13:03:04', '17:03:36', NULL, NULL, '2021-09-06 07:03:55', '2021-09-06 17:03:36'),
        (55, 1, 1, 1, '18:50:59', '18:54:08', NULL, NULL, NULL, NULL, '2021-12-31 18:50:59', '2021-12-31 18:54:08'),
        (56, 1, 1, 1, '14:29:45', NULL, NULL, NULL, NULL, NULL, '2022-01-10 14:29:44', NULL),
        (57, 1, 1, 1, '09:36:34', NULL, NULL, NULL, NULL, NULL, '2022-01-12 09:36:33', NULL),
        (58, 1, 1, 1, '06:46:18', NULL, NULL, NULL, NULL, NULL, '2022-01-18 06:46:17', NULL),
        (59, 1, 1, 1, '13:02:41', NULL, NULL, NULL, NULL, NULL, '2022-01-20 13:02:40', NULL),
        (60, 1, 1, 1, '14:33:42', NULL, NULL, NULL, NULL, NULL, '2022-02-10 14:35:29', NULL)";
        $conn ->exec($insert);
    } catch (PDOException $e) {
        setLog($e->getFile());
        setLog($e->getLine());
        setLog($e->getMessage());
    }
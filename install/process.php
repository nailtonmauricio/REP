<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

    //criar validações para os campos

    //criar o banco de dados
    try {
        $conn = new PDO("mysql:host={$data["host_name"]}; charset={$data["charset"]}", $data["user_name"], $data["password"]);
        // set the PDO error mode to exception
        $conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE DATABASE {$data["db_name"]}";
        // use exec() because no results are returned
        $conn ->exec($sql);
        //echo "Database created successfully<br>";

    } catch(PDOException $e) {
        echo $e ->getMessage();
    } finally {
        //Cria o arquivo de configuração em /config/config.php
        if(!is_file(__DIR__ . "/config/config.txt")){
            $stmt = array("{$data["host_name"]}", "{$data["db_name"]}", "{$data["charset"]}", "{$data["user_name"]}", "{$data["password"]}");
            $config_file = implode(";", $stmt);

            $folder = __DIR__."/config/";
            if(!is_dir($folder)){
                mkdir($folder, 0777, true);
                chmod($folder, 0777);
            }
            //Criação do arquivo config.txt com os dados vindos pelo formulário de instalação
            $file = "{$folder}config.txt";
            $handle = fopen($file, "a+");
            fwrite($handle, $config_file);
            fclose($handle);
        }
    }
    try{
        //CREATE CONNECTION
        try {
            $conn = new PDO("mysql:host={$data["host_name"]}; dbname={$data["db_name"]}; charset={$data["charset"]}", $data["user_name"], $data["password"]);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e ->getMessage();
        }

        //Table pages
        $sql_pages = "CREATE TABLE `pages` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(60) DEFAULT NULL,
          `path` varchar(220) NOT NULL UNIQUE,
          `description` varchar(500) DEFAULT NULL,
          `created` timestamp NOT NULL DEFAULT current_timestamp(),
          `modified` timestamp NULL DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $conn ->exec($sql_pages);
        $insert_pages ="INSERT INTO `pages` (`id`, `name`, `path`, `description`, `created`, `modified`) VALUES
        (1, 'home', 'home', NULL, '2022-02-02 05:36:32', NULL),
        (2, 'paginas', 'list/list_paginas', NULL, DEFAULT, NULL),
        (3, NULL, 'register/reg_paginas', NULL, DEFAULT, NULL),
        (4, NULL, 'edit/edit_paginas', NULL, DEFAULT, NULL),
        (5, NULL, 'viewer/view_paginas', NULL, DEFAULT, NULL),
        (6, NULL, 'process/reg/reg_paginas', NULL, DEFAULT, NULL),
        (7, NULL, 'process/edit/edit_paginas', NULL, DEFAULT, NULL),
        (8, 'níveis acesso', 'list/list_niveis_acesso', NULL, DEFAULT, NULL),
        (9, 'permissões', 'list/list_permissoes', NULL, DEFAULT, NULL),
        (10, NULL, 'register/reg_niveis_acesso', NULL, DEFAULT, NULL),
        (11, NULL, 'edit/edit_niveis_acesso', NULL, DEFAULT, NULL),
        (12, NULL, 'viewer/view_niveis_acesso', NULL, DEFAULT, NULL),
        (13, NULL, 'process/reg/reg_niveis_acesso', NULL, DEFAULT, NULL),
        (14, NULL, 'process/edit/edit_niveis_acesso', NULL, DEFAULT, NULL),
        (15, NULL, 'process/edit/edit_menu', NULL, DEFAULT, NULL),
        (16, NULL, 'process/edit/edit_permissao', NULL, DEFAULT, NULL),
        (17, 'usuários', 'list/list_usuarios', NULL, DEFAULT, NULL),
        (18, NULL, 'register/reg_usuarios', NULL, DEFAULT, NULL),
        (19, NULL, 'viewer/view_usuarios', NULL, DEFAULT, NULL),
        (20, NULL, 'edit/edit_usuarios', NULL, DEFAULT, NULL),
        (21, NULL, 'process/reg/reg_usuarios', NULL, DEFAULT, NULL),
        (22, NULL, 'process/edit/proc_edit_usuario', NULL, DEFAULT, NULL),
        (23, NULL, 'process/del/del_usuario', NULL, DEFAULT, NULL),
        (24, NULL, 'backup', NULL, DEFAULT, NULL),
        (25, 'synchronize', 'process/synchronize/synchronize', NULL, DEFAULT, NULL)";
        $conn ->exec($insert_pages);

        //Table access_level
        $sql_access_level = "CREATE TABLE `access_level` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(60) NOT NULL UNIQUE,
          `position` int(11) NOT NULL,
          `privilege` tinyint(1) DEFAULT 0,
          `situation` tinyint(1) DEFAULT 1,
          `created` timestamp NOT NULL DEFAULT current_timestamp(),
          `modified` timestamp NULL DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $conn ->exec($sql_access_level);
        $insert_access_level = "INSERT INTO `access_level` (`id`, `name`, `position`, `privilege`,`situation`, `created`, `modified`) VALUES
        (1, 'admin', 1, 1, 1, DEFAULT, NULL),
        (2, 'default', 2, 0, 1, DEFAULT, NULL)";
        $conn ->exec($insert_access_level);

        //Table page_access_level
        $sql_page_access_level = "CREATE TABLE `page_access_level` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `al_id` int(11) NOT NULL,
          `page_id` int(11) NOT NULL,
          `access` tinyint(1) DEFAULT 0,
          `menu` tinyint(1) DEFAULT 0,
          `created` timestamp NOT NULL DEFAULT current_timestamp(),
          `modified` timestamp NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          FOREIGN KEY (`al_id`) REFERENCES access_level (`id`),
          FOREIGN KEY (`page_id`) REFERENCES pages (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $conn ->exec($sql_page_access_level);
        $insert_page_access_level = "INSERT INTO `page_access_level` (`id`, `al_id`, `page_id`, `access`, `menu`, `created`, `modified`) VALUES
        (1, 1, 1, 1, 1, DEFAULT, NULL),
        (2, 1, 2, 1, 1, DEFAULT, NULL),
        (3, 1, 3, 1, 0, DEFAULT, NULL),
        (4, 1, 4, 1, 0, DEFAULT, NULL),
        (5, 1, 5, 1, 0, DEFAULT, NULL),
        (6, 1, 6, 1, 0, DEFAULT, NULL),
        (7, 1, 7, 1, 0, DEFAULT, NULL),
        (8, 1, 8, 1, 1, DEFAULT, NULL),
        (9, 1, 9, 1, 0, DEFAULT, NULL),
        (10, 1, 10, 1, 0, DEFAULT, NULL),
        (11, 1, 11, 1, 0, DEFAULT, NULL),
        (12, 1, 12, 1, 0, DEFAULT, NULL),
        (13, 1, 13, 1, 0, DEFAULT, NULL),
        (14, 1, 14, 1, 0, DEFAULT, NULL),
        (15, 1, 15, 1, 0, DEFAULT, NULL),
        (16, 1, 16, 1, 0, DEFAULT, NULL),
        (17, 1, 17, 1, 1, DEFAULT, NULL),
        (18, 1, 18, 1, 0, DEFAULT, NULL),
        (19, 1, 19, 1, 0, DEFAULT, NULL),
        (20, 1, 20, 1, 0, DEFAULT, NULL),
        (21, 1, 21, 1, 0, DEFAULT, NULL),
        (22, 1, 22, 1, 0, DEFAULT, NULL),
        (23, 1, 23, 1, 0, DEFAULT, NULL),
        (24, 1, 24, 1, 0, DEFAULT, NULL),
        (25, 1, 25, 1, 1, DEFAULT, NULL),
        (26, 2, 1, 1, 1, DEFAULT, NULL),
        (27, 2, 2, 0, 0, DEFAULT, NULL),
        (28, 2, 3, 0, 0, DEFAULT, NULL),
        (29, 2, 4, 0, 0, DEFAULT, NULL),
        (30, 2, 5, 0, 0, DEFAULT, NULL),
        (31, 2, 6, 0, 0, DEFAULT, NULL),
        (32, 2, 7, 0, 0, DEFAULT, NULL),
        (33, 2, 8, 0, 0, DEFAULT, NULL),
        (34, 2, 9, 0, 0, DEFAULT, NULL),
        (35, 2, 10, 0, 0, DEFAULT, NULL),
        (36, 2, 11, 0, 0, DEFAULT, NULL),
        (37, 2, 12, 0, 0, DEFAULT, NULL),
        (38, 2, 13, 0, 0, DEFAULT, NULL),
        (39, 2, 14, 0, 0, DEFAULT, NULL),
        (40, 2, 15, 0, 0, DEFAULT, NULL),
        (41, 2, 16, 0, 0, DEFAULT, NULL),
        (42, 2, 17, 0, 0, DEFAULT, NULL),
        (43, 2, 18, 0, 0, DEFAULT, NULL),
        (44, 2, 19, 1, 0, DEFAULT, NULL),
        (45, 2, 20, 1, 0, DEFAULT, NULL),
        (46, 2, 21, 0, 0, DEFAULT, NULL),
        (47, 2, 22, 1, 0, DEFAULT, NULL),
        (48, 2, 23, 0, 0, DEFAULT, NULL),
        (49, 2, 24, 1, 0, DEFAULT, NULL),
        (50, 2, 25, 1, 1, DEFAULT, NULL)";
        $conn ->exec($insert_page_access_level);

        //Table users
        $sql_users = "CREATE TABLE `users` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `name` varchar(220) NOT NULL,
          `email` varchar(220) DEFAULT NULL UNIQUE ,
          `cell_phone` varchar(11) DEFAULT NULL,
          `user_name` varchar(20) NOT NULL UNIQUE,
          `user_password` varchar(220) NOT NULL,
          `password_recover` varchar(220) DEFAULT NULL,
          `situation` tinyint(1) DEFAULT 1,
          `access_level` int(11) NOT NULL,
          `created` timestamp NOT NULL DEFAULT current_timestamp(),
          `modified` timestamp NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          FOREIGN KEY (`access_level`) REFERENCES access_level (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $conn ->exec($sql_users);
        $insert_users ="INSERT INTO `users` (`id`, `name`, `email`, `cell_phone`, `user_name`, `user_password`, `password_recover`, `situation`, `access_level`, `created`, `modified`) VALUES
(1, 'system admin', 'suporte@nmatec.com.br', '83993348144', 'root', '$2y$10\$r2s9nIM3PUimirknEP19huOz0jWnMuWE8BBcyLiK061jtkOsNmSSe', NULL, 1, 1, DEFAULT, NULL)";
        $conn ->exec($insert_users);

        header("Location: ../index.php");

    } catch (PDOException $e){
        echo $e ->getMessage();
    }
    $conn = null;
}

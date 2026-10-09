<?php

require_once __DIR__ . "/connection.php";

$DB = connection();


$DB->exec("CREATE TABLE IF NOT EXISTS students(
id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
first_name VARCHAR(255) NOT NULL, 
last_name VARCHAR(255) NOT NULL, 
email VARCHAR(255) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
age INT NOT NULL,
phone VARCHAR(255) NOT NULL UNIQUE
);");
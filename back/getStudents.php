<?php

function getStudents(string $search = "", int $page = 1)
{
  require_once __DIR__ . "/helpers.php";
  require_once __DIR__ . "/../database/connection.php";

  $DB = connection();

  $offset = ($page * 10) - 10;

  $stmt = $DB->query("SELECT * FROM students
          WHERE CONCAT(first_name , ' ' , last_name) LIKE '%{$search}%' 
          OR email LIKE '%{$search}%' 
          OR age LIKE '%{$search}%' 
          OR phone LIKE '%{$search}%'
          LIMIT 10 OFFSET {$offset} ;");

  $result = $stmt->fetchAll();

  return $result;
}

function getStudentsCount(string $search = ""){
  $DB = connection();
  $stmt = $DB->query("SELECT COUNT(*) AS total FROM students
          WHERE first_name LIKE '%{$search}%' 
          OR last_name LIKE '%{$search}%' 
          OR email LIKE '%{$search}%' 
          OR age LIKE '%{$search}%' 
          OR phone LIKE '%{$search}%';");
  $result = $stmt->fetch();
  return $result['total'];
}
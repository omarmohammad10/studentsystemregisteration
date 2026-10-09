<?php

session_start();

require_once __DIR__ . "/../database/connection.php";

if ($_SERVER['REQUEST_METHOD'] !== "GET") {
  throwError(405, "Method is not allowed");
}

if (!isset($_GET['student_id'])) {
  throwError(422, "Unprocessable Entity");
}

if (empty($_SESSION['_errors'])) {
  $DB = connection();



  $stmt = $DB->query("SELECT id, first_name as firstName,
last_name as lastName , email , age , phone
FROM students WHERE id = '{$_GET['student_id']}'");

  $student = $stmt->fetch();

  if(empty($student)){
    throwError(422, "Id does not exist");
  }

  $_SESSION['_old'] = $student;
}

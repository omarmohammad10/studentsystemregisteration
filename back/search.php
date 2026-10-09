<?php

require_once __DIR__ . "/getStudents.php";
require_once __DIR__ . "/helpers.php";

header('Content-Type: application/json; charset=UTF-8');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
  throwAPIError(405 , "Method is not allowed");
}

if(!isset($_POST['search'])){
  throwAPIError(422 , "Unprocessable Entity");
}


$page = (isset($_POST['page'])) ? $_POST['page'] : 1;
$students = getStudents($_POST['search'],$page);
$totalStudents = getStudentsCount($_POST['search']);



echo json_encode([
  'students' => $students,
  'total' => $totalStudents,
  'page' => $page
]);
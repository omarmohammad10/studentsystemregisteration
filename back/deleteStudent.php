<?php

require_once __DIR__ . "/helpers.php";
require_once __DIR__ . "/../database/connection.php";

header('Content-Type: application/json, charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
  throwAPIError(405, "Method is not allowed");
}

if (!isset($_POST['student_id'])) {
  throwAPIError(422, "Unprocessable Entity");
}

$DB = connection();

$DB->exec("DELETE FROM students WHERE id = '{$_POST['student_id']}';");

throwAPIError(200,"Done");
<?php

require_once __DIR__ . "/../database/connection.php";

function validate()
{
  foreach ($_POST as $field => $value) {
    validateRequired($field, $value);
    if ($field == 'email') {
      validateEmail($field, $value);
      validateUnique($field, $value, 'students');
    } else if ($field == 'phone') {
      validateEGPhone($field, $value);
      validateUnique($field, $value, 'students');
    } else if ($field == 'age') {
      validateAge($field, $value);
    }
  }
  if (!empty($_SESSION['_errors'])) {
    // pr($_SESSION['_errors']);
    // throwError(422, "Unprocessable Entity");
    // pr($_POST, true);

    back();
  }
}

function editValidate()
{
  foreach ($_POST as $field => $value) {
    if ($field != 'password') {
      validateRequired($field, $value);
    }

    if ($field == 'email') {
      validateEmail($field, $value);
      validateUnique($field, $value, 'students', $_POST['student_id']);
    } else if ($field == 'phone') {
      validateEGPhone($field, $value);
      validateUnique($field, $value, 'students', $_POST['student_id']);
    } else if ($field == 'age') {
      validateAge($field, $value);
    }
  }

  if (!empty($_SESSION['_errors'])) {
    // pr($_SESSION['_errors']);
    // throwError(422, "Unprocessable Entity");
    back();
  }
}

function validateRequired(string $field, mixed $value)
{
  if ($value === null || trim((string)$value) === "") {
    addError($field, "{$field} is required");
  }
}

function addError(string $field, mixed $msg)
{
  $_SESSION['_errors'][$field][] = $msg;
}

function validateEmail(string $field, mixed $value)
{
  if (empty($value)) {
    return;
  }

  $regex = "/^[A-Za-z_][A-Za-z_0-9\-\.]+@(gmail|yahoo)\.(com|org)$/";

  if (!preg_match($regex, $value)) {
    addError($field, "{$field} is invalid");
  }
}

function validateEGPhone(string $field, mixed $value)
{
  if (empty($value)) {
    return;
  }

  $regex = "/^(02)?01(0|1|2|5)[0-9]{8}$/";

  if (!preg_match($regex, $value)) {
    addError($field, "{$field} is must be valid egyptian phone");
  }
}


function validateAge(string $field, mixed $value)
{
  if (empty($value)) {
    return;
  }

  $regex = "/^[0-9]{1,2}$/";

  if (!preg_match($regex, $value)) {
    addError($field, "{$field} is invalid");
  }
}

function validateUnique(string $field, mixed $value, string $tableName, ?int $exceptId = null)
{
  if (empty($value)) {
    return;
  }

  $DB = connection();

  $subQuery = "";

  if ($exceptId !== null) {
    $subQuery = "AND id != '{$exceptId}'";
  }

  $stmt = $DB->query("SELECT * FROM {$tableName} WHERE {$field} = '{$value}' 
  {$subQuery};");

  $result = $stmt->fetchAll();

  if (!empty($result)) {
    addError($field, "{$field} already exists");
  }
}

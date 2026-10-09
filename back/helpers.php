<?php

function pr(mixed $data, bool $die = false)
{
  echo "<pre>";
  print_r($data);
  echo "</pre>";
  if ($die) {
    exit;
  }
}

function throwError(int $code, string $msg = "")
{
  http_response_code($code);
  echo $msg;
  exit;
}

function throwAPIError(int $code, string $msg = "")
{
  http_response_code($code);
  echo json_encode([
    "status" => $code,
    "message" => $msg
  ]);
  exit;
}


function back()
{
  $path = $_SERVER['HTTP_REFERER'];
  header("Location: {$path}");
  exit;
}

function getError(string $key)
{
  $htmlErr = "";
  if (isset($_SESSION['_errors'][$key])) {
    $htmlErr = "<p class='alert alert-danger mt-2'>{$_SESSION['_errors'][$key][0]}</p>";
    unset($_SESSION['_errors'][$key]);
  }
  return $htmlErr;
}

function old(string $key)
{
  $oldValue = $_SESSION['_old'][$key] ?? '';
  unset($_SESSION['_old'][$key]);
  return $oldValue;
}

<?php

function connection(): PDO
{
  // $DSN = "mysql:host=fdb1028.awardspace.net;dbname=4787223_omartest2";
  // $USERNAME = "4787223_omartest2";
  // $PASSWORD = "OOOO4231200598#";
  $DSN = "mysql:host=localhost;dbname=register";
  $USERNAME = "root";
  $PASSWORD = "";
  try {
    $DB = new PDO($DSN, $USERNAME, $PASSWORD);
    $DB->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "Connection Failed: {$e->getMessage()}";
    exit;
  }
  return $DB;
}

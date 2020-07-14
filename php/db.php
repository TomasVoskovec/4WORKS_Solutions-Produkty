<?php
define("dbserver", "sql.endora.cz:3311");
define("dbuser", "tomasv1594312519");
define("dbpass", "SminU7O2");
define("dbname", "tomasv1594312519");

global $db;
$db = new PDO(
  "mysql:host=" .dbserver. ";dbname=" .dbname,dbuser,dbpass,
  array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8",
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  )
);
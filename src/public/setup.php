<?php
namespace MHorwood\Dashboard;
use PhpOrm\Configuration;
use PhpOrm\Connection;

require __DIR__ . '/../../vendor/autoload.php';
require_once('../config/config.php');

$database = include '../config/database.php';

$opts = $database['default'];

$configuration = new Configuration(
    $opts['username'],
    $opts['password'],
    $opts['database'],
    $opts['host'],
    $opts['port'],
    $opts['driver'],
    $opts['charset'],
    $opts['collation']);
$connection = new Connection($configuration);
$dbh = $connection->getDbh();

$params = array();
$statement = 'show tables';
$sth = $dbh->prepare($statement);
if (!$sth) {
   echo "This errored";
}
if (!$sth->execute($params)) {
   echo "This errored";
}

echo "Start of setup, do we need to build tables?"."<br>\n";

if($sth->fetch(\PDO::FETCH_ASSOC) === false){
  echo ' - we sure do need to make tables'."<br>\n";
  echo ' - make app table'."<br>\\n";
  $statement = 'CREATE TABLE `apps`
    (`id` INTEGER PRIMARY KEY AUTO_INCREMENT,
     `name` VARCHAR(255) NOT NULL,
     `url` VARCHAR(255) NOT NULL,
     `icon` VARCHAR(255) NOT NULL DEFAULT \'cancel\',
     `isPinned` TINYINT DEFAULT 0,
     `createdAt` DATETIME NOT NULL,
     `updatedAt` DATETIME NOT NULL,
     `orderId` INTEGER DEFAULT NULL,
     `isPublic` INTEGER DEFAULT 1,
     `description` VARCHAR(255) NOT NULL DEFAULT \'\'
    )';
  $sth = $dbh->prepare($statement);
  if (!$sth) {
     echo "This errored";
  }
  if (!$sth->execute($params)) {
     echo "This errored";
  }
  echo ' - make bookmarks table'."<br>\n";
  $statement = 'CREATE TABLE `bookmarks`
    (`id` INTEGER PRIMARY KEY AUTO_INCREMENT,
     `name` VARCHAR(255) NOT NULL,
     `url` VARCHAR(255) NOT NULL,
     `categoryId` INTEGER NOT NULL,
     `icon` VARCHAR(255) DEFAULT \'\',
     `createdAt` DATETIME NOT NULL,
     `updatedAt` DATETIME NOT NULL,
     `isPublic` INTEGER DEFAULT 1,
     `orderId` INTEGER DEFAULT NULL
    )';
  $sth = $dbh->prepare($statement);
  if (!$sth) {
     echo "This errored";
  }

  if (!$sth->execute($params)) {
     echo "This errored";
  }
  echo ' - make categories table'."<br>\n";
  $statement = 'CREATE TABLE `categories`
    (`id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  	 `name` VARCHAR(255) NOT NULL,
  	 `isPinned` TINYINT DEFAULT 0,
  	 `createdAt` DATETIME NOT NULL,
  	 `updatedAt` DATETIME NOT NULL,
  	 `orderId` INTEGER DEFAULT NULL,
  	 `isPublic` INTEGER DEFAULT 1
    )';
  $sth = $dbh->prepare($statement);
  if (!$sth) {
     echo "This errored";
  }

  if (!$sth->execute($params)) {
     echo "This errored";
  }
  echo 'All tables have been created, now onto the main event'."<br>\n";
}else{
  echo "setup is complete, you can go to the main site now"."<br>\n";
}
echo '<a href="/">main site</a>';

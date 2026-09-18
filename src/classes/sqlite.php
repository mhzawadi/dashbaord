<?php

namespace MHorwood\Dashboard\classes;

class sqlite {

  protected $pdo;
  public function __construct(){
    if(file_exists('../../user_data/database.sqlite') === false){
      $create = true;
    }else{
      $create = false;
    }
    $db = '../../user_data/database.sqlite';
    $dsn = "sqlite:$db";
    try {
      $this->pdo = new \PDO($dsn);
      if($create === true){
        error_log("Building new database", 0);
        $statements = [
          'CREATE TABLE "applications" (
          "id"	INTEGER NOT NULL UNIQUE,
          "name"	TEXT NOT NULL,
          "url"	TEXT,
          "icon"	TEXT,
          "description"	TEXT,
          "isPublic"	INTEGER,
          "createdAt"	TEXT NOT NULL,
          "updatedAt"	TEXT NOT NULL,
          "orderId"	INTEGER,
          PRIMARY KEY("id" AUTOINCREMENT)
        )',
        'CREATE TABLE "bookmarks" (
          "id"	INTEGER NOT NULL UNIQUE,
          "categoryId"	INTEGER NOT NULL,
          "name"	TEXT NOT NULL,
          "url"	TEXT,
          "icon"	TEXT,
          "isPublic"	INTEGER NOT NULL,
          "createdAt"	TEXT NOT NULL,
          "updatedAt"	TEXT NOT NULL,
          "orderId"	INTEGER NOT NULL,
          PRIMARY KEY("id" AUTOINCREMENT)
        )',
        'CREATE TABLE "categorys" (
          "id"	INTEGER NOT NULL UNIQUE,
          "name"	TEXT NOT NULL,
          "isPublic"	INTEGER,
          "createdAt"	TEXT NOT NULL,
          "updatedAt"	TEXT NOT NULL,
          "orderId"	INTEGER,
          PRIMARY KEY("id" AUTOINCREMENT)
        )'];
        foreach($statements as $statement){
          $this->pdo->exec($statement);
        }
      }
    } catch (\PDOException $e) {
      echo $e->getMessage();
    }
  }
  /*
  load a file and load to array
  */
  protected function load_from_file($database, $json, $sort = ''){
    $stmt = $this->pdo->query('SELECT * FROM ' . $database . ' order by '.$sort);
    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
      $myjson[$json][] = $row;
    }
    if(!isset($myjson)){
      $myjson[$json] = array();
    }
    return $myjson;
  }

  /*
  Save a json blob to file
  */
  protected function save_to_file($sql, $array){
    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute($array);
      return $this->pdo->lastInsertId();
    } catch (\Exception $e) {
      echo 'that didnt work';
      print_pre($e);
      exit;
      return false;
    }
  }
  /*
  Run a query
  */
  protected function query($sql, $array = array()){
    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute($array);
      while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        $rows[] = $row;
      }
      if(!isset($rows)){
        $rows = array();
      }
      return $rows;
    } catch (\Exception $e) {
      echo 'that didnt work';
      return false;
    }
  }
}

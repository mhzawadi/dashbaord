<?php

namespace MHorwood\Dashboard\classes;

class sqlite {

  protected object $pdo;

  /**
   * Construct function
   * used to build the object and connect to the database
   * @return void
   */
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

  /**
   * Load data from the database and into an array
   *
   * @param string $table The table to query
   * @param string $json The part of the json array to add the data to
   * @param string $sort How to sort the data from the database
   * @return array The data from the database
  */
  protected function load_from_file($table, $json, $sort = ''){
    $stmt = $this->pdo->query('SELECT * FROM ' . $table . ' order by '.$sort);
    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
      $myjson[$json][] = $row;
    }
    if(!isset($myjson)){
      $myjson[$json] = array();
    }
    return $myjson;
  }

  /**
   * Save a json blob to file
   *
   * @param string $sql The pre-prepare SQL to insert into the database
   * @param string $array The data to store in the database
   * @return int|bool if the query was sucessful the row ID is return, false otherwise
   **/
  protected function save_to_file($sql, $array){
    try {
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute($array);
      return $this->pdo->lastInsertId();
    } catch (\Exception $e) {
      echo 'that didnt work';
      return false;
    }
  }

  /**
   * Run a query
   * @param string $sql The pre-prepare SQL to insert into the database
   * @param string $array The data to store in the database
   * @return int|bool if the query was sucessful the row ID is return, false otherwise
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

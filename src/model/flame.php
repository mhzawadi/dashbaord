<?php
namespace MHorwood\Dashboard\model;
use MHorwood\Dashboard\model\application;
use MHorwood\Dashboard\model\bookmark;

class flame {

  protected $db;

  public function __construct(){
    $this->db = new \SQLite3('../config/db.sqlite');
  }

  function import_apps($apps){
    $results = $this->db->query('SELECT * FROM apps');
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
      $apps->flame_import($row);
    }
  }
  function import_categories($bks){
    $results = $this->db->query('SELECT * FROM categories');
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
      $bks->flame_import_category($row);
    }
  }
  function import_bookmarks($bks){
    $results = $this->db->query('select c.name as cname, b.name, b.icon, b.url, b.isPublic, b.categoryId from bookmarks b
  left join categories c on b.categoryId = c.id');
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
      $bks->flame_import_bookmarks($row);
    }
  }
}

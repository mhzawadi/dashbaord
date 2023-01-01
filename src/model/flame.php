<?php
namespace MHorwood\Dashboard\Model;
use MHorwood\Dashboard\Model\application;
use MHorwood\Dashboard\Model\bookmark;

class flame {

  protected $apps;
  protected $bks;
  protected $db;

  public function __construct(){
    $this->apps = new application();
    $this->bks = new bookmark();
    $this->db = new \SQLite3('../config/db.sqlite');
  }

  function import_apps(){
    $results = $this->db->query('SELECT * FROM apps');
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
      $this->apps->flame_import($row);
    }
  }
  function import_categories(){
    $results = $this->db->query('SELECT * FROM categories');
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
      $this->bks->flame_import_category($row);
    }
  }
  function import_bookmarks(){
    $results = $this->db->query('select c.name as cname, b.name, b.icon, b.url, b.isPublic, b.categoryId from bookmarks b
  left join categories c on b.categoryId = c.id');
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
      $this->bks->flame_import_bookmarks($row);
    }
  }
}

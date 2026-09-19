<?php
namespace MHorwood\Dashboard\model;
use MHorwood\Dashboard\model\application;
use MHorwood\Dashboard\model\bookmark;

class flame {

  protected $db;

  public function __construct(){
    $this->db = new \SQLite3('../../user_data/db.sqlite');
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
    $results = $this->db->query('select
      c.name as cname,
      b.name,
      b.icon,
      b.url,
      b.isPublic,
      b.categoryId,
      b.orderId,
      b.createdAt,
      b.updatedAt
    from bookmarks b
      left join categories c on b.categoryId = c.id');
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
      $bks->flame_import_bookmarks($row);
    }
  }
  public function flame_import($flame_db){
    $store = true;
    foreach($this->app_list['apps'] as $key => $app){
      if( ($app['name'] == $flame_db['name']) && ($this->remove_http($app['url']) == $this->remove_http($flame_db['url'])) ){
        $store = false;
      }
    }
    if($store === true){
      if(isset($flame_db['icon'])){
        $icon = $flame_db['icon'];
      }else{
        $icon = 'mdi:fire';
      }
      $this->insert_application(array(
        'name' => $flame_db['name'],
        'url' => $flame_db['url'],
        'icon' => $icon,
        'description' => $flame_db['name'],
        'isPublic' => $flame_db['isPublic'],
        'orderId' => $flame_db['orderId'],
        'createdAt' => $flame_db['createdAt'],
        'updatedAt' => $flame_db['updatedAt'],
        'app_proto' => 'http',
      ));
    }
  }
  public function flame_import_category($flame_db){
    $store = false;
    foreach($this->bookmarks_list['categorys'] as $key => $category){
      if( ($category['name'] == $flame_db['name']) ){
        $store = true;
      }
    }
    if($store === false){
      $this->insert_category(array(
        'name' => $flame_db['name'],
        'isPublic' => 1,
        'orderId' => $flame_db['orderId'],
        'createdAt' => $flame_db['createdAt'],
        'updatedAt' => $flame_db['updatedAt']
      ));
    }
  }
  public function flame_import_bookmarks($flame_db){
    $store = false;
    foreach($this->bookmarks_list['categorys'] as $key => $category){
      if($category['name'] == $flame_db['cname']){
        $categoryID = $key;
      }
      foreach($category['bookmarks'] as $bkey => $bookmark){
        if( ($bookmark['name'] == $flame_db['name']) && ($bookmark['url'] == $flame_db['url']) ){
          $store = true;
        }
      }
    }
    if($store === false){
      if( (strpos($flame_db['icon'], '.jpg') === false) &&
          (strpos($flame_db['icon'], '.jpeg') === false) &&
          (strpos($flame_db['icon'], '.png') === false) &&
          (strpos($flame_db['icon'], '.svg') === false) &&
          (strpos($flame_db['icon'], '.ico') === false) ){
        $flame_db['icon'] = 'mdi:'.$flame_db['icon'];
      }
      $this->insert_bookmark($categoryID, array(
        'name'=>$flame_db['name'],
        'url'=>$flame_db['url'],
        'icon'=>$flame_db['icon'],
        'categoryId'=>$categoryID,
        'isPublic'=>$flame_db['isPublic'],
        'orderId'=>$flame_db['orderId'],
        'createdAt' => $flame_db['createdAt'],
        'updatedAt' => $flame_db['updatedAt']
      ));
    }
  }
}


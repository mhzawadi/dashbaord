<?php
namespace MHorwood\Dashboard\model;
use MHorwood\Dashboard\model\application;
use MHorwood\Dashboard\model\bookmark;

class flame {

  protected $db;
  protected $c_application;
  protected $c_bookmark;

  /**
   * undocumented function summary
   *
   * Undocumented function long description
   *
   * @param type var Description
   * @return return type
   */
  public function __construct($sorting){
    $this->db = new \SQLite3('../../user_data/db.sqlite');
    $this->c_application = new application($sorting);
    $this->c_bookmark = new bookmark($sorting);
    $this->import_apps();
    $this->import_categories();
    rename('../../user_data/db.sqlite', '../../user_data/db.sqlite.old');
  }

  /**
   * undocumented function summary
   *
   * Undocumented function long description
   *
   * @param type var Description
   * @return return type
   */
  protected function import_apps(){
    $apps = $this->c_application->get_list();
    $results = $this->db->query('SELECT name,url,icon,description,isPublic,createdAt,updatedAt,orderId FROM apps');
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
      $store = true;
      foreach($this->c_application->get_list() as $key => $app){
        if( ($app['name'] == $row['name']) && ($this->remove_http($app['url']) == $this->remove_http($row['url'])) ){
          $store = false;
        }
      }
      if($store === true){
        if(strpos($row['url'], 'http') === false){
          $row['app_proto'] = 'http';
        }else{
          $row['app_proto'] = 'https';
        }
        if(strpos($row['icon'], '.png') === false || strpos($app['icon'], '.jpg') === false){
          $row['icon'] = 'mdi:'.$row['icon'];
        }
        $this->c_application->insert_application($row);
      }
    }
  }

  /**
   * undocumented function summary
   *
   * Undocumented function long description
   *
   * @param type var Description
   * @return return type
   */
  protected function remove_http($string){
    $replace = array('http://', 'https://', 'http-', 'https-', '://');
    return str_replace($replace, '', $string);
  }

  /**
   * undocumented function summary
   *
   * Undocumented function long description
   *
   * @param type var Description
   * @return return type
   */
  protected function import_categories(){
    $results = $this->db->query('SELECT id,name,isPublic,createdAt,updatedAt,orderId FROM categories');
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
      if(count($this->c_bookmark->get_category($row['name'])) == 0){
        $this->c_bookmark->insert_category($row);
      }
      $search_category = $this->c_bookmark->get_category($row['name']);
      $this->import_bookmarks($row['id'], $search_category[0]['id']);
    }
  }

  /**
   * undocumented function summary
   *
   * Undocumented function long description
   *
   * @param type var Description
   * @return return type
   */
  protected function import_bookmarks($row_id, $categoryId){
    $results = $this->db->query('select
      name,
      icon,
      url,
      isPublic,
      categoryId,
      orderId,
      createdAt,
      updatedAt
    from bookmarks
    WHERE categoryId = '.$row_id);
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
      $search_bookmark = $this->c_bookmark->get_bookamrk($row['name']);
      if(count($search_bookmark) < 1){
        if(strpos($row['icon'], '.png') === false || strpos($row['icon'], '.jpg') === false){
          $row['icon'] = 'mdi:'.$row['icon'];
        }
        $row['categoryId'] = $categoryId;
        $this->c_bookmark->insert_bookmark($categoryId, $row);
      }
    }
  }
}

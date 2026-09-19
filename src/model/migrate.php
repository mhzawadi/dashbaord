<?php
namespace MHorwood\Dashboard\model;
use MHorwood\Dashboard\classes\json;
use MHorwood\Dashboard\model\application;
use MHorwood\Dashboard\model\bookmark;

class migrate extends json{

  public function __construct($sorting){
    $c_application = new application($sorting);
    $c_bookmark = new bookmark($sorting);

    if( file_exists('../../user_data/apps.json') ){
      $apps = $this->load_from_file('../../user_data/apps.json');
      foreach($apps['apps'] as $key => $app){
        if(strpos($app['url'], 'http') === false){
          $app['app_proto'] = 'http';
        }else{
          $app['app_proto'] = 'https';
        }
        $app['url'] = $this->set_http($app['url']);
        $c_application->insert_application($app);
      }
      rename('../../user_data/apps.json', '../../user_data/apps.json.old');
    }
    if( file_exists('../../user_data/bookmarks.json') ){
      $f_bookmarks = $this->load_from_file('../../user_data/bookmarks.json');
      foreach($f_bookmarks['categorys'] as $c_key => $category){
        $search_category = $c_bookmark->get_category($category['name']);
        if(count($search_category) < 1){
          $categoryId = $c_bookmark->insert_category($category);
          $search_category = $c_bookmark->get_category($category['name']);
        }
        $categoryId = $search_category[0]['id'];
        foreach($f_bookmarks['categorys'][$c_key]['bookmarks'] as $key => $bookmark){
          $search_bookmark = $c_bookmark->get_bookamrk($bookmark['name']);
          $bookmark['categoryId'] = $categoryId;
          if(count($search_bookmark) < 1){
            $c_bookmark->insert_bookmark($categoryId, $bookmark);
          }
        }
      }
      rename('../../user_data/bookmarks.json', '../../user_data/bookmarks.json.old');
    }
  }
  protected function set_http($string){
    $replace = array('http-', 'https-');
    $with = array('http://', 'https://');
    return str_replace($replace, $with, $string);
  }
}

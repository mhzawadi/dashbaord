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
        $categoryId = $c_bookmark->insert_category($category);
        foreach($f_bookmarks['categorys'][$c_key]['bookmarks'] as $key => $bookmark){
          $bookmark['categoryId'] = $categoryId;
          $c_bookmark->insert_bookmark($categoryId, $bookmark);
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

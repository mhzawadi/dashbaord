<?php
namespace MHorwood\Dashboard\model;
use MHorwood\Dashboard\classes\json;
use MHorwood\Dashboard\model\application;
use MHorwood\Dashboard\model\bookmark;

class migrate extends json{

  public function __construct($sorting){
    $application = new application($sorting);
    $bookmark = new bookmark($sorting);

    if( file_exists('../../user_data/apps.json') ){
      $apps = $this->load_from_file('../../user_data/apps.json');
      foreach($apps['apps'] as $key => $app){
        if(strpos($app['url'], 'http') === false){
          $app['app_proto'] = 'http';
        }else{
          $app['app_proto'] = 'https';
        }
        $app['url'] = $this->set_http($app['url']);
        $application->insert_application($app);
      }
      rename('../../user_data/apps.json', '../../user_data/apps.json.old');
    }
    if( file_exists('../../user_data/bookmarks.json') ){
      echo 'migrate from json to sqlite';
    }
  }
  protected function set_http($string){
    $replace = array('http-', 'https-');
    $with = array('http://', 'https://');
    return str_replace($replace, $with, $string);
  }
}

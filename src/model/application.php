<?php
namespace MHorwood\Dashboard\model;
use MHorwood\Dashboard\classes\json;

class application extends json {

  protected $app_list;

  public function __construct(){
    if(file_exists('../config/settings.json') === false){
      $this->app_list = $this->load_from_file('../../data/apps.json');
      $this->save_to_file('../config/apps.json', $this->app_list);
    }else{
      $this->app_list = $this->load_from_file('../config/apps.json');
    }
  }

  public function get_list(){
    return $this->app_list['apps'];
  }

  public function update_application($applicationID, $args){
    $this->app_list['apps'][$applicationID]['name'] = $args['name'];
    $this->app_list['apps'][$applicationID]['url'] = $this->set_http($args['url']);
    $this->app_list['apps'][$applicationID]['icon'] = $args['icon'];
    $this->app_list['apps'][$applicationID]['description'] = $args['description'];
    $this->app_list['apps'][$applicationID]['isPublic'] = $args['isPublic'];
    $this->app_list['apps'][$applicationID]['updatedAt'] = date('Y-m-d H:i:s');
    $this->save_to_file('../config/apps.json', $this->app_list);
  }
  public function insert_application($args){
    $data = array(
      'name'=>$args['name'],
      'url'=>$this->set_http($args['url']),
      'icon'=>$args['icon'],
      'description'=>$args['description'],
      'isPublic'=>$args['isPublic'],
      'createdAt'=>date('Y-m-d H:i:s'),
      'updatedAt'=>date('Y-m-d H:i:s')
    );
    $this->app_list['apps'][] = $data;
    $this->save_to_file('../config/apps.json', $this->app_list);
  }

  public function delete_application($applicationID){
    unset($this->app_list['apps'][$applicationID]);
    $this->save_to_file('../config/apps.json', $this->app_list);
  }

  public function store_docker($docker_apps){
    foreach ($docker_apps as $dkey => $dvalue) {
      $store = true;
      if(isset($dvalue['enable']) && $dvalue['enable'] === false){
        $store = false;
      }elseif(isset($dvalue['url']) === false){
        $store = false;
      }else{
        foreach($this->app_list['apps'] as $key => $app){
          if( ($app['name'] == $dvalue['name']) && ($this->remove_http($app['url']) == $dvalue['url']) ){
            $store = false;
          }
        }
      }
      if($store === true){
        $this->insert_application(array(
          'name' => $dvalue['name'],
          'url' => $dvalue['url'],
          'icon' => 'mdi:docker',
          'description' => $dvalue['name'],
          'isPublic' => 1
        ));
      }
    }
  }

  public function flame_import($flame_db){
    $store = true;
    foreach($this->app_list['apps'] as $key => $app){
      if( ($app['name'] == $flame_db['name']) && ($app['url'] == $flame_db['url']) ){
        $store = false;
      }
    }
    if($store === true){
      $this->insert_application(array(
        'name' => $flame_db['name'],
        'url' => $flame_db['url'],
        'icon' => 'mdi:fire',
        'description' => $flame_db['name'],
        'isPublic' => $flame_db['isPublic']
      ));
    }
  }

  protected function set_http($string){
    if(strpos($string, 'http://') !== false){
      return "$string";
    }elseif(strpos($string, 'https://') !== false){
      return "$string";
    }else{
      return "http://$string";
    }
  }

  protected function remove_http($string){
    $replace = array('http://', 'https://');
    return str_replace($replace, '', $string);
  }
}

<?php
namespace MHorwood\Dashboard\model;
use MHorwood\Dashboard\classes\json;

class application extends json {

  protected $app_list;
  protected $sorting;

  public function __construct($sorting){
    $this->sorting = $sorting;
    if(file_exists('../config/settings.json') === false){
      $this->app_list = $this->load_from_file('../../data/apps.json');
      $this->save_to_file('../config/apps.json', $this->app_list);
    }else{
      $this->app_list = $this->load_from_file('../config/apps.json');
    }
    // $this->sort();
  }

  public function get_list(){
    return $this->app_list['apps'];
  }
  public function set_sorting($sorting){
    if($sorting == 'createdAt'){
      $this->sort_by_date();
    }elseif($sorting == 'name'){
      $this->sort_by_name();
    }elseif($sorting == 'orderId'){
      $this->sort_by_orderID();
    }
    $this->save_to_file('../config/apps.json', $this->app_list);
  }

  public function update_application($applicationID, $args){
    $sorting = false;
    if(!isset($args['orderId'])){
      $args['orderId'] = 1;
    }
    if($args['orderId'] != $this->app_list['apps'][$applicationID]['orderId']){
      $sorting = true;
    }
    $this->app_list['apps'][$applicationID]['name'] = $args['name'];
    $this->app_list['apps'][$applicationID]['url'] = $this->store_http($args['url']);
    $this->app_list['apps'][$applicationID]['icon'] = $args['icon'];
    $this->app_list['apps'][$applicationID]['description'] = $args['description'];
    $this->app_list['apps'][$applicationID]['isPublic'] = $args['isPublic'];
    $this->app_list['apps'][$applicationID]['updatedAt'] = date('Y-m-d H:i:s');
    $this->app_list['apps'][$applicationID]['orderId'] = $args['orderId'];
    if($sorting === true){
      $this->set_sorting($this->sorting);
    }else{
      $this->save_to_file('../config/apps.json', $this->app_list);
    }
  }
  public function insert_application($args){
    $last = count($this->app_list['apps']);
    if(!isset($args['orderId'])){
      $args['orderId'] = $last++;
    }
    if(!isset($args['createdAt'])){
      $args['createdAt'] = date('Y-m-d H:i:s');
    }
    if(!isset($args['updatedAt'])){
      $args['updatedAt'] = date('Y-m-d H:i:s');
    }
    $data = array(
      'name'=>$args['name'],
      'url'=>$this->store_http($args['url']),
      'icon'=>$args['icon'],
      'description'=>$args['description'],
      'isPublic'=>$args['isPublic'],
      'createdAt'=>$args['createdAt'],
      'updatedAt'=>$args['updatedAt'],
      'orderId'=>$args['orderId']
    );
    $this->app_list['apps'][] = $data;
    $this->save_to_file('../config/apps.json', $this->app_list);
  }

  public function delete_application($applicationID){
    $this->app_list['apps'][$applicationID]['name'] = '00DELETEME00';
    $this->sort_by_name();
    array_shift($this->app_list['apps']);
    $this->save_to_file('../config/apps.json', $this->app_list);
  }
  public function order_application($applications_json){
    $applications = json_decode($applications_json, true);
    foreach ($applications as $key => $value) {
      $this->app_list['apps'][$value['appId']]['orderId'] = $value['orderId'];
    }
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
          if( ($app['name'] == $dvalue['name']) && ($this->remove_http($app['url']) == $this->remove_http($dvalue['url'])) ){
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
          'isPublic' => 1,
        ));
      }
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
      $this->insert_application(array(
        'name' => $flame_db['name'],
        'url' => $flame_db['url'],
        'icon' => 'mdi:fire',
        'description' => $flame_db['name'],
        'isPublic' => $flame_db['isPublic'],
        'orderId' => $flame_db['orderId'],
        'createdAt' => $flame_db['createdAt'],
        'updatedAt' => $flame_db['updatedAt']
      ));
    }
  }

  protected function store_http($string){
    $replace = array('http://', 'https://');
    $with = array('http-', 'https-');
    return str_replace($replace, $with, $string);
  }

  protected function remove_http($string){
    $replace = array('http://', 'https://', 'http-', 'https-');
    return str_replace($replace, '', $string);
  }

  protected function sort_by_name(){
    $sorted = array();
    foreach($this->app_list['apps'] as $key => $app){
      $sorted[$app['name']] = $key;
    }
    ksort($sorted);
    foreach ($sorted as $value) {
      $sorted_apps[] = $this->app_list['apps'][$value];
    }
    $this->app_list['apps'] = $sorted_apps;
  }
  protected function sort_by_orderID(){
    $sorted = array();
    foreach($this->app_list['apps'] as $key => $app){
      $sorted[$app['orderId']] = $key;
    }
    ksort($sorted);
    foreach ($sorted as $value) {
      $sorted_apps[] = $this->app_list['apps'][$value];
    }
    $this->app_list['apps'] = $sorted_apps;
  }
  protected function sort_by_date(){
    $sorted = array();
    foreach($this->app_list['apps'] as $key => $app){
      $sorted[$app['createdAt']] = $key;
    }
    ksort($sorted);
    foreach ($sorted as $value) {
      $sorted_apps[] = $this->app_list['apps'][$value];
    }
    $this->app_list['apps'] = $sorted_apps;
  }
}

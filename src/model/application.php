<?php
namespace MHorwood\Dashboard\model;
use MHorwood\Dashboard\classes\sqlite;

class application extends sqlite {

  protected $app_list;
  protected $sorting;

  public function __construct($sorting){
    parent::__construct();
    $this->sorting = $sorting;
    $this->app_list = $this->load_from_file('applications', 'apps', $sorting);
  }

  public function get_list(){
    return $this->app_list['apps'];
  }

  public function set_sorting($sorting){
    $this->sorting = $sorting;
    $sorted = $this->app_list['apps'];
    usort($sorted, function($a, $b ) { //Sort the array using a user defined function
        return $a[$this->sorting] > $b[$this->sorting] ? 1 : -1; //Compare the scores
    });
    $this->app_list['apps'] = $sorted;
    $this->save_to_file('../../user_data/apps.json', $this->app_list);
  }

  public function update_application($applicationID, $args){
    $last = count($this->app_list['apps']);
    if(!isset($args['orderId']) || $args['orderId'] == 'none'){
      $args['orderId'] = $last++;
    }
    if (!isset($args['app_proto'])){
      $args['app_proto'] = 'http';
    }

    $sql = 'UPDATE applications
      SET
        name = :name,
        url = :url,
        icon = :icon,
        description = :description,
        isPublic = :isPublic,
        updatedAt = :updatedAt,
        orderId = :orderId
      WHERE
        id = :appid';

    $data = array(
      'name' => $args['name'],
      'url' => $this->store_http($args['app_proto'].'://'.$this->remove_http($args['url'])),
      'icon' => $args['icon'],
      'description' => $args['description'],
      'isPublic' => $args['isPublic'],
      'updatedAt' => date('Y-m-d H:i:s'),
      'orderId' => $args['orderId'],
      'appid' => $applicationID
    );
    $this->save_to_file($sql, $data);
  }
  public function insert_application($args){
    $last = count($this->app_list['apps']);
    if(!isset($args['orderId']) || $args['orderId'] == 'none'){
      $args['orderId'] = $last++;
    }
    if(!isset($args['createdAt'])){
      $args['createdAt'] = date('Y-m-d H:i:s');
    }
    if(!isset($args['updatedAt'])){
      $args['updatedAt'] = date('Y-m-d H:i:s');
    }
    $data = array(
      ':name'=>$args['name'],
      ':url'=>$this->store_http($args['app_proto'].'://'.$this->remove_http($args['url'])),
      ':icon'=>$args['icon'],
      ':description'=>$args['description'],
      ':isPublic'=>$args['isPublic'],
      ':createdAt'=>$args['createdAt'],
      ':updatedAt'=>$args['updatedAt'],
      ':orderId'=>$args['orderId']
    );
    $sql = 'INSERT INTO applications
      (name,url,icon,description,isPublic,createdAt,updatedAt,orderId)
      VALUES(:name,:url,:icon,:description,:isPublic,:createdAt,:updatedAt,:orderId)';
    $this->save_to_file($sql, $data);
  }

  public function delete_application($applicationID){
    $sql = 'DELETE FROM applications WHERE id = :id';
    $data['id'] = $applicationID;
    $this->save_to_file($sql, $data);
  }
  public function order_application($applications_json){
    $sql = 'UPDATE applications set orderId = ';
    $applications = json_decode($applications_json, true);
    foreach ($applications as $key => $value) {
      $this->app_list['apps'][$value['appId']]['orderId'] = $value['orderId'];
    }
    $this->save_to_file('../../user_data/apps.json', $this->app_list);
  }

  public function store_docker($docker_apps){
    if (is_null($docker_apps)){
      return;
    }
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
        if(isset($dvalue['icon'])){
          $icon = $dvalue['icon'];
        }else{
          $icon = 'mdi:docker';
        }
        if ( $dvalue['https'] === true ){
          $dvalue['url'] = $dvalue['url'];
        }
        if($dvalue['https'] === 'true'){
          $dvalue['https'] = 'https';
        }else{
          $dvalue['https'] = 'http';
        }
        $this->insert_application(array(
          'name' => $dvalue['name'],
          'url' => $dvalue['url'],
          'icon' => $icon,
          'description' => $dvalue['description'],
          'isPublic' => 1,
          'app_proto' => $dvalue['https'],
        ));
      }
    }
  }

  protected function store_http($string){
    $replace = array('http://', 'https://');
    $with = array('http-', 'https-');
    if(strpos($string, 'http') === false){
      return 'http-'.$string;
    }else{
      return str_replace($replace, $with, $string);
    }
  }

  protected function remove_http($string){
    $replace = array('http://', 'https://', 'http-', 'https-', '://');
    return str_replace($replace, '', $string);
  }
}

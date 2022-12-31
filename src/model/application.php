<?php
namespace MHorwood\Dashboard\Model;
use MHorwood\Dashboard\classes\json;

class application extends json {

  protected $app_list;

  public function __construct(){
    $this->app_list = $this->load_from_file('../config/apps.json');
  }

  public function get_list(){
    return $this->app_list['apps'];
  }

  public function update_application($applicationID, $args){
    $this->app_list['apps'][$applicationID]['name'] = $args['name'];
    $this->app_list['apps'][$applicationID]['url'] = $args['url'];
    $this->app_list['apps'][$applicationID]['icon'] = $args['icon'];
    $this->app_list['apps'][$applicationID]['description'] = $args['description'];
    $this->app_list['apps'][$applicationID]['isPublic'] = $args['isPublic'];
    $this->app_list['apps'][$applicationID]['updatedAt'] = date('Y-m-d H:i:s');
    $this->save_to_file('../config/apps.json', $this->app_list);
  }
  public function insert_application($args){
    $data = array(
      'name'=>$args['name'],
      'url'=>$args['url'],
      'icon'=>$args['icon'],
      'description'=>$args['description'],
      'isPublic'=>$args['isPublic'],
      'createdAt'=>date('Y-m-d H:i:s'),
      'updatedAt'=>date('Y-m-d H:i:s')
    );
    $this->app_list['apps'][] = $data;
    $this->save_to_file('../config/apps.json', $this->app_list);
  }

}

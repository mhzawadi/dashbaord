<?php
namespace MHorwood\Dashboard\model;
use MHorwood\Dashboard\classes\json;

class bookmark extends json {
  protected $bookmarks_list;
  protected $category_options;
  protected $sorting;

  public function __construct($sorting){
    $this->sorting = $sorting;
    if(file_exists('../../user_data/settings.json') === false){
      $this->bookmarks_list = $this->load_from_file('../../data/bookmarks.json');
      $this->save_to_file('../../user_data/bookmarks.json', $this->bookmarks_list);
    }else{
      $this->bookmarks_list = $this->load_from_file('../../user_data/bookmarks.json');
    }
  }

  public function get_list(){
    return $this->bookmarks_list['categorys'];
  }

  public function set_sorting($sorting){
    if($sorting == 'createdAt'){
      $this->sort_by_date();
    }elseif($sorting == 'name'){
      $this->sort_by_name();
    }elseif($sorting == 'orderId'){
      $this->sort_by_orderID();
    }
    $this->save_to_file('../../user_data/bookmarks.json', $this->bookmarks_list);
  }

  public function get_bookmark($categoryID){
    return $this->bookmarks_list['categorys'][$categoryID];
  }

  public function get_category_options($categoryID = null){
    $this->build_category_options($categoryID);
    return $this->category_options;
  }

  protected function build_category_options($categoryID){
    foreach($this->bookmarks_list['categorys'] as $key => $category){
      if($categoryID == $key){
        $this->category_options .= '<option value="'.$key.'" selected>'.$category['name'].'</option>';
      }else{
        $this->category_options .= '<option value="'.$key.'">'.$category['name'].'</option>';
      }

    }
  }

  public function update_bookmark($bookmarkID, $categoryId, $args){
    if(!isset($args['orderId'])){
      $args['orderId'] = 1;
    }
    $this->bookmarks_list['categorys'][$categoryId]['bookmarks'][$bookmarkID]['name'] = $args['name'];
    $this->bookmarks_list['categorys'][$categoryId]['bookmarks'][$bookmarkID]['url'] = $args['url'];
    $this->bookmarks_list['categorys'][$categoryId]['bookmarks'][$bookmarkID]['icon'] = $args['icon'];
    $this->bookmarks_list['categorys'][$categoryId]['bookmarks'][$bookmarkID]['categoryId'] = $args['categoryId'];
    $this->bookmarks_list['categorys'][$categoryId]['bookmarks'][$bookmarkID]['isPublic'] = $args['isPublic'];
    $this->bookmarks_list['categorys'][$categoryId]['bookmarks'][$bookmarkID]['updatedAt'] = date('Y-m-d H:i:s');
    $this->bookmarks_list['categorys'][$categoryId]['bookmarks'][$bookmarkID]['orderId'] = $args['orderId'];
    $this->save_to_file('../../user_data/bookmarks.json', $this->bookmarks_list);
  }
  public function insert_bookmark($categoryId, $args){
    if(!isset($args['orderId'])){
      $args['orderId'] = 1;
    }
    if(!isset($args['createdAt'])){
      $args['createdAt'] = date('Y-m-d H:i:s');
    }
    if(!isset($args['updatedAt'])){
      $args['updatedAt'] = date('Y-m-d H:i:s');
    }
    $data = array(
      'name'=>$args['name'],
      'url'=>$args['url'],
      'icon'=>$args['icon'],
      'categoryId'=>$args['categoryId'],
      'isPublic'=>$args['isPublic'],
      'createdAt'=>$args['createdAt'],
      'updatedAt'=>$args['updatedAt'],
      'orderId' => $args['orderId']
    );
    $this->bookmarks_list['categorys'][$categoryId]['bookmarks'][] = $data;
    $this->save_to_file('../../user_data/bookmarks.json', $this->bookmarks_list);
  }

  public function delete_bookmark($categoryId, $bookmarkID){
    unset($this->bookmarks_list['categorys'][$categoryId]['bookmarks'][$bookmarkID]);
    $this->save_to_file('../../user_data/bookmarks.json', $this->bookmarks_list);
  }

  public function update_category($categoryId, $args){
    $sorting = false;
    if(!isset($args['orderId'])){
      $args['orderId'] = 1;
    }
    if($args['orderId'] != $this->bookmarks_list['categorys'][$categoryId]['orderId']){
      $sorting = true;
    }
    $this->bookmarks_list['categorys'][$categoryId]['name'] = $args['name'];
    $this->bookmarks_list['categorys'][$categoryId]['isPublic'] = $args['isPublic'];
    $this->bookmarks_list['categorys'][$categoryId]['orderId'] = $args['orderId'];
    $this->bookmarks_list['categorys'][$categoryId]['updatedAt'] = date('Y-m-d H:i:s');
    if($sorting === true){
      $this->set_sorting($this->sorting);
    }else{
      $this->save_to_file('../../user_data/bookmarks.json', $this->bookmarks_list);
    }
  }

  public function insert_category($args){
    if(!isset($args['orderId'])){
      $args['orderId'] = 1;
    }
    if(!isset($args['createdAt'])){
      $args['createdAt'] = date('Y-m-d H:i:s');
    }
    if(!isset($args['updatedAt'])){
      $args['updatedAt'] = date('Y-m-d H:i:s');
    }
    $data = array(
      'name'=>$args['name'],
      'isPublic'=>$args['isPublic'],
      'createdAt'=>$args['createdAt'],
      'updatedAt'=>$args['updatedAt'],
      'orderId'=>$args['orderId'],
      "bookmarks"=>array()
    );
    $this->bookmarks_list['categorys'][] = $data;
    $this->save_to_file('../../user_data/bookmarks.json', $this->bookmarks_list);
  }

  public function delete_category($categoryId){
    unset($this->bookmarks_list['categorys'][$categoryId]);
    $this->save_to_file('../../user_data/bookmarks.json', $this->bookmarks_list);
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

  protected function sort_by_name(){
    $sorted = array();
    foreach($this->bookmarks_list['categorys'] as $key => $app){
      $sorted[$app['name']] = $key;
    }
    ksort($sorted);
    foreach ($sorted as $value) {
      $sorted_apps[] = $this->bookmarks_list['categorys'][$value];
    }
    $this->bookmarks_list['categorys'] = $sorted_apps;
  }
  protected function sort_by_orderID(){
    $sorted = array();
    foreach($this->bookmarks_list['categorys'] as $key => $app){
      $sorted[$app['orderId']] = $key;
    }
    ksort($sorted);
    foreach ($sorted as $value) {
      $sorted_apps[] = $this->bookmarks_list['categorys'][$value];
    }
    $this->bookmarks_list['categorys'] = $sorted_apps;
  }
  protected function sort_by_date(){
    $sorted = array();
    foreach($this->bookmarks_list['categorys'] as $key => $app){
      $sorted[$app['createdAt']] = $key;
    }
    ksort($sorted);
    foreach ($sorted as $value) {
      $sorted_apps[] = $this->bookmarks_list['categorys'][$value];
    }
    $this->bookmarks_list['categorys'] = $sorted_apps;
  }
}

<?php
namespace MHorwood\Dashboard\model;
use MHorwood\Dashboard\classes\json;

class bookmark extends json {
  protected $bookmarks_list;
  protected $category_options;

  public function __construct(){
    if(file_exists('../config/settings.json') === false){
      $this->bookmarks_list = $this->load_from_file('../../data/bookmarks.json');
      $this->save_to_file('../config/bookmarks.json', $this->bookmarks_list);
    }else{
      $this->bookmarks_list = $this->load_from_file('../config/bookmarks.json');
    }
  }

  public function get_list(){
    return $this->bookmarks_list['categorys'];
  }

  public function get_bookmark($categoryID){
    return $this->bookmarks_list['categorys'][$categoryID]['bookmarks'];
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
    $this->bookmarks_list['categorys'][$categoryId]['bookmarks'][$bookmarkID]['name'] = $args['name'];
    $this->bookmarks_list['categorys'][$categoryId]['bookmarks'][$bookmarkID]['url'] = $args['url'];
    $this->bookmarks_list['categorys'][$categoryId]['bookmarks'][$bookmarkID]['icon'] = $args['icon'];
    $this->bookmarks_list['categorys'][$categoryId]['bookmarks'][$bookmarkID]['categoryId'] = $args['categoryId'];
    $this->bookmarks_list['categorys'][$categoryId]['bookmarks'][$bookmarkID]['isPublic'] = $args['isPublic'];
    $this->bookmarks_list['categorys'][$categoryId]['bookmarks'][$bookmarkID]['updatedAt'] = date('Y-m-d H:i:s');
    $this->save_to_file('../config/bookmarks.json', $this->bookmarks_list);
  }
  public function insert_bookmark($categoryId, $args){
    $data = array(
      'name'=>$args['name'],
      'url'=>$args['url'],
      'icon'=>$args['icon'],
      'categoryId'=>$args['categoryId'],
      'isPublic'=>$args['isPublic'],
      'createdAt'=>date('Y-m-d H:i:s'),
      'updatedAt'=>date('Y-m-d H:i:s')
    );
    $this->bookmarks_list['categorys'][$categoryId]['bookmarks'][] = $data;
    $this->save_to_file('../config/bookmarks.json', $this->bookmarks_list);
  }

  public function update_category($categoryId, $args){
    $this->bookmarks_list['categorys'][$categoryId]['name'] = $args['name'];
    $this->bookmarks_list['categorys'][$categoryId]['isPublic'] = $args['isPublic'];
    $this->bookmarks_list['categorys'][$categoryId]['updatedAt'] = date('Y-m-d H:i:s');
    $this->save_to_file('../config/bookmarks.json', $this->bookmarks_list);
  }

  public function insert_category($args){
    $data = array(
      'name'=>$args['name'],
      'isPublic'=>$args['isPublic'],
      'createdAt'=>date('Y-m-d H:i:s'),
      'updatedAt'=>date('Y-m-d H:i:s'),
      "bookmarks"=>array()
    );
    $this->bookmarks_list['categorys'][] = $data;
    $this->save_to_file('../config/bookmarks.json', $this->bookmarks_list);
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
        'isPublic' => 1
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
      $this->insert_bookmark($categoryID, array(
        'name'=>$flame_db['name'],
        'url'=>$flame_db['url'],
        'icon'=>$flame_db['icon'],
        'categoryId'=>$categoryID,
        'isPublic'=>$flame_db['isPublic'],
      ));
    }
  }
}

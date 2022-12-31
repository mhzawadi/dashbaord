<?php
namespace MHorwood\Dashboard\Model;
use MHorwood\Dashboard\classes\json;

class bookmark extends json {
  protected $bookmarks_list;
  protected $category_options;

  public function __construct(){
    $this->bookmarks_list = $this->load_from_file('../config/bookmarks.json');
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
}

<?php
namespace MHorwood\Dashboard\model;
use MHorwood\Dashboard\classes\json;

class category extends json{
  protected $category_list;

  public function __construct(){
    if(file_exists('../../user_data/bookmarks.json') === false){
      $this->category_list = $this->load_from_file('../../data/bookmarks.json');
      $this->save_to_file('../../user_data/bookmarks.json', $this->category_list);
    }else{
      $this->category_list = $this->load_from_file('../../user_data/bookmarks.json');
    }
  }

  public function get_list(){
    return $this->category_list['categorys'];
  }
}

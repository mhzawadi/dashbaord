<?php
namespace MHorwood\Dashboard\Model;
use MHorwood\Dashboard\classes\json;

class category extends json{
  protected $category_list;

  public function __construct(){
    $this->category_list = $this->load_from_file('../config/bookmarks.json');
  }

  public function get_list(){
    return $this->category_list['categorys'];
  }
}

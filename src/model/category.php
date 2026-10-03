<?php
namespace MHorwood\Dashboard\model;
use MHorwood\Dashboard\classes\json;

class category extends json{
  protected $category_list;

  /**
   * undocumented function summary
   *
   * Undocumented function long description
   *
   * @param type var Description
   * @return return type
   */
  public function __construct(){
    if(file_exists('../../user_data/bookmarks.json') === false){
      $this->category_list = $this->load_from_file('../../data/bookmarks.json');
      $this->save_to_file('../../user_data/bookmarks.json', $this->category_list);
    }else{
      $this->category_list = $this->load_from_file('../../user_data/bookmarks.json');
    }
  }

  /**
   * undocumented function summary
   *
   * Undocumented function long description
   *
   * @param type var Description
   * @return return type
   */
  public function get_list(){
    return $this->category_list['categorys'];
  }
}

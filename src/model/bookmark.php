<?php
namespace MHorwood\Dashboard\model;
use MHorwood\Dashboard\classes\sqlite;

class bookmark extends sqlite {
  protected $bookmarks_list;
  protected $category_options;
  protected $sorting;
  protected $last_category;

  public function __construct($sorting){
    parent::__construct();
    $this->sorting = $sorting;
    $this->build_list($sorting);
  }

  /**
   * undocumented function summary
   *
   * Undocumented function long description
   *
   * @sorting type var Description
   * @return return type
   */
  private function last_bookmark($bookmarks_list, $categoryId){
    foreach($this->bookmarks_list['categorys'] as $key => $category){
      if($categoryId == $category['id']){
        $last = count($bookmarks_list['categorys'][$key]['bookmarks']);
      }
    }
    return $last++;
  }

  /**
   * undocumented function summary
   *
   * Undocumented function long description
   *
   * @sorting type var Description
   * @return return type
   */
  protected function build_list($sorting)
  {
    $bookmark_sql = 'SELECT b.id,b.name,b.url,b.icon,b.isPublic,b.createdAt,b.updatedAt,b.orderId
            from bookmarks as b
            left join categorys as c on b.categoryId = c.id
            where b.categoryId = :categoryId
            order by b.'.$sorting;

    $this->bookmarks_list = $this->load_from_file('categorys', 'categorys', $sorting);
    foreach($this->bookmarks_list['categorys'] as $key => $category){
      $rows = $this->query($bookmark_sql, array($this->bookmarks_list['categorys'][$key]['id']));
      $this->bookmarks_list['categorys'][$key]['bookmarks'] = $rows;
    }
    $this->last_category = count($this->bookmarks_list['categorys']);
  }

  public function get_list($sorting){
    $this->build_list($sorting);
    return $this->bookmarks_list['categorys'];
  }

  /**
   * undocumented function summary
   *
   * Undocumented function long description
   *
   * @param type var Description
   * @return return type
   */
  public function get_category($category_name) {
    $sql = 'SELECT * FROM categorys WHERE name = :category_name';
    $rows = $this->query($sql, array($category_name));
    return $rows;
  }

  /**
   * undocumented function summary
   *
   * Undocumented function long description
   *
   * @param type var Description
   * @return return type
   */
  public function get_bookamrk($bookmark_name) {
    $sql = 'SELECT * FROM bookmarks WHERE name = :bookmark_name';
    $rows = $this->query($sql, array($bookmark_name));
    return $rows;
  }

  public function set_sorting($sorting){
    $this->sorting = $sorting;
    foreach($this->bookmarks_list['categorys'] as $key => $category){
      $this->bookmarks_list['categorys'][$key]['bookmarks'] = $this->sort_categorys($category['bookmarks']);
    }
    $sorted = $this->bookmarks_list['categorys'];
    usort($sorted, function($a, $b) { //Sort the array using a user defined function
        return $a[$this->sorting] > $b[$this->sorting] ? 1 : -1; //Compare the scores
    });
    $this->bookmarks_list['categorys'] = $sorted;
    $this->save_to_file('../../user_data/bookmarks.json', $this->bookmarks_list);
  }

  private function sort_categorys($category){
    $sorted = $category;
    usort($sorted, function($a, $b) { //Sort the array using a user defined function
        return $a[$this->sorting] > $b[$this->sorting] ? 1 : -1; //Compare the scores
    });
    return $sorted;
  }

  public function get_bookmark($categoryID){
    foreach($this->bookmarks_list['categorys'] as $key => $category){
      if($categoryID == $category['id']){
        $return = $this->bookmarks_list['categorys'][$key];
      }
    }
    return $return;
  }

  public function get_category_options($categoryID = null){
    foreach($this->bookmarks_list['categorys'] as $key => $category){
      if($categoryID == $key){
        $this->category_options .= '<option value="'.$category['id'].'" selected>'.$category['name'].'</option>';
      }else{
        $this->category_options .= '<option value="'.$category['id'].'">'.$category['name'].'</option>';
      }
    }
    return $this->category_options;
  }

  public function update_bookmark($bookmarkID, $categoryId, $args){
    if(!isset($args['orderId'])){
      $args['orderId'] = $this->last_bookmark($this->bookmarks_list, $categoryId);
    }
    $sql = 'UPDATE bookmarks SET
        categoryId = :categoryId,
        name = :name,
        url = :url,
        icon = :icon,
        isPublic = :isPublic,
        updatedAt = :updatedAt,
        orderId = :orderId
      WHERE id = :bookmarkID';
    $data['bookmarkID'] = $bookmarkID;
    $data['name'] = $args['name'];
    $data['url'] = $args['url'];
    $data['icon'] = $args['icon'];
    $data['categoryId'] = $args['categoryId'];
    $data['isPublic'] = $args['isPublic'];
    $data['updatedAt'] = date('Y-m-d H:i:s');
    $data['orderId'] = $args['orderId'];
    $this->save_to_file($sql, $data);
  }
  public function insert_bookmark($categoryId, $args){
    if(!isset($args['orderId']) || $args['orderId'] == 'none'){
      $args['orderId'] = $this->last_bookmark($this->bookmarks_list, $categoryId);
    }
    if(!isset($args['createdAt'])){
      $args['createdAt'] = date('Y-m-d H:i:s');
    }
    if(!isset($args['updatedAt'])){
      $args['updatedAt'] = date('Y-m-d H:i:s');
    }
    $sql = 'INSERT INTO bookmarks
      (name,url,icon,isPublic,createdAt,updatedAt,orderId,categoryId)
      VALUES(:name,:url,:icon,:isPublic,:createdAt,:updatedAt,:orderId,:categoryId)';
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
    $this->save_to_file($sql, $data);
  }

  public function delete_bookmark($categoryId, $bookmarkID){
    $sql = 'DELETE FROM bookmarks WHERE id = :id';
    $data['id'] = $bookmarkID;
    $this->save_to_file($sql, $data);
  }

  public function update_category($categoryId, $args){
    $sorting = false;
    if(!isset($args['orderId'])){
      $args['orderId'] = $this->last_category++;
    }
    $sql = 'UPDATE categorys
      SET
        name = :name,
        isPublic = :isPublic,
        updatedAt = :updatedAt,
        orderId = :orderId
      WHERE
        id = :categoryId';
    $data['name'] = $args['name'];
    $data['isPublic'] = $args['isPublic'];
    $data['orderId'] = $args['orderId'];
    $data['updatedAt'] = date('Y-m-d H:i:s');
    $data['categoryId'] = $categoryId;
    $this->save_to_file($sql, $data);
  }

  public function insert_category($args){
    $last_category = count($this->bookmarks_list['categorys']);
    if(!isset($args['orderId']) || $args['orderId'] === 'none'){
      $args['orderId'] = $last_category++;
    }
    if(!isset($args['createdAt'])){
      $args['createdAt'] = date('Y-m-d H:i:s');
    }
    if(!isset($args['updatedAt'])){
      $args['updatedAt'] = date('Y-m-d H:i:s');
    }
    $sql = 'INSERT INTO categorys
      (name,isPublic,createdAt,updatedAt,orderId)
      VALUES(:name,:isPublic,:createdAt,:updatedAt,:orderId)';
    $data = array(
      'name'=>$args['name'],
      'isPublic'=>$args['isPublic'],
      'createdAt'=>$args['createdAt'],
      'updatedAt'=>$args['updatedAt'],
      'orderId'=>$args['orderId']
    );
    $this->bookmarks_list['categorys'][] = $data;
    $this->save_to_file($sql, $data);
  }

  public function delete_category($categoryId){
    $sql = 'DELETE FROM categorys WHERE id = :id';
    $data['id'] = $categoryId;
    $this->save_to_file($sql, $data);
  }
}

<?php
namespace MHorwood\Dashboard\controller;
use MHorwood\Dashboard\model\bookmark;
use MHorwood\Dashboard\classes\bookmark_view;

class bookmarks{
  public function __construct($user_agent){
    $this->bookmark = new bookmark();
    $this->bookmark_view = new bookmark_view($this->bookmark);
  }
  public function routing($args){
    if($this->logged_in === false) {
      header('Location: /');
      exit;
    }
    $finish_edits = false;
    if($urls['type'] === 'edit'){
      if(isset($args['bookmarkID']) && $args['bookmarkID'] == 'none' && isset(args['categoryId'])){
        $this->bookmark->insert_bookmark($args['categoryId'], $args);
      }elseif(isset($args['categoryId']) && isset($args['bookmarkID'])){
        $this->bookmark->update_bookmark($args['bookmarkID'], $args['categoryId'], $args);
      }
    }elseif($urls['type'] == 'delete' && isset($args['categoryId']) && isset($args['bookmarkID'])){
      $this->bookmark->delete_bookmark($args['categoryId'], $args['bookmarkID']);
    }
    if($urls['id'] != 'none'){
      $finish_edits = true;
      $category_options = $this->bookmark->get_category_options($urls['id']);
      $bookmarks = $this->bookmark_view->build_bookmark_table($urls['id']);
    }else{
      $category_options = $this->bookmark->get_category_options();
      $bookmarks = $this->bookmark_view->build_list(true, $this->logged_in);
    }
    include (__DIR__ . '/../view/edit_bookmarks.php');
  }
}

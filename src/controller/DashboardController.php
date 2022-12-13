<?php
namespace MHorwood\Dashboard\Controller;
use MHorwood\Dashboard\Model\application;
use MHorwood\Dashboard\Model\bookmark;
use MHorwood\Dashboard\Model\category;
use MHorwood\Dashboard\classes\application as Class_App;
use MHorwood\Dashboard\classes\bookmark as Class_Bookmark;
use MHorwood\Dashboard\classes\category as Class_Category;

class DashboardController{

  protected $html;
  protected $App;

  public function __construct(){
    $this->app = new Class_App;
    $this->bookmark = new Class_Bookmark;
    $this->category = new Class_Category;
  }
  /**
  * Routing from index page
  **/
  public function process_action($args){
    if(isset($args['action']) && $args['action'] !== '' && !isset($args['category'])){
      switch ($args['action']) {
        case 'applications':
          $this->html = '';
          $applications = $this->app->build_app_table(application::factory()->get());
          include (__DIR__ . '/../view/edit_apps.php');
          break;
        case 'bookmarks':
          $this->html = '';
          $bookmarks = $this->category->build_category_list(category::factory()->get(), true);
          include (__DIR__ . '/../view/edit_bookmarks.php');
          break;
        case 'bookmark':
          $category_options = $this->category->build_category_option($args['id']);
          $bookmarks = $this->bookmark->build_bookmark_table(bookmark::factory()->where('id', '=', $args['id']), $args['id']);
          include (__DIR__ . '/../view/edit_bookmarks.php');
          break;
        case 'bookmark_edit':
          if($args['bookmark_name'] == 0){
            $category = bookmark::factory()->insert(array(
              'name'=>$args['name'],
              'url'=>$args['url'],
              'isPublic'=>$args['isPublic']
            ));
          }else{
            $category = bookmark::factory()->where('name', '=', $args['cat_name']);
            $category->update(array('name'=>$args['name'],'isPublic'=>$args['isPublic']));
          }
          $bookmarks = $this->category->build_category_list(category::factory()->get(), true);
          include (__DIR__ . '/../view/edit_bookmarks.php');
          break;
        case 'category_edit':
          if($args['cat_name'] == 0){
            $category = category::factory()->insert(array('name'=>$args['name'],'isPublic'=>$args['isPublic']));
          }else{
            $category = category::factory()->where('name', '=', $args['cat_name']);
            $category->update(array('name'=>$args['name'],'isPublic'=>$args['isPublic']));
          }

          $bookmarks = $this->category->build_category_table(category::factory()->get(), true);
          include (__DIR__ . '/../view/edit_bookmarks.php');
          break;
        case 'categories';
          $bookmarks = $this->category->build_category_table(category::factory()->get(), true);
          include (__DIR__ . '/../view/edit_bookmarks.php');
          break;
      }
    }else{
      $this->html = '';
      $applications = $this->app->build_app_grid(application::factory()->select('name, url')->get());
      $bookmarks = $this->category->build_category_list(category::factory()->select('name, id')->get());
      include (__DIR__ . '/../view/main_view.php');
    }
  }



}

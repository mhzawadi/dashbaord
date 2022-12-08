<?php
namespace MHorwood\Dashboard\Controller;
use MHorwood\Dashboard\Model\application;
use MHorwood\Dashboard\Model\bookmark;
use MHorwood\Dashboard\Model\category;

class DashboardController{

  protected $html;

  /**
  * Routing from index page
  **/
  public function process_action($args){
    if(isset($args['action']) && $args['action'] !== ''){
      switch ($args['action']) {
        case 'applications':
        $this->html = '';
        $applications = $this->build_app_list(application::factory()->get());
        include (__DIR__ . '/../view/edit_apps.php');
        break;
      }
      echo 'some model here';
    }else{
      $this->html = '';
      $applications = $this->build_app_list(application::factory()->select('name, url')->get());
      $bookmarks = $this->build_category_list(category::factory()->select('name, id')->get());
      include (__DIR__ . '/../view/main_view.php');
    }
  }

  private function build_app_list($applications){
    $app_list = '';
    foreach($applications as $key => $app){
      $app_list .= '<a href="'.$app['url'].'" target="_blank" rel="noreferrer" class="AppCard_AppCard__1V2_0">'."\n";
      $app_list .= '  <div class="AppCard_AppCardIcon__8ZZTq"></div>'."\n";
      $app_list .= '  <div class="AppCard_AppCardDetails__tbAhY">'."\n";
      $app_list .= '    <h5>'.$app['name'].'</h5>'."\n";
      $app_list .= '    <span>'.$app['url'].'</span>'."\n";
      $app_list .= '  </div>'."\n";
      $app_list .= '</a>'."\n";
    }
    return $app_list;
  }
  private function build_category_list($categorys){
    $category_list = '';
    foreach($categorys as $key => $category){
      $category_list .= '<div class="BookmarkCard_BookmarkCard__1GmHc">'."\n";
      $category_list .= '  <h3 class="">'.$category['name'].'</h3>'."\n";
      $category_list .= $this->build_bookmark_list(bookmark::factory()->where('id', '=', $category['id']));
      $category_list .= '</div>'."\n";
    }
    return $category_list;
  }
  private function build_bookmark_list($bookmarks_object){
    $bookmarks = $bookmarks_object->select('name, url')->get();
    $bookmark_list = '';
    $bookmark_list .= '  <div class="BookmarkCard_Bookmarks__YhsfD">'."\n";
    foreach($bookmarks as $key => $bookmark){
      $bookmark_list .= '    <a href="'.$bookmark['url'].'" target="_blank" rel="noreferrer">'.$bookmark['name'].'</a>'."\n";
    }
    $bookmark_list .= '  </div>'."\n";
    return $bookmark_list;

  }

}

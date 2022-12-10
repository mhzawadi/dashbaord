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
    if(isset($args['action']) && $args['action'] !== '' && !isset($args['category'])){
      switch ($args['action']) {
        case 'applications':
          $this->html = '';
          $applications = $this->build_app_table(application::factory()->get());
          include (__DIR__ . '/../view/edit_apps.php');
          break;
        case 'bookmarks':
          $this->html = '';
          $bookmarks = $this->build_category_list(category::factory()->get(), true);
          include (__DIR__ . '/../view/edit_bookmarks.php');
          break;
      }
    }elseif(isset($args['category']) && $args['category'] !== ''){
      $bookmarks = $this->build_bookmark_table(bookmark::factory()->where('name', '=', $args['category']), $args['category']);
      include (__DIR__ . '/../view/edit_bookmarks.php');
    }else{
      $this->html = '';
      $applications = $this->build_app_grid(application::factory()->select('name, url')->get());
      $bookmarks = $this->build_category_list(category::factory()->select('name, id')->get());
      include (__DIR__ . '/../view/main_view.php');
    }
  }

  private function build_app_grid($applications){
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
  private function build_category_list($categorys, $link = false){
    $category_list = '';
    $category_list .= '<div class="BookmarkGrid_BookmarkGrid__26LlR">';
    foreach($categorys as $key => $category){
      $category_list .= '<div class="BookmarkCard_BookmarkCard__1GmHc">'."\n";
      if($link === true){
        $category_list .= '  <h3 class=""><a href="/bookmarks?category='.$category['name'].'">'.$category['name'].'</a></h3>'."\n";
      }else{
        $category_list .= '  <h3 class="">'.$category['name'].'</h3>'."\n";
      }
      $category_list .= $this->build_bookmark_list(bookmark::factory()->where('id', '=', $category['id']));
      $category_list .= '</div>'."\n";
    }
    $category_list .= '</div>'."\n";
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
  private function build_app_table($applications){
    $app_list = '';
    $app_list .= '<div class="Table_TableContainer__UrXXd">'."\n";
    $app_list .= '<table class="Table_Table__pinST">'."\n";
    $app_list .= '<thead>'."\n";
    $app_list .= '<tr>'."\n";
    $app_list .= '<th>Name</th>'."\n";
    $app_list .= '<th>URL</th>'."\n";
    $app_list .= '<th>Icon</th>'."\n";
    $app_list .= '<th>Visibility</th>'."\n";
    $app_list .= '<th>Actions</th>'."\n";
    $app_list .= '</tr>'."\n";
    $app_list .= '</thead>'."\n";
    $app_list .= '<tbody>'."\n";
    foreach($applications as $key => $app){
      $app_list .= '<tr data-rbd-draggable-context-id="1" data-rbd-draggable-id="46" tabindex="0" role="button" aria-describedby="rbd-hidden-text-1-hidden-text-22" data-rbd-drag-handle-draggable-id="46" data-rbd-drag-handle-context-id="1" draggable="false" style="border: none; border-radius: 4px;">'."\n";
      $app_list .= '  <td style="width: 200px;">'.$app['name'].'</td>'."\n";
      $app_list .= '  <td style="width: 200px;">http://'.$app['name'].'</td>'."\n";
      $app_list .= '  <td style="width: 200px;">'.$app['icon'].'</td>'."\n";
      $app_list .= '  <td style="width: 200px;">'.$app['isPublic'].'</td>'."\n";
      $app_list .= '  <td class="TableActions_TableActions__2_v2I">'."\n";
      $app_list .= '    <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $app_list .= '      D'."\n";
      $app_list .= '    </div>'."\n";
      $app_list .= '    <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $app_list .= '      E'."\n";
      $app_list .= '    </div>'."\n";
      $app_list .= '    <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $app_list .= '      P'."\n";
      $app_list .= '    </div>'."\n";
      $app_list .= '    <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $app_list .= '      L'."\n";
      $app_list .= '    </div>'."\n";
      $app_list .= '  </td>'."\n";
      $app_list .= '</tr>'."\n";
    }
    $app_list .= '</tbody>'."\n";
    $app_list .= '</table>'."\n";
    $app_list .= '</div>'."\n";
    return $app_list;
  }

  private function build_bookmark_table($bookmarks_object, $category){
    $bookmarks = $bookmarks_object->get();
    $bookmark_list = '';
    $bookmark_list .= '<div class="Table_TableContainer__UrXXd">'."\n";
    $bookmark_list .= '  <table class="Table_Table__pinST">'."\n";
    $bookmark_list .= '    <thead>'."\n";
    $bookmark_list .= '      <tr>'."\n";
    $bookmark_list .= '        <th>Name</th>'."\n";
    $bookmark_list .= '        <th>URL</th>'."\n";
    $bookmark_list .= '        <th>Icon</th>'."\n";
    $bookmark_list .= '        <th>Visibility</th>'."\n";
    $bookmark_list .= '        <th>Category</th>'."\n";
    $bookmark_list .= '        <th>Actions</th>'."\n";
    $bookmark_list .= '      </tr>'."\n";
    $bookmark_list .= '    </thead>'."\n";
    $bookmark_list .= '  <tbody>'."\n";
    foreach($bookmarks as $key => $bookmark){
      $bookmark_list .= '  <tr data-rbd-draggable-context-id="1" data-rbd-draggable-id="46" tabindex="0" role="button" aria-describedby="rbd-hidden-text-1-hidden-text-22" data-rbd-drag-handle-draggable-id="46" data-rbd-drag-handle-context-id="1" draggable="false" style="border: none; border-radius: 4px;">'."\n";
      $bookmark_list .= '    <td style="width: 200px;">'.$bookmark['name'].'</td>'."\n";
      $bookmark_list .= '    <td style="width: 200px;">http://'.$bookmark['name'].'</td>'."\n";
      $bookmark_list .= '    <td style="width: 200px;">'.$bookmark['icon'].'</td>'."\n";
      $bookmark_list .= '    <td style="width: 200px;">'.$bookmark['isPublic'].'</td>'."\n";
      $bookmark_list .= '    <td style="width: 200px;">'.$category.'</td>'."\n";
      $bookmark_list .= '    <td class="TableActions_TableActions__2_v2I">'."\n";
      $bookmark_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $bookmark_list .= '        D'."\n";
      $bookmark_list .= '      </div>'."\n";
      $bookmark_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $bookmark_list .= '        E'."\n";
      $bookmark_list .= '      </div>'."\n";
      $bookmark_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $bookmark_list .= '        P'."\n";
      $bookmark_list .= '      </div>'."\n";
      $bookmark_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $bookmark_list .= '        L'."\n";
      $bookmark_list .= '      </div>'."\n";
      $bookmark_list .= '    </td>'."\n";
      $bookmark_list .= '  </tr>'."\n";
    }
    $bookmark_list .= '    </tbody>'."\n";
    $bookmark_list .= '  </table>'."\n";
    $bookmark_list .= '</div>'."\n";
    return $bookmark_list;
  }

}

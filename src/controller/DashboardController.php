<?php
namespace MHorwood\Dashboard\Controller;
use MHorwood\Dashboard\Model\application;
use MHorwood\Dashboard\Model\bookmark;
use MHorwood\Dashboard\Model\category;
use MHorwood\Dashboard\Model\settings;
use MHorwood\Dashboard\classes\application as Class_App;
use MHorwood\Dashboard\classes\bookmark as Class_Bookmark;
use MHorwood\Dashboard\classes\category as Class_Category;
use MHorwood\Dashboard\classes\docker;
use MHorwood\Dashboard\classes\settings as Class_Settings;

class DashboardController{

  protected $html;
  protected $App;
  protected $setting_obj;

  public function __construct(){
    $this->app = new Class_App;
    $this->bookmark = new Class_Bookmark;
    $this->category = new Class_Category;
    $this->settings = new Class_Settings;
    $this->setting_obj = $this->settings->load_settings();
    $this->theme = explode(';',$this->setting_obj['defaultTheme']);
    $this->greeting = $this->settings->greeting();
    $this->docker = new docker();
    print_pre($this->docker);
  }
  /**
  * Routing from index page
  **/
  public function process_action($args){
    if(isset($args['action']) && $args['action'] !== '' && !isset($args['category'])){
      switch ($args['action']) {
        case 'settings':
          if(isset($args['id']) && $args['id'] !== ''){
            $this->setting_obj = $this->settings->save_settings($args['id'], $args['type'], $this->setting_obj, $args);
            switch($args['id']){
              case 'general':
                include (__DIR__ . '/../view/settings_general.php');
                break;
              case 'interface':
                include (__DIR__ . '/../view/settings_interface.php');
                break;
              case 'weather':
                include (__DIR__ . '/../view/settings_weather.php');
                break;
              case 'docker':
                include (__DIR__ . '/../view/settings_docker.php');
                break;
              case 'css':
                include (__DIR__ . '/../view/settings_css.php');
                break;
              case 'app':
                include (__DIR__ . '/../view/settings_app.php');
                break;
            }
          }else{
            $themes = $this->settings->load_themes();
            include (__DIR__ . '/../view/settings.php');
          }
          break;
        case 'applications':
          $this->html = '';
          $applications = $this->app->build_app_table(application::factory()->get());
          include (__DIR__ . '/../view/edit_apps.php');
          break;
        case 'application_edit':
          if($args['description'] == ''){
            $args['description'] = $args['url'];
          }
          if($args['application_id'] == 0){
            application::factory()->insert(array(
              'name'=>$args['name'],
              'url'=>$args['url'],
              'icon'=>$args['icon'],
              'description'=>$args['description'],
              'isPublic'=>$args['isPublic'],
              'createdAt'=>date('Y-m-d H:i:s'),
              'updatedAt'=>date('Y-m-d H:i:s')
            ));
          }else{
            $app = application::factory()->where('id', '=', $args['application_id']);
            $app->update(array(
              'name'=>$args['name'],
              'url'=>$args['url'],
              'icon'=>$args['icon'],
              'description'=>$args['description'],
              'isPublic'=>$args['isPublic'],
              'updatedAt'=>date('Y-m-d H:i:s')
            ));
          }
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
          $bookmarks = $this->bookmark->build_bookmark_table(bookmark::factory()->where('categoryId', '=', $args['id']), $args['id']);
          include (__DIR__ . '/../view/edit_bookmarks.php');
          break;
        case 'bookmark_edit':
          if($args['bookmark_name'] == 0){
            $category = bookmark::factory()->insert(array(
              'name'=>$args['name'],
              'url'=>$args['url'],
              'icon'=>$args['icon'],
              'categoryId'=>$args['categoryId'],
              'isPublic'=>$args['isPublic'],
              'createdAt'=>date('Y-m-d H:i:s'),
              'updatedAt'=>date('Y-m-d H:i:s')
            ));
          }else{
            $category = bookmark::factory()->where('id', '=', $args['bookmark_name']);
            $category->update(array(
              'name'=>$args['name'],
              'url'=>$args['url'],
              'icon'=>$args['icon'],
              'categoryId'=>$args['categoryId'],
              'isPublic'=>$args['isPublic'],
              'updatedAt'=>date('Y-m-d H:i:s')
            ));
          }
          $args['id'] = $args['categoryId'];
          $category_options = $this->category->build_category_option();
          $bookmarks = $this->bookmark->build_bookmark_table(bookmark::factory()->where('categoryId', '=', $args['categoryId']), $args['categoryId']);
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
      $applications = $this->app->build_app_grid(application::factory()->select('name, url, icon')->get());
      $bookmarks = $this->category->build_category_list(category::factory()->select('name, id')->get());
      include (__DIR__ . '/../view/main_view.php');
    }
  }



}

<?php
namespace MHorwood\Dashboard\Controller;
use MHorwood\Dashboard\Model\application;
use MHorwood\Dashboard\Model\bookmark;
use MHorwood\Dashboard\Model\category;
use MHorwood\Dashboard\Model\settings;
use MHorwood\Dashboard\Model\login;
use MHorwood\Dashboard\classes\application_view;
use MHorwood\Dashboard\classes\bookmark_view;
use MHorwood\Dashboard\classes\category_view;
use MHorwood\Dashboard\classes\docker;

class DashboardController{

  protected $html;
  protected $App;
  protected $setting_obj;
  protected $routing;
  protected $session;
  protected $logged_in;

  public function __construct($user_agent){
    $this->application = new application();
    $this->application_view = new application_view;
    $this->bookmark = new bookmark();
    $this->bookmark_view = new bookmark_view($this->bookmark);
    $this->category = new category();
    $this->category_view = new category_view($this->bookmark);
    $this->settings = new settings;
    $this->setting_obj = $this->settings->get_settings();
    $this->theme = explode(';',$this->setting_obj['defaultTheme']);
    $this->greeting = $this->settings->greeting();
    $this->docker = new docker();
    $session = new login();
    $this->session = new login();
    $this->logged_in = $this->session->isUserAuthenticated();
  }

  /**
   * get URL and work out what we have
   **/
  private function pre_routing($urls){
    $url = array(
      'page' => 'none',
      'sub_page' => 'none',
      'type' => 'none',
      'id' => 'none'
    );
    if($urls[0] !== ''){
      $url['page'] = $urls[0];
    }
    if(isset($urls[1]) && $urls[1] !== ''){
      switch($urls[1]){
        case 'edit':
          $url['type'] = 'edit';
          break;
        case 'new':
          $url['type'] = 'edit';
          break;
        case is_numeric($urls[1]):
          $url['id'] = $urls[1];
          break;
        case 0:
          $url['id'] = $urls[1];
          break;
        default:
          $url['sub_page'] = $urls[1];
          break;
      }
    }
    if(isset($urls[2]) && $urls[2] !== ''){
      switch($urls[2]){
        case 'edit':
          $url['type'] = 'edit';
          break;
        case 'new':
          $url['type'] = 'edit';
          break;
        default:
          $url['sub_page'] = $urls[2];
          break;
        }
      }
      return $url;
    }


  /**
  * Routing from index page
  **/
  public function routing($args){
    $urls = $this->pre_routing($args['URL']);
    switch ($urls['page']) {
      case 'applications':
        if(isset($urls['type']) && $urls['type'] !== 'none'){
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
        }
        $applications = $this->app->build_app_table(application::factory()->get());
        include (__DIR__ . '/../view/edit_apps.php');
        break;
      case 'bookmarks':
        $finish_edits = false;
        if($urls['type'] === 'edit'){
          if($args['bookmarkID'] == 0){
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
            $category = bookmark::factory()->where('id', '=', $args['bookmarkID']);
            $category->update(array(
              'name'=>$args['name'],
              'url'=>$args['url'],
              'icon'=>$args['icon'],
              'categoryId'=>$args['categoryId'],
              'isPublic'=>$args['isPublic'],
              'updatedAt'=>date('Y-m-d H:i:s')
            ));
          }
        }
        print_pre($urls);
        if($urls['id'] != 'none'){
          $finish_edits = true;
          $category_options = $this->bookmark->get_category_options($urls['id']);
          $bookmarks = $this->bookmark_view->build_bookmark_table($urls['id']);
        }else{
          $category_options = $this->bookmark->get_category_options();
          $bookmarks = $this->bookmark_view->build_list(true);
        }
        include (__DIR__ . '/../view/edit_bookmarks.php');
        break;
      case 'categories':
        if(isset($urls['type']) && $urls['type'] === 'edit'){
          if($args['categoryID'] == 0){
            $category = category::factory()->insert(array('name'=>$args['name'],'isPublic'=>$args['isPublic']));
          }else{
            $category = category::factory()->where('name', '=', $args['categoryID']);
            $category->update(array('name'=>$args['name'],'isPublic'=>$args['isPublic']));
          }
        }
        $finish_edits = true;
        $bookmarks = $this->category->build_category_table(category::factory()->get(), true);
        include (__DIR__ . '/../view/edit_bookmarks.php');
        break;
      case 'settings':
        if(isset($urls['type']) && $urls['type'] !== 'none'){
          $this->setting_obj = $this->settings->save_settings($urls['sub_page'], $urls['type'], $args);
        }
        switch($urls['sub_page']){
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
            $txt = '';
            include (__DIR__ . '/../view/settings_app.php');
            break;
          case 'login':
            $txt = $this->session->checkLogin($args['password'], $args['duration']);
            include (__DIR__ . '/../view/settings_app.php');
            break;
          case 'logout':
            $_SESSION = array();
            if (ini_get("session.use_cookies")) {
              $params = session_get_cookie_params();
              setcookie(session_name(), '', time() - 42000,
                  $params["path"], $params["domain"],
                  $params["secure"], $params["httponly"]
              );
            }
            session_destroy();
            header("Location: /");
            exit;
            break;
          default:
            $themes = $this->settings->get_themes();
            include (__DIR__ . '/../view/settings.php');
            break;
        }
        break;
      default:
      $applications = $this->application_view->build_app_grid($this->application->get_list());
      $bookmarks = $this->bookmark_view->build_list($this->bookmark->get_list());
      include (__DIR__ . '/../view/main_view.php');
        break;
      }
  }
}

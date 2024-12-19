<?php
namespace MHorwood\Dashboard\controller;
use MHorwood\Dashboard\model\application;
use MHorwood\Dashboard\model\bookmark;
use MHorwood\Dashboard\model\settings;
use MHorwood\Dashboard\model\login;
use MHorwood\Dashboard\model\flame;
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
  protected $uploadOk;

  public function __construct($user_agent){
    if(!is_dir('../../user_data/uploads')){
      mkdir('../../user_data/uploads', 0775, true);
      copy('../../data/dashboard.png', '../../user_data/uploads/dashboard.png');
    }
    $this->settings = new settings;
    $this->setting_obj = $this->settings->get_settings();
    $this->theme = explode(';',$this->setting_obj['defaultTheme']);
    $this->greeting = $this->settings->greeting();
    $this->application = new application($this->setting_obj['useOrdering']);
    $this->application_view = new application_view;
    $this->bookmark = new bookmark($this->setting_obj['useOrdering']);
    $this->bookmark_view = new bookmark_view($this->bookmark);
    $this->category_view = new category_view($this->bookmark);
    $this->docker = new docker();
    $this->application->store_docker($this->docker->get_data());
    if(file_exists('../../user_data/db.sqlite')){
      $this->flame = new flame();
      $this->flame->import_apps($this->application);
      $this->flame->import_categories($this->bookmark);
      $this->flame->import_bookmarks($this->bookmark);
    }
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
        case 'delete':
          $url['type'] = 'delete';
          break;
        case 'order':
          $url['type'] = 'order';
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
        case 'delete':
          $url['type'] = 'delete';
          break;
        case 'order':
          $url['type'] = 'order';
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
      case 'oauth':
        $this->session->oauth($this->setting_obj['oauth']);
        break;
      case 'applications':
        if($this->logged_in === false) {
          header('Location: /');
          exit;
        }
        if(isset($urls['type']) && $urls['type'] !== 'none'){
          if(isset($_FILES['icon_file'])){
            if($this->store_image()){
               $args['icon'] = $this->uploadOk;
            }else{
              echo '<div style="color: red; text-align: center;font-size: 20px;">'.$this->uploadOk.'</div>';
            }
          }elseif(isset($args['icon'])){
            $args['icon'] = $this->is_mdi_si($args['icon']);
          }
          if(isset($args['application_id']) && $args['application_id'] == 'none'){
            $this->application->insert_application($args);
          }elseif(isset($args['application_id']) && isset($urls['type']) && $urls['type'] == 'edit'){
            $this->application->update_application($args['application_id'], $args);
          }elseif(isset($args['application_id']) && isset($urls['type']) && $urls['type'] == 'delete'){
            $this->application->delete_application($args['application_id']);
          }
          header('Location: /applications');
          exit;
        }
        $applications = $this->application_view->build_app_table($this->application->get_list());
        include (__DIR__ . '/../view/edit_apps.php');
        break;
      case 'bookmarks':
        if($this->logged_in === false) {
          header('Location: /');
          exit;
        }
        $finish_edits = false;
        if($urls['type'] === 'edit'){
          if(isset($_FILES['icon_file'])){
            if($this->store_image()){
               $args['icon'] = $this->uploadOk;
            }else{
              echo '<div style="color: red; text-align: center;font-size: 20px;">'.$this->uploadOk.'</div>';
            }
          }elseif(isset($args['icon'])){
            $args['icon'] = $this->is_mdi_si($args['icon']);
          }
          if(isset($args['bookmarkID']) && $args['bookmarkID'] == 'none' && isset($args['categoryId'])){
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
          $bookmarks = $this->bookmark_view->build_list($this->setting_obj['useOrdering'], true, $this->logged_in);
        }
        include (__DIR__ . '/../view/edit_bookmarks.php');
        break;
      case 'categories':
        if($this->logged_in === false) {
          header('Location: /');
          exit;
        }
        if(isset($urls['type']) && $urls['type'] === 'edit'){
          if($args['categoryID'] == 'none'){
            $this->bookmark->insert_category($args);
          }else{
            $this->bookmark->update_category($args['categoryID'], $args);
          }
          header('Location: /categories');
          exit;
        }elseif(isset($urls['type']) && $urls['type'] === 'delete'){
          $this->bookmark->delete_category($args['categoryID']);
          header('Location: /categories');
          exit;
        }
        $finish_edits = true;
        $bookmarks = $this->category_view->build_category_table($this->bookmark->get_list());
        include (__DIR__ . '/../view/edit_bookmarks.php');
        break;
      case 'settings':
        if(isset($urls['type']) && $urls['type'] !== 'none'){
          $this->setting_obj = $this->settings->save_settings($urls['sub_page'], $urls['type'], $args);
          $this->application->set_sorting($this->setting_obj['useOrdering']);
          $this->bookmark->set_sorting($this->setting_obj['useOrdering']);
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
          case 'oauth':
            include (__DIR__ . '/../view/settings_oauth.php');
            break;
          case 'app':
            $txt = '';
            include (__DIR__ . '/../view/settings_app.php');
            break;
          case 'login':
            if(isset($args['oauth_login'])){
              $this->session->oauth($this->setting_obj['oauth'], $args['duration']);
            }else{
              $txt = $this->session->checkLogin($args['password'], $args['duration']);
            }
            include (__DIR__ . '/../view/settings_app.php');
            break;
          case 'token':
            $txt = $this->session->checkLogin('password');
            include (__DIR__ . '/../view/settings_app.php');
            break;
          case 'logout':
            $_SESSION = array();
            if (ini_get("session.use_cookies")) {
              $params = session_get_cookie_params();
              setcookie('token', '', $_SESSION['logout_time'],
                  $params["path"], $params["domain"],
                  $params["secure"], $params["httponly"]
              );
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
      $applications = $this->application_view->build_app_grid($this->application->get_list(), $this->logged_in);
      $bookmarks = $this->bookmark_view->build_list($this->setting_obj['useOrdering'], false, $this->logged_in);
      include (__DIR__ . '/../view/main_view.php');
        break;
      }
  }

  protected function is_mdi_si($icon){
    if( (strpos($icon, '.jpg') === false) &&
        (strpos($icon, '.jpeg') === false) &&
        (strpos($icon, '.png') === false) &&
        (strpos($icon, '.svg') === false) &&
        (strpos($icon, 'si:') === false) &&
        (strpos($icon, '.ico') === false) ){
      return 'mdi:'.$icon;
    }elseif( (strpos($icon, 'si:') !== false) ){
      return $icon;
    }
  }

  protected function store_image(){
    $target_dir = __DIR__ . '/../../user_data/uploads/';
    $target_file = $target_dir . basename($_FILES["icon_file"]["name"]);
    $target_filename = basename($_FILES["icon_file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["icon_file"]["tmp_name"]);
      if($check !== false) {
        $uploadOk = 1;
      } else {
        $uploadOk = 0;
        $this->uploadOk = "File is not an image.";
      }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
      $uploadOk = 2;
    }

    // Check file size
    if ($_FILES["icon_file"]["size"] > 500000) {
      $uploadOk = 0;
      $this->uploadOk = "Sorry, your file is too large.";
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      $uploadOk = 0;
      $this->uploadOk = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      return false;
    // if everything is ok, try to upload file
    } elseif($uploadOk == 2) {
      $this->uploadOk = htmlspecialchars($target_filename, ENT_QUOTES);
      return true;
    } else {
      if (move_uploaded_file($_FILES["icon_file"]["tmp_name"], $target_file)) {
        $this->uploadOk = htmlspecialchars($target_filename, ENT_QUOTES);
        return true;
      } else {
        return false;
      }
    }
  }
}

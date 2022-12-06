<?php
namespace MHorwood\Dashboard\Controller;
use MHorwood\Dashboard\Model\application;

class DashboardController{

  protected $html;

  /**
  * Routing from index page
  **/
  public function process_action($args){
    if(isset($args['action']) && $args['action'] !== ''){
      echo 'some model here';
    }else{
      $this->html = '';
      $applications = $this->build_app_list(application::factory()->get());

      $bookmarks = '';
      include (__DIR__ . '/../view/main_view.php');
    }
  }

  private function build_app_list($applications){
    $app_list = '';
    foreach($applications as $key => $app){
      $app_list .= '<a href="'.$app['url'].'" target="_blank" rel="noreferrer" class="AppCard_AppCard__1V2_0">'."\n";
      $app_list .= '  <div class="AppCard_AppCardIcon__8ZZTq"></div>'."\n";
      $app_list .= '  <div class="AppCard_AppCardDetails__tbAhY">'."\n";
      $app_list .= '    <h5>'.$app['url'].'</h5>'."\n";
      $app_list .= '    <span>'.$app['name'].'</span>'."\n";
      $app_list .= '  </div>'."\n";
      $app_list .= '</a>'."\n";
    }
    return $app_list;
  }

}

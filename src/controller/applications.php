<?php
namespace MHorwood\Dashboard\controller;
use MHorwood\Dashboard\model\application;
use MHorwood\Dashboard\classes\application_view;

class applications{
  protected $application;
  protected $application_view;

  public function __construct($user_agent){
    $this->application = new application();
    $this->application_view = new application_view;
  }

  public function routing(){
    if($this->logged_in === false) {
      header('Location: /');
      exit;
    }
    if(isset($urls['type']) && $urls['type'] !== 'none'){
      if($args['description'] == '' && $urls['type'] != 'delete'){
        $args['description'] = $args['url'];
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
  }
}

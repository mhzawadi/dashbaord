<?php
namespace MHorwood\Dashboard\Model;
use MHorwood\Dashboard\classes\json;

class application extends json {

  protected $app_list;

  public function __construct(){
    $this->app_list = $this->load_from_file('../config/apps.json');
  }

  public function get_list(){
    return $this->app_list['apps'];
  }
}

<?php
namespace MHorwood\Dashboard\controller;
use MHorwood\Dashboard\model\flame;

class flame{
  public function __construct($user_agent){
    if(file_exists('../config/db.sqlite')){
      $this->flame = new flame();
      $this->flame->import_apps($this->application);
      $this->flame->import_categories($this->bookmark);
      $this->flame->import_bookmarks($this->bookmark);
    }
  }
}

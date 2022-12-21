<?php

namespace MHorwood\Dashboard\classes;

class docker {

  private $data;

  public function __construct(){
    set_time_limit(0);
    $ch = curl_init();
    curl_setopt_array ( $ch , [
      CURLOPT_URL => "http://localhost:8081/get_containers",
      CURLOPT_RETURNTRANSFER => true
      ] );
    $this->data = json_decode(curl_exec($ch));
    curl_close($ch);
  }

  public function get_data(){
    return $this->data;
  }
}

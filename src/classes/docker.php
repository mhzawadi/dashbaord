<?php

namespace MHorwood\Dashboard\classes;

/**
 * Docker collector
 *
 * This is used to connect to docker and collect all the running containers
 *
 */
class docker {

  /**
   * @var mixed[] The json array of the docker items
   */
  private $data;

  /**
   * Collect docker containers and store for later
   * @return void
   */
  public function __construct(){
    set_time_limit(0);
    $ch = curl_init();
    curl_setopt_array ( $ch , [
      CURLOPT_URL => "http://localhost:8081/get_containers",
      CURLOPT_RETURNTRANSFER => true
      ] );
    $this->data = json_decode(curl_exec($ch), true);
    curl_close($ch);
  }

  /**
   * @return mixed[] all the running containers
   */
  public function get_data(){
    return $this->data;
  }
}

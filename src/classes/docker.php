<?php

namespace MHorwood\Dashboard\classes;

class docker {
  private $SOCKET = '/var/run/docker.sock';
  private $HOST = 'localhost';

  public function __construct(){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_UNIX_SOCKET_PATH, $this->SOCKET);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_URL, 'http://'.$this->HOST.'/containers/json');
    $data = curl_exec($ch);
    print_r($data);
    curl_close($ch);
  }
}

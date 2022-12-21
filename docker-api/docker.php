<?php

namespace MHorwood\Dashboard_Docker;

class docker {
  private $SOCKET;
  private $HOST;
  private $connection;

  public function __construct($socket = '/var/run/docker.sock', $host = 'localhost'){
    $this->connection = curl_init();
    $this->SOCKET = $socket;
    $this->HOST = $host;

  }
  public function get_containers(){
    set_time_limit(0);
    $ch = $this->connection;
    curl_setopt($ch, CURLOPT_UNIX_SOCKET_PATH, $this->SOCKET);
    curl_setopt($ch, CURLOPT_BUFFERSIZE, 256);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1000000);
    curl_setopt($ch, CURLOPT_URL, "http://$this->HOST/containers/json?{\"status\":[\"running\"]}");
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;

  }
}

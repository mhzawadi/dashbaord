<?php

namespace MHorwood\Dashboard_Docker;

class docker {
  // Properties
  private $SOCKET;
  private $HOST;
  private $connection;
  private $containers;
  private $swarm;

  public function __construct($socket = '/var/run/docker.sock', $host = 'localhost'){
    $this->connection = curl_init();
    $this->SOCKET = $socket;
    $this->HOST = $host;
    set_time_limit(0);
    curl_setopt($this->connection, CURLOPT_UNIX_SOCKET_PATH, '/var/run/docker.sock');
    curl_setopt($this->connection, CURLOPT_BUFFERSIZE, 256);
    curl_setopt($this->connection, CURLOPT_TIMEOUT, 1000000);
    curl_setopt($this->connection, CURLOPT_RETURNTRANSFER , true);
    curl_setopt($this->connection, CURLOPT_URL, "http://$this->HOST/info");
    $host_info = json_decode(curl_exec($this->connection), true);
    curl_close($this->connection);
    $this->swarm  = $host_info['Swarm']['LocalNodeState'];
  }

  public function get_containers(){

    if($this->swarm === 'active'){
      $containers = $this->docker_swarm();
      $containers = $this->docker_node($containers);
    }else{
      $containers = $this->docker_node();
    }

    return $containers;
  }

  private function docker_node($node_containers = false){
    set_time_limit(0);
    $this->connection = $this->connection;
    curl_setopt($this->connection, CURLOPT_UNIX_SOCKET_PATH, $this->SOCKET);
    curl_setopt($this->connection, CURLOPT_BUFFERSIZE, 256);
    curl_setopt($this->connection, CURLOPT_TIMEOUT, 1000000);
    curl_setopt($this->connection, CURLOPT_RETURNTRANSFER , true);
    curl_setopt($this->connection, CURLOPT_URL, "http://$this->HOST/containers/json?{\"status\":[\"running\"]}");
    $containers = json_decode(curl_exec($this->connection), true);
    curl_close($this->connection);

    $count = count($containers);
    if($node_containers !== false){
      $container_list = json_decode($node_containers, true);
    }else{
      $container_list = array();
    }
    $start = count($container_list);
    $d = $start;
    for($c = 0; $c < $count; $c++){
      if( (array_key_exists('dashboard.ignore', $containers[$c]['Labels']) === false) ||
          ( array_key_exists('traefik.enable', $containers[$c]['Labels']) &&
            $containers[$c]['Labels']['traefik.enable'] === false) ||
          (array_key_exists('com.docker.stack.namespace', $containers[$c]['Labels']) === false)
        ){
        $container_list[$d]['name'] = str_replace('/', '', $containers[$c]['Names'][0]);
        foreach($containers[$c]['Labels'] as $key => $label){
          if( (strpos($key, 'traefik.http.routers') !== false) && (strpos($key, 'rule') !== false) ){
            if (strpos($label, ' || ') !== false){
              $hosts = explode(str_replace(array('Host(`','`)'), '', $label));
              $container_list[$d]['url'] = $hosts[0];
            }else{
              $container_list[$d]['url'] = str_replace(array('Host(`','`)'), '', $label);
            }
          }
          if( $key === 'dashboard.url' ){
            $container_list[$d]['url'] = $label;
          }
          if( $key === 'dashboard.name' ){
            $container_list[$d]['name'] = $label;
          }
          if( $key === 'dashboard.description' ){
            $container_list[$d]['description'] = $label;
          }
          if( $key === 'dashboard.icon' ){
            $container_list[$d]['icon'] = $label;
          }
          if( $key === 'traefik.enable' ){
            $container_list[$d]['enable'] = $label;
          }
          if( $key === 'dashboard.https' ){
            $container_list[$d]['https'] = $label;
          }
          if(!isset($container_list[$d]['description'])){
            $container_list[$d]['description'] = '';
          }
          if(!isset($container_list[$d]['https'])){
            $container_list[$d]['https'] = false;
          }
        }
        $d++;
      }else{
        if($d > 0){
          --$d;
        }
      }
    }
    return json_encode($container_list);
  }

  private function docker_swarm(){
    set_time_limit(0);
    $this->connection = $this->connection;
    curl_setopt($this->connection, CURLOPT_UNIX_SOCKET_PATH, $this->SOCKET);
    curl_setopt($this->connection, CURLOPT_BUFFERSIZE, 256);
    curl_setopt($this->connection, CURLOPT_TIMEOUT, 1000000);
    curl_setopt($this->connection, CURLOPT_RETURNTRANSFER , true);
    curl_setopt($this->connection, CURLOPT_URL, "http://$this->HOST/services");
    $containers = json_decode(curl_exec($this->connection), true);
    curl_close($this->connection);

    $count = count($containers);
    $container_list = array();
    $d = 0;
    for($c = 0; $c < $count; $c++){
      if( (array_key_exists('dashboard.ignore', $containers[$c]['Spec']['Labels']) === false) ||
          ( array_key_exists('traefik.enable', $containers[$c]['Spec']['Labels']) &&
            $containers[$c]['Spec']['Labels']['traefik.enable'] === false)
        ){
        $container_list[$d]['name'] = $containers[$c]['Spec']['Name'];
        foreach($containers[$c]['Spec']['Labels'] as $key => $label){
          if( (strpos($key, 'traefik.http.routers') !== false) && (strpos($key, 'rule') !== false) ){
            if (strpos($label, ' || ') !== false){
              $hosts = explode(' || ', str_replace(array('Host(`','`)'), '', $label));
              $container_list[$d]['url'] = $hosts[0];
            }else{
              $container_list[$d]['url'] = str_replace(array('Host(`','`)'), '', $label);
            }
          }
          if( $key === 'dashboard.url' ){
            $container_list[$d]['url'] = $label;
          }
          if( $key === 'dashboard.name' ){
            $container_list[$d]['name'] = $label;
          }
          if( $key === 'dashboard.description' ){
            $container_list[$d]['description'] = $label;
          }
          if( $key === 'dashboard.icon' ){
            $container_list[$d]['icon'] = $label;
          }
          if( $key === 'traefik.enable' ){
            $container_list[$d]['enable'] = $label;
          }
          if( $key === 'dashboard.https' ){
            $container_list[$d]['https'] = $label;
          }
          if(!isset($container_list[$d]['description'])){
            $container_list[$d]['description'] = '';
          }
          if(!isset($container_list[$d]['https'])){
            $container_list[$d]['https'] = false;
          }
        }
        $d++;
      }else{
        if($d > 0){
          --$d;
        }
      }
    }
    return json_encode($container_list);
  }
}

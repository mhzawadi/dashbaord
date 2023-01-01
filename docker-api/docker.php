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
    $ch = $this->connection;
    curl_setopt($ch, CURLOPT_UNIX_SOCKET_PATH, $this->SOCKET);
    curl_setopt($ch, CURLOPT_BUFFERSIZE, 256);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1000000);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
    curl_setopt($ch, CURLOPT_URL, "http://$this->HOST/info");
    $host_info = json_decode(curl_exec($ch), true);
    if($host_info['Swarm']['LocalNodeState'] == 'active'){
      $this->swarm = 'services';
    }else{
      $this->swarm = 'containers/json?{\"status\":[\"running\"]}';
    }
  }
  public function get_containers(){
    set_time_limit(0);
    $ch = $this->connection;
    curl_setopt($ch, CURLOPT_UNIX_SOCKET_PATH, $this->SOCKET);
    curl_setopt($ch, CURLOPT_BUFFERSIZE, 256);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1000000);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
    curl_setopt($ch, CURLOPT_URL, "http://$this->HOST/$this->swarm");
    $containers = json_decode(curl_exec($ch), true);
    curl_close($ch);
    if($this->swarm === 'services'){
      return $this->docker_swarm($containers);
    }else{
      return $this->docker_node($containers);
    }
  }

  private function docker_node($containers){
    $count = count($containers);
    $container_list = array();
    $d = 0;
    for($c = 0; $c < $count; $c++){
      if( (array_key_exists('dashboard.ignore', $containers[$c]['Labels']) === false) ||
          ( array_key_exists('traefik.enable', $containers[$c]['Labels']) &&
            $containers[$c]['Labels']['traefik.enable'] === false)
        ){
        $container_list[$d]['name'] = str_replace('/', '', $containers[$c]['Names'][0]);
        foreach($containers[$c]['Labels'] as $key => $label){
          if( (strpos($key, 'traefik.http.routers') !== false) && (strpos($key, 'rule') !== false) ){
            $container_list[$d]['url'] = str_replace(array('Host(`','`)'), '', $label);
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
          if( $key === 'traefik.enable' ){
            $container_list[$d]['enable'] = $label;
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

  private function docker_swarm($containers){
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
            $container_list[$d]['url'] = str_replace(array('Host(`','`)'), '', $label);
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
          if( $key === 'traefik.enable' ){
            $container_list[$d]['enable'] = $label;
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

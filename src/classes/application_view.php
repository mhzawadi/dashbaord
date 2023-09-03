<?php

namespace MHorwood\Dashboard\classes;

class application_view {
  protected function remove_http($string){
    $replace = array('http-', 'https-');
    return str_replace($replace, '', $string);
  }
  protected function set_http($string){
    $replace = array('http-', 'https-');
    $with = array('http://', 'https://');
    return str_replace($replace, $with, $string);
  }

  protected function set_js($app_id, $app, $array_id = null, $value = null){
    $js_object[0] = $app_id;
    $js_object[1] = $app['name'];
    $js_object[2] = $this->set_http($app['url']);
    $js_object[3] = $app['isPublic'];
    $js_object[4] = $app['icon'];
    $js_object[5] = $app['description'];
    $js_object[6] = $app['orderId'];

    if(isset($array_id) !== null){
      $js_object[$array_id] = $value;
    }

    return implode("','",$js_object);
  }

  public function build_app_grid($applications, $logged_in){
    $app_list = '';
    foreach($applications as $key => $app){
      if( ($app['isPublic'] == 1 && $logged_in === false) ||
          ($logged_in === true)
      ){
        $app_list .= '<a href="'.$this->set_http($app['url']).'" target="_blank" rel="noreferrer" class="AppCard_AppCard__1V2_0">'."\n";
        $app_list .= '  <div class="AppCard_AppCardIcon__8ZZTq">';
        if(strpos($app['icon'], 'mdi:') === false && strpos($app['icon'], 'si:') === false){
          $app_list .= '    <img src="/uploads/'.$app['icon'].'" alt="'.$app['description'].'" class="BookmarkCard_CustomIcon__2I7Wo">'."\n";
        }elseif(strpos($app['icon'], 'si:') !== false){ // is not false
          $parts= explode(':', $app['icon']);
          $category_list .= file_get_contents('../../vendor/simple-icons/simple-icons/icons/'.str_replace('si:', '', $parts[1]).'.svg')."\n";
        }else{
          $app_list .= '    <span class="iconify" data-icon="'.$app['icon'].'" data-width="24"></span>'."\n";
        }
        $app_list .= '  </div>'."\n";
        $app_list .= '  <div class="AppCard_AppCardDetails__tbAhY">'."\n";
        $app_list .= '    <h5>'.$app['name'].'</h5>'."\n";
        $app_list .= '    <span>'.substr($this->remove_http($app['url']), 0, 40).'</span>'."\n";
        $app_list .= '  </div>'."\n";
        $app_list .= '</a>'."\n";
      }
    }
    return $app_list;
  }

  public function build_app_table($applications){
    $app_list = '';
    $app_list .= '<div class="Table_TableContainer__UrXXd">'."\n";
    $app_list .= '<table id="table" class="Table_Table__pinST table">'."\n";
    $app_list .= '<thead>'."\n";
    $app_list .= '<tr>'."\n";
    $app_list .= '<th>Name</th>'."\n";
    $app_list .= '<th>URL</th>'."\n";
    $app_list .= '<th>Icon</th>'."\n";
    $app_list .= '<th>Visibility</th>'."\n";
    $app_list .= '<th>Order</th>'."\n";
    $app_list .= '<th>Actions</th>'."\n";
    $app_list .= '</tr>'."\n";
    $app_list .= '</thead>'."\n";
    $app_list .= '<tbody>'."\n";
    foreach($applications as $key => $app){
      if($app['url'] == $app['description']){
        $app['description'] = '';
      }
      $app['icon'] = str_replace('mdi:', '', $app['icon']);
      $app_list .= '<tr>'."\n";
      $app_list .= '  <td style="width: 350px;">'.$app['name'].'</td>'."\n";
      $app_list .= '  <td style="width: 200px;">'.$this->remove_http($app['url']).'</td>'."\n";
      $app_list .= '  <td style="width: 200px;">'.$app['icon'].'</td>'."\n";
      if($app['isPublic'] == 0){
        $app_list .= '  <td style="width: 200px;">Hidden</td>'."\n";
      }else{
        $app_list .= '  <td style="width: 200px;">Visible</td>'."\n";
      }
      $app_list .= '  <td style="width: 50px;"><input type="number" min="1" max="200" name="order" value="'.$app['orderId'].'" onchange="app_order(this.value, \''.$this->set_js($key, $app).'\')"></td>'."\n";
      $app_list .= '  <td class="TableActions_TableActions__2_v2I">'."\n";
      $app_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0" onclick="delete_application('.$key.')">'."\n";
      $app_list .= '        <span class="iconify" data-icon="mdi:delete" data-width="18"></span>'."\n";
      $app_list .= '      </div>'."\n";
      $app_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0" onclick="edit_app(\''.$this->set_js($key, $app).'\')">'."\n";
      $app_list .= '        <span class="iconify" data-icon="mdi:pencil" data-width="18"></span>'."\n";
      $app_list .= '      </div>'."\n";
      $app_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $app_list .= '        <span class="iconify" data-icon="mdi:pin-off" data-width="18"></span>'."\n";
      $app_list .= '      </div>'."\n";
      if( ($app['isPublic'] == 0 ) ){
        $app_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0" onclick="edit_app(\''.$this->set_js($key, $app, 3, 1).'\', true)">'."\n";
        $app_list .= '        <span class="iconify" data-icon="mdi:eye-off" data-width="18"></span>'."\n";
      }else{
        $app_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0" onclick="edit_app(\''.$this->set_js($key, $app, 3, 0).'\', true)">'."\n";
        $app_list .= '        <span class="iconify" data-icon="mdi:eye" data-width="18"></span>'."\n";
      }
      $app_list .= '      </div>'."\n";
      $app_list .= '  </td>'."\n";
      $app_list .= '</tr>'."\n";
    }
    $app_list .= '</tbody>'."\n";
    $app_list .= '</table>'."\n";
    $app_list .= '</div>'."\n";
    return $app_list;
  }
}

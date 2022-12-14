<?php

namespace MHorwood\Dashboard\classes;

class application_view {
  protected function remove_http($string){
    $replace = array('http://', 'https://');
    return str_replace($replace, '', $string);
  }

  public function build_app_grid($applications, $logged_in){
    $app_list = '';
    foreach($applications as $key => $app){
      if( ($app['isPublic'] == 1 && $logged_in === false) ||
          ($logged_in === true)
      ){
        $app_list .= '<a href="'.$app['url'].'" target="_blank" rel="noreferrer" class="AppCard_AppCard__1V2_0">'."\n";
        $app_list .= '  <div class="AppCard_AppCardIcon__8ZZTq">';
        if(strpos($app['icon'], 'mdi:') === false){
          $app_list .= '    <img src="/uploads/'.$app['icon'].'" alt="'.$app['description'].'" class="BookmarkCard_CustomIcon__2I7Wo">'."\n";
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
    $app_list .= '<table class="Table_Table__pinST">'."\n";
    $app_list .= '<thead>'."\n";
    $app_list .= '<tr>'."\n";
    $app_list .= '<th>Name</th>'."\n";
    $app_list .= '<th>URL</th>'."\n";
    $app_list .= '<th>Icon</th>'."\n";
    $app_list .= '<th>Visibility</th>'."\n";
    $app_list .= '<th>Actions</th>'."\n";
    $app_list .= '</tr>'."\n";
    $app_list .= '</thead>'."\n";
    $app_list .= '<tbody>'."\n";
    foreach($applications as $key => $app){
      if($app['url'] == $app['description']){
        $app['description'] = '';
      }
      $app['icon'] = str_replace('mdi:', '', $app['icon']);
      $app_list .= '<tr data-rbd-draggable-context-id="1" data-rbd-draggable-id="46" tabindex="0" role="button" aria-describedby="rbd-hidden-text-1-hidden-text-22" data-rbd-drag-handle-draggable-id="46" data-rbd-drag-handle-context-id="1" draggable="false">'."\n";
      $app_list .= '  <td style="width: 200px;">'.$app['name'].'</td>'."\n";
      $app_list .= '  <td style="width: 200px;">'.$app['url'].'</td>'."\n";
      $app_list .= '  <td style="width: 200px;">'.$app['icon'].'</td>'."\n";
      $app_list .= '  <td style="width: 200px;">'.$app['isPublic'].'</td>'."\n";
      $app_list .= '  <td class="TableActions_TableActions__2_v2I">'."\n";
      $app_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0" onclick="delete_application('.$key.')">'."\n";
      $app_list .= '        <span class="iconify" data-icon="mdi:delete" data-width="18"></span>'."\n";
      $app_list .= '      </div>'."\n";
      $app_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0" onclick="edit_app(\''.$key.'\',\''.$app['name'].'\',\''.$app['url'].'\',\''.$app['isPublic'].'\',\''.$app['icon'].'\',\''.$app['description'].'\')">'."\n";
      $app_list .= '        <span class="iconify" data-icon="mdi:pencil" data-width="18"></span>'."\n";
      $app_list .= '      </div>'."\n";
      $app_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $app_list .= '        <span class="iconify" data-icon="mdi:pin-off" data-width="18"></span>'."\n";
      $app_list .= '      </div>'."\n";
      if( ($app['isPublic'] == 0 ) ){
        $app_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0" onclick="edit_app(\''.$key.'\',\''.$app['name'].'\',\''.$app['url'].'\',\'1\',\''.$app['icon'].'\',\''.$app['description'].'\', true)">'."\n";
        $app_list .= '        <span class="iconify" data-icon="mdi:eye-off" data-width="18"></span>'."\n";
      }else{
        $app_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0" onclick="edit_app(\''.$key.'\',\''.$app['name'].'\',\''.$app['url'].'\',\'0\',\''.$app['icon'].'\',\''.$app['description'].'\', true)">'."\n";
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

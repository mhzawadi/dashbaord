<?php

namespace MHorwood\Dashboard\classes;

class application {
  public function build_app_grid($applications){
    $app_list = '';
    foreach($applications as $key => $app){
      $app_list .= '<a href="'.$app['url'].'" target="_blank" rel="noreferrer" class="AppCard_AppCard__1V2_0">'."\n";
      $app_list .= '  <div class="AppCard_AppCardIcon__8ZZTq"></div>'."\n";
      $app_list .= '  <div class="AppCard_AppCardDetails__tbAhY">'."\n";
      $app_list .= '    <h5>'.$app['name'].'</h5>'."\n";
      $app_list .= '    <span>'.$app['url'].'</span>'."\n";
      $app_list .= '  </div>'."\n";
      $app_list .= '</a>'."\n";
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
      $app_list .= '<tr data-rbd-draggable-context-id="1" data-rbd-draggable-id="46" tabindex="0" role="button" aria-describedby="rbd-hidden-text-1-hidden-text-22" data-rbd-drag-handle-draggable-id="46" data-rbd-drag-handle-context-id="1" draggable="false" style="border: none; border-radius: 4px;">'."\n";
      $app_list .= '  <td style="width: 200px;">'.$app['name'].'</td>'."\n";
      $app_list .= '  <td style="width: 200px;">http://'.$app['name'].'</td>'."\n";
      $app_list .= '  <td style="width: 200px;">'.$app['icon'].'</td>'."\n";
      $app_list .= '  <td style="width: 200px;">'.$app['isPublic'].'</td>'."\n";
      $app_list .= '  <td class="TableActions_TableActions__2_v2I">'."\n";
      $app_list .= '    <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $app_list .= '      D'."\n";
      $app_list .= '    </div>'."\n";
      $app_list .= '    <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $app_list .= '      E'."\n";
      $app_list .= '    </div>'."\n";
      $app_list .= '    <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $app_list .= '      P'."\n";
      $app_list .= '    </div>'."\n";
      $app_list .= '    <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $app_list .= '      L'."\n";
      $app_list .= '    </div>'."\n";
      $app_list .= '  </td>'."\n";
      $app_list .= '</tr>'."\n";
    }
    $app_list .= '</tbody>'."\n";
    $app_list .= '</table>'."\n";
    $app_list .= '</div>'."\n";
    return $app_list;
  }
}

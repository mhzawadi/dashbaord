<?php

namespace MHorwood\Dashboard\classes;
use MHorwood\Dashboard\classes\bookmark as Class_Bookmark;
use MHorwood\Dashboard\Model\bookmark;
use MHorwood\Dashboard\Model\category as model_category;

class category {
  public function build_category_option(){
    $categorys = model_category::factory()->select('id, name')->get();
    $category_options = '';
    foreach($categorys as $key => $category){
      $category_options .= '<option value="'.$category['id'].'">'.$category['name'].'</option>';
    }
    return $category_options;
  }
  public function build_category_list($categorys, $link = false){
    $this->bookmark = new Class_Bookmark;
    $category_list = '';
    $category_list .= '<div class="BookmarkGrid_BookmarkGrid__26LlR">';
    foreach($categorys as $key => $category){
      $category_list .= '<div class="BookmarkCard_BookmarkCard__1GmHc">'."\n";
      if($link === true){
        $category_list .= '  <h3 class=""><a href="/bookmark/'.$category['id'].'">'.$category['name'].'</a></h3>'."\n";
      }else{
        $category_list .= '  <h3 class="">'.$category['name'].'</h3>'."\n";
      }
      $category_list .= $this->bookmark->build_bookmark_list(bookmark::factory()->where('categoryId', '=', $category['id']));
      $category_list .= '</div>'."\n";
    }
    $category_list .= '</div>'."\n";
    return $category_list;
  }
  public function build_category_table($categories){
    $category_list = '';
    $category_list .= '<div class="Table_TableContainer__UrXXd">'."\n";
    $category_list .= '  <table class="Table_Table__pinST">'."\n";
    $category_list .= '    <thead>'."\n";
    $category_list .= '      <tr>'."\n";
    $category_list .= '        <th>Name</th>'."\n";
    $category_list .= '        <th>Visibility</th>'."\n";
    $category_list .= '        <th>Actions</th>'."\n";
    $category_list .= '      </tr>'."\n";
    $category_list .= '    </thead>'."\n";
    $category_list .= '  <tbody>'."\n";
    foreach($categories as $key => $category){
      $category_list .= '  <tr data-rbd-draggable-context-id="1" data-rbd-draggable-id="46" tabindex="0" role="button" aria-describedby="rbd-hidden-text-1-hidden-text-22" data-rbd-drag-handle-draggable-id="46" data-rbd-drag-handle-context-id="1" draggable="false" style="border: none; border-radius: 4px;">'."\n";
      $category_list .= '    <td style="width: 200px;">'.$category['name'].'</td>'."\n";
      $category_list .= '    <td style="width: 200px;">'.$category['isPublic'].'</td>'."\n";
      $category_list .= '    <td class="TableActions_TableActions__2_v2I">'."\n";
      $category_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $category_list .= '        <span class="iconify" data-icon="mdi:delete" data-width="18"></span>'."\n";
      $category_list .= '      </div>'."\n";
      $category_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0" onclick="category_edit(\''.$category['id'].'\',\''.$category['name'].'\', '.$category['isPublic'].')">'."\n";
      $category_list .= '        <span class="iconify" data-icon="mdi:pencil" data-width="18"></span>'."\n";
      $category_list .= '      </div>'."\n";
      $category_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $category_list .= '        <span class="iconify" data-icon="mdi:pin-off" data-width="18"></span>'."\n";
      $category_list .= '      </div>'."\n";
      $category_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $category_list .= '        <span class="iconify" data-icon="mdi:eye-off" data-width="18"></span>'."\n";
      $category_list .= '      </div>'."\n";
      $category_list .= '    </td>'."\n";
      $category_list .= '  </tr>'."\n";
    }
    $category_list .= '    </tbody>'."\n";
    $category_list .= '  </table>'."\n";
    $category_list .= '</div>'."\n";
    return $category_list;
  }
}
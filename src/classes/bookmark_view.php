<?php

namespace MHorwood\Dashboard\classes;

class bookmark_view {

  public function __construct($bookmarks){
    $this->bookmark = $bookmarks;
  }

  protected function set_js($bookmark_id, $bookmark, $array_id = null, $value = null){
    $js_object[0] = $bookmark_id;
    $js_object[1] = $bookmark['name'];
    $js_object[2] = $bookmark['url'];
    $js_object[3] = $bookmark['categoryId'];
    $js_object[4] = $bookmark['isPublic'];
    $js_object[5] = $bookmark['icon'];
    $js_object[6] = $bookmark['orderId'];
    if(isset($array_id) !== null){
      $js_object[$array_id] = $value;
    }
    return implode("','",$js_object);
  }

  public function build_list($useOrdering, $link = false, $logged_in){
    $bookmarks = $this->bookmark->get_list($useOrdering);
    $category_list = '';
    $category_list .= '<div class="BookmarkGrid_BookmarkGrid__26LlR">';
    foreach($bookmarks as $key => $category){
      if( ($category['isPublic'] == 1 ) || ($logged_in === true) ){
        $category_list .= '<div class="BookmarkCard_BookmarkCard__1GmHc">'."\n";
        if($link === true){
          $category_list .= '  <h3 class="BookmarkCard_BookmarkHeader__112bh"><a href="/bookmarks/'.$key.'">'.$category['name'].'</a></h3>'."\n";
        }else{
          $category_list .= '  <h3 class="BookmarkCard_BookmarkHeader__112bh">'.$category['name'].'</h3>'."\n";
        }
        $category_list .= '  <div class="BookmarkCard_Bookmarks__YhsfD">'."\n";
        foreach($category['bookmarks'] as $key => $bookmark){
          if( ($bookmark['isPublic'] == 1 ) || ($logged_in === true) ){
            $category_list .= '    <a href="'.$bookmark['url'].'" target="_blank" rel="noreferrer">'."\n";
            $category_list .= '      <div class="BookmarkCard_BookmarkIcon__2c2C5">'."\n";
            if(strpos($bookmark['icon'], 'mdi:') === false && strpos($bookmark['icon'], 'si:') === false){
              $category_list .= '        <img src="/uploads/'.$bookmark['icon'].'" alt="'.$bookmark['name'].'" class="BookmarkCard_CustomIcon__2I7Wo">'."\n";
            }elseif(strpos($bookmark['icon'], 'si:') !== false){
              $parts= explode(':', $bookmark['icon']);
              $category_list .= file_get_contents('../../vendor/simple-icons/simple-icons/icons/'.str_replace('si:', '', $parts[1]).'.svg')."\n";
            }else{
              $category_list .= '        <span class="iconify" data-icon="'.$bookmark['icon'].'" data-width="20"></span>'."\n";
            }
            $category_list .= '      </div>'."\n";
            $category_list .= ''.$bookmark['name'].'</a>'."\n";
          }
        }
        $category_list .= '</div>'."\n";
        $category_list .= '</div>'."\n";
      }
    }
    $category_list .= '</div>'."\n";
    return $category_list;
  }



  public function build_bookmark_list($bookmarks_object){
    $bookmarks = $bookmarks_object->select('id, name, url, icon')->get();
    $bookmark_list = '';
    $bookmark_list .= '  <div class="BookmarkCard_Bookmarks__YhsfD">'."\n";
    foreach($bookmarks as $key => $bookmark){
      $bookmark_list .= '    <a href="'.$bookmark['url'].'" target="_blank" rel="noreferrer">'."\n";
      $bookmark_list .= '      <div class="BookmarkCard_BookmarkIcon__2c2C5">'."\n";
      if(strpos($bookmark['icon'], 'mdi:') === false && strpos($bookmark['icon'], 'si:') === false){
        $bookmark_list .= '        <img src="/uploads/'.$bookmark['icon'].'" alt="'.$bookmark['name'].'" class="BookmarkCard_CustomIcon__2I7Wo">'."\n";
      }elseif(strpos($bookmark['icon'], 'si:') !== false){
        $bookmark_list .= file_get_contents('../../vendor/simple-icons/simple-icons/icons/'.$bookmark['icon'].'.svg')."\n";
      }else{
        $bookmark_list .= '        <span class="iconify" data-icon="mdi:'.$bookmark['icon'].'" data-width="20"></span>'."\n";
      }
      $bookmark_list .= '      </div>'."\n";
      $bookmark_list .= ''.$bookmark['name'].'</a>'."\n";
    }
    $bookmark_list .= '  </div>'."\n";
    return $bookmark_list;
  }
  public function build_bookmark_table($category){
    $bookmarks = $this->bookmark->get_bookmark($category);
    $bookmark_list = '';
    $bookmark_list .= '<div class="Table_TableContainer__UrXXd">'."\n";
    $bookmark_list .= '  <table class="Table_Table__pinST">'."\n";
    $bookmark_list .= '    <thead>'."\n";
    $bookmark_list .= '      <tr>'."\n";
    $bookmark_list .= '        <th>Name</th>'."\n";
    $bookmark_list .= '        <th>URL</th>'."\n";
    $bookmark_list .= '        <th>Icon</th>'."\n";
    $bookmark_list .= '        <th>Visibility</th>'."\n";
    $bookmark_list .= '        <th>Category</th>'."\n";
    $bookmark_list .= '        <th>Order</th>'."\n";
    $bookmark_list .= '        <th>Actions</th>'."\n";
    $bookmark_list .= '      </tr>'."\n";
    $bookmark_list .= '    </thead>'."\n";
    $bookmark_list .= '  <tbody>'."\n";
    foreach($bookmarks['bookmarks'] as $key => $bookmark){
      $bookmark['categoryId'] = $category;
      $js_object = '';
      $bookmark['icon'] = str_replace('mdi:', '', $bookmark['icon']);
      $bookmark_list .= '  <tr data-rbd-draggable-context-id="1" data-rbd-draggable-id="46" tabindex="0" role="button" aria-describedby="rbd-hidden-text-1-hidden-text-22" data-rbd-drag-handle-draggable-id="46" data-rbd-drag-handle-context-id="1" draggable="false">'."\n";
      $bookmark_list .= '    <td style="width: 200px;">'.$bookmark['name'].'</td>'."\n";
      $bookmark_list .= '    <td style="width: 400px;">'.$bookmark['url'].'</td>'."\n";
      $bookmark_list .= '    <td style="width: 200px;">'.$bookmark['icon'].'</td>'."\n";
      if($bookmark['isPublic'] == 0){
        $bookmark_list .= '    <td style="width: 200px;">Hidden</td>'."\n";
      }else{
        $bookmark_list .= '    <td style="width: 200px;">Visible</td>'."\n";
      }
      $bookmark_list .= '    <td style="width: 100px;">'.$bookmarks['name'].'</td>'."\n";
      $bookmark_list .= '    <td style="width: 100px;"><input type="number" min="1" max="200" name="order" value="'.$bookmark['orderId'].'" onchange="bookmark_order(this.value, \''.$this->set_js($key, $bookmark).'\')"></td>'."\n";
      $bookmark_list .= '    <td class="TableActions_TableActions__2_v2I">'."\n";
      $bookmark_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0" onclick="delete_bookmark('.$category.', '.$key.')">'."\n";
      $bookmark_list .= '        <span class="iconify" data-icon="mdi:delete" data-width="18"></span>'."\n";
      $bookmark_list .= '      </div>'."\n";
      $bookmark_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0" onclick="edit_bookmark(\''.$this->set_js($key, $bookmark).'\')">'."\n";
      $bookmark_list .= '        <span class="iconify" data-icon="mdi:pencil" data-width="18"></span>'."\n";
      $bookmark_list .= '      </div>'."\n";
      $bookmark_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $bookmark_list .= '        <span class="iconify" data-icon="mdi:pin-off" data-width="18"></span>'."\n";
      $bookmark_list .= '      </div>'."\n";
      if( ($bookmark['isPublic'] == 0 ) ){
        $bookmark_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0" onclick="edit_bookmark(\''.$this->set_js($key, $bookmark, 4, 1).'\',true)">'."\n";
        $bookmark_list .= '        <span class="iconify" data-icon="mdi:eye-off" data-width="18"></span>'."\n";
      } else {
        $bookmark_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0" onclick="edit_bookmark(\''.$this->set_js($key, $bookmark, 4, 0).'\',true)">'."\n";
        $bookmark_list .= '        <span class="iconify" data-icon="mdi:eye" data-width="18"></span>'."\n";
      }
      $bookmark_list .= '      </div>'."\n";
      $bookmark_list .= '    </td>'."\n";
      $bookmark_list .= '  </tr>'."\n";
    }
    $bookmark_list .= '    </tbody>'."\n";
    $bookmark_list .= '  </table>'."\n";
    $bookmark_list .= '</div>'."\n";
    return $bookmark_list;
  }
}

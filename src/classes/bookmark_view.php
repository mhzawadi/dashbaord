<?php

namespace MHorwood\Dashboard\classes;

class bookmark_view {

  public function __construct($bookmarks){
    $this->bookmark = $bookmarks;
  }

  public function build_list($link = false){
    $bookmarks = $this->bookmark->get_list();
    $category_list = '';
    $category_list .= '<div class="BookmarkGrid_BookmarkGrid__26LlR">';
    foreach($bookmarks as $key => $category){
      $category_list .= '<div class="BookmarkCard_BookmarkCard__1GmHc">'."\n";
      if($link === true){
        $category_list .= '  <h3 class=""><a href="/bookmarks/'.$key.'">'.$category['name'].'</a></h3>'."\n";
      }else{
        $category_list .= '  <h3 class="">'.$category['name'].'</h3>'."\n";
      }
      foreach($category['bookmarks'] as $key => $bookmark){
        $category_list .= '   <a href="'.$bookmark['url'].'" target="_blank" rel="noreferrer"><div class="BookmarkCard_BookmarkIcon__2c2C5">';
        $category_list .= '<span class="iconify" data-icon="mdi:'.$bookmark['icon'].'" data-width="20"></span></div> ';
        $category_list .= ''.$bookmark['name'].'</a>'."\n";
      }
      $category_list .= '</div>'."\n";
    }
    $category_list .= '</div>'."\n";
    return $category_list;
  }



  public function build_bookmark_list($bookmarks_object){
    $bookmarks = $bookmarks_object->select('id, name, url, icon')->get();
    $bookmark_list = '';
    $bookmark_list .= '  <div class="BookmarkCard_Bookmarks__YhsfD">'."\n";
    foreach($bookmarks as $key => $bookmark){
      $bookmark_list .= '   <a href="'.$bookmark['url'].'" target="_blank" rel="noreferrer"><div class="BookmarkCard_BookmarkIcon__2c2C5">';
      $bookmark_list .= '<span class="iconify" data-icon="mdi:'.$bookmark['icon'].'" data-width="20"></span></div> ';
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
    $bookmark_list .= '        <th>Actions</th>'."\n";
    $bookmark_list .= '      </tr>'."\n";
    $bookmark_list .= '    </thead>'."\n";
    $bookmark_list .= '  <tbody>'."\n";
    foreach($bookmarks as $key => $bookmark){
      $bookmark_list .= '  <tr data-rbd-draggable-context-id="1" data-rbd-draggable-id="46" tabindex="0" role="button" aria-describedby="rbd-hidden-text-1-hidden-text-22" data-rbd-drag-handle-draggable-id="46" data-rbd-drag-handle-context-id="1" draggable="false" style="border: none; border-radius: 4px;">'."\n";
      $bookmark_list .= '    <td style="width: 200px;">'.$bookmark['name'].'</td>'."\n";
      $bookmark_list .= '    <td style="width: 400px;">'.$bookmark['url'].'</td>'."\n";
      $bookmark_list .= '    <td style="width: 200px;">'.$bookmark['icon'].'</td>'."\n";
      $bookmark_list .= '    <td style="width: 100px;">'.$bookmark['isPublic'].'</td>'."\n";
      $bookmark_list .= '    <td style="width: 100px;">'.$category.'</td>'."\n";
      $bookmark_list .= '    <td class="TableActions_TableActions__2_v2I">'."\n";
      $bookmark_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $bookmark_list .= '        <span class="iconify" data-icon="mdi:delete" data-width="18"></span>'."\n";
      $bookmark_list .= '      </div>'."\n";
      $bookmark_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0" onclick="edit_bookmark(\''.$key.'\',\''.$bookmark['name'].'\',\''.$bookmark['url'].'\',\''.$category.'\',\''.$bookmark['isPublic'].'\',\''.$bookmark['icon'].'\',)">'."\n";
      $bookmark_list .= '        <span class="iconify" data-icon="mdi:pencil" data-width="18"></span>'."\n";
      $bookmark_list .= '      </div>'."\n";
      $bookmark_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $bookmark_list .= '        <span class="iconify" data-icon="mdi:pin-off" data-width="18"></span>'."\n";
      $bookmark_list .= '      </div>'."\n";
      $bookmark_list .= '      <div class="TableActions_TableAction__tc3XZ" tabindex="0">'."\n";
      $bookmark_list .= '        <span class="iconify" data-icon="mdi:eye-off" data-width="18"></span>'."\n";
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

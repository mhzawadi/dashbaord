
    if(isset($args['action']) && $args['action'] !== '' && !isset($args['category'])){
      switch ($args['action']) {
        case 'settings':

          }
          break;
        case 'applications':
          $this->html = '';
          $applications = $this->app->build_app_table(application::factory()->get());
          include (__DIR__ . '/../view/edit_apps.php');
          break;
        case 'application_edit':
          if($args['description'] == ''){
            $args['description'] = $args['url'];
          }
          if($args['application_id'] == 0){
            application::factory()->insert(array(
              'name'=>$args['name'],
              'url'=>$args['url'],
              'icon'=>$args['icon'],
              'description'=>$args['description'],
              'isPublic'=>$args['isPublic'],
              'createdAt'=>date('Y-m-d H:i:s'),
              'updatedAt'=>date('Y-m-d H:i:s')
            ));
          }else{
            $app = application::factory()->where('id', '=', $args['application_id']);
            $app->update(array(
              'name'=>$args['name'],
              'url'=>$args['url'],
              'icon'=>$args['icon'],
              'description'=>$args['description'],
              'isPublic'=>$args['isPublic'],
              'updatedAt'=>date('Y-m-d H:i:s')
            ));
          }
          $this->html = '';
          $applications = $this->app->build_app_table(application::factory()->get());
          include (__DIR__ . '/../view/edit_apps.php');
          break;
        case 'bookmarks':
          $this->html = '';
          $bookmarks = $this->category->build_category_list(category::factory()->get(), true);
          include (__DIR__ . '/../view/edit_bookmarks.php');
          break;
        case 'bookmark':
          $category_options = $this->category->build_category_option($args['id']);
          $bookmarks = $this->bookmark->build_bookmark_table(bookmark::factory()->where('categoryId', '=', $args['id']), $args['id']);
          include (__DIR__ . '/../view/edit_bookmarks.php');
          break;
        case 'bookmark_edit':
          if($args['bookmark_name'] == 0){
            $category = bookmark::factory()->insert(array(
              'name'=>$args['name'],
              'url'=>$args['url'],
              'icon'=>$args['icon'],
              'categoryId'=>$args['categoryId'],
              'isPublic'=>$args['isPublic'],
              'createdAt'=>date('Y-m-d H:i:s'),
              'updatedAt'=>date('Y-m-d H:i:s')
            ));
          }else{
            $category = bookmark::factory()->where('id', '=', $args['bookmark_name']);
            $category->update(array(
              'name'=>$args['name'],
              'url'=>$args['url'],
              'icon'=>$args['icon'],
              'categoryId'=>$args['categoryId'],
              'isPublic'=>$args['isPublic'],
              'updatedAt'=>date('Y-m-d H:i:s')
            ));
          }
          $args['id'] = $args['categoryId'];
          $category_options = $this->category->build_category_option();
          $bookmarks = $this->bookmark->build_bookmark_table(bookmark::factory()->where('categoryId', '=', $args['categoryId']), $args['categoryId']);
          include (__DIR__ . '/../view/edit_bookmarks.php');
          break;
        case 'category_edit':
          if($args['cat_name'] == 0){
            $category = category::factory()->insert(array('name'=>$args['name'],'isPublic'=>$args['isPublic']));
          }else{
            $category = category::factory()->where('name', '=', $args['cat_name']);
            $category->update(array('name'=>$args['name'],'isPublic'=>$args['isPublic']));
          }

          $bookmarks = $this->category->build_category_table(category::factory()->get(), true);
          include (__DIR__ . '/../view/edit_bookmarks.php');
          break;
        case 'categories';
          $bookmarks = $this->category->build_category_table(category::factory()->get(), true);
          include (__DIR__ . '/../view/edit_bookmarks.php');
          break;
      }
    }else{
      $this->html = '';

    }

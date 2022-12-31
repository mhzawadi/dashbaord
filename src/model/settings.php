<?php
namespace MHorwood\Dashboard\Model;
use MHorwood\Dashboard\classes\json;

class settings extends json{
  protected $settings;
  protected $themes;
  protected $themes_custom;

  public function __construct(){
    $this->settings = $this->load_from_file('../config/settings.json');
    $this->themes = $this->load_from_file('../config/themes.json');
    $this->themes_custom = $this->load_from_file('../config/themes_custom.json');
  }

  public function get_settings(){
    return $this->settings;
  }

  public function load_css(){
    $filename = "css/custom.css";
    $handle = fopen($filename, "r");
    $css = fread($handle, filesize($filename));
    fclose($handle);
    return $css;
  }

  public function get_themes(){
    return array_merge_recursive($this->themes, $this->themes_custom);
  }

  public function save_settings($page, $type, $new_settings){
    if(isset($type) && $type == 'edit'){
      switch($page){
        case 'theme':
          print_pre($this->themes_custom['themes']);
          var_dump(in_array($new_settings['name'], $this->themes_custom));
        break;
        case 'defaultTheme':
          $this->settings['defaultTheme'] = $new_settings['defaultTheme'];
          $this->save_to_file('../config/settings.json', $this->settings);
        break;
        case 'general':
          $this->settings['useOrdering']            = $new_settings['useOrdering'];
          $this->settings['pinAppsByDefault']       = $new_settings['pinAppsByDefault'];
          $this->settings['appsSameTab']            = $new_settings['appsSameTab'];
          $this->settings['pinCategoriesByDefault'] = $new_settings['pinCategoriesByDefault'];
          $this->settings['bookmarksSameTab']       = $new_settings['bookmarksSameTab'];
          $this->settings['defaultSearchProvider']  = $new_settings['defaultSearchProvider'];
          $this->settings['searchSameTab']          = $new_settings['searchSameTab'];
          $this->save_to_file('../config/settings.json', $this->settings);
          break;
        case 'interface':
          $this->settings['customTitle'] = $new_settings['customTitle'];
          $this->settings['hideSearch'] = $new_settings['hideSearch'];
          $this->settings['disableAutofocus'] = $new_settings['disableAutofocus'];
          $this->settings['hideHeader'] = $new_settings['hideHeader'];
          $this->settings['hideDate'] = $new_settings['hideDate'];
          $this->settings['showTime'] = $new_settings['showTime'];
          $this->settings['useAmericanDate'] = $new_settings['useAmericanDate'];
          $this->settings['greetingsSchema'] = $new_settings['greetingsSchema'];
          $this->settings['daySchema'] = $new_settings['daySchema'];
          $this->settings['monthSchema'] = $new_settings['monthSchema'];
          $this->settings['hideApps'] = $new_settings['hideApps'];
          $this->settings['hideCategories'] = $new_settings['hideCategories'];
         $this->save_to_file('../config/settings.json', $this->settings);
          break;
        case 'weather':
          break;
        case 'docker':
          $this->settings['dockerHost']       = $new_settings['dockerHost'];
          $this->settings['dockerApps']       = $new_settings['dockerApps'];
          $this->settings['unpinStoppedApps'] = $new_settings['unpinStoppedApps'];
          $this->settings['kubernetesApps']   = $new_settings['kubernetesApps'];
          $this->save_to_file('../config/settings.json', $this->settings);
          break;
        case 'css':
          $filename = "css/custom.css";
          $handle = fopen($filename, "w");
          fwrite($handle, $new_settings['customStyles']);
          fclose($handle);
          break;
        case 'app':
          break;
      }
      # need to get theme settings and update
      return $this->get_settings();
    }elseif(isset($type) && $type == 'new'){
      switch($page){
        case 'theme':
          $this->themes_custom['themes'][] = array(
            'name' => $new_settings['name'],
            'colors' => array(
                'accent' => $new_settings['accent'],
                'primary' => $new_settings['primary'],
                'background' => $new_settings['background']
              ),
            'isCustom' => true
          );
          $this->save_to_file('../config/themes_custom.json', $this->themes_custom);
        break;
      }
    }else{
      return $this->get_settings();
    }
  }

  public function greeting(){
    $settings = $this->get_settings();
    $greetings = explode(';', $settings['greetingsSchema']);
    $date = date('H');
    if ($date >= 18) {$msg = $greetings[0];}
    elseif ($date >= 12) {$msg = $greetings[1];}
    elseif ($date >= 6) {$msg = $greetings[2];}
    elseif ($date >= 0) {$msg = $greetings[3];}
    else {$msg = 'Hello!';}
    return $msg;
  }

}

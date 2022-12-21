<?php

namespace MHorwood\Dashboard\classes;
use MHorwood\Dashboard\Model\settings as Model_Settings;

class settings {
  public function load_css(){
    $filename = "css/custom.css";
    $handle = fopen($filename, "r");
    $css = fread($handle, filesize($filename));
    fclose($handle);
    return $css;
  }

  public function load_settings(){
    $settings = Model_Settings::factory()->where('id', '=', 1)->get();
    $setting_obj = json_decode($settings[0]['setting'], true);
    return $setting_obj;
  }
  public function load_themes(){
    $themes = Model_Settings::factory()->where('id', '=', 2)->get();
    $themes_obj = json_decode($themes[0]['setting'], true);
    return $themes_obj;
  }
  public function save_settings($page, $type, $curr_settings, $new_settings){
    if(isset($type) && $type == 'edit'){
      switch($page){
        case 'general':
            $curr_settings['useOrdering']            = $new_settings['useOrdering'];
            $curr_settings['pinAppsByDefault']       = $new_settings['pinAppsByDefault'];
            $curr_settings['appsSameTab']            = $new_settings['appsSameTab'];
            $curr_settings['pinCategoriesByDefault'] = $new_settings['pinCategoriesByDefault'];
            $curr_settings['bookmarksSameTab']       = $new_settings['bookmarksSameTab'];
            $curr_settings['defaultSearchProvider']  = $new_settings['defaultSearchProvider'];
            $curr_settings['searchSameTab']          = $new_settings['searchSameTab'];
            $settings = Model_Settings::factory()->where('id', '=', 1);
            $settings->update(array('setting'=>json_encode($curr_settings)));
          break;
        case 'interface':
          $curr_settings['customTitle'] = $new_settings['customTitle'];
          $curr_settings['hideSearch'] = $new_settings['hideSearch'];
          $curr_settings['disableAutofocus'] = $new_settings['disableAutofocus'];
          $curr_settings['hideHeader'] = $new_settings['hideHeader'];
          $curr_settings['hideDate'] = $new_settings['hideDate'];
          $curr_settings['showTime'] = $new_settings['showTime'];
          $curr_settings['useAmericanDate'] = $new_settings['useAmericanDate'];
          $curr_settings['greetingsSchema'] = $new_settings['greetingsSchema'];
          $curr_settings['daySchema'] = $new_settings['daySchema'];
          $curr_settings['monthSchema'] = $new_settings['monthSchema'];
          $curr_settings['hideApps'] = $new_settings['hideApps'];
          $curr_settings['hideCategories'] = $new_settings['hideCategories'];
          $settings = Model_Settings::factory()->where('id', '=', 1);
          $settings->update(array('setting'=>json_encode($curr_settings)));
          break;
        case 'weather':
          break;
        case 'docker':
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
      return $this->load_settings();
    }else{
      return $this->load_settings();
    }
  }

  public function greeting(){
    $settings = $this->load_settings();
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

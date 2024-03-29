<?php
namespace MHorwood\Dashboard\model;
use MHorwood\Dashboard\classes\json;

class settings extends json{
  protected $settings;
  protected $themes;
  protected $themes_custom;

  public function __construct(){
    if(file_exists('../../user_data/settings.json') === false){
      $this->settings = $this->load_from_file('../../data/settings.json');
      $this->save_to_file('../../user_data/settings.json', $this->settings);
    }else{
      $this->settings = $this->load_from_file('../../user_data/settings.json');
    }
    if(file_exists('../../user_data/themes.json') === false){
      $this->themes = $this->load_from_file('../../data/themes.json');
      $this->save_to_file('../../user_data/themes.json', $this->themes);
    }else{
      $this->themes = $this->load_from_file('../../user_data/themes.json');
    }
    if(file_exists('../../user_data/themes_custom.json') === false){
      $this->themes_custom = $this->load_from_file('../../data/themes_custom.json');
      $this->save_to_file('../../user_data/themes_custom.json', $this->themes_custom);
    }else{
      $this->themes_custom = $this->load_from_file('../../user_data/themes_custom.json');
    }
  }

  public function get_settings(){
    return $this->settings;
  }
  public function get_oauth(){
    return $this->set_http($this->settings['oauth']);
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
          $this->save_to_file('../../user_data/settings.json', $this->settings);
        break;
        case 'general':
          $this->settings['useOrdering']            = $new_settings['useOrdering'];
          $this->settings['pinAppsByDefault']       = $new_settings['pinAppsByDefault'];
          $this->settings['appsSameTab']            = $new_settings['appsSameTab'];
          $this->settings['pinCategoriesByDefault'] = $new_settings['pinCategoriesByDefault'];
          $this->settings['bookmarksSameTab']       = $new_settings['bookmarksSameTab'];
          $this->settings['defaultSearchProvider']  = $new_settings['defaultSearchProvider'];
          $this->settings['searchSameTab']          = $new_settings['searchSameTab'];
          $this->save_to_file('../../user_data/settings.json', $this->settings);
          break;
        case 'interface':
          $this->settings['customTitle']      = $new_settings['customTitle'];
          $this->settings['hideSearch']       = $new_settings['hideSearch'];
          $this->settings['disableAutofocus'] = $new_settings['disableAutofocus'];
          $this->settings['hideHeader']       = $new_settings['hideHeader'];
          $this->settings['hideDate']         = $new_settings['hideDate'];
          $this->settings['showTime']         = $new_settings['showTime'];
          $this->settings['useAmericanDate']  = $new_settings['useAmericanDate'];
          $this->settings['greetingsSchema']  = $new_settings['greetingsSchema'];
          $this->settings['daySchema']        = $new_settings['daySchema'];
          $this->settings['monthSchema']      = $new_settings['monthSchema'];
          $this->settings['hideApps']         = $new_settings['hideApps'];
          $this->settings['hideCategories']   = $new_settings['hideCategories'];
          $this->save_to_file('../../user_data/settings.json', $this->settings);
          break;
        case 'weather':
          break;
        case 'docker':
          $this->settings['dockerHost']       = $new_settings['dockerHost'];
          $this->settings['dockerApps']       = $new_settings['dockerApps'];
          $this->settings['unpinStoppedApps'] = $new_settings['unpinStoppedApps'];
          $this->settings['kubernetesApps']   = $new_settings['kubernetesApps'];
          $this->save_to_file('../../user_data/settings.json', $this->settings);
          break;
        case 'css':
          $filename = "css/custom.css";
          $handle = fopen($filename, "w");
          fwrite($handle, $new_settings['customStyles']);
          fclose($handle);
          break;
        case 'oauth':
          $this->settings['oauth_login']                      = $new_settings['oauth_login'];
          $this->settings['oauth']['oauth_client_id']         = $new_settings['oauth_client_id'];
          $this->settings['oauth']['oauth_client_secret']     = $new_settings['oauth_client_secret'];
          $this->settings['oauth']['oauth_authorization_uri'] = $this->store_http($new_settings['oauth_authorization_uri']);
          $this->settings['oauth']['oauth_access_token_uri']  = $this->store_http($new_settings['oauth_access_token_uri']);
          $this->settings['oauth']['oauth_resource_uri']      = $this->store_http($new_settings['oauth_resource_uri']);
          $this->settings['oauth']['oauth_redirect_uri']      = $this->store_http($new_settings['oauth_redirect_uri']);
          $this->settings['oauth']['oauth_logout_url']        = $new_settings['oauth_logout_url'];
          $this->settings['oauth']['oauth_user_identifier']   = $new_settings['oauth_user_identifier'];
          $this->settings['oauth']['oauth_scopes']            = $new_settings['oauth_scopes'];
          $this->save_to_file('../../user_data/settings.json', $this->settings);
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
          $this->save_to_file('../../user_data/themes_custom.json', $this->themes_custom);
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

  protected function remove_http($string){
    $replace = array('http://', 'https://', 'http-', 'https-');
    return str_replace($replace, '', $string);
  }
  protected function store_http($string){
    $replace = array('http://', 'https://');
    $with = array('http-', 'https-');
    if(strpos($string, 'http') === false){
      return 'http-'.$string;
    }else{
      return str_replace($replace, $with, $string);
    }
  }
  protected function set_http($string){
    $replace = array('http-', 'https-');
    $with = array('http://', 'https://');
    return str_replace($replace, $with, $string);
  }
}

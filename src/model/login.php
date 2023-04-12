<?php
namespace MHorwood\Dashboard\model;

class login {

  protected $env_password;
  protected $env_password_file;
  protected $session;
  protected $path;
  protected $token;

  public function __construct(){
    $this->env_password = getenv('PASSWORD');
    $this->env_password_file = getenv('PASSWORD_FILE');
    if(file_exists($this->env_password_file) === true){
      $handle = fopen($this->env_password_file, "r");
      $this->env_password = fread($handle, filesize($this->env_password_file));
      fclose($handle);
    }
    if($this->env_password == ''){
      $this->env_password = 'HorwoodDashboard';
    }
    $this->token = crypt($this->env_password, '$5$rounds=5000$'.$_SERVER['SERVER_NAME'].'$');
  }

  public function checkLogin($password, $duration = 'P14D') {

    # set failed flag to update authFailed table
    $authSuccess = false;

    if($this->env_password == $password ){
      $authSuccess = true;
    }else{
      $authText = 'Invlaid username or password!';
    }
    if(isset($_COOKIE['token']) && hash_equals($this->cookie_hash($_COOKIE['token']), $this->token) ) {
      if(time() < $this->cookie_logout($_COOKIE['token'])){
        $authSuccess = true;
        $duration = $this->cookie_duration($_COOKIE['token']);
      }else{
        $authText = 'The token you have has expired';
      }
    }


    /**
     * print errors
     */
    if ($authSuccess === false) {
        return '<div style="color: red; text-align: center;font-size: 20px;">'.$authText.'</div>';
    } else {
        /**
         * print success
         */
        $date = new \DateTimeImmutable;
        $logout = $date->add(new \DateInterval("$duration"));
        $_SESSION['login_time'] = time();
        $_SESSION['logout_time'] = $logout->format('U');
        $_SESSION['duration'] = $duration;
        setcookie(
          'token',
          $this->token.';'.$_SESSION['logout_time'].';'.$duration,
          $logout->format('U'),
          "/",
          $_SERVER['SERVER_NAME'],
          true
        ); // 86400 = 1 day
        $this->reset_inactivity_time();
        session_write_close();
        header('Location: /');
        exit;
    }
    return true;
  }

    public function isUserAuthenticated() {
      // - is `login_time` set
      // - is `time` more then logout_time (logout and redirect to `settings/app`
      if(isset($_COOKIE['token']) && hash_equals($this->cookie_hash($_COOKIE['token']), $this->token) ) {
        if( $_SERVER['REQUEST_URI'] != '/settings/token' && empty($_SESSION['login_time']) ){
          header("Location: /settings/token");
          exit;
        }else{
          return true;
        }
      }elseif (empty($_SESSION['login_time'])) {
        return false;
      } else {
        if ( time() > $_SESSION['logout_time'] ) {
          if($_SERVER['REQUEST_URI'] != '/settings/app'){
            # redirect
            header("Location: /settings/app");
            exit;
          }else{
            return false;
          }
        }
        $this->reset_inactivity_time();
      }

      /* close session */
      session_write_close();
      return true;
    }

    /**
    * reset inactivity time
    */
    protected function reset_inactivity_time() {
      $_SESSION['lastactive'] = time();
    }

  public function set_path($urls){
    $this->path = join('/', $urls);
  }

  public function get_logout(){
    return date('l jS \of F Y H:i:s A', $_SESSION['logout_time']);
  }

  protected function cookie_hash($token){
    $parts = explode(';', $token);
    return $parts[0];
  }
  protected function cookie_logout($token){
    $parts = explode(';', $token);
    return $parts[1];
  }
  protected function cookie_duration($token){
    $parts = explode(';', $token);
    return $parts[2];
  }
  public function oauth($settings, $duration = 'P14D'){
    $provider = new \League\OAuth2\Client\Provider\GenericProvider([
      'clientId'                => $settings['oauth_client_id'],    // The client ID assigned to you by the provider
      'clientSecret'            => $settings['oauth_client_secret'],    // The client password assigned to you by the provider
      'redirectUri'             => $this->set_http($settings['oauth_redirect_uri']),
      'urlAuthorize'            => $this->set_http($settings['oauth_authorization_uri']),
      'urlAccessToken'          => $this->set_http($settings['oauth_access_token_uri']),
      'urlResourceOwnerDetails' => $this->set_http($settings['oauth_resource_uri'])
    ]);
    if (!isset($_GET['code'])) {

      // If we don't have an authorization code then get one
      $authUrl = $provider->getAuthorizationUrl();
      $_SESSION['oauth2state'] = $provider->getState();
      $_SESSION['duration'] = $duration;
      header('Location: '.$authUrl);
      exit;

    // Check given state against previously stored one to mitigate CSRF attack
    } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

      unset($_SESSION['oauth2state']);
      exit('Invalid state, make sure HTTP sessions are enabled.');

    } else {

        // Try to get an access token (using the authorization code grant)
        try {
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);
        } catch (Exception $e) {
            exit('Failed to get access token: '.$e->getMessage());
        }
        // Use this to interact with an API on the users behalf
        $date = new \DateTimeImmutable;
        $logout = $date->add(new \DateInterval($_SESSION['duration']));
        $_SESSION['login_time'] = time();
        $_SESSION['logout_time'] = $logout->format('U');
        setcookie(
          'token',
          $this->token.';'.$_SESSION['logout_time'].';'.$duration,
          $logout->format('U'),
          "/",
          $_SERVER['SERVER_NAME'],
          true
        ); // 86400 = 1 day
        $this->reset_inactivity_time();
        session_write_close();
        header('Location: /');
        exit;
    }
  }
  protected function set_http($string){
    $replace = array('http-', 'https-');
    $with = array('http://', 'https://');
    return str_replace($replace, $with, $string);
  }
}

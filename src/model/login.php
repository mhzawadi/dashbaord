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
      $this->env_password = fread($handle, filesize($filename));
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
        setcookie('token', $this->token.';'.$_SESSION['logout_time'].';'.$duration, $logout->format('U'), "/"); // 86400 = 1 day
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
}

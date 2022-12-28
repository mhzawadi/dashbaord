<?php
namespace MHorwood\Dashboard\Model;

class login {

  /*
  login flow:
  - main page should test for active session
  - head to `settings/app`
  - login (with PW or OAuth)
  - redirect back to main page
  ​
  session:
  - login_time
  - logout_time
  - duration
  ​
  login test:
  - is `login_time` set
  - is `time` more then logout_time (logout and redirect to `settings/app`
  */
  protected $env_password;
  protected $env_password_file;
  protected $session;
  protected $path;

  public function __construct(){
    $this->env_password = getenv('PASSWORD');
    $this->env_password_file = getenv('PASSWORD_FILE');
    if($this->env_password == ''){
      $this->env_password = 'HorwoodDashboard';
    }
  }

  public function checkLogin($password, $duration) {

    # set failed flag to update authFailed table
    $authFailed = true;
    $updatepass = false;
    $i = 0;

    if($this->env_password == $password){
      $authSuccess = true;
    }else{
      $authSuccess = false;
    }

    /**
     * print errors
     */
    if ($authSuccess === false) {
        return '<div style="color: red; text-align: center;font-size: 20px;">Invlaid username or password!</div>';
    } else {
        /**
         * print success
         */
        $date = new \DateTimeImmutable;
        $logout = $date->add(new \DateInterval("$duration"));
        $_SESSION['login_time'] = time();
        $_SESSION['logout_time'] = $logout->format('U');
        $_SESSION['duration'] = $duration;
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
      if (empty($_SESSION['login_time'])) {
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
}

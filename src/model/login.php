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
        $uerror = 'Not logged in';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        # add block count
        //block_ip ($ip);

        return '<div style="color: red; text-align: center;font-size: 20px;">Invlaid username or password!</div>';
    } else {
        /**
         * print success
         */
        $_SESSION['login_time'] = time();
        $_SESSION['last_active'] = time();
        $_SESSION['duration'] = $duration;
        session_write_close();
        header('Location: /');
        exit;
    }
    return true;
  }

    public function isUserAuthenticated() {
      if (empty($_SESSION['lastactive'])) {
        return false;
      } else {
        //echo "check timeout,";
        if ((isset($_GET['section']) && ($_GET['section'] != "login" && $_GET['section'] != "request_ip" && $_GET['section'] != "upgrade" && $_GET['section'] != "install" && $_GET['section'] != "logout")) || !isset($_GET['section'])) {
          global $settings;
          /* check inactivity time */
          if (strlen($settings['inactivityTimeout'] > 0) && ( (time() - $_SESSION['lastactive']) > $settings['inactivityTimeout'])) {
            # redirect
            // header("Location: /settings/app");
            // exit;
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
}

<?php
require_once('header.php');
?>
            <header class="Header_Header__2oavH">
              <p><?php echo date("l, j F Y");?></p>
              <a class="Header_SettingsLink__3ublJ" href="/settings">Go to Settings</a>
              <span class="Header_HeaderMain__ZUhf5">
                <h1>Good evening!</h1>
                <div class="WeatherWidget_WeatherWidget__1Wn8c">
                  <div>
                    <canvas id="weather-icon" width="50" height="50"></canvas>
                  </div>
                  <div class="WeatherWidget_WeatherDetails__2JUm1">
                    <span>3.4°C</span>
                    <span>69%</span>
                  </div>
                </div>
              </span>
            </header>
            <a href="/applications">
              <h2 class="SectionHeadline_SectionHeadline__2gmr_">Applications</h2>
            </a>
            <div class="AppGrid_AppGrid__33iLW"><?php echo $applications;?></div>
            <div class="Home_HomeSpace__2q0OU"></div>
            <a href="/bookmarks">
              <h2 class="SectionHeadline_SectionHeadline__2gmr_">Bookmarks</h2>
            </a>
            <div class="BookmarkGrid_BookmarkGrid__26LlR">
              <?php echo $bookmarks;?>
            </div>
            <a class="Home_SettingsButton__Qvn8C" href="/settings">
              svg icon here
            </a>
<?php
require_once('footer.php');
?>

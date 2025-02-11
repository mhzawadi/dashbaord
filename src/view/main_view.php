<?php
require_once('header.php');
?>
            <header class="Header_Header__2oavH">
              <p><?php if($this->setting_obj['useAmericanDate'] == 1){ echo date("l, F j Y");}else{echo date("l, j F Y"); }?></p>
              <a class="Header_SettingsLink__3ublJ" href="/settings">Go to Settings</a>
              <span class="Header_HeaderMain__ZUhf5">
                <img src="/icons/logo-76.png" alt="Logo small" onclick="openModal('logo_modal')" style="cursor: pointer">
                <h1><?php echo $this->greeting;?></h1>
                <div class="WeatherWidget_WeatherWidget__1Wn8c">
                  <div>
                    <canvas id="weather-icon" width="50" height="50"></canvas>
                  </div>
                  <div class="WeatherWidget_WeatherDetails__2JUm1">

                  </div>
                </div>
              </span>
            </header>
            <div id="logo_modal" class="Modal_Modal__1-5dN Modal_ModalClose__3Cav6">
              <div class="ModalForm_ModalForm__KUznX">
                <div class="ModalForm_ModalFormIcon__3Og8r" onclick="CloseModal('logo_modal')">
                  <span class="iconify" data-icon="mdi:close" data-width="30"></span>
                </div>
                <img class="horwoodimg" src="/icons/logo.png" alt="Logo">
                <h2>This is the Horwood Dashboard, writen in PHP.</h2>
                <p>you can find it on <a href="https://github.com/mhzawadi/dashbaord">github "mhzawadi/dashbaord"</a></p>
                <p>Version <?php echo $this->version; ?>, <a href="https://github.com/mhzawadi/dashbaord/blob/master/CHANGELOG.md" target="_blank" rel="noreferrer">Change Log</a></p>
              </div>
            </div>
            <section>
            <?php if($this->logged_in === true) {?>
            <a href="/applications">
              <h2 class="SectionHeadline_SectionHeadline__2gmr_"><span class="iconify" data-icon="mdi:pencil" data-width="20"></span> Applications</h2>
            </a>
          <?php }else{ ?>
            <h2 class="SectionHeadline_SectionHeadline__2gmr_">Applications</h2>
          <?php } ?>
            <div class="AppGrid_AppGrid__33iLW"><?php echo $applications;?></div>
            <div class="Home_HomeSpace__2q0OU"></div>
            <?php if($this->logged_in === true) {?>
            <a href="/bookmarks">
              <h2 class="SectionHeadline_SectionHeadline__2gmr_"><span class="iconify" data-icon="mdi:pencil" data-width="20"></span> Bookmarks</h2>
            </a>
            <?php }else{ ?>
              <h2 class="SectionHeadline_SectionHeadline__2gmr_">Bookmarks</h2>
            <?php } ?>
            <?php echo $bookmarks;?>
            <a class="Home_SettingsButton__Qvn8C" href="/settings">
              <span class="iconify" data-icon="mdi:cog" data-width="35"></span>
            </a>
          </section>
<?php
require_once('footer.php');
?>

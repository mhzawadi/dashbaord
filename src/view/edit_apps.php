<?php
require_once('header.php');
?>
            <h1 class="Headline_HeadlineTitle__3WjW5">All Applications</h1>
            <p class="Headline_HeadlineSubtitle__Aon5D"><a href="/">Go back</a></p>
            <div class="Apps_ActionsContainer__1Nn5v">
              <div class="ActionButton_ActionButton__3Ckgw" tabindex="0">
                <div class="ActionButton_ActionButtonIcon__oPDrT">
                  <svg viewBox="0 0 24 24" role="presentation" class="Icon_Icon__1Fl5u">
                    <path d="M17,13H13V17H11V13H7V11H11V7H13V11H17M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" style="fill: var(--color-primary);">
                    </path>
                  </svg>
                </div>
                <div class="ActionButton_ActionButtonName__32SDW">Add</div>
              </div>
              <div class="ActionButton_ActionButton__3Ckgw" tabindex="0"><div class="ActionButton_ActionButtonIcon__oPDrT">
                <svg viewBox="0 0 24 24" role="presentation" class="Icon_Icon__1Fl5u">
                  <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" style="fill: var(--color-primary);">
                  </path>
                </svg>
                </div>
                <div class="ActionButton_ActionButtonName__32SDW">Edit</div>
              </div>
            </div>
            <div class="AppGrid_AppGrid__33iLW"><?php echo $applications;?></div>
            <a class="Home_SettingsButton__Qvn8C" href="/settings">
              svg icon here
            </a>
<?php
require_once('footer.php');
?>

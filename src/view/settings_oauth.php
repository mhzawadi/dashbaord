<?php
require_once('header.php');
?>
<img src="/icons/logo-76.png" alt="Logo small">
<h1 class="Headline_HeadlineTitle__3WjW5">Settings</h1>
<p class="Headline_HeadlineSubtitle__Aon5D"><a href="/">Go back</a></p>

<div class="Settings_Settings__2WEZf">
  <?php require_once('settings_menu.php');?>
  <section>
    <form method="post" action="/settings/oauth/edit">
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">OAuth Configuration</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="dockerApps">Use oAuth login</label>
        <select id="oauth_login" name="oauth_login">
          <option value="1"<?php if($this->setting_obj['oauth_login'] == 1){?> selected=""<?php }?>>True</option>
          <option value="0"<?php if($this->setting_obj['oauth_login'] == 0){?> selected=""<?php }?>>False</option>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="oauth_client_id" >Client ID</label>
        <input type="text" name="oauth_client_id" placeholder="xxxxxxxxxxxxxxxxxxxx" value="<?php echo $this->setting_obj['oauth']['oauth_client_id'];?>">
      </div>

      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="oauth_client_secret" >
          Client secret
        </label>
          <input type="password" name="oauth_client_secret" value="<?php echo $this->setting_obj['oauth']['oauth_client_secret'];?>">
      </div>
      <div if="$ctrl.state.provider == 'custom' || $ctrl.state.overrideConfiguration" >
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="oauth_authorization_uri" >
          Authorization URL
        </label>
        <div class="InputGroup_InputGroup__1Nm_2">
          <input type="text" name="oauth_authorization_uri" value="<?php echo $this->setting_obj['oauth']['oauth_authorization_uri'];?>">
        </div>
      </div>

      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="oauth_access_token_uri" >
          Access token URL
        </label>
        <div class="InputGroup_InputGroup__1Nm_2">
          <input type="text" name="oauth_access_token_uri" value="<?php echo $this->setting_obj['oauth']['oauth_access_token_uri'];?>">
        </div>
      </div>

      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="oauth_resource_uri" >
          Resource URL
        </label>
        <div class="InputGroup_InputGroup__1Nm_2">
          <input type="text" name="oauth_resource_uri" value="<?php echo $this->setting_obj['oauth']['oauth_resource_uri'];?>">
        </div>
      </div>

      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="oauth_redirect_uri" >
          Redirect URL
        </label>
        <div class="InputGroup_InputGroup__1Nm_2">
          <input type="text" name="oauth_redirect_uri" value="<?php echo $this->setting_obj['oauth']['oauth_redirect_uri'];?>">
        </div>
      </div>

      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="oauth_logout_url" >
          Logout URL
        </label>
        <div class="InputGroup_InputGroup__1Nm_2">
          <input type="text" name="oauth_logout_url" value="<?php echo $this->setting_obj['oauth']['oauth_logout_url'];?>">
        </div>
      </div>

      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="oauth_user_identifier" >
          User identifier
        </label>
        <div class="InputGroup_InputGroup__1Nm_2">
          <input type="text" name="oauth_user_identifier" value="<?php echo $this->setting_obj['oauth']['oauth_user_identifier'];?>">
        </div>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="oauth_scopes">
          Scopes
        </label>
        <div class="InputGroup_InputGroup__1Nm_2">
          <input type="text" name="oauth_scopes" value="<?php echo $this->setting_obj['oauth']['oauth_scopes'];?>">
        </div>
      </div>
    </div>
    <button class="Button_Button__1hnZa">Save changes</button>
  </form>
</section>
</div>
<?php
require_once('footer.php');
?>

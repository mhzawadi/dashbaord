<?php
require_once('header.php');
?>
<img src="/icons/logo-76.png" alt="Logo small">
<h1 class="Headline_HeadlineTitle__3WjW5">Settings</h1>
<p class="Headline_HeadlineSubtitle__Aon5D"><a href="/">Go back</a></p>

<div class="Settings_Settings__2WEZf">
  <?php require_once('settings_menu.php');?>
  <section>
    <form method="post" action="/settings/css/edit">
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="customStyles">Custom CSS</label>
        <textarea id="customStyles" name="customStyles" spellcheck="false">
<?php
echo $this->settings->load_css();
?>
        </textarea>
      </div>
      <button class="Button_Button__1hnZa">Save CSS</button>
    </form>
  </section>
</div>
<?php
require_once('footer.php');
?>

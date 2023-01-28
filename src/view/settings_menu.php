<?php
$menu = array(
  'Theme' => '/settings;false',
  'General' => '/settings/general;true',
  'Interface' => '/settings/interface;true',
  'Weather' => '/settings/weather;true',
  'Docker' => '/settings/docker;true',
  'CSS' => '/settings/css;true',
  'oAuth' => '/settings/oauth;true',
  'App' => '/settings/app;false'
);
 ?>
<nav class="Settings_SettingsNav__14rA1">
<?php
foreach ($menu as $name => $link) {
  $link_parts = explode(';', $link);
  if( $this->logged_in === false && $link_parts[1] === 'false'){
    $display = true;
  }elseif($this->logged_in === true){
    $display = true;
  }else{
    $display = false;
  }
  if($display === true){?>
  <a class="Settings_SettingsNavLink__1Eo-j <?php if($_SERVER['REQUEST_URI'] == $link_parts[0]){?>Settings_SettingsNavLinkActive__BWxtM<?php }?>" href="<?php echo $link_parts[0];?>"><?php echo $name;?></a>
<?php }?>
<?php } ?>
</nav>

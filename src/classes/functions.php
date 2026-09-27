<?php

/*
 * Print out print_r in pre HTML tags
 * @param mixed $data The data that print_r should print
 */
function print_pre($data){
  echo '<pre>'."\n";
  print_r($data);
  echo '</pre>'."\n";
}

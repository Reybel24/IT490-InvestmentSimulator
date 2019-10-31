<?php

function writeLogMessage($time, $machine_name, $error_message){
  $logfile = fopen("funwitherrors.txt", "w") or die("unable to open file!");
  $txt = $time." ".$machine_name." ".$error_message."\n";
  fwrite($logfile, $txt);
  fclose($logfile);
}


?>

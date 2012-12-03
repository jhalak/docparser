<?php

/**
* DocParser script (server)
*
* Parses docs using LibreOffice command
*
* @author Jhalak <jhalak1983@gmail.com>
* @copyright  Copyright (c) 2012 Tasawr Interactive.
*
*/
if (!empty($_POST['file_content'])) {
  $filename = $_POST['filename'];
  $outdir = dirname(__FILE__) . '/files/';
  $doc_filepath = $outdir . $filename;
  
  $pathinfo = pathinfo($doc_filepath);
  $html_filepath = $outdir . $pathinfo['filename'] . '.html';
  
  // write the doc data locally into a file
  file_put_contents($doc_filepath, $_POST['file_content']);
  
  
  try{
    $output = system('LANG=en_us.UTF-8 /usr/bin/unoconv -i charset=utf8 -f html ' . $doc_filepath, $r);
    if (!$r) {
      $html = file_get_contents($html_filepath);

      if (stat($html_filepath)) {
        unlink($html_filepath);
      }
      echo $html;
    } else{
      throw new Exception('Can\'t execute command');
    }
  }catch (Exception $e) {
    echo $e->getMessage();
    echo ('/usr/bin/unoconv --stdout -f html ' . $doc_filepath);
  }

  if (stat($doc_filepath)) {
  //  unlink($doc_filepath);
  }
}

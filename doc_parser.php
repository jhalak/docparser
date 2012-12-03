<?php

/**
* DocParser script (server)
*
* Parses docs using LibreOffice command
*
* @author Jhalak <jhalak1983@gmail.com>
*
*/

$error = false;

// assert API Key
if (empty($_POST['api_key']) 
  || $_POST['api_key'] != 'e4a2ed88c280c425a1e8add7c0ac5f171be9c4b2ecfe5a881d71e64d14361ac8'
  ) {
  $error = true;
}

// assert file content
if (empty($_POST['file_content'])) {
  $error = true;
}

// Something going fishy??
if ($error) {
  echo 'Better luck next time buddy !!';
  exit;
}

$filename = $_POST['filename'];
$outdir = dirname(__FILE__) . '/files/';
$doc_filepath = $outdir . $filename;

$pathinfo = pathinfo($doc_filepath);
$html_filepath = $outdir . $pathinfo['filename'] . '.html';

// write the doc data locally into a file
file_put_contents($doc_filepath, $_POST['file_content']);


try{
  $output = system('/usr/bin/unoconv -f html ' . $doc_filepath, $r);
  if (!$r) {
    $html = file_get_contents($html_filepath);
    
    // say bye bye to html file
    if (stat($html_filepath)) {
      unlink($html_filepath);
    }
    // We got it!! send it, hurry!!
    echo $html;
  } else{
    throw new Exception('Can\'t execute command');
  }
}catch (Exception $e) {
  echo $e->getMessage();
}

// say bye bye to doc file
if (stat($doc_filepath)) {
  unlink($doc_filepath);
}

<?php
require_once 'DocParser.php';

try {
  $dp = new DocParser();
  $html = $dp->getHtmlFromDocFile('SAKK-Fatawa.doc');
  echo $html;
}catch (Exception $e) {
  echo $e->getMessage();
}
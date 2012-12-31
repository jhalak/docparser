<?php
/**
* DocParser class
*
* Parses docs using LibreOffice command
*
* @author Jhalak <jhalak1983@gmail.com>
* @copyright  Copyright (c) 2012 Tasawr Interactive.
*
*/

class DocParser {
  //private $url = 'http://198.101.153.9/docparser/doc_parser.php';
  private $url = 'http://localhost/docparser/doc_parser.php';
  
  public function getHtmlFromDocFile($fileName) {
    $file = file_get_contents($fileName);
    $data = http_build_query(
      array(
      	'file_content' => $file,
      	'filename' => 'file_name_' . rand(10, 99),
      	'api_key' => 'e4a2ed88c280c425a1e8add7c0ac5f171be9c4b2ecfe5a881d71e64d14361ac8',
      )
    );
    return $this->doPostRequest($data);
  }
  
  public function doPostRequest($data, $optionalHeaders = null){
    $params = array(
    	'http' => array(
      	'method' => 'POST',
      	'content' => $data
      )
    );
    
    if ($optionalHeaders !== null) {
      $params['http']['header'] = $optionalHeaders;
    }
    $ctx = stream_context_create($params);
    $fp = @fopen($this->url, 'rb', false, $ctx);
    if (!$fp) {
      throw new Exception("Problem with $this->url");
    }
    $response = @stream_get_contents($fp);
    if ($response === false) {
      throw new Exception("Problem reading data from $this->url");
    }
    return $response;
  }
}
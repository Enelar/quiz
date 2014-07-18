<?php

class text extends api 
{
  private function getText()
  {
    return $txt = '123';//TODO
  }
  
  private function startSession()
  {
    if (session_status() == PHP_SESSION_ACTIVE)
      return;
    session_start();
  }
  
  protected function isTextShown()
  {
    $this->startSession();
    if ( !isset($_SESSION['showText']) )
      return true;
        
    return false;
  }
  
  protected function showText()
  {       
    $this->startSession();
    $_SESSION['showText'] = true;
    $txt = $this->getText();
    return 
    [
      "design"  =>  "text",
      "result"  =>  "content",
      "data"  =>  ["txt"  =>  $txt]
    ];
  }
  
  
  protected function show()
  {         
    return
    [
      "design" => "isTextShown",
      "data" => ["isTextShown"  =>  LoadModule('api', 'text')->isTextShown()]
    ];
    /*
    return 
    [    
      "design"  =>  "text",
      "result"  =>  "content",
      "data"  =>  ["txt"  =>  $txt]
    ];
    */
  }
}
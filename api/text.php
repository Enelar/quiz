<?php

class text extends api 
{
  protected function getTextId()
  {
    return 1;//TODO
  }
  
  private function getText()
  {
    return $txt = '123';//TODO
  }
    
  protected function isTextShown()
  {
    LoadModule('api', 'register')->startSession();
    
    if ( !isset($_SESSION['showText']) )
      return true;
        
    return false;
  }
  
  protected function showText()
  {       
    LoadModule('api', 'register')->startSession();
    $_SESSION['showText'] = true;
    $txt = $this->getText();
    return 
    [
      "design"  =>  "text",
      "result"  =>  "content",
      "data"  =>  ["txt"  =>  $txt]
    ];
  }
  
  
  protected function Reserve()
  {         
    return
    [
      "design" => "isTextShown",
      "data" => ["isTextShown"  =>  $this->isTextShown()]
    ];
  }
}